<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_admin();
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['action']) ? $_POST['action'] : '') === 'add') {
  $q = isset($_POST['question']) ? trim($_POST['question']) : '';
  $a = isset($_POST['answer']) ? trim($_POST['answer']) : '';
  if ($q !== '' && $a !== '') {
    $st = $pdo->prepare('INSERT INTO faqs (question, answer, sort_order) VALUES (?, ?, ?)');
    $st->execute([$q, $a, 0]);
    set_flash('FAQ added');
    redirect_to('dcsschools.com/admin/faqs.php');
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['action']) ? $_POST['action'] : '') === 'update') {
  $id = (int)(isset($_POST['id']) ? $_POST['id'] : 0);
  $q = isset($_POST['question']) ? trim($_POST['question']) : '';
  $a = isset($_POST['answer']) ? trim($_POST['answer']) : '';
  if ($id && $q !== '' && $a !== '') {
    $u = $pdo->prepare('UPDATE faqs SET question = ?, answer = ? WHERE id = ?');
    $u->execute([$q, $a, $id]);
    set_flash('FAQ updated');
    redirect_to('dcsschools.com/admin/faqs.php');
  }
}

if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $pdo->prepare('DELETE FROM faqs WHERE id = ?')->execute([$id]);
  set_flash('FAQ deleted');
  redirect_to('dcsschools.com/admin/faqs.php');
}

$items = $pdo->query('SELECT * FROM faqs ORDER BY sort_order, id DESC')->fetchAll();
$edit = null;
if (isset($_GET['edit'])) {
  $eid = (int)$_GET['edit'];
  $s = $pdo->prepare('SELECT * FROM faqs WHERE id = ?');
  $s->execute([$eid]);
  $edit = $s->fetch() ?: null;
}
$page_title = 'Manage FAQs';
ob_start();
?>
<section class="panel"><h2>Add FAQ</h2><form method="post"><input type="hidden" name="action" value="add"><label>Question<input name="question" required></label><label>Answer<textarea name="answer" required></textarea></label><button type="submit">Add</button></form></section>
<?php if($edit){ ?>
<section class="panel"><h2>Edit FAQ</h2><form method="post"><input type="hidden" name="action" value="update"><input type="hidden" name="id" value="<?php echo (int)$edit['id']; ?>"><label>Question<input name="question" value="<?php echo htmlspecialchars($edit['question']); ?>" required></label><label>Answer<textarea name="answer" required><?php echo htmlspecialchars($edit['answer']); ?></textarea></label><button type="submit">Update</button></form></section>
<?php } ?>
<section class="panel"><h2>FAQs</h2><div class="list">
<?php foreach($items as $f){ echo '<div class="row"><div class="cell">'.htmlspecialchars($f['question']).'</div><div class="cell">'.htmlspecialchars(mb_substr($f['answer'],0,120)).'...</div><a class="btn-danger" href="https://dcsschools.com/admin/faqs.php?delete='.$f['id'].'">Delete</a> <button type="button" data-modal="modal-edit-faq" data-id="'.(int)$f['id'].'" data-question="'.htmlspecialchars($f['question']).'" data-answer="'.htmlspecialchars($f['answer']).'">Edit</button></div>'; } ?>
</div></section>
<div class="modal" id="modal-edit-faq" style="display:none"><header><h3>Edit FAQ</h3><button class="modal-close" type="button">Close</button></header><form method="post"><input type="hidden" name="action" value="update"><input type="hidden" name="id" data-fill="id"><label>Question<input name="question" data-fill="question" required></label><label>Answer<textarea name="answer" data-fill="answer" required></textarea></label><button type="submit">Update</button></form></div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
