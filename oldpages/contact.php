<?php
require_once __DIR__ . '/../admin/db.php';
$pdo = db();
$settings = array();
$social_links = array();
$faqs = array();
try {
  $settings = $pdo->query('SELECT * FROM settings WHERE id = 1')->fetch(PDO::FETCH_ASSOC);
  $social_links = $pdo->query('SELECT * FROM social_links ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
  $faqs = $pdo->query('SELECT * FROM faqs ORDER BY sort_order, id DESC')->fetchAll(PDO::FETCH_ASSOC);
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
  <link rel="stylesheet" href="../assets/css/contact.css" />
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
        <a href="https://dcsschools.com/" class="nav-link">Home</a>
        <a href="https://dcsschools.com/pages/about.php" class="nav-link">About Us</a>
        <a href="https://dcsschools.com/pages/academics.php" class="nav-link">Academics</a>
        <a href="https://dcsschools.com/pages/contact.php" class="nav-link nav-link-active">Contact Us</a>
      </nav>
      <a href="https://dcsschools.com/pages/enrollment.php" class="btn-enroll-header">Enroll Now &rarr;</a>
      <button class="mobile-menu-btn" aria-label="Toggle Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </header>

  <section class="contact-hero">
    <p class="contact-label">CONTACT US</p>
    <div class="contact-hero-grid">
      <div class="contact-intro">
        <h2 class="contact-title">Get in Touch With Us</h2>
        <p class="contact-subtext">If you have questions about admissions, programs, fees, or anything else about the school, reach out. Our team is always happy to guide parents, students, and partners.</p>
        <div class="contact-details">
          <div class="contact-detail"><img src="../assets/images/location.png" alt="Location" class="contact-detail-icon"><span class="contact-detail-text"><?php echo isset($settings['address']) ? htmlspecialchars($settings['address']) : ''; ?></span></div>
          <div class="contact-detail"><img src="../assets/images/mail.png" alt="Email" class="contact-detail-icon"><span class="contact-detail-text"><?php echo isset($settings['email']) ? htmlspecialchars($settings['email']) : ''; ?></span></div>
          <div class="contact-detail"><img src="../assets/images/call.png" alt="Phone" class="contact-detail-icon"><span class="contact-detail-text"><?php echo isset($settings['phone']) ? htmlspecialchars($settings['phone']) : ''; ?></span></div>
        </div>
      </div>
      <div class="contact-hero-image"><img src="../assets/images/contact-us.png" alt="contact hero" class="contact-hero-img"></div>
    </div>
    <div class="contact-divider"></div>
  </section>

  <section class="contact-form-section">
    <p class="form-label">Send Us a Message</p>
    <p class="form-subtext">We would Love to hear From You, Enquirers, Observations, Place an order.</p>
    <form id="contact-form" class="contact-form">
      <div class="form-row">
        <label class="form-field"><span class="form-field-label">Name *</span><input type="text" name="name" placeholder="Enter Name" required /></label>
        <label class="form-field"><span class="form-field-label">Email *</span><input type="email" name="email" placeholder="Enter Email" required /></label>
        <label class="form-field"><span class="form-field-label">Phone Number *</span><input type="tel" name="phone" placeholder="Enter Phone Number" required /></label>
      </div>
      <label class="form-field form-field-full"><span class="form-field-label">Enter your Message *</span><textarea name="message" placeholder="Type Here" maxlength="1000" required></textarea>
        <div class="char-count"><span id="char-count">0</span>/1000</div>
      </label>
      <div class="form-actions"><button type="submit" class="btn-submit" id="contact-btn">Send Message</button></div>
    </form>
  </section>

  <!-- Success/Error Modal -->
  <div id="status-modal" class="modal-backdrop" style="display:none;">
    <div class="modal-content">
      <div class="modal-icon success-icon">✅</div>
      <div class="modal-icon error-icon" style="display:none;">❌</div>
      <h3 id="modal-title">Success!</h3>
      <p id="modal-message">Your message has been sent successfully.</p>
      <button class="btn-close-modal" onclick="closeModal()">Close</button>
    </div>
  </div>

  <style>
    .modal-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease;
    }

    .modal-backdrop.show {
      opacity: 1;
      visibility: visible;
    }

    .modal-content {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      width: 90%;
      max-width: 400px;
      text-align: center;
      transform: translateY(20px);
      transition: transform 0.3s ease;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-backdrop.show .modal-content {
      transform: translateY(0);
    }

    .modal-icon {
      font-size: 48px;
      margin-bottom: 15px;
    }

    .modal-content h3 {
      color: #1e293b;
      margin-bottom: 10px;
      font-size: 22px;
    }

    .modal-content p {
      color: #64748b;
      margin-bottom: 25px;
      line-height: 1.5;
    }

    .btn-close-modal {
      background: var(--primary-green);
      color: #fff;
      border: none;
      padding: 10px 24px;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
    }

    .btn-close-modal:hover {
      background: #0d5f30;
    }

    .btn-submit:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }
  </style>

  <section class="faq-section">
    <p class="faq-label">FAQ</p>
    <div class="faq-grid">
      <div class="faq-left">
        <h2 class="faq-title">What You May Want to Know</h2>
        <p class="faq-text">We've answered some of the most common questions Parents have.</p>
      </div>
      <div class="faq-right">
        <?php foreach ($faqs as $f): ?>
          <div class="faq-item">
            <button class="faq-question" type="button"><span><?php echo htmlspecialchars($f['question']); ?></span><img src="../assets/images/plus.svg" alt="Toggle" class="faq-toggle-icon" /></button>
            <div class="faq-answer"><?php echo htmlspecialchars($f['answer']); ?></div>
          </div>
        <?php endforeach; ?>
      </div>
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

  <script>
    (function() {
      var ta = document.querySelector('.contact-form textarea');
      var cc = document.getElementById('char-count');
      if (ta && cc) {
        var upd = function() {
          cc.textContent = String(ta.value.length);
        };
        ta.addEventListener('input', upd);
        upd();
      }
      
      var form = document.getElementById('contact-form');
      if (form) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();
          
          var btn = document.getElementById('contact-btn');
          var originalBtnText = btn.innerHTML;
          
          // Disable button and show loading
          btn.disabled = true;
          btn.innerHTML = 'Sending...';
          
          var fd = new FormData(form);
          
          fetch('contact-handler.php', {
              method: 'POST',
              body: fd
            })
            .then(function(r) {
              return r.json();
            })
            .then(function(data) {
              var modal = document.getElementById('status-modal');
              var title = document.getElementById('modal-title');
              var message = document.getElementById('modal-message');
              var successIcon = document.querySelector('.success-icon');
              var errorIcon = document.querySelector('.error-icon');
              
              // if (data.success) {
                title.textContent = 'Message Sent!';
                message.textContent = data.message;
                successIcon.style.display = 'block';
                errorIcon.style.display = 'none';
                form.reset();
                if (cc) cc.textContent = '0';
              // } else {
              //   title.textContent = 'Sending Failed';
              //   message.textContent = data.message;
              //   successIcon.style.display = 'none';
              //   errorIcon.style.display = 'block';
              // }
              
              // Show modal
              modal.style.display = 'flex';
              // Trigger reflow
              modal.offsetHeight; 
              modal.classList.add('show');
            })
            .catch(function(error) {
              console.error('Error:', error);
              var modal = document.getElementById('status-modal');
              document.getElementById('modal-title').textContent = 'Error';
              document.getElementById('modal-message').textContent = 'An unexpected error occurred. Please try again.';
              document.querySelector('.success-icon').style.display = 'none';
              document.querySelector('.error-icon').style.display = 'block';
              
              modal.style.display = 'flex';
              modal.offsetHeight;
              modal.classList.add('show');
            })
            .finally(function() {
              // Re-enable button after 2 seconds
              setTimeout(function() {
                btn.disabled = false;
                btn.innerHTML = originalBtnText;
              }, 2000);
            });
        });
      }

      var qs = document.querySelectorAll('.faq-item');
      for (var i = 0; i < qs.length; i++) {
        var item = qs[i];
        var btn = item.querySelector('.faq-question');
        var ans = item.querySelector('.faq-answer');
        if (btn && ans) {
          btn.addEventListener('click', function() {
            var parent = this.parentNode;
            var answ = parent.querySelector('.faq-answer');
            var open = parent.classList.toggle('open');
            answ.style.display = open ? 'block' : 'none';
          });
          ans.style.display = 'none';
        }
      }
    })();

    function closeModal() {
      var modal = document.getElementById('status-modal');
      modal.classList.remove('show');
      setTimeout(function() {
        modal.style.display = 'none';
      }, 300);
    }

    // Close modal on outside click
    document.getElementById('status-modal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeModal();
      }
    });
  </script>

  <script src="assets/js/script.js"></script>
</body>

</html>