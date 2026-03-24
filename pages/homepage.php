<?php
require_once __DIR__ . '/../admin/db.php';
$pdo = db();
$academic_cards = array();
$gallery_items = array();
$settings = array();
$social_links = array();
try {
  $academic_cards = $pdo->query('SELECT * FROM academic_cards ORDER BY sort_order, id DESC')->fetchAll(PDO::FETCH_ASSOC);
  $gallery_items = $pdo->query('SELECT * FROM gallery_items ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
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
  <title>Divine Confidence School</title>
  <link rel="stylesheet" href="assets/css/master.css" />
  <link rel="stylesheet" href="assets/css/home.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/png" href="assets/images/fav.svg">
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<body>
  <canvas id="particles-canvas" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 999; pointer-events: none;"></canvas>

  <header class="main-header">
    <div class="header-container">
      <a href="homepage" class="logo">
        <img src="assets/images/logo.png" style="width:250px" alt="Divine Confidence School" class="logo-img">
      </a>
      <nav class="nav-menu">
        <a href="https://dcsschools.com/" class="nav-link nav-link-active">Home</a>
        <a href="https://dcsschools.com/pages/about.php" class="nav-link">About Us</a>
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

  <section class="hero-section">
    <div class="hero-content-wrapper">
      <div class="hero-text reveal fade-up">
        <h1 class="hero-title">Building <span class="highlight">Confident Minds</span> for Tomorrow</h1>
        <p class="hero-subtitle reveal fade-up" style="--delay: .06s">
          A safe, nurturing, and academically sound environment for Preschool, Primary, and Secondary education.
        </p>
        <div class="hero-buttons reveal fade-up" style="--delay: .12s">
          <a href="https://dcsschools.com/pages/enrollment.php" class="btn-primary" target="_blank" rel="noopener" style="--delay: .12s">
            Apply for Admission &rarr;
          </a>
          <a href="https://dcsschools.com/pages/about.php" class="btn-secondary" style="--delay: .18s">
            Learn More &rarr;
          </a>
        </div>
      </div>
      <div class="hero-image-container reveal zoom-in" style="--delay: .2s">
        <img src="assets/images/hero.png" alt="Students" class="hero-img reveal zoom-in" style="--delay: .24s">
      </div>
    </div>

    <div class="contact-strip">
      <div class="contact-strip-content reveal fade-up" style="--delay: .1s">
        <div class="contact-strip-item reveal slide-right" style="--delay: .12s">
          <img src="assets/images/svgs/phone.svg" alt="Phone" class="contact-icon">
          <span><?php echo isset($settings['phone']) ? htmlspecialchars($settings['phone']) : '+234 817 961 1109'; ?></span>
        </div>
        <div class="contact-strip-item reveal slide-right" style="--delay: .18s">
          <img src="assets/images/svgs/mail.svg" alt="Email" class="contact-icon">
          <span><?php echo isset($settings['email']) ? htmlspecialchars($settings['email']) : 'info@dcsschool.com'; ?></span>
        </div>
        <div class="contact-strip-item address-item reveal slide-right" style="--delay: .24s">
          <img src="assets/images/svgs/location.svg" alt="Address" class="contact-icon">
          <span><?php echo isset($settings['address']) ? htmlspecialchars($settings['address']) : '60/62 Abaranje Rd, Ikotun, Lagos'; ?></span>
        </div>
        <a href="https://dcsschools.com/pages/enrollment.php" class="btn-enroll-strip reveal fade-up" style="--delay: .3s">Enroll Now &rarr;</a>
      </div>
    </div>
  </section>

  <section class="welcome-section">
    <h2 class="section-title reveal fade-up">Welcome to Divine Confidence School</h2>
    <div class="welcome-text-container reveal fade-up" style="--delay: .06s">
      <p class="welcome-desc reveal fade-up" style="--delay: .12s">
        Divine Confidence School (DCS) is a co-educational, Christian-based institution committed to raising well-rounded students through sound academics, strong moral values, and purposeful mentorship.
      </p>
      <p class="welcome-desc reveal fade-up" style="--delay: .18s">
        Born out of a vision to nurture the whole child, Divine Confidence School provides a seamless learning journey across Preschool, Primary, and Secondary education, equipping students with the skills, character, and confidence needed to thrive in a dynamic world.
      </p>
    </div>

    <div class="proprietress-area reveal fade-up" style="--delay: .06s">
      <div class="proprietress-img-wrapper reveal zoom-in" style="--delay: .12s">
        <img src="assets/images/pro.png" alt="Proprietress" class="proprietress-img">
      </div>
      <a href="https://dcsschools.com/pages/about.php" class="btn-proprietress reveal fade-up" style="--delay: .18s">Read More from Proprietress | Johnson F. B &rarr;</a>
    </div>

    <div class="values-grid reveal fade-up" style="--delay: .06s">
      <div class="value-card reveal zoom-in" style="--delay: .08s">
        <h3>Mission</h3>
        <p>To Provide an all-inclusive teaching and modeling with the fear of God to produce inspirational, focused and visionary leaders of the future.</p>
      </div>
      <div class="value-card reveal zoom-in" style="--delay: .14s">
        <h3>Vision</h3>
        <p>To promote education with qualitative values.</p>
      </div>
      <div class="value-card reveal zoom-in" style="--delay: .2s">
        <h3>Core Values</h3>
        <p>Vision, Passion, Integrity, Respect and Excellence.</p>
      </div>
    </div>
  </section>

  <section class="academics-section">
    <h2 class="section-title reveal fade-up">Our Academic Programmes</h2>
    <div class="academic-cards-container reveal fade-up" style="--delay: .06s">
      <!-- Preschool -->
      <div class="academic-card-new reveal zoom-in" style="--delay: .08s">
        <div class="academic-img-wrapper reveal zoom-in" style="--delay: .1s">
          <img src="assets/images/aca1.png" alt="Preschool" class="academic-img">
        </div>
        <a href="https://dcsschools.com/pages/academics.php" class="academic-link-btn reveal fade-up" style="--delay: .14s">Preschool | Ages 2-5 &rarr;</a>
      </div>
      <!-- Primary -->
      <div class="academic-card-new reveal zoom-in" style="--delay: .16s">
        <div class="academic-img-wrapper reveal zoom-in" style="--delay: .18s">
          <img src="assets/images/aca3.png" alt="Primary" class="academic-img">
        </div>
        <a href="https://dcsschools.com/pages/about.php" class="academic-link-btn reveal fade-up" style="--delay: .22s">Primary | Ages 6-11 &rarr;</a>
      </div>
      <!-- Secondary -->
      <div class="academic-card-new reveal zoom-in" style="--delay: .24s">
        <div class="academic-img-wrapper reveal zoom-in" style="--delay: .26s">
          <img src="assets/images/aca2.png" alt="Secondary" class="academic-img">
        </div>
        <a href="https://dcsschools.com/pages/about.php" class="academic-link-btn reveal fade-up" style="--delay: .3s">Secondary | Ages 12-17 &rarr;</a>
      </div>
    </div>
  </section>

  <section class="why-choose-us">
    <h2 class="section-title reveal fade-up">Why Choose Us</h2>

    <div class="features-circular-layout reveal fade-up" style="--delay: .06s">
      <div class="center-circle-image">
        <img src="assets/images/cultural.png" alt="Students" class="circle-img reveal zoom-in" style="--delay: .1s">
      </div>

      <!-- Feature Items -->
      <div class="feature-item item-1">
        <div class="feature-icon-dot reveal zoom-in" style="--delay: .14s"></div>
        <h3 class="reveal fade-up" style="--delay: .18s">Experienced Teachers</h3>
        <p class="reveal fade-up" style="--delay: .22s">Our educators are professionally trained, carefully selected, and committed to nurturing every child's academic and personal growth.</p>
      </div>

      <div class="feature-item item-2 reveal fade-in" style="--delay: .18s">
        <div class="feature-icon-dot"></div>
        <h3>Safe Learning Environment</h3>
        <p>We provide a secure, well-supervised campus where students learn, explore, and grow with confidence and peace of mind.</p>
      </div>

      <div class="feature-item item-3 reveal fade-in" style="--delay: .22s">
        <div class="feature-icon-dot"></div>
        <h3>Strong Academic Results</h3>
        <p>Our structured curriculum and continuous assessment approach consistently prepare students for success in national and international examinations.</p>
      </div>

      <div class="feature-item item-4 reveal fade-in" style="--delay: .26s">
        <div class="feature-icon-dot"></div>
        <h3>Modern Learning Tools</h3>
        <p>We integrate technology, digital learning platforms, and innovative teaching methods to enhance understanding and engagement.</p>
      </div>

      <div class="feature-item item-5 reveal fade-in" style="--delay: .3s">
        <div class="feature-icon-dot"></div>
        <h3>Moral & Character Training</h3>
        <p>Beyond academics, we instill strong moral values, discipline, leadership, and a God-centered foundation for life.</p>
      </div>
    </div>
  </section>

  <section class="impact-section">
    <div class="impact-container">
      <h2 class="section-title-light reveal fade-up">Our Impact in Numbers</h2>
      <div class="impact-content reveal fade-up" style="--delay: .06s">
        <div class="impact-grid">
          <div class="impact-card reveal zoom-in" style="--delay: .08s">
            <span class="impact-number">20+</span>
            <span class="impact-label">Years of Education</span>
          </div>
          <div class="impact-card reveal zoom-in" style="--delay: .12s">
            <span class="impact-number">5000+</span>
            <span class="impact-label">Students Taught</span>
          </div>
          <div class="impact-card reveal zoom-in" style="--delay: .16s">
            <span class="impact-number">500+</span>
            <span class="impact-label">Graduates</span>
          </div>
          <div class="impact-card reveal zoom-in" style="--delay: .2s">
            <span class="impact-number">15-25</span>
            <span class="impact-label">Students per Class</span>
          </div>
          <div class="impact-card reveal zoom-in" style="--delay: .24s">
            <span class="impact-number">95%</span>
            <span class="impact-label">Jamb and Waec Success Rate</span>
          </div>
          <div class="impact-card reveal zoom-in" style="--delay: .28s">
            <span class="impact-number">2 Curricula</span>
            <span class="impact-label">Nigerian and British pathways</span>
          </div>
        </div>
        <div class="impact-image-wrapper reveal zoom-in" style="--delay: .1s">
          <img src="assets/images/impact.png" alt="Impact" class="impact-img reveal zoom-in" style="--delay: .14s">
        </div>
      </div>
    </div>
  </section>

  <section class="photo-splash-section">
    <h2 class="section-title reveal fade-up">Photo Splash</h2>
    <div class="gallery-grid reveal fade-up" style="--delay: .06s">
      <!-- Using PHP to fetch gallery items if available, else placeholders -->
      <?php if (!empty($gallery_items)): ?>
        <?php foreach (array_slice($gallery_items, 0, 9) as $item): ?>
          <div class="gallery-item reveal zoom-in">
            <img src="<?php echo htmlspecialchars($item['image_path'] ?? ''); ?>" alt="Gallery Image" class="reveal zoom-in" style="--delay: .06s">
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="gallery-item reveal zoom-in" style="--delay: .08s"><img src="assets/images/group1.png" alt="Gallery"></div>
        <div class="gallery-item reveal zoom-in" style="--delay: .12s"><img src="assets/images/group2.png" alt="Gallery"></div>
        <div class="gallery-item reveal zoom-in" style="--delay: .16s"><img src="assets/images/group3.png" alt="Gallery"></div>
        <div class="gallery-item reveal zoom-in" style="--delay: .2s"><img src="assets/images/group1.png" alt="Gallery"></div>
        <div class="gallery-item reveal zoom-in" style="--delay: .24s"><img src="assets/images/group2.png" alt="Gallery"></div>
        <div class="gallery-item reveal zoom-in" style="--delay: .28s"><img src="assets/images/group3.png" alt="Gallery"></div>
      <?php endif; ?>
    </div>
  </section>

  <section class="testimonials-section">
    <div class="testimonial-container reveal fade-up">
      <div class="testimonial-image-wrapper reveal zoom-in" style="--delay: .06s">
        <img src="assets/images/trusted.png" alt="Testimonial Context" class="testimonial-img reveal zoom-in" style="--delay: .1s">
      </div>
      <div class="testimonial-content reveal fade-up" style="--delay: .14s">
        <h2 class="section-title-left">Trusted by Parents. Loved by Students.</h2>
        <p class="testimonial-text">
          "Divine Confidence School has truly transformed my child's confidence and learning ability. The teachers are attentive, and the academic progress we've seen is impressive."
        </p>
        <div class="testimonial-author">
          <div class="author-avatar reveal zoom-in" style="--delay: .18s">
            <img src="assets/images/logo.png" alt="Parent">
          </div>
          <div class="author-info reveal fade-up" style="--delay: .22s">
            <h4>Mrs. Adebayo</h4>
            <span>Parent (Primary School)</span>
          </div>
        </div>
        <div class="testimonial-nav reveal fade-up" style="--delay: .26s">
          <button class="nav-btn prev-btn" aria-label="Previous">&larr;</button>
          <button class="nav-btn next-btn" aria-label="Next">&rarr;</button>
        </div>
      </div>
    </div>
  </section>

  <section class="cta-section">
    <div class="cta-container reveal fade-up">
      <h2 class="cta-title reveal fade-up" style="--delay: .06s">Give your child a confident start today</h2>
      <a href="pages/enrollment.php" class="btn-cta-enroll reveal fade-up" style="--delay: .12s">Enroll Now &rarr;</a>
    </div>
  </section>

  <footer class="site-footer">
    <div class="footer-main reveal fade-up">
      <!-- Col 1: Logo & Info -->
      <div class="footer-col footer-col-info reveal fade-up" style="--delay: .06s">
        <div class="footer-logo reveal zoom-in" style="--delay: .1s">
          <img src="assets/images/logo.png" style="width:250px" alt="Divine Confidence School" class="footer-logo-img">
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
          <li><a href="https://www.youtube.com/@Divineconfidenceschoolmedia">Divine Confidence Media (YouTube)</a></li>
           <li><a href="https://web.facebook.com/p/Divine-Confidence-School-100054429327233/?_rdc=1&_rdr#">Divine Confidence School (Facebook)</a></li>
        </ul>
      </div>

      <!-- Col 4: Talk To Us -->
      <div class="footer-col reveal fade-up" style="--delay: .18s">
        <h3 class="footer-col-title">Talk To Us</h3>
        <p class="contact-subtitle">Got Questions? Call us</p>
        <a href="tel:<?php echo isset($settings['phone']) ? htmlspecialchars($settings['phone']) : '+2348179611109'; ?>" class="contact-big-phone reveal fade-up" style="--delay: .22s">
    <?php echo isset($settings['phone']) ? htmlspecialchars($settings['phone']) : '+234 817 961 1109, +234 805 521 3935'; ?>
</a>
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

  <script src="assets/js/script.js"></script>
  <script src="assets/js/particles.js"></script>
</body>

</html>
