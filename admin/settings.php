<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_admin();
$pdo = db();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['action']) ? $_POST['action'] : '') === 'settings') {
  $email = isset($_POST['email']) ? trim($_POST['email']) : '';
  $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
  $address = isset($_POST['address']) ? trim($_POST['address']) : '';
  $st = $pdo->prepare('UPDATE settings SET email = ?, phone = ?, address = ? WHERE id = 1');
  $st->execute([$email !== '' ? $email : null, $phone !== '' ? $phone : null, $address !== '' ? $address : null]);
  set_flash('Settings saved');
  redirect_to('dcsschools.com/admin/settings.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['action']) ? $_POST['action'] : '') === 'social_add') {
  $url = isset($_POST['url']) ? trim($_POST['url']) : '';
  $icon_path = '';
  if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);
    $name = uniqid('s_', true) . '.' . strtolower($ext);
    $dir = __DIR__ . '/../assets/upload/social';
    if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
    @chmod($dir, 0775);
    if (!is_writable($dir)) { @chmod($dir, 0777); }
    if (!is_writable($dir)) { $error = 'Upload directory is not writable: ' . htmlspecialchars($dir); }
    $dest = $dir . '/' . $name;
    if ($error === '' && is_uploaded_file($_FILES['icon']['tmp_name']) && move_uploaded_file($_FILES['icon']['tmp_name'], $dest)) {
      @chmod($dest, 0664);
      $icon_path = 'assets/upload/social/' . $name;
    } else {
      $error = 'Failed to upload icon. Please check permissions for assets/upload/social.';
    }
  }
  if ($icon_path !== '' && $url !== '') {
    $pdo->prepare('INSERT INTO social_links (icon_path, url) VALUES (?, ?)')->execute([$icon_path, $url]);
    set_flash('Social link added');
    redirect_to('dcsschools.com/admin/settings.php');
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['action']) ? $_POST['action'] : '') === 'social_update') {
  $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
  $url = isset($_POST['url']) ? trim($_POST['url']) : '';
  $st = $pdo->prepare('SELECT icon_path FROM social_links WHERE id = ?');
  $st->execute([$id]);
  $row = $st->fetch();
  $icon = $row ? (isset($row['icon_path']) ? $row['icon_path'] : null) : null;
  if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);
    $name = uniqid('s_', true) . '.' . strtolower($ext);
    $dir = __DIR__ . '/../assets/upload/social';
    if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
    @chmod($dir, 0775);
    if (!is_writable($dir)) { @chmod($dir, 0777); }
    $dest = $dir . '/' . $name;
    if (is_uploaded_file($_FILES['icon']['tmp_name']) && move_uploaded_file($_FILES['icon']['tmp_name'], $dest)) {
      @chmod($dest, 0664);
      if ($icon) {
        $old = __DIR__ . '/../' . $icon;
        if (is_file($old)) @unlink($old);
      }
      $icon = 'assets/upload/social/' . $name;
    }
  }
  if ($id && $url !== '') {
    $u = $pdo->prepare('UPDATE social_links SET url = ?, icon_path = ? WHERE id = ?');
    $u->execute([$url, $icon !== '' ? $icon : null, $id]);
    set_flash('Social link updated');
    // var_dump('in here');exit;
    redirect_to("dcsschools.com/admin/settings.php");
  }
}

if (isset($_GET['social_delete'])) {
  $id = (int)$_GET['social_delete'];
  $st = $pdo->prepare('SELECT icon_path FROM social_links WHERE id = ?');
  $st->execute([$id]);
  $row = $st->fetch();
  $pdo->prepare('DELETE FROM social_links WHERE id = ?')->execute([$id]);
  if ($row && $row['icon_path']) {
    $file = __DIR__ . '/../' . $row['icon_path'];
    if (is_file($file)) @unlink($file);
  }
  set_flash('Social link deleted');
  redirect_to('dcsschools.com/admin/settings.php');
}

$s = $pdo->query('SELECT * FROM settings WHERE id = 1')->fetch();
$links = $pdo->query('SELECT * FROM social_links ORDER BY id DESC')->fetchAll();
$edit = null;
if (isset($_GET['social_edit'])) {
  $eid = (int)$_GET['social_edit'];
  $s2 = $pdo->prepare('SELECT * FROM social_links WHERE id = ?');
  $s2->execute([$eid]);
  $edit = $s2->fetch() ?: null;
}
$page_title = 'Settings';
ob_start();
?>
<section class="panel"><h2>Contact</h2><form method="post"><input type="hidden" name="action" value="settings"><label>Email<input name="email" value="<?php echo isset($s['email']) ? htmlspecialchars($s['email']) : '' ?>"></label><label>Phone<input name="phone" value="<?php echo isset($s['phone']) ? htmlspecialchars($s['phone']) : '' ?>"></label><label>Address<textarea name="address"><?php echo isset($s['address']) ? htmlspecialchars($s['address']) : '' ?></textarea></label><button type="submit">Save</button></form></section>
<section class="panel"><h2>Social Links</h2><?php if($error){echo '<div class="error">'.htmlspecialchars($error).'</div>'; } ?><form method="post" enctype="multipart/form-data"><input type="hidden" name="action" value="social_add"><label>Icon<input name="icon" type="file" accept="image/*"></label><label>URL<input name="url" placeholder="https://..."></label><button type="submit">Add</button></form>
<div class="list">
<?php foreach($links as $l){ echo '<div class="row">'.($l['icon_path']?'<img src="https://dcsschools.com/'.htmlspecialchars($l['icon_path']).'" alt="" style="width:24px;height:24px;object-fit:contain">':'').'<a href="'.htmlspecialchars($l['url']).'" target="_blank">'.htmlspecialchars($l['url']).'</a><a class="btn-danger" href="/admin/settings.php?social_delete='.$l['id'].'">Delete</a> <button type="button" data-modal="modal-edit-social" data-id="'.(int)$l['id'].'" data-url="'.htmlspecialchars($l['url']).'">Edit</button></div>'; } ?>
</div></section>
<div class="modal" id="modal-edit-social" style="display:none"><header><h3>Edit Social Link</h3><button class="modal-close" type="button">Close</button></header><form method="post" enctype="multipart/form-data"><input type="hidden" name="action" value="social_update"><input type="hidden" name="id" data-fill="id"><label>Icon<input name="icon" type="file" accept="image/*"></label><label>URL<input name="url" data-fill="url" placeholder="https://..."></label><button type="submit">Update</button></form></div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
