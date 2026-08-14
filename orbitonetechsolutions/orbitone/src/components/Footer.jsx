import React from 'react';
import { Link } from 'react-router-dom';
import { COMPANY_INFO } from '../data/services';
import { Mail, Phone, MapPin, Linkedin, Twitter, Facebook, Instagram } from 'lucide-react';
import { useTheme } from '../context/ThemeContext';

export default function Footer() {
  const { theme } = useTheme();
  const isDark = theme === 'dark';
  const footerLogo = isDark ? '/assets/head2-transparent.png' : '/assets/head1-transparent.png';

  const headingColor = isDark ? '#ffffff' : '#0f172a';
  const textColor = isDark ? '#cbd5e1' : '#475569';
  const linkColor = isDark ? '#94a3b8' : '#475569';

  return (
    <footer
      className="footer-container"
      style={{
        background: isDark ? '#081220' : '#f8fafc',
        borderTop: isDark ? '1px solid rgba(255, 255, 255, 0.08)' : '1px solid rgba(11, 25, 44, 0.1)',
        padding: '60px 6% 36px 6%',
        position: 'relative',
        zIndex: 10,
      }}
    >
      {/* Responsive Main Grid */}
      <div className="footer-grid" style={{ maxWidth: '1650px', margin: '0 auto 48px auto' }}>
        {/* Col 1: Brand */}
        <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'flex-start' }}>
          <Link to="/" style={{ display: 'block', textDecoration: 'none', marginBottom: '16px' }}>
            <img
              src={footerLogo}
              alt="Orbitone Tech Solutions"
              className="footer-logo-img"
              style={{ height: '70px', width: 'auto', display: 'block', objectFit: 'contain' }}
            />
          </Link>
          <p style={{ fontSize: '1.02rem', lineHeight: 1.6, color: headingColor, fontWeight: 700, margin: '0 0 10px 0' }}>
            {COMPANY_INFO.tagline}
          </p>
          <p style={{ color: textColor, fontSize: '0.92rem', fontWeight: 400, lineHeight: 1.65, maxWidth: '380px', margin: '0 0 20px 0' }}>
            Orbitone Tech Solutions combines AI, software engineering, data analytics, and digital marketing to build high-performance products and drive business growth.
          </p>
          {/* Social Icons */}
          <div style={{ display: 'flex', gap: '14px', alignItems: 'center' }}>
            {[
              { icon: Linkedin, url: COMPANY_INFO.socials.linkedin, title: 'LinkedIn' },
              { icon: Twitter, url: COMPANY_INFO.socials.twitter, title: 'Twitter' },
              { icon: Facebook, url: COMPANY_INFO.socials.facebook, title: 'Facebook' },
              { icon: Instagram, url: COMPANY_INFO.socials.instagram, title: 'Instagram' }
            ].map((s, idx) => {
              const IconComp = s.icon;
              return (
                <a
                  key={idx}
                  href={s.url}
                  target="_blank"
                  rel="noopener noreferrer"
                  title={s.title}
                  style={{
                    width: '36px',
                    height: '36px',
                    borderRadius: '50%',
                    background: isDark ? 'rgba(255,255,255,0.06)' : 'rgba(11,25,44,0.05)',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    color: isDark ? '#e2e8f0' : '#334155',
                    transition: 'all 0.2s ease',
                    textDecoration: 'none'
                  }}
                  onMouseEnter={e => {
                    e.currentTarget.style.background = 'var(--orbit-orange)';
                    e.currentTarget.style.color = '#ffffff';
                    e.currentTarget.style.transform = 'translateY(-2px)';
                  }}
                  onMouseLeave={e => {
                    e.currentTarget.style.background = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(11,25,44,0.05)';
                    e.currentTarget.style.color = isDark ? '#e2e8f0' : '#334155';
                    e.currentTarget.style.transform = 'translateY(0)';
                  }}
                >
                  <IconComp size={18} />
                </a>
              );
            })}
          </div>
        </div>

        {/* Col 2: Services */}
        <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'flex-start' }}>
          <h4 style={{ color: headingColor, fontSize: '1.08rem', fontWeight: 800, marginBottom: '18px', letterSpacing: '0.02em' }}>
            Services
          </h4>
          <ul style={{ listStyle: 'none', display: 'flex', flexDirection: 'column', gap: '10px', padding: 0, margin: 0 }}>
            {[
              { name: 'Web Development', path: '/web-development' },
              { name: 'App Development', path: '/app-development' },
              { name: 'AI & Machine Learning', path: '/ai-solutions' },
              { name: 'Data Analytics', path: '/data-analytics' },
              { name: 'Marketing Analytics', path: '/marketing-analytics' },
              { name: 'Digital Marketing', path: '/digital-marketing' }
            ].map((s, idx) => (
              <li key={idx}>
                <Link
                  to={s.path}
                  onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })}
                  style={{ color: linkColor, textDecoration: 'none', fontSize: '0.94rem', fontWeight: 500, transition: 'all 0.2s ease' }}
                  onMouseEnter={e => {
                    e.currentTarget.style.color = 'var(--orbit-orange)';
                    e.currentTarget.style.paddingLeft = '4px';
                  }}
                  onMouseLeave={e => {
                    e.currentTarget.style.color = linkColor;
                    e.currentTarget.style.paddingLeft = '0';
                  }}
                >
                  {s.name}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        {/* Col 3: Company */}
        <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'flex-start' }}>
          <h4 style={{ color: headingColor, fontSize: '1.08rem', fontWeight: 800, marginBottom: '18px', letterSpacing: '0.02em' }}>
            Company
          </h4>
          <ul style={{ listStyle: 'none', display: 'flex', flexDirection: 'column', gap: '10px', padding: 0, margin: 0 }}>
            {[
              { name: 'About Us', path: '/about' },
              { name: 'Industries', path: '/industries' },
              { name: 'Our Process', path: '/process' },
              { name: 'Projects & Case Studies', path: '/projects' },
              { name: 'Insights / Blog', path: '/blog' },
              { name: 'Careers', path: '/careers' },
              { name: 'Get a Quote', path: '/quote' }
            ].map((link, idx) => (
              <li key={idx}>
                <Link
                  to={link.path}
                  onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })}
                  style={{ color: linkColor, textDecoration: 'none', fontSize: '0.94rem', fontWeight: 500, transition: 'all 0.2s ease' }}
                  onMouseEnter={e => {
                    e.currentTarget.style.color = 'var(--orbit-orange)';
                    e.currentTarget.style.paddingLeft = '4px';
                  }}
                  onMouseLeave={e => {
                    e.currentTarget.style.color = linkColor;
                    e.currentTarget.style.paddingLeft = '0';
                  }}
                >
                  {link.name}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        {/* Col 4: Contact Us */}
        <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'flex-start' }}>
          <h4 style={{ color: headingColor, fontSize: '1.08rem', fontWeight: 800, marginBottom: '18px', letterSpacing: '0.02em' }}>
            Contact Us
          </h4>
          <div style={{ display: 'flex', flexDirection: 'column', gap: '14px', fontSize: '0.93rem', fontWeight: 500, color: textColor }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
              <Mail size={18} color="var(--orbit-orange)" style={{ flexShrink: 0 }} />
              <a href={`mailto:${COMPANY_INFO.email}`} style={{ color: textColor, textDecoration: 'none', transition: 'color 0.2s ease' }} onMouseEnter={e => e.currentTarget.style.color = 'var(--orbit-orange)'} onMouseLeave={e => e.currentTarget.style.color = textColor}>
                {COMPANY_INFO.email}
              </a>
            </div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
              <Phone size={18} color="var(--orbit-orange)" style={{ flexShrink: 0 }} />
              <a href={`tel:${COMPANY_INFO.phone}`} style={{ color: textColor, textDecoration: 'none', transition: 'color 0.2s ease' }} onMouseEnter={e => e.currentTarget.style.color = 'var(--orbit-orange)'} onMouseLeave={e => e.currentTarget.style.color = textColor}>
                {COMPANY_INFO.phone}
              </a>
            </div>
            <Link to="/contact" onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })} style={{ display: 'flex', alignItems: 'flex-start', gap: '10px', color: textColor, textDecoration: 'none', transition: 'color 0.2s ease' }} onMouseEnter={e => e.currentTarget.style.color = 'var(--orbit-orange)'} onMouseLeave={e => e.currentTarget.style.color = textColor}>
              <MapPin size={18} color="var(--orbit-orange)" style={{ marginTop: '2px', flexShrink: 0 }} />
              <span>{COMPANY_INFO.address}</span>
            </Link>
          </div>
        </div>
      </div>

      {/* Bottom Copyright Bar */}
      <div
        className="footer-bottom-bar"
        style={{
          maxWidth: '1650px',
          margin: '0 auto',
          paddingTop: '24px',
          borderTop: isDark ? '1px solid rgba(255, 255, 255, 0.08)' : '1px solid rgba(11, 25, 44, 0.1)',
          display: 'flex',
          flexWrap: 'wrap',
          alignItems: 'center',
          justifyContent: 'space-between',
          gap: '16px',
          fontSize: '0.88rem',
          fontWeight: 500,
          color: linkColor
        }}
      >
        <div>© {new Date().getFullYear()} Orbitone Tech Solutions. All rights reserved.</div>
        <div style={{ display: 'flex', gap: '20px', flexWrap: 'wrap' }}>
          <Link to="/contact" onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })} style={{ color: linkColor, textDecoration: 'none', transition: 'color 0.2s ease' }} onMouseEnter={e => e.currentTarget.style.color = 'var(--orbit-orange)'} onMouseLeave={e => e.currentTarget.style.color = linkColor}>Privacy Policy</Link>
          <Link to="/contact" onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })} style={{ color: linkColor, textDecoration: 'none', transition: 'color 0.2s ease' }} onMouseEnter={e => e.currentTarget.style.color = 'var(--orbit-orange)'} onMouseLeave={e => e.currentTarget.style.color = linkColor}>Terms of Service</Link>
          <Link to="/contact" onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })} style={{ color: linkColor, textDecoration: 'none', transition: 'color 0.2s ease' }} onMouseEnter={e => e.currentTarget.style.color = 'var(--orbit-orange)'} onMouseLeave={e => e.currentTarget.style.color = linkColor}>Security</Link>
          <a href="/admin/" target="_blank" rel="noopener noreferrer" style={{ color: linkColor, textDecoration: 'none', transition: 'color 0.2s ease' }} onMouseEnter={e => e.currentTarget.style.color = 'var(--orbit-orange)'} onMouseLeave={e => e.currentTarget.style.color = linkColor}>Admin Portal</a>
        </div>
      </div>
    </footer>
  );
}

