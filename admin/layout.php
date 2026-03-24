<?php
require_once __DIR__ . '/auth.php';
?>
<!doctype html><html><head><meta charset="utf-8"><title><?php echo htmlspecialchars(isset($page_title) ? $page_title : 'Admin'); ?></title><link rel="stylesheet" href="https://dcsschools.com/assets/css/admin.css"></head><body>
<div class="admin-shell" id="admin-shell">
  <aside class="sidebar">
    <div class="brand"><img class="brand-logo" style="width:200px" src="https://dcsschools.com/assets/images/logo.png" alt="Logo"></div>
    <nav class="side-nav">
      <a href="https://dcsschools.com/admin/index.php">Dashboard</a>
      <a href="https://dcsschools.com/admin/gallery.php">Gallery</a>
      <a href="https://dcsschools.com/admin/academics.php">Academics</a>
      <a href="https://dcsschools.com/admin/faqs.php">FAQs</a>
      <a href="https://dcsschools.com/admin/enrollments.php">Enrollments</a>
      <a href="https://dcsschools.com/admin/contacts.php">Contact Messages</a>
      <a href="https://dcsschools.com/admin/settings.php">Settings</a>
      <a href="https://dcsschools.com/admin/logout.php">Logout</a>
    </nav>
  </aside>
  <main class="content">
    <header class="topbar"><button class="menu-toggle" id="menu-toggle" aria-label="Toggle Menu">☰</button><h1><?php echo htmlspecialchars(isset($page_title) ? $page_title : 'Admin'); ?></h1></header>
    <?php $flash = pop_flash(); if($flash){ $cls = $flash['type'] === 'success' ? 'success' : 'error'; echo '<div class="'.$cls.'">'.htmlspecialchars($flash['message']).'</div>'; } ?>
    <?php echo isset($content) ? $content : ''; ?>
  </main>
</div>
<div class="modal-backdrop" id="modal-backdrop" style="display:none"></div>
<script>
(function(){
  var shell = document.getElementById('admin-shell');
  var toggle = document.getElementById('menu-toggle');
  if(toggle){ toggle.addEventListener('click', function(){ shell.classList.toggle('sidebar-hidden'); }); }
  document.addEventListener('click', function(e){
    var a = e.target.closest('a');
    if(a && a.classList.contains('btn-danger')){
      if(!confirm('Are you sure you want to delete this item?')){ e.preventDefault(); }
    }
    var btn = e.target.closest('[data-modal]');
    if(btn){
      var target = btn.getAttribute('data-modal');
      var m = document.getElementById(target);
      if(m){
        var b = document.getElementById('modal-backdrop');
        m.style.display = 'block';
        b.style.display = 'block';
        var fill = btn.dataset;
        var inputs = m.querySelectorAll('[data-fill]');
        inputs.forEach(function(inp){ var k = inp.getAttribute('data-fill'); if(k && fill[k] !== undefined){ if(inp.tagName==='INPUT' || inp.tagName==='TEXTAREA'){ inp.value = fill[k]; } } });
      }
    }
    if(e.target.classList.contains('modal-close')){
      var m2 = e.target.closest('.modal');
      var b2 = document.getElementById('modal-backdrop');
      if(m2){ m2.style.display = 'none'; }
      if(b2){ b2.style.display = 'none'; }
    }
    if(e.target.id === 'modal-backdrop'){
      document.querySelectorAll('.modal').forEach(function(m){ m.style.display='none'; });
      e.target.style.display='none';
    }
  });
})();
</script>
</body></html>
