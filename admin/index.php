<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_admin();
$pdo = db();
$row = $pdo->query('SELECT COUNT(*) AS c FROM gallery_items')->fetch();
$galleryCount = isset($row['c']) ? (int)$row['c'] : 0;
$row = $pdo->query('SELECT COUNT(*) AS c FROM academic_cards')->fetch();
$academicCount = isset($row['c']) ? (int)$row['c'] : 0;
$row = $pdo->query('SELECT COUNT(*) AS c FROM contact_messages')->fetch();
$contactCount = isset($row['c']) ? (int)$row['c'] : 0;
$row = $pdo->query('SELECT COUNT(*) AS c FROM faqs')->fetch();
$faqCount = isset($row['c']) ? (int)$row['c'] : 0;
$row = $pdo->query('SELECT COUNT(*) AS c FROM enrollments')->fetch();
$enrollmentCount = isset($row['c']) ? (int)$row['c'] : 0;
$page_title = 'Dashboard';
ob_start();
?>
<section class="summary">
  <div class="summary-card">
    <div class="summary-icon" style="background:#e0f2fe; color:#0284c7;">📸</div>
    <div class="summary-info">
        <div class="summary-title">Gallery Items</div>
        <div class="summary-value"><?php echo $galleryCount; ?></div>
        <a class="summary-link" href="https://dcsschools.com/admin/gallery.php">Manage &rarr;</a>
    </div>
  </div>
  <div class="summary-card">
    <div class="summary-icon" style="background:#fef3c7; color:#d97706;">🎓</div>
    <div class="summary-info">
        <div class="summary-title">Academic Cards</div>
        <div class="summary-value"><?php echo $academicCount; ?></div>
        <a class="summary-link" href="https://dcsschools.com/admin/academics.php">Manage &rarr;</a>
    </div>
  </div>
  <div class="summary-card">
    <div class="summary-icon" style="background:#dcfce7; color:#16a34a;">📝</div>
    <div class="summary-info">
        <div class="summary-title">Enrollments</div>
        <div class="summary-value"><?php echo $enrollmentCount; ?></div>
        <a class="summary-link" href="https://dcsschools.com/admin/enrollments.php">Manage &rarr;</a>
    </div>
  </div>
  <div class="summary-card">
    <div class="summary-icon" style="background:#fee2e2; color:#dc2626;">✉️</div>
    <div class="summary-info">
        <div class="summary-title">Messages</div>
        <div class="summary-value"><?php echo $contactCount; ?></div>
        <a class="summary-link" href="https://dcsschools.com/admin/contacts.php">Manage &rarr;</a>
    </div>
  </div>
  <div class="summary-card">
    <div class="summary-icon" style="background:#f3e8ff; color:#9333ea;">❓</div>
    <div class="summary-info">
        <div class="summary-title">FAQs</div>
        <div class="summary-value"><?php echo $faqCount; ?></div>
        <a class="summary-link" href="https://dcsschools.com/admin/faqs.php">Manage &rarr;</a>
    </div>
  </div>
</section>
<section class="panel">
    <h2>Welcome to Admin Dashboard</h2>
    <p>Here you can manage all aspects of the Divine Confidence School website. Select a section from the cards above or the sidebar menu to get started.</p>
</section>

<style>
.summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.summary-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border: 1px solid #eee;
    transition: transform 0.2s, box-shadow 0.2s;
}
.summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.summary-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
.summary-info {
    flex: 1;
}
.summary-title {
    font-size: 13px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}
.summary-value {
    font-size: 28px;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.2;
    margin-bottom: 4px;
}
.summary-link {
    font-size: 13px;
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
}
.summary-link:hover {
    text-decoration: underline;
}
</style>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
