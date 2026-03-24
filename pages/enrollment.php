<?php
require_once __DIR__ . '/../admin/db.php';
$pdo = db();

// Fetch settings and social links for footer
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM social_links");
$social_links = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment - Divine Confidence School</title>
    <link rel="stylesheet" href="../assets/css/master.css">
    <link rel="stylesheet" href="../assets/css/enrollment.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
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

    <main>
        <!-- Hero Section -->
        <section class="enrollment-hero">
            <h1 class="enrollment-title reveal fade-up">Start your Application to Divine Confidence School</h1>
            <p class="enrollment-subtext reveal fade-up" style="--delay: .06s">Thank you for your interest in Divine Confidence School. Please complete the form below to begin your child's admission process. Our admissions team will contact you shortly to guide you through the next steps.</p>
        </section>

        <!-- Form Section -->
        <section class="enrollment-form-section">
            <form class="enrollment-form reveal fade-up" style="--delay: .08s" id="enrollmentForm" action="enrollment-handler.php" method="POST">
                
                <h3 class="form-section-title">Student Information</h3>
                <div class="form-grid">
                    <div class="form-field col-span-6 reveal fade-up" style="--delay: .1s">
                        <label class="form-label">Student Full Name <span class="required">*</span></label>
                        <input type="text" name="student_name" class="form-input" placeholder="Enter Name" required>
                    </div>
                    <div class="form-field col-span-3 reveal fade-up" style="--delay: .14s">
                        <label class="form-label">Gender <span class="required">*</span></label>
                        <select name="gender" class="form-select" required>
                            <option value="" disabled selected>Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-field col-span-3 reveal fade-up" style="--delay: .18s">
                        <label class="form-label">Date of Birth <span class="required">*</span></label>
                        <input type="date" name="dob" class="form-input" required>
                    </div>
                    <div class="form-field col-span-6 reveal fade-up" style="--delay: .22s">
                        <label class="form-label">Intended Class <span class="required">*</span></label>
                        <select name="intended_class" class="form-select" required>
                            <option value="" disabled selected>Select Class</option>
                            <option value="Creche">Creche</option>
                            <option value="Preschool">Preschool</option>
                            <option value="Nursery 1">Nursery 1</option>
                            <option value="Nursery 2">Nursery 2</option>
                            <option value="Primary 1">Primary 1</option>
                            <option value="Primary 2">Primary 2</option>
                            <option value="Primary 3">Primary 3</option>
                            <option value="Primary 4">Primary 4</option>
                            <option value="Primary 5">Primary 5</option>
                            <option value="Primary 6">Primary 6</option>
                            <option value="JSS 1">JSS 1</option>
                            <option value="JSS 2">JSS 2</option>
                            <option value="JSS 3">JSS 3</option>
                            <option value="SSS 1">SSS 1</option>
                            <option value="SSS 2">SSS 2</option>
                            <option value="SSS 3">SSS 3</option>
                        </select>
                    </div>
                </div>

                <h3 class="form-section-title">Parent / Guardian Information</h3>
                <div class="form-grid">
                    <div class="form-field col-span-4 reveal fade-up" style="--delay: .1s">
                        <label class="form-label">Parent/Guardian Full Name <span class="required">*</span></label>
                        <input type="text" name="parent_name" class="form-input" placeholder="Enter Name" required>
                    </div>
                    <div class="form-field col-span-4 reveal fade-up" style="--delay: .14s">
                        <label class="form-label">Phone Number <span class="required">*</span></label>
                        <input type="tel" name="phone" class="form-input" placeholder="Enter Number" required>
                    </div>
                    <div class="form-field col-span-4 reveal fade-up" style="--delay: .18s">
                        <label class="form-label">Email Address <span class="required">*</span></label>
                        <input type="email" name="email" class="form-input" placeholder="Enter Email" required>
                    </div>
                    <div class="form-field col-span-4 reveal fade-up" style="--delay: .22s">
                        <label class="form-label">Relationship to Child <span class="required">*</span></label>
                        <select name="relationship" class="form-select" required>
                            <option value="" disabled selected>Select</option>
                            <option value="Father">Father</option>
                            <option value="Mother">Mother</option>
                            <option value="Guardian">Guardian</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-field col-span-8 reveal fade-up" style="--delay: .26s">
                        <label class="form-label">Home Address</label>
                        <textarea name="address" class="form-textarea" placeholder="Enter address"></textarea>
                    </div>
                </div>

                <button type="submit" class="btn-submit-enroll reveal fade-up" style="--delay: .3s" id="enroll-btn">Submit Application <span style="font-size: 18px;">&rarr;</span></button>
            </form>
        </div>
    </section>

    <!-- Success/Error Modal -->
    <div id="status-modal" class="modal-backdrop" style="display:none;">
        <div class="modal-content">
            <div class="modal-icon success-icon">✅</div>
            <div class="modal-icon error-icon" style="display:none;">❌</div>
            <h3 id="modal-title">Success!</h3>
            <p id="modal-message">Your enrollment application has been submitted successfully.</p>
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
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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
        .btn-submit-enroll:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>

    <script>
        document.getElementById('enrollmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const btn = document.getElementById('enroll-btn');
            const originalBtnText = btn.innerHTML;
            
            // Disable button and show loading
            btn.disabled = true;
            btn.innerHTML = 'Submitting...';
            
            const formData = new FormData(form);
            
            fetch('enrollment-handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const modal = document.getElementById('status-modal');
                const title = document.getElementById('modal-title');
                const message = document.getElementById('modal-message');
                const successIcon = document.querySelector('.success-icon');
                const errorIcon = document.querySelector('.error-icon');
                
                if (data.success) {
                    title.textContent = 'Application Received!';
                    message.textContent = data.message;
                    successIcon.style.display = 'block';
                    errorIcon.style.display = 'none';
                    form.reset();
                } else {
                    title.textContent = 'Submission Failed';
                    message.textContent = data.message;
                    successIcon.style.display = 'none';
                    errorIcon.style.display = 'block';
                }
                
                // Show modal
                modal.style.display = 'flex';
                // Trigger reflow
                modal.offsetHeight; 
                modal.classList.add('show');
            })
            .catch(error => {
                console.error('Error:', error);
                const modal = document.getElementById('status-modal');
                document.getElementById('modal-title').textContent = 'Error';
                document.getElementById('modal-message').textContent = 'An unexpected error occurred. Please try again.';
                document.querySelector('.success-icon').style.display = 'none';
                document.querySelector('.error-icon').style.display = 'block';
                
                modal.style.display = 'flex';
                modal.offsetHeight;
                modal.classList.add('show');
            })
            .finally(() => {
                // Re-enable button after 2 seconds
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalBtnText;
                }, 2000);
            });
        });

        function closeModal() {
            const modal = document.getElementById('status-modal');
            modal.classList.remove('show');
            setTimeout(() => {
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
    </main>

    <!-- Footer -->
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
          <li><a href="#">Our Community</a></li>
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
      <p class="footer-copyright">Copyright © 2026 <span class="highlight">Divine Confidence School</span> All Rights Reserved</p>
    </div>
  </footer>

    <script src="../assets/js/script.js"></script>
    <script>
        // Simple client-side validation or AJAX handling could go here
        document.getElementById('enrollmentForm').addEventListener('submit', function(e) {
            // e.preventDefault();
            // Handle submission logic if we want AJAX
        });
    </script>
</body>
</html>
