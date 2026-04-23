<style>
#ccFooter {
    background: #0a0f1e;
    color: #94a3b8;
    padding: 4rem 0 0;
    margin-top: 4rem;
}
.cc-footer-inner {
    max-width: 1280px; margin: 0 auto;
    padding: 0 1.5rem;
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 3rem;
}
@media(max-width: 900px) { .cc-footer-inner { grid-template-columns: 1fr 1fr; gap: 2rem; } }
@media(max-width: 540px) { .cc-footer-inner { grid-template-columns: 1fr; gap: 1.5rem; } }

#ccFooter .cc-f-logo {
    font-size: 1.4rem; font-weight: 900; letter-spacing: -.04em;
    background: linear-gradient(135deg,#60a5fa,#a78bfa);
    -webkit-background-clip: text; background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block; margin-bottom: .7rem;
}
#ccFooter p { font-size: .88rem; line-height: 1.7; color: #64748b; }

/* Newsletter */
.cc-newsletter {
    display: flex; margin-top: 1.2rem;
    border-radius: 10px; overflow: hidden;
    border: 1.5px solid #1e293b;
}
.cc-newsletter input {
    flex: 1; background: #0f172a; border: none; outline: none;
    padding: .6rem .9rem; font-size: .82rem; color: #e2e8f0;
    font-family: var(--cc-font);
}
.cc-newsletter input::placeholder { color: #475569; }
.cc-newsletter button {
    background: linear-gradient(135deg,#2563eb,#7c3aed);
    color: #fff; border: none; padding: .6rem 1rem;
    font-size: .8rem; font-weight: 700; cursor: pointer;
    font-family: var(--cc-font); transition: opacity .15s;
}
.cc-newsletter button:hover { opacity: .88; }

/* Column headings */
#ccFooter h4 {
    font-size: .8rem; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: #e2e8f0; margin-bottom: 1.1rem;
}

/* Links */
#ccFooter ul { list-style: none; padding: 0; margin: 0; }
#ccFooter ul li { margin-bottom: .55rem; }
#ccFooter ul a {
    font-size: .87rem; color: #64748b; text-decoration: none;
    transition: color .15s, padding-left .15s;
    display: flex; align-items: center; gap: .4rem;
}
#ccFooter ul a:hover { color: #60a5fa; padding-left: 4px; }

/* Social icons */
.cc-social-icons { display: flex; gap: .75rem; margin-top: .5rem; flex-wrap: wrap; }
.cc-social-btn {
    width: 38px; height: 38px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: .95rem; background: #111827; color: #64748b;
    text-decoration: none; border: 1px solid #1e293b;
    transition: all .2s;
}
.cc-social-btn:hover { transform: translateY(-3px); }
.cc-social-btn.fb:hover  { background: #1877f2; color: #fff; border-color: #1877f2; }
.cc-social-btn.tw:hover  { background: #000; color: #fff; border-color: #333; }
.cc-social-btn.li:hover  { background: #0077b5; color: #fff; border-color: #0077b5; }
.cc-social-btn.ig:hover  { background: linear-gradient(135deg,#e1306c,#f77737); color: #fff; border: none; }
.cc-social-btn.yt:hover  { background: #ff0000; color: #fff; border-color: #ff0000; }

/* Bottom bar */
.cc-footer-bottom {
    max-width: 1280px; margin: 3rem auto 0;
    padding: 1.25rem 1.5rem;
    border-top: 1px solid #1e293b;
    display: flex; align-items: center; justify-content: space-between;
    font-size: .82rem; flex-wrap: wrap; gap: .75rem;
}
.cc-footer-badges { display: flex; gap: .5rem; flex-wrap: wrap; }
.cc-footer-badge {
    background: #1e293b; border: 1px solid #334155;
    color: #475569; padding: 3px 10px;
    border-radius: 6px; font-size: .72rem; font-weight: 600;
}
</style>

<footer id="ccFooter">
    <div class="cc-footer-inner">

        <!-- Column 1: Brand -->
        <div>
            <div class="cc-f-logo">
                <i class="fas fa-briefcase" style="font-size:.9em;margin-right:.25rem;"></i>CareerConnect
            </div>
            <p>Your gateway to thousands of career opportunities. Connecting ambitious talent with world-class companies since 2023.</p>

            <div class="cc-newsletter">
                <input type="email" placeholder="Enter your email…">
                <button onclick="showToast('Subscribed! Welcome aboard 🎉', 'success')">Subscribe</button>
            </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div>
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ route('about') }}"><i class="fas fa-angle-right text-xs text-blue-500"></i> About Us</a></li>
                <li><a href="#"><i class="fas fa-angle-right text-xs text-blue-500"></i> Contact</a></li>
                <li><a href="#"><i class="fas fa-angle-right text-xs text-blue-500"></i> Privacy Policy</a></li>
                <li><a href="#"><i class="fas fa-angle-right text-xs text-blue-500"></i> Terms of Service</a></li>
                <li><a href="{{ route('companies.index') }}"><i class="fas fa-angle-right text-xs text-blue-500"></i> For Employers</a></li>
            </ul>
        </div>

        <!-- Column 3: Job Seekers -->
        <div>
            <h4>Job Seekers</h4>
            <ul>
                <li><a href="{{ route('jobs.index') }}"><i class="fas fa-angle-right text-xs text-purple-400"></i> Browse Jobs</a></li>
                <li><a href="{{ route('internships.index') }}"><i class="fas fa-angle-right text-xs text-purple-400"></i> Internships</a></li>
                <li><a href="#"><i class="fas fa-angle-right text-xs text-purple-400"></i> Career Advice</a></li>
                <li><a href="{{ route('register') }}"><i class="fas fa-angle-right text-xs text-purple-400"></i> Create Profile</a></li>
                <li><a href="{{ route('candidate.applications') }}"><i class="fas fa-angle-right text-xs text-purple-400"></i> My Applications</a></li>
            </ul>
        </div>

        <!-- Column 4: Social -->
        <div>
            <h4>Follow Us</h4>
            <p style="margin-bottom:.9rem;">Stay connected for job alerts and career tips.</p>
            <div class="cc-social-icons">
                <a href="#" class="cc-social-btn fb" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="cc-social-btn tw" title="Twitter / X"><i class="fab fa-x-twitter"></i></a>
                <a href="#" class="cc-social-btn li" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="cc-social-btn ig" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="cc-social-btn yt" title="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <!-- Bottom bar -->
    <div class="cc-footer-bottom">
        <span>© {{ date('Y') }} <strong style="color:#e2e8f0;">CareerConnect</strong>. All rights reserved.</span>
        <div class="cc-footer-badges">
            <span class="cc-footer-badge">🔒 SSL Secured</span>
            <span class="cc-footer-badge">🇮🇳 Made in India</span>
            <span class="cc-footer-badge">❤️ Open Source</span>
        </div>
    </div>
</footer>