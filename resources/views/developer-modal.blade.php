<section class="developer-section" style="max-width: 100%; margin: 0; background: #ffffff; overflow: hidden; position: relative; padding-top: 0;">
    
    <!-- Close Button -->
    <div style="position: absolute; top: 15px; right: 20px; z-index: 1000;">
        <button onclick="closeDeveloperModal()" style="background: rgba(0,0,0,0.5); border: none; border-radius: 50%; width: 40px; height: 40px; color: white; font-size: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
            ×
        </button>
    </div>

    <!-- Header with profile -->
    <div class="profile-header" style="text-align: center; background: linear-gradient(135deg, #2D3748 0%, #4A5568 100%); color: white; padding: 60px 20px 40px; position: relative; margin-top: 0;">
        <img src="{{ asset('images/Profile.jpg') }}" alt="Sunny Pantig - Software Developer" style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid white; object-fit: cover; margin-bottom: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
        <h1 style="margin: 10px 0 8px; font-size: 2.2rem; font-weight: 700;">Sunny Pantig</h1>
        <p style="font-size: 1.1rem; opacity: 0.9; font-weight: 300; margin-bottom: 10px;">Software Developer | Database Architect | Future Software Engineer</p>
        <div class="tagline" style="display: inline-block; padding: 6px 16px; background: rgba(255, 255, 255, 0.2); border-radius: 50px; font-size: 0.9rem; font-weight: 500;">Building digital solutions with clean code and modern technologies</div>
    </div>

    <!-- Introduction -->
    <div class="intro" style="text-align: center; padding: 40px 30px; background: #F7FAFC; border-bottom: 1px solid #E2E8F0;">
        <p style="max-width: 700px; margin: 0 auto; color: #4A5568; font-size: 1rem; font-weight: 400; line-height: 1.6;">I specialize in creating custom web applications that combine creativity, clean architecture, and seamless user experience. This Dental Clinic Portal showcases my expertise in full-stack development using modern tools and robust database design.</p>
    </div>

    <!-- Skills Row -->
    <div class="skills-row" style="padding: 40px 30px; display: flex; flex-direction: column; gap: 40px;">
        
        <!-- Tech Stack -->
        <div class="tech-stack-section">
            <h2 style="color: #2D3748; text-align: center; margin-bottom: 30px; font-size: 1.8rem; font-weight: 600;">Technologies Powering This Application</h2>
            <div class="tech-stack" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                
                <div class="stack-category" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); text-align: center;">
                    <h3 style="color: #2D3748; margin-bottom: 15px; font-size: 1.1rem; font-weight: 600; display: flex; align-items: center; justify-content: center;"><i class="fas fa-code" style="margin-right: 8px; color: #4299E1;"></i> Frontend</h3>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">HTML5, CSS3, JavaScript</div>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">Blade Templates</div>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">Bootstrap / Tailwind CSS</div>
                </div>

                <div class="stack-category" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); text-align: center;">
                    <h3 style="color: #2D3748; margin-bottom: 15px; font-size: 1.1rem; font-weight: 600; display: flex; align-items: center; justify-content: center;"><i class="fas fa-server" style="margin-right: 8px; color: #4299E1;"></i> Backend & Database</h3>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;"><strong>Laravel PHP Framework</strong></div>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">MySQL (XAMPP)</div>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">Eloquent ORM</div>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">RESTful Routing</div>
                </div>

                <div class="stack-category" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); text-align: center;">
                    <h3 style="color: #2D3748; margin-bottom: 15px; font-size: 1.1rem; font-weight: 600; display: flex; align-items: center; justify-content: center;"><i class="fas fa-tools" style="margin-right: 8px; color: #4299E1;"></i> Development & Tools</h3>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">Git & GitHub</div>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">VS Code</div>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">XAMPP Stack</div>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">Postman</div>
                </div>

                <div class="stack-category" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); text-align: center;">
                    <h3 style="color: #2D3748; margin-bottom: 15px; font-size: 1.1rem; font-weight: 600; display: flex; align-items: center; justify-content: center;"><i class="fas fa-shield-alt" style="margin-right: 8px; color: #4299E1;"></i> Security & Features</h3>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">User Authentication</div>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">Data Validation</div>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">Session Management</div>
                    <div class="tech-item" style="background: #F7FAFC; padding: 8px 12px; border-radius: 6px; margin: 6px 0; font-size: 0.85rem; color: #4A5568;">Responsive Design</div>
                </div>
            </div>
        </div>

        <!-- Expertise Section -->
        <div class="expertise-section">
            <h2 style="color: #2D3748; text-align: center; margin-bottom: 30px; font-size: 1.8rem; font-weight: 600;">Database & Backend Expertise</h2>
            <div class="skills-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                
                <div class="skill-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); text-align: center;">
                    <h3 style="color: #2D3748; margin-bottom: 12px; font-size: 1rem; font-weight: 600; display: flex; align-items: center; justify-content: center;"><i class="fas fa-database" style="margin-right: 6px; color: #4299E1;"></i> MySQL Database</h3>
                    <p style="color: #4A5568; font-size: 0.85rem; line-height: 1.5;">Designed scalable databases for patient records and appointments using MySQL with optimized queries.</p>
                </div>
                
                <div class="skill-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); text-align: center;">
                    <h3 style="color: #2D3748; margin-bottom: 12px; font-size: 1rem; font-weight: 600; display: flex; align-items: center; justify-content: center;"><i class="fas fa-desktop" style="margin-right: 6px; color: #4299E1;"></i> Local Development</h3>
                    <p style="color: #4A5568; font-size: 0.85rem; line-height: 1.5;">Configured XAMPP environments for seamless development and testing workflows.</p>
                </div>
                
                <div class="skill-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); text-align: center;">
                    <h3 style="color: #2D3748; margin-bottom: 12px; font-size: 1rem; font-weight: 600; display: flex; align-items: center; justify-content: center;"><i class="fas fa-shield-alt" style="margin-right: 6px; color: #4299E1;"></i> Data Security</h3>
                    <p style="color: #4A5568; font-size: 0.85rem; line-height: 1.5;">Implemented secure practices including SQL injection prevention and input validation.</p>
                </div>
                
                <div class="skill-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); text-align: center;">
                    <h3 style="color: #2D3748; margin-bottom: 12px; font-size: 1rem; font-weight: 600; display: flex; align-items: center; justify-content: center;"><i class="fas fa-cogs" style="margin-right: 6px; color: #4299E1;"></i> System Integration</h3>
                    <p style="color: #4A5568; font-size: 0.85rem; line-height: 1.5;">Built complete management systems for appointments, patient data, and billing.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Buttons -->
    <div class="cta-buttons" style="text-align: center; margin: 40px 0; padding: 0 30px;">
        <a href="mailto:Leipantig3@gmail.com" class="btn" style="display: inline-flex; align-items: center; justify-content: center; padding: 12px 28px; margin: 8px; border-radius: 50px; background: linear-gradient(135deg, #4299E1 0%, #3182ce 100%); color: white; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(66, 153, 225, 0.4);"><i class="fas fa-paper-plane" style="margin-right: 6px;"></i> Hire Me</a>
        <a href="https://github.com/TofuMcflurry" target="_blank" class="btn btn-outline" style="display: inline-flex; align-items: center; justify-content: center; padding: 12px 28px; margin: 8px; border-radius: 50px; background: transparent; border: 2px solid #4299E1; color: #4299E1; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease;"><i class="fab fa-github" style="margin-right: 6px;"></i> View GitHub</a>
    </div>

    <!-- Contact -->
    <div class="contact-box" style="text-align: center; padding: 35px 30px; background: linear-gradient(135deg, #2D3748 0%, #4A5568 100%); color: white;">
        <h3 style="margin-bottom: 15px; font-size: 1.5rem; font-weight: 600;">Let's Collaborate</h3>
        <p style="margin: 8px 0; font-size: 1rem; opacity: 0.9;"><i class="fas fa-envelope"></i> Leipantig3@gmail.com</p>
        <p style="margin: 8px 0; font-size: 1rem; opacity: 0.9;"><i class="fas fa-briefcase"></i> Open to freelance and project collaborations</p>
        <div class="social-links" style="display: flex; justify-content: center; margin-top: 20px; gap: 10px;">
            <a href="https://www.linkedin.com/login" title="LinkedIn" target="_blank" style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); color: white; transition: all 0.3s ease;"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://www.instagram.com/leileitofu_/" title="Instagram" target="_blank" style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); color: white; transition: all 0.3s ease;"><i class="fab fa-instagram"></i></a>
            <a href="https://github.com/TofuMcflurry" title="GitHub" target="_blank" style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); color: white; transition: all 0.3s ease;"><i class="fab fa-github"></i></a>
        </div>
    </div>
</section>

<style>
    /* Modern Scrollbar for Modal */
    .modal-content::-webkit-scrollbar {
        width: 8px;
    }
    
    .modal-content::-webkit-scrollbar-track {
        background: #f1f5f9; 
        border-radius: 10px;
    }
    
    .modal-content::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #cbd5e0, #94a3b8); 
        border-radius: 10px;
    }
    
    .modal-content::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #94a3b8, #64748b);
    }
</style>