<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_admin();
$pdo = db();

if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $pdo->prepare('DELETE FROM contact_messages WHERE id = ?')->execute([$id]);
  set_flash('Message deleted');
  redirect_to('dcsschools.com/admin/contacts.php');
}

if (isset($_GET['mark'])) {
  $id = (int)$_GET['mark'];
  $pdo->prepare('UPDATE contact_messages SET is_read = 1 WHERE id = ?')->execute([$id]);
  set_flash('Message marked as read');
  redirect_to('dcsschools.com/admin/contacts.php');
}

$items = $pdo->query('SELECT * FROM contact_messages ORDER BY created_at DESC, id DESC')->fetchAll();
$page_title = 'Contact Messages';
ob_start();
?>
<section class="panel">
  <div class="panel-header">
    <h2>Contact Messages</h2>
    <span class="count"><?= count($items) ?> total</span>
  </div>

  <div class="table-wrapper">
    <table class="messages-table">
      <thead>
        <tr>
          <th>Sender</th>
          <th>Phone</th>
          <th>Message</th>
          <th>Date</th>
          <th>Status</th>
          <th class="actions">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $m): ?>
          <tr class="<?= $m['is_read'] ? 'read' : 'unread' ?>">
            <td>
              <strong><?= htmlspecialchars($m['name']) ?></strong><br>
              <small><?= htmlspecialchars($m['email']) ?></small>
            </td>
            <td><?= htmlspecialchars($m['phone']) ?></td>
            <td class="message">
              <?= htmlspecialchars(mb_substr($m['message'], 0, 150)) ?>…
            </td>
            <td><?= date('M d, Y H:i', strtotime($m['created_at'])) ?></td>
            <td>
              <span class="badge <?= $m['is_read'] ? 'badge-read' : 'badge-unread' ?>">
                <?= $m['is_read'] ? 'Read' : 'Unread' ?>
              </span>
            </td>
            <td class="actions">
              <?php if (!$m['is_read']): ?>
                <a class="btn btn-primary" href="?mark=<?= $m['id'] ?>">Mark Read</a>
              <?php endif; ?>
              <a class="btn btn-danger" href="?delete=<?= $m['id'] ?>"
                 onclick="return confirm('Delete this message?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
<style> 
/* PANEL */
.panel {
  background: #ffffff;
  border-radius: 14px;
  padding: 24px;
  box-shadow: 0 10px 30px rgba(0,0,0,.06);
}

.panel-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 18px;
}

.panel-header h2 {
  font-size: 22px;
  font-weight: 600;
  margin: 0;
}

.panel-header .count {
  background: #f1f5f9;
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 13px;
  color: #475569;
}

/* TABLE */
.table-wrapper {
  overflow-x: auto;
}

.messages-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.messages-table thead {
  background: #f8fafc;
}

.messages-table th {
  text-align: left;
  padding: 14px 12px;
  font-weight: 600;
  color: #334155;
  border-bottom: 1px solid #e5e7eb;
}

.messages-table td {
  padding: 14px 12px;
  vertical-align: top;
  border-bottom: 1px solid #f1f5f9;
}

.messages-table tr:hover {
  background: #f9fafb;
}

/* READ / UNREAD */
tr.unread {
  background: #f0f9ff;
}

tr.read {
  opacity: .9;
}

/* MESSAGE CELL */
td.message {
  max-width: 360px;
  color: #475569;
}

/* BADGES */
.badge {
  padding: 4px 10px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 500;
}

.badge-unread {
  background: #dbeafe;
  color: #1d4ed8;
}

.badge-read {
  background: #dcfce7;
  color: #166534;
}

/* ACTIONS */
.actions {
  white-space: nowrap;
}

.btn {
  display: inline-block;
  padding: 6px 12px;
  font-size: 13px;
  border-radius: 8px;
  text-decoration: none;
  transition: all .2s ease;
}

.btn-primary {
  background: #2563eb;
  color: #fff;
}

.btn-primary:hover {
  background: #1d4ed8;
}

.btn-danger {
  background: #fee2e2;
  color: #b91c1c;
}

.btn-danger:hover {
  background: #fecaca;
}

</style>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
