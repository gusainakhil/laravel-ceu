document.addEventListener('DOMContentLoaded', function () {
    // 1. Sticky Navbar on Scroll
    const navbar = document.querySelector('.main-navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 80) {
                navbar.classList.add('sticky');
            } else {
                navbar.classList.remove('sticky');
            }
        });
    }

    // 2. Animated Stats Counter
    const stats = document.querySelectorAll('.stat-number');
    if (stats.length > 0) {
        const countUp = (element) => {
            const target = parseInt(element.getAttribute('data-target'), 10);
            let count = 0;
            const speed = target / 50; // Adjust duration here

            const updateCount = () => {
                count += speed;
                if (count < target) {
                    element.innerText = Math.floor(count);
                    setTimeout(updateCount, 20);
                } else {
                    element.innerText = target + (element.getAttribute('data-suffix') || '');
                }
            };
            updateCount();
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    countUp(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        stats.forEach(stat => observer.observe(stat));
    }

    // 3. Testimonial Custom Carousel / Slider
    const testimonialCards = document.querySelectorAll('.testimonial-slide');
    const testimonialDots = document.querySelectorAll('.testimonial-dot');
    
    if (testimonialCards.length > 1 && testimonialDots.length > 0) {
        let currentIndex = 0;
        let slideInterval;

        const showSlide = (index) => {
            testimonialCards.forEach((card, i) => {
                if (i === index) {
                    card.style.display = 'block';
                    testimonialDots[i].classList.add('active');
                } else {
                    card.style.display = 'none';
                    testimonialDots[i].classList.remove('active');
                }
            });
            currentIndex = index;
        };

        const startAutoplay = () => {
            slideInterval = setInterval(() => {
                let nextIndex = (currentIndex + 1) % testimonialCards.length;
                showSlide(nextIndex);
            }, 5000); // Auto scroll every 5s
        };

        const resetAutoplay = () => {
            clearInterval(slideInterval);
            startAutoplay();
        };

        // Dots click listener
        testimonialDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
                resetAutoplay();
            });
        });

        // Initialize first slide and start autoplay
        showSlide(0);
        startAutoplay();
    } else if (testimonialCards.length === 1) {
        testimonialCards[0].style.display = 'block';
    }
});
