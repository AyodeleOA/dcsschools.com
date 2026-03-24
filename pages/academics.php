<?php
require_once __DIR__ . '/../admin/db.php';
$pdo = db();
$settings = array();
$social_links = array();
try {
  $settings = $pdo->query('SELECT * FROM settings WHERE id = 1')->fetch(PDO::FETCH_ASSOC);
  $social_links = $pdo->query('SELECT * FROM social_links ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
}

function nav_active($file)
{
  return basename($_SERVER['SCRIPT_NAME']) === $file ? 'nav-link-active' : '';
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <link rel="stylesheet" href="../assets/css/master.css" />
  <link rel="stylesheet" href="../assets/css/academics.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="icon" type="image/png" href="../assets/images/fav.svg">
 
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<body>

     <header class="main-header">
    <div class="header-container">
      <a href="homepage" class="logo">
        <img src="../assets/images/logo.png" style="width:250px" alt="Divine Confidence School" class="logo-img">
      </a>
      <nav class="nav-menu">
        <a href="https://dcsschools.com/" class="nav-link">Home</a>
        <a href="https://dcsschools.com/pages/about.php" class="nav-link">About Us</a>
        <a href="https://dcsschools.com/pages/academics.php" class="nav-link nav-link-active">Academics</a>
        <a href="https://dcsschools.com/pages/contact.php" class="nav-link">Contact Us</a>
      </nav>
      <a href="https://dcsschools.com/pages/enrollment.php" class="btn-enroll-header">Enroll Now &rarr;</a>
      <button class="mobile-menu-btn" aria-label="Toggle Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </header>

  <section class="academics-overview">
    <div class="container">
      <h2 class="section-title-left reveal fade-up">Overview of Our Academic Programme</h2>
      <div class="overview-text reveal fade-up" style="--delay: .06s">
        <p>At Divine Confidence School, our academic framework is thoughtfully built on a dual-curriculum system that integrates the Nigerian and British curricula. This deliberate blend allows us to deliver an education that is academically rigorous, morally grounded, and relevant in an increasingly global world. Our goal is to raise learners who are confident in knowledge, strong in character, and well prepared for future academic and life challenges.</p>
        <p>The Nigerian curriculum, guided by the Nigerian National Policy on Education, provides a solid educational foundation by emphasizing literacy, numeracy, critical thinking, creativity, and responsible decision-making. It is designed to help learners understand their environment, develop problem-solving skills, and apply knowledge in practical and meaningful ways. This curriculum also reinforces discipline, civic responsibility, and moral values that are essential for personal and societal growth.</p>
        <p>Complementing this is the British curriculum, which broadens students’ academic exposure through higher-order cognitive learning and internationally benchmarked standards. Through this framework, pupils and students are encouraged to think analytically, communicate effectively, and engage with global perspectives. The British curriculum supports independent learning, inquiry, and academic depth, preparing learners for international opportunities and global competitiveness.</p>
        <p>By combining the strengths of both curricula, Divine Confidence School ensures that learners are thoroughly prepared for national and international examinations. This balanced approach enables our students to compete confidently at both local and global levels, while developing discipline, integrity, and strong moral values that guide them beyond the classroom.</p>
      </div>
    </div>
  </section>

  <?php
  $academic_cards = [];
  try {
    $stmt = $pdo->query("SELECT * FROM academic_cards ORDER BY sort_order ASC");
    $academic_cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    // Handle error gracefully or log it
  }

  foreach ($academic_cards as $card):
  ?>
  <section class="academics-track">
    <div class="container">
      <h2 class="section-title-left reveal fade-up"><?php echo htmlspecialchars($card['title']); ?></h2>
      <div class="track-text reveal fade-up" style="--delay: .06s">
        <?php 
        $paragraphs = explode("\n\n", $card['description']);
        foreach ($paragraphs as $p) {
            echo '<p>' . htmlspecialchars($p) . '</p>';
        }
        ?>
      </div>
      <div class="gallery-row reveal fade-up" style="--delay: .06s">
        <?php if (!empty($card['image_path_1'])): ?>
        <div class="gallery-card reveal zoom-in" style="--delay: .08s"><img src="../<?php echo htmlspecialchars($card['image_path_1']); ?>" alt="<?php echo htmlspecialchars($card['title']); ?> 1"></div>
        <?php endif; ?>
        <?php if (!empty($card['image_path_2'])): ?>
        <div class="gallery-card reveal zoom-in" style="--delay: .12s"><img src="../<?php echo htmlspecialchars($card['image_path_2']); ?>" alt="<?php echo htmlspecialchars($card['title']); ?> 2"></div>
        <?php endif; ?>
      </div>
      <div class="track-cta"><a href="https://dcsschools.com/pages/enrollment.php" class="btn-enroll-academics reveal fade-up" style="--delay: .1s">Enroll Now &rarr;</a></div>
    </div>
  </section>
  <?php endforeach; ?>

  <section class="academics-info">
    <div class="container">
      <h2 class="section-title-left reveal fade-up">Academics & Curriculum</h2>
      <div class="track-text reveal fade-up" style="--delay: .06s">
        <p>Born out of vision, Divine Confidence College is the Secondary arm of Divine Confidence Nursery and Primary school, with the sole aim to produce the whole student. Following our experience and outstanding results in the Nursery and Primary arms, Divine Confidence College was birthed.</p>
        <p>DCC is a Christian based co-educational school, built on the principles of God Almighty and where Christian practices are greatly emphasized. Through our curricular, the school is poised to produce the caliber of students who have undergone both spiritual and academic mentorship, with the instillation of correct societal values in the student.</p>
        <p>DCC ensures that her students are equipped with basic skills, including soft skills, required to adapt to any environment they go to. Just as we put God first, every student is taught to recognize the God-factor in every activity undertaken. With carefully selected qualified, professional staff members and infrastructures, DCC is set to bring out the best in every student because we recognize that every child is a threshold of potentials.</p>
        <p>DCC is co-educational and regardless of your background, religion and race, you are welcome to have a wonderful DCC experience.</p>
      </div>
      <h2 class="section-title-left">Co-Curricular and Extracurricular Activities</h2>
      <div class="activities-grid reveal fade-up" style="--delay: .06s">
        <div class="activities-col reveal fade-up" style="--delay: .08s">
          <h3>Sports and Physical Activities</h3>
          <ul class="activities-list">
            <li>Football</li>
            <li>Volleyball</li>
            <li>Handball</li>
            <li>Swimming</li>
          </ul>
        </div>
        <div class="activities-col reveal fade-up" style="--delay: .12s">
          <h3>Clubs and Recreational Activities</h3>
          <ul class="activities-list">
            <li>Dance and Drama</li>
            <li>Music Club</li>
            <li>Board Games</li>
            <li>Boys’ Scout and Girls’ Guide</li>
            <li>Red Cross</li>
            <li>Taekwondo</li>
          </ul>
        </div>

       
      </div>
       <div class="gallery-row reveal fade-up" style="--delay: .06s">
          <div class="gallery-card reveal zoom-in" style="--delay: .08s"><img src="../assets/images/extra1.png" alt="Secondary 1"></div>
          <div class="gallery-card reveal zoom-in" style="--delay: .12s"><img src="../assets/images/extra2.png" alt="Secondary 2"></div>
          <div class="gallery-card reveal zoom-in" style="--delay: .16s"><img src="../assets/images/extra3.png" alt="Secondary 3"></div>
        </div>
    </div>
  </section>

     <footer class="site-footer">
    <div class="footer-main reveal fade-up">
      <!-- Col 1: Logo & Info -->
      <div class="footer-col footer-col-info reveal fade-up" style="--delay: .06s">
        <div class="footer-logo reveal zoom-in" style="--delay: .1s">
          <img src="../assets/images/logo.png" style="width:250px" alt="Divine Confidence School" class="footer-logo-img">
        </div>
        <p class="footer-desc reveal fade-up" style="--delay: .14s">
          Divine Confidence School (DCS) is a co-educational, Christian-based institution committed to raising well-rounded students
        </p>
        <div class="footer-social reveal fade-up" style="--delay: .18s">
          <div class="social-links reveal fade-up" style="--delay: .22s">
            <?php foreach ($social_links as $link): ?>
              <?php
              $url = $link['url'] ?? '#';
              $icon = $link['icon_path'] ?? '';
              if (empty($icon)) continue;
              ?>
              <a href="<?php echo htmlspecialchars($url); ?>" target="_blank">
                <img src="https://dcsschools.com/<?php echo htmlspecialchars($icon); ?>" alt="Social Link">
              </a>
            <?php endforeach; ?>
          </div>

          <style>
            /* Wrapper (optional but recommended) */
            .social-links {
              display: flex;
              gap: 12px;
              align-items: center;
            }

            /* Anchor reset */
            .social-links a {
              display: inline-flex;
              align-items: center;
              justify-content: center;
              text-decoration: none;
            }

            /* ICON IMAGE FIX */
            .social-links a img {
              display: block;
              /* Prevent inline image collapse */
              width: 24px;
              /* Force visible size */
              height: 24px;
              object-fit: contain;
              /* Prevent distortion */
              opacity: 1;
              visibility: visible;
              max-width: 100%;
            }
          </style>
        </div>
      </div>

      <!-- Col 2: Academics -->
      <div class="footer-col reveal fade-up" style="--delay: .1s">
        <h3 class="footer-col-title">Academics</h3>
        <ul class="footer-links">
          <li><a href="https://dcsschools.com/pages/academics.php">Preschool</a></li>
          <li><a href="https://dcsschools.com/pages/academics.php">Primary School</a></li>
          <li><a href="https://dcsschools.com/pages/academics.php">Secondary School</a></li>
          <li><a href="https://dcsschools.com/pages/academics.php">Co and Extracurricular</a></li>
        </ul>
      </div>

      <!-- Col 3: Information -->
      <div class="footer-col reveal fade-up" style="--delay: .14s">
        <h3 class="footer-col-title">Information</h3>
        <ul class="footer-links">
          <li><a href="https://dcsschools.com/pages/about.php">Our Community</a></li>
          <li><a href="https://dcsschools.com/pages/about.php">About Us</a></li>
          <li><a href="https://dcsschools.com/pages/contact.php">Contact Us</a></li>
          <li><a href="https://dcsschools.com/pages/about.php">Brief History</a></li>
        </ul>
      </div>

      <!-- Col 4: Talk To Us -->
      <div class="footer-col reveal fade-up" style="--delay: .18s">
        <h3 class="footer-col-title">Talk To Us</h3>
        <p class="contact-subtitle">Got Questions? Call us</p>
        <a href="tel:<?php echo isset($settings['phone']) ? htmlspecialchars($settings['phone']) : '+2348179611109'; ?>" class="contact-big-phone reveal fade-up" style="--delay: .22s"><?php echo isset($settings['phone']) ? htmlspecialchars($settings['phone']) : '+234 817 961 1109'; ?></a>
        <div class="contact-list reveal fade-up" style="--delay: .26s">
          <div class="contact-row reveal fade-up" style="--delay: .3s">
            <img src="../assets/images/mail.png" class="footer-icon" alt="Email">
            <a href="mailto:<?php echo isset($settings['email']) ? htmlspecialchars($settings['email']) : 'info@dcsschools.com'; ?>"><?php echo isset($settings['email']) ? htmlspecialchars($settings['email']) : 'info@dcsschools.com'; ?></a>
          </div>
          <div class="contact-row reveal fade-up" style="--delay: .34s">
            <img src="../assets/images/location.png" class="footer-icon" alt="Location">
            <span><?php echo isset($settings['address']) ? nl2br(htmlspecialchars($settings['address'])) : '60/62 Abaranje Rd, Ikotun Rd,<br>Ikotun, Lagos, 102213,<br>Lagos.'; ?></span>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p class="footer-copyright reveal fade-up">Copyright © 2026 <span class="highlight">Divine Confidence School</span> All Rights Reserved</p>
    </div>
  </footer>

  <script src="../assets/js/script.js"></script>
</body>

</html>
