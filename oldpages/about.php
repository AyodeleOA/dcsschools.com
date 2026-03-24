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
  <title>About Us - Divine Confidence School</title>
  <link rel="stylesheet" href="../assets/css/master.css" />
  <link rel="stylesheet" href="../assets/css/about.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
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
        <a href="https://dcsschools.com/" class="nav-link ">Home</a>
        <a href="https://dcsschools.com/pages/about.php" class="nav-link nav-link-active">About Us</a>
        <a href="https://dcsschools.com/pages/academics.php" class="nav-link">Academics</a>
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

  <section class="about-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>Welcome to <span class="highlight-yellow">Divine Confidence School</span></h1>
      <p>
        Divine Confidence Nursery, Primary and Secondary School has spanned over 11 years, with excellent academic achievements, result-oriented club activities, sporting engagements and emphasis on sound moral upbringing, which have endeared parents to enroll their children/wards. The same zeal is going into the secondary school for more outstanding results.
      </p>
      <a href="https://dcsschools.com/pages/enrollment.php" class="btn-hero-enroll" target="_blank" rel="noopener">Apply for Admission &rarr;</a>
    </div>
  </section>

  <section class="who-we-are-section">
    <div class="container">
      <h2 class="section-title-left">Who We Are</h2>
      <div class="who-we-are-text">
        <p>Born out of vision, <strong>Divine Confidence College</strong> is the Secondary arm of <strong>Divine Confidence Nursery and Primary school</strong>, with the sole aim to produce the whole student. Following our experience and outstanding results in the Nursery and Primary arms, Divine Confidence College was birthed.</p>
        <p>DCC is a Christian based co-educational school, built on the principles of God Almighty and where Christian practices are greatly emphasized. Through our curricular, the school is poised to produce the caliber of students who have undergone both spiritual and academic mentorship, with the instillation of correct societal values in the student.</p>
        <p>DCC ensures that her students are equipped with basic skills, including soft skills, required to adapt to any environment they go to. Just as we put God first, every student is taught to recognize the God-factor in every activity undertaken. With carefully selected qualified, professional staff members and infrastructures, DCC is set to bring out the best in every student because we recognize that every child is a threshold of potentials.</p>
        <p>DCC is co-educational and regardless of your background, religion and race, you are welcome to have a wonderful DCC experience.</p>
      </div>
    </div>
  </section>

  <section class="history-section">
    <div class="container history-grid">
      <div class="history-content">
        <h2 class="section-title-left">Brief History</h2>
        <p>Divine Confidence School was established in September 2009 by the grace of God the Almighty upon the visioneer <strong>Mrs. Folashade Johnson.</strong></p>
        <p>The school was born out of her profound passion for qualitative, sound and affordable all round education that is devoid of any form of discrimination and inequality for the school age children in Ikotun - Abaranje and all her environs.</p>
        <p>This passion for the provision of such education became a compulsion because of the disparity noticed in the performances of children in the environment when compared to their affluent counterparts in other areas.</p>
        <p>In the light of this, the need to set up a standard school that is uniquely child centred and equipped with the capacity to develop maximally the three major domains of child development became a non negotiable necessity.</p>
        <p>The school gate was however opened for her first set of pupils on the 15th of September, 2009 with 2 pioneer pupils: Joy Oluwakanyinsola Johnson and Oladimeji Temiloluwa.</p>
      </div>
      <div class="history-image">
        <img src="../assets/images/sign.png" alt="Divine Confidence School Building">
      </div>
    </div>
  </section>

  <section class="values-section">
    <div class="container values-grid">
      <div class="value-card">
        <h3>Mission</h3>
        <p>To Provide an all-inclusive teaching and modeling with the fear of God to produce inspirational, focused and visionary leaders of the future.</p>
      </div>
      <div class="value-card">
        <h3>Vision</h3>
        <p>To foster spiritual, physical and emotional developments in every child.</p>
      </div>
      <div class="value-card">
        <h3>Core Values</h3>
        <p>Vision, Child-centredness, respect, integrity, passion and excellence.</p>
      </div>
    </div>
  </section>

  <section class="proprietress-section">
    <div class="container">
      <h2 class="section-title-center">Welcome Address from the Proprietress</h2>
      <div class="proprietress-content">
        <div class="proprietress-text">
          <p><strong>Welcome to Divine Confidence Nursery and Primary School.</strong></p>
          <p>Divine Confidence is a school founded on faith, purpose, and a deep commitment to raising children who are confident in character, strong in values, and sound in learning. From the very beginning, our focus has been on combining moral upbringing with academic excellence, ensuring that every child entrusted to us receives a balanced and meaningful education.</p>
          <p>We believe that the foundation of true learning begins with the fear of God, respect for others, and a strong sense of responsibility. These values guide our teaching, our relationships, and our daily interactions with our pupils. Beyond academics, we are intentional about shaping attitudes, building confidence, and preparing our children to face each stage of life with wisdom and courage.</p>
          <p>At Divine Confidence, we value the partnership between the school and the home. We work closely with parents and guardians to create a supportive environment where children can thrive both academically and morally. This shared responsibility allows us to nurture discipline, good study habits, and positive character traits that stay with our pupils long after they leave our classrooms.</p>
          <p>Our dedicated teachers are committed to continuous growth and effective teaching practices, ensuring that each child is taught with care, patience, and excellence. Through a broad curriculum and enriching extracurricular activities, we give our pupils opportunities to discover their talents, develop their abilities, and grow holistically.</p>
          <p>We are encouraged by the progress of our pupils and the positive testimonies that follow them as they advance in their educational journey. These outcomes reaffirm our belief that when children are guided with love, discipline, and godly values, excellence naturally follows.</p>
          <p>I warmly invite you to become part of the Divine Confidence family, where faith, learning, and character development come together to build a solid foundation for the future, with God at the center of it all.</p>
          <div class="proprietress-sign">
            <h4>Mrs. Folashade Johnson</h4>
            <span>Proprietress</span>
          </div>
        </div>
        <div class="proprietress-image">
          <img src="../assets/images/pro.png" alt="Mrs. Folashade Johnson">
        </div>
      </div>
    </div>
  </section>

  <section class="academics-curriculum-section">
    <div class="container">
      <h2 class="section-title-left">Academics & Curriculum</h2>
      <div class="academics-text">
        <p>Born out of vision, <strong>Divine Confidence College</strong> is the Secondary arm of <strong>Divine Confidence Nursery and Primary school</strong>, with the sole aim to produce the whole student. Following our experience and outstanding results in the Nursery and Primary arms, Divine Confidence College was birthed.</p>
        <p>DCC is a Christian based co-educational school, built on the principles of God Almighty and where Christian practices are greatly emphasized. Through our curricular, the school is poised to produce the caliber of students who have undergone both spiritual and academic mentorship, with the instillation of correct societal values in the student.</p>
        <p>DCC ensures that her students are equipped with basic skills, including soft skills, required to adapt to any environment they go to. Just as we put God first, every student is taught to recognize the God-factor in every activity undertaken. With carefully selected qualified, professional staff members and infrastructures, DCC is set to bring out the best in every student because we recognize that every child is a threshold of potentials.</p>
        <p>DCC is co-educational and regardless of your background, religion and race, you are welcome to have a wonderful DCC experience.</p>
      </div>
    </div>
  </section>

  <section class="community-section">
    <div class="container">
      <h2 class="section-title-center">Our Community</h2>
      <div class="community-intro">
        <p>DCC parades a community where the Christian orientation thrives. At DCC, the environment is conducive to ensure the students get the academic orientation and will make them able to face life challenges, providing solutions to them and fit in diverse environments.</p>
        <p>Well equipped infrastructures that include well equipped Science Laboratories, ICT room, Music room, Home-Economics laboratory etc. are put in place to ensure standardized tutoring to students, with effective supervision by staff, who are poised to engineer the creative abilities of the students.</p>
        <p>Just as we create a sound environment for the students, the parents are not left behind, as the vibrancy of the Parents' Partnership Forum (PPF) is geared towards the students' benefit.</p>
      </div>
      <div class="community-gallery">
        <div class="community-img-wrapper"><img src="../assets/images/abt1.png" alt="Community 1"></div>
        <div class="community-img-wrapper"><img src="../assets/images/abt2.png" alt="Community 2"></div>
        <div class="community-img-wrapper"><img src="../assets/images/abt3.png" alt="Community 3"></div>
      </div>
    </div>
  </section>

  <section class="cta-section">
    <div class="cta-container">
      <h2 class="cta-title">Give your child a confident start today</h2>
      <a href="https://dcsschools.com/pages/enrollment.php" class="btn-cta-enroll" target="_blank" rel="noopener">Enroll Now &rarr;</a>
    </div>
  </section>

   <footer class="site-footer">
    <div class="footer-main">
      <!-- Col 1: Logo & Info -->
      <div class="footer-col footer-col-info">
        <div class="footer-logo">
          <img src="../assets/images/logo.png" style="width:250px" alt="Divine Confidence School" class="footer-logo-img">
        </div>
        <p class="footer-desc">
          Divine Confidence School (DCS) is a co-educational, Christian-based institution committed to raising well-rounded students
        </p>
        <div class="footer-social">
          <div class="social-links">
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
      <div class="footer-col">
        <h3 class="footer-col-title">Academics</h3>
        <ul class="footer-links">
          <li><a href="https://dcsschools.com/pages/academics.php">Preschool</a></li>
          <li><a href="https://dcsschools.com/pages/academics.php">Primary School</a></li>
          <li><a href="https://dcsschools.com/pages/academics.php">Secondary School</a></li>
          <li><a href="https://dcsschools.com/pages/academics.php">Co and Extracurricular</a></li>
        </ul>
      </div>

      <!-- Col 3: Information -->
      <div class="footer-col">
        <h3 class="footer-col-title">Information</h3>
        <ul class="footer-links">
          <li><a href="#">Our Community</a></li>
          <li><a href="https://dcsschools.com/pages/about.php">About Us</a></li>
          <li><a href="https://dcsschools.com/pages/contact.php">Contact Us</a></li>
          <li><a href="https://dcsschools.com/pages/about.php">Brief History</a></li>
        </ul>
      </div>

      <!-- Col 4: Talk To Us -->
      <div class="footer-col">
        <h3 class="footer-col-title">Talk To Us</h3>
        <p class="contact-subtitle">Got Questions? Call us</p>
        <a href="tel:<?php echo isset($settings['phone']) ? htmlspecialchars($settings['phone']) : '+2348179611109'; ?>" class="contact-big-phone"><?php echo isset($settings['phone']) ? htmlspecialchars($settings['phone']) : '+234 817 961 1109'; ?></a>
        <div class="contact-list">
          <div class="contact-row">
            <img src="../assets/images/mail.png" class="footer-icon" alt="Email">
            <a href="mailto:<?php echo isset($settings['email']) ? htmlspecialchars($settings['email']) : 'info@dcsschools.com'; ?>"><?php echo isset($settings['email']) ? htmlspecialchars($settings['email']) : 'info@dcsschools.com'; ?></a>
          </div>
          <div class="contact-row">
            <img src="../assets/images/location.png" class="footer-icon" alt="Location">
            <span><?php echo isset($settings['address']) ? nl2br(htmlspecialchars($settings['address'])) : '60/62 Abaranje Rd, Ikotun Rd,<br>Ikotun, Lagos, 102213,<br>Lagos.'; ?></span>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p class="footer-copyright">Copyright © 2026 <span class="highlight">Divine Confidence School</span> All Rights Reserved</p>
    </div>
  </footer>

  <script src="assets/js/script.js"></script>
</body>

</html>