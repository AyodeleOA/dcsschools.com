document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navMenu = document.querySelector('.nav-menu');

    if (mobileMenuBtn && navMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            mobileMenuBtn.classList.toggle('active');
        });
    }

    // Testimonials Slider
    const testimonials = [
        {
            text: "Divine Confidence School has truly transformed my child's confidence and learning ability. The teachers are attentive, and the academic progress we've seen is impressive.",
            name: "Mrs. Adebayo",
            role: "Parent (Primary School)",
            image: "assets/images/logo.png" 
        },
        {
            text: "We love the Christian foundation of the school. It's not just about academics; they are molding character. Our daughter has become so much more respectful and disciplined.",
            name: "Mr. & Mrs. Okonkwo",
            role: "Parents (Secondary School)",
            image: "assets/images/logo.png"
        },
        {
            text: "The facilities are top-notch, especially the science labs and ICT room. My son is always excited to go to school, which speaks volumes about the environment they've created.",
            name: "Mr. Johnson",
            role: "Parent (Junior Secondary)",
            image: "assets/images/logo.png"
        },
        {
            text: "The preschool section is amazing. The care and attention given to the little ones is exceptional. I have peace of mind knowing my toddler is in safe hands.",
            name: "Mrs. Peters",
            role: "Parent (Preschool)",
            image: "assets/images/logo.png"
        }
    ];

    let currentTestimonial = 0;

    const testimonialText = document.querySelector('.testimonial-text');
    const authorName = document.querySelector('.author-info h4');
    const authorRole = document.querySelector('.author-info span');
    const authorImg = document.querySelector('.author-avatar img');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    function updateTestimonial() {
        if (!testimonialText) return;
        
        // Simple fade effect
        const content = document.querySelector('.testimonial-content');
        content.style.opacity = '0';
        
        setTimeout(() => {
            const t = testimonials[currentTestimonial];
            testimonialText.textContent = `"${t.text}"`;
            authorName.textContent = t.name;
            authorRole.textContent = t.role;
            if (authorImg) authorImg.src = t.image;
            
            content.style.opacity = '1';
        }, 300);
    }

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            currentTestimonial--;
            if (currentTestimonial < 0) {
                currentTestimonial = testimonials.length - 1;
            }
            updateTestimonial();
        });

        nextBtn.addEventListener('click', () => {
            currentTestimonial++;
            if (currentTestimonial >= testimonials.length) {
                currentTestimonial = 0;
            }
            updateTestimonial();
        });
    }
    
    const reveals = document.querySelectorAll('.reveal');
    if (reveals.length) {
        const io = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -80px 0px' });
        reveals.forEach(el => io.observe(el));
    }
});
