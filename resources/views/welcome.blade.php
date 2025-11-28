<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Experience world-class dental care at LCAD Dental Clinic. 50,000+ happy patients, 80+ expert dentists, 99.6% success rate.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <title>LCAD Dental Clinic | Expert Dental Care & Beautiful Smiles</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Manrope:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">

</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">
                <div class="logo-circle">P</div>
                <div class="logo-text">
                    <h1>LCAD</h1>
                    <p>Dental Clinic</p>
                </div>
            </div>

            <nav>
                <a href="#home">Home</a>
                <a href="#services">Services</a>
                <a href="#about">About Us</a>
                <a href="#team">Team</a>
                <a href="#contact">Contact</a>
            </nav>

            <div class="header-actions">
                <a href="{{ route('login') }}" class="btn login">Log in</a>
                <a href="{{ route('register') }}" class="btn register">Register</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h2>LCAD Dental Clinic</h2>
            <p>Your smile is our priority. Experience world-class dental care with our team of expert dentists and state-of-the-art technology.</p>
            <a href="#book" class="btn btn-hero">Make An Appointment</a>
        </div>
    </section>

    <!-- Features -->
    <section class="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">✓</div>
                    <h3>Accountability Care</h3>
                    <p>We take full responsibility for your dental health journey with transparent treatment plans and regular follow-ups.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚕</div>
                    <h3>Treatment Verified</h3>
                    <p>All our treatments are verified by certified dental professionals ensuring the highest quality standards.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <h3>Comprehensive Plans</h3>
                    <p>Personalized treatment plans designed specifically for your unique dental needs and budget.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="statistics">
        <div class="container">
            <div class="stats-grid">
                <div>
                    <div class="stat-value">5000+</div>
                    <div class="stat-label">Happy Patients</div>
                </div>
                <div>
                    <div class="stat-value">10+</div>
                    <div class="stat-label">Expert Dentists</div>
                </div>
                <div>
                    <div class="stat-value">99.6%</div>
                    <div class="stat-label">Success Rate</div>
                </div>
                <div>
                    <div class="stat-value">12</div>
                    <div class="stat-label">Years Experience</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services - Updated Section -->
    <section id="services" class="services">
        <div class="container">
            <div class="section-header">
                <h2>Our Services</h2>
                <p>Comprehensive dental solutions tailored to your needs</p>
            </div>
            <div class="services-grid">
                <!-- Braces Service -->
                <div class="service-card">
                    <div class="service-image">
                        <img src="images/Brace.jpg" alt="Braces">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Braces</h3>
                        <p class="service-description">Dental braces help enhance your smile, fix bite issues, and straighten misaligned teeth.</p>
                    </div>
                    <div class="service-overlay">
                        <h3 class="overlay-title">Braces</h3>
                        <p class="overlay-description">Dental braces can help improve the appearance of your smile, correct bite problems or misaligned teeth, and enhance your overall oral health and well-being.</p>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>

                <!-- Crowns & Bridges Service -->
                <div class="service-card">
                    <div class="service-image">
                        <img src="images/Dental-Bridges.jpg" alt="Dental Bridges">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Crowns & Bridges</h3>
                        <p class="service-description">Repair broken teeth or fill in gaps with our personalized crowns and bridges.</p>
                    </div>
                    <div class="service-overlay">
                        <h3 class="overlay-title">Crowns & Bridges</h3>
                        <p class="overlay-description">Restore damaged teeth or replace missing ones with our custom-made crowns and bridges, designed to match your natural teeth perfectly.</p>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>

                <!-- Veneers Service -->
                <div class="service-card">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Dental Veneers">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Veneers</h3>
                        <p class="service-description">Transform your smile with our custom porcelain veneers for a flawless appearance.</p>
                    </div>
                    <div class="service-overlay">
                        <h3 class="overlay-title">Veneers</h3>
                        <p class="overlay-description">Transform your smile with our custom porcelain veneers for a flawless appearance. Our veneers are designed to cover imperfections and create a natural-looking smile.</p>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>

                <!-- Whitening Service -->
                <div class="service-card">
                    <div class="service-image">
                        <img src="images/Whitening.jpg" alt="whitening">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Whitening</h3>
                        <p class="service-description">Brighten your smile with our professional teeth whitening treatments for lasting results.</p>
                    </div>
                    <div class="service-overlay">
                        <h3 class="overlay-title">Whitening</h3>
                        <p class="overlay-description">Brighten your smile with our professional teeth whitening treatments for lasting results. Our safe and effective methods remove stains and discoloration.</p>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header">
                <p style="color: #05668d; font-weight: 600; margin-bottom: 8px;">Testimonials</p>
                <h2>What Are The Patients Saying...</h2>
                <div class="testimonial-filters">
                    <button class="filter-btn">All Reviews (580)</button>
                    <button class="filter-btn">Google (340)</button>
                    <button class="filter-btn">Facebook (240)</button>
                </div>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="stars">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p>Exceptional service! The team at LCAD made me feel comfortable throughout my treatment. Highly recommend!</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">S</div>
                        <div>
                            <div class="author-name">Pantig Aisly Miles</div>
                            <div class="author-role">Patient</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="stars">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p>Professional, caring, and thorough. The best dental experience I've ever had. The clinic is modern and clean.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">M</div>
                        <div>
                            <div class="author-name">Arabella Caminong</div>
                            <div class="author-role">Patient</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="stars">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p>Amazing results with my teeth whitening treatment. The staff is friendly and the dentists are highly skilled.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">E</div>
                        <div>
                            <div class="author-name">David Beltrano</div>
                            <div class="author-role">Patient</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="stars">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p>I was nervous about my dental work, but the team put me at ease. Outstanding care and attention to detail.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">D</div>
                        <div>
                            <div class="author-name">Jhaynard Tafalla</div>
                            <div class="author-role">Patient</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="stars">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p>The comprehensive dental plan they created for me was perfect. Great communication and excellent results!</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">L</div>
                        <div>
                            <div class="author-name">Chyna Ricafrente</div>
                            <div class="author-role">Patient</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="stars">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p>State-of-the-art facilities and top-notch dental professionals. My family trusts LCAD for all our dental needs.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">J</div>
                        <div>
                            <div class="author-name">Arian Ross Solivet</div>
                            <div class="author-role">Patient</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="view-all">
                <button class="btn btn-primary">View All Reviews</button>
            </div>
        </div>
    </section>

    <!-- About -->
    <section id="about" class="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-image">
                    <img src="images/Dental-Clinic.jpg" alt="About Us">
                </div>

                <div class="about-content">
                    <p style="color: #05668d; font-weight: 600; margin-bottom: 8px;">About Us</p>
                    <h2>About Us</h2>
                    <p>Welcome to LCAD Dental Clinic, where your oral health is our top priority. With over 12 years of excellence in dental care, we've helped more than 50,000 patients achieve their perfect smile.</p>
                    <p>Our team of 80+ highly qualified dentists and dental professionals are committed to providing comprehensive, personalized care using the latest technology and techniques in modern dentistry.</p>
                    <p>We believe in creating a comfortable, welcoming environment where patients feel at ease. From routine check-ups to complex procedures, we ensure every visit is a positive experience with outstanding results.</p>
                    <button class="btn btn-primary">Learn More</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section id="team" class="team">
        <div class="container">
            <div class="section-header">
                <p style="color: #05668d; font-weight: 600; margin-bottom: 8px;">Meet The Team</p>
                <h2>Our Partner Dentists</h2>
                <p>Experienced professionals dedicated to your dental health</p>
            </div>

            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar">
                        <img src="images/doc-mayki.jpg" alt="Dr. Michael Angelus">
                    </div>
                    <h3>Dr. Michael Angelus</h3>
                    <p>Clinical Director</p>
                </div>

                <div class="team-card">
                    <div class="team-avatar">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='128' height='128'%3E%3Ccircle cx='64' cy='64' r='64' fill='%23e8f4f4'/%3E%3Ctext x='50%25' y='50%25' font-size='48' text-anchor='middle' dy='.3em' fill='%232b9b9e'%3ESW%3C/text%3E%3C/svg%3E" alt="Dr. Sarah Williams">
                    </div>
                    <h3>Dr. John Robinson</h3>
                    <p>Partner Dentist</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-section">
                    <div class="footer-logo">
                        <div class="footer-logo-circle">P</div>
                        <div class="footer-logo-text">
                            <h3>LCAD</h3>
                            <p>Dental Clinic</p>
                        </div>
                    </div>
                    <p style="opacity: 0.9; font-size: 14px; margin-bottom: 10px; font-family: 'Manrope', sans-serif;">
                        LCAD Dental is a brand of TISPRING Inc.
                    </p>
                    <p style="opacity: 0.9; font-size: 14px; margin-bottom: 15px; font-family: 'Manrope', sans-serif;">
                        Your Convenient, Accommodating, and Affordable Dental Care Partner
                    </p>
                    <div class="footer-social-links">
                        <a href="https://facebook.com" class="footer-social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://instagram.com" class="footer-social-link"><i class="fab fa-instagram"></i></a>
                        <a href="https://linkedin.com" class="footer-social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://twitter.com" class="footer-social-link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><i class="fas fa-home"></i> <a href="#home">Home</a></li>
                        <li><i class="fas fa-user"></i> <a href="#about">About Us</a></li>
                        <li><i class="fas fa-concierge-bell"></i> <a href="#services">Services</a></li>
                        <li><i class="fas fa-phone"></i> <a href="#contact">Contact Us</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Our Services</h4>
                    <ul>
                        <li><i class="fas fa-tooth"></i> Braces</li>
                        <li><i class="fas fa-crown"></i> Crowns & Bridges</li>
                        <li><i class="fas fa-gem"></i> Veneers</li>
                        <li><i class="fas fa-sun"></i> Whitening</li>
                        <li><i class="fas fa-fill-drip"></i> Fillings</li>
                        <li><i class="fas fa-pump-soap"></i> Cleaning</li>
                        <li><i class="fas fa-teeth"></i> Extractions</li>
                        <li><i class="fas fa-syringe"></i> Dental Surgery</li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <ul>
                        <li><i class="far fa-clock"></i> 8am-1pm or 10am-4pm<br>Monday to Saturday</li>
                        <li><i class="fas fa-phone"></i> 0906 337 7898</li>
                        <li><i class="far fa-envelope"></i>Amipantig@pcu.edu.ph</li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i> 
                            <div>
                                <strong>Our Locations:</strong><br>
                                Dasmarinas, Imus
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div>
                    <p>Copyright © 2025 LCAD Dental. All Rights Reserved.</p>
                </div>
                <div class="footer-social-links">
                    <p class="developer-credit">
                        Website designed & developed by 
                        <a href="javascript:void(0)" class="developer-link" onclick="openDeveloperModal()">Pantig Aisly Miles</a>
                    </p>
                </div>
            </div>

            <!-- Modal Container (KEEP THIS) -->
            <div id="developer-modal" class="modal" style="display: none;">
                <div class="modal-content">
                    <div id="modal-content-container">
                        <!-- AJAX content loads here -->
                    </div>
                </div>
            </div>

            <!-- Include your JS file -->
            <script src="{{ asset('js/developer-modal.js') }}"></script>
</body>
</html>