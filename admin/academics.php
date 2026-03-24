<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_admin();
$pdo = db();
$error = '';

function handle_upload($file_key, &$error) {
  if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES[$file_key]['name'], PATHINFO_EXTENSION);
    $name = uniqid('a_', true) . '.' . strtolower($ext);
    $dir = __DIR__ . '/../assets/upload';
    if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
    @chmod($dir, 0775);
    if (!is_writable($dir)) { @chmod($dir, 0777); }
    if (!is_writable($dir)) { 
      $error = 'Upload directory is not writable: ' . htmlspecialchars($dir); 
      return ''; 
    }
    $dest = $dir . '/' . $name;
    if (is_uploaded_file($_FILES[$file_key]['tmp_name']) && move_uploaded_file($_FILES[$file_key]['tmp_name'], $dest)) {
      @chmod($dest, 0664);
      return 'assets/upload/' . $name;
    } else {
      $error = 'Failed to upload ' . $file_key . '.';
    }
  }
  return '';
}

/* ================= ADD ================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
  $title = trim($_POST['title'] ?? '');
  $desc  = trim($_POST['description'] ?? '');

  $img1 = handle_upload('image1', $error);
  $img2 = handle_upload('image2', $error);

  if ($title && $desc) {
    $st = $pdo->prepare('INSERT INTO academic_cards (title, description, image_path_1, image_path_2, sort_order) VALUES (?, ?, ?, ?, ?)');
    $st->execute([
      $title,
      $desc,
      $img1 ?: null,
      $img2 ?: null,
      0
    ]);
  }

  if ($error === '') {
    set_flash('Academic card added');
    redirect_to('dcsschools.com/admin/academics.php');
  }
}

/* ================= UPDATE ================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
  $id    = (int)($_POST['id'] ?? 0);
  $title = trim($_POST['title'] ?? '');
  $desc  = trim($_POST['description'] ?? '');

  $st = $pdo->prepare('SELECT image_path_1, image_path_2 FROM academic_cards WHERE id = ?');
  $st->execute([$id]);
  $row = $st->fetch();

  $img1 = $row['image_path_1'] ?? null;
  $img2 = $row['image_path_2'] ?? null;

  /* REMOVE IMAGE 1 */
  if (!empty($_POST['remove_image1']) && $img1) {
    $old = __DIR__ . '/../' . $img1;
    if (is_file($old)) @unlink($old);
    $img1 = null;
  }

  /* REMOVE IMAGE 2 */
  if (!empty($_POST['remove_image2']) && $img2) {
    $old = __DIR__ . '/../' . $img2;
    if (is_file($old)) @unlink($old);
    $img2 = null;
  }

  $new_img1 = handle_upload('image1', $error);
  $new_img2 = handle_upload('image2', $error);

  if ($new_img1) {
    if ($img1) {
      $old = __DIR__ . '/../' . $img1;
      if (is_file($old)) @unlink($old);
    }
    $img1 = $new_img1;
  }

  if ($new_img2) {
    if ($img2) {
      $old = __DIR__ . '/../' . $img2;
      if (is_file($old)) @unlink($old);
    }
    $img2 = $new_img2;
  }

  if ($id && $title && $desc) {
    $u = $pdo->prepare('UPDATE academic_cards SET title=?, description=?, image_path_1=?, image_path_2=? WHERE id=?');
    $u->execute([$title, $desc, $img1, $img2, $id]);
    set_flash('Academic card updated');
    redirect_to('dcsschools.com/admin/academics.php');
  }
}

/* ================= DELETE ================= */

if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $row = $pdo->prepare('SELECT image_path_1, image_path_2 FROM academic_cards WHERE id = ?');
  $row->execute([$id]);
  $r = $row->fetch();

  $pdo->prepare('DELETE FROM academic_cards WHERE id = ?')->execute([$id]);

  if ($r['image_path_1']) {
    $f = __DIR__ . '/../' . $r['image_path_1'];
    if (is_file($f)) @unlink($f);
  }
  if ($r['image_path_2']) {
    $f = __DIR__ . '/../' . $r['image_path_2'];
    if (is_file($f)) @unlink($f);
  }

  set_flash('Academic card deleted');
  redirect_to('dcsschools.com/admin/academics.php');
}

/* ================= LOAD ================= */

$cards = $pdo->query('SELECT * FROM academic_cards ORDER BY sort_order, id DESC')->fetchAll();
$edit = null;

if (isset($_GET['edit'])) {
  $eid = (int)$_GET['edit'];
  $s = $pdo->prepare('SELECT * FROM academic_cards WHERE id = ?');
  $s->execute([$eid]);
  $edit = $s->fetch();
}

$page_title = 'Manage Academics';
ob_start();
?>

<section class="panel">
<h2>Add Card</h2>
<?php if($error){ echo '<div class="error">'.htmlspecialchars($error).'</div>'; } ?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="add">
<label>Title<input name="title" required></label>
<label>Description<textarea name="description" required rows="5"></textarea></label>
<label>Image 1<input type="file" name="image1"></label>
<label>Image 2<input type="file" name="image2"></label>
<button type="submit">Add</button>
</form>
</section>

<?php if($edit){ ?>
<section class="panel">
<h2>Edit Card</h2>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="update">
<input type="hidden" name="id" value="<?php echo (int)$edit['id']; ?>">

<label>Title<input name="title" value="<?php echo htmlspecialchars($edit['title']); ?>" required></label>
<label>Description<textarea name="description" rows="5" required><?php echo htmlspecialchars($edit['description']); ?></textarea></label>

<label>Image 1<input type="file" name="image1"></label>
<?php if($edit['image_path_1']): ?>
<img src="<?php echo 'https://dcsschools.com/'.$edit['image_path_1']; ?>" style="max-height:150px"><br>
<label><input type="checkbox" name="remove_image1" value="1"> Remove Image 1</label>
<?php endif; ?>

<label>Image 2<input type="file" name="image2"></label>
<?php if($edit['image_path_2']): ?>
<img src="<?php echo 'https://dcsschools.com/'.$edit['image_path_2']; ?>" style="max-height:150px"><br>
<label><input type="checkbox" name="remove_image2" value="1"> Remove Image 2</label>
<?php endif; ?>

<button type="submit">Update</button>
</form>
</section>
<?php } ?>

<section class="panel">
<h2>Cards</h2>
<div class="grid">
<?php foreach($cards as $c){ ?>
<div class="card">
<div style="display:flex;gap:10px;">
<?php if($c['image_path_1']): ?>
<img src="<?php echo 'https://dcsschools.com/'.$c['image_path_1']; ?>" style="width:50%;">
<?php endif; ?>
<?php if($c['image_path_2']): ?>
<img src="<?php echo 'https://dcsschools.com/'.$c['image_path_2']; ?>" style="width:50%;">
<?php endif; ?>
</div>
<div class="card-body">
<div class="card-title"><?php echo htmlspecialchars($c['title']); ?></div>
<div class="card-meta"><?php echo htmlspecialchars(mb_substr($c['description'],0,120)); ?>...</div>
<a class="btn-danger" href="?delete=<?php echo $c['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
<a class="btn" href="?edit=<?php echo $c['id']; ?>">Edit</a>
</div>
</div>
<?php } ?>
</div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
