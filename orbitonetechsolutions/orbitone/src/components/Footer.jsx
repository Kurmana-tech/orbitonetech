import React from 'react';
import { Link } from 'react-router-dom';
import { COMPANY_INFO } from '../data/services';
import { Mail, Phone, MapPin } from 'lucide-react';
import { useTheme } from '../context/ThemeContext';

export default function Footer() {
  const { theme } = useTheme();
  const footerLogo = theme === 'dark' ? '/assets/head2-transparent.png' : '/assets/head1-transparent.png';

  return (
    <footer
      style={{
        background: 'var(--footer-bg)',
        borderTop: '1px solid var(--border-glass)',
        padding: '80px 6% 44px 6%',
        position: 'relative',
        zIndex: 10,
      }}
    >
      {/* Main 4-column grid: brand gets 2fr, nav cols get 1fr each */}
      <div
        style={{
          maxWidth: '1650px',
          margin: '0 auto',
          display: 'grid',
          gridTemplateColumns: '2fr 1fr 1fr 1fr',
          gap: '60px',
          alignItems: 'start',
          marginBottom: '60px'
        }}
      >
        {/* Col 1: Brand */}
        <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'flex-start' }}>
          <Link to="/" style={{ display: 'block', textDecoration: 'none', marginBottom: '24px' }}>
            <img
              src={footerLogo}
              alt="Orbitone Tech Solutions"
              style={{ height: '220px', width: 'auto', display: 'block', objectFit: 'contain' }}
            />
          </Link>
          <p style={{ fontSize: '1rem', lineHeight: 1.7, color: 'var(--text-primary)', fontWeight: 600, margin: '0 0 12px 0' }}>
            {COMPANY_INFO.tagline}
          </p>
          <div style={{ color: '#334155', fontSize: '0.95rem', fontWeight: 500, lineHeight: 1.75, maxWidth: '380px' }}>
            Orbitone Tech Solutions combines technology, AI, data, and digital marketing to build high-performance products.
          </div>
        </div>

        {/* Col 2: Services */}
        <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'flex-start' }}>
          <h4 style={{ color: 'var(--text-primary)', fontSize: '1.05rem', fontWeight: 800, marginBottom: '20px', letterSpacing: '-0.01em' }}>Services</h4>
          <ul style={{ listStyle: 'none', display: 'flex', flexDirection: 'column', gap: '12px', padding: 0, margin: 0 }}>
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
                  style={{ color: '#334155', textDecoration: 'none', fontSize: '0.93rem', fontWeight: 500, transition: 'color 0.2s ease' }}
                  onMouseEnter={e => e.currentTarget.style.color = 'var(--orbit-orange)'}
                  onMouseLeave={e => e.currentTarget.style.color = '#334155'}
                >
                  {s.name}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        {/* Col 3: Company */}
        <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'flex-start' }}>
          <h4 style={{ color: 'var(--text-primary)', fontSize: '1.05rem', fontWeight: 800, marginBottom: '20px', letterSpacing: '-0.01em' }}>Company</h4>
          <ul style={{ listStyle: 'none', display: 'flex', flexDirection: 'column', gap: '12px', padding: 0, margin: 0 }}>
            {[
              { name: 'About Us', path: '/about' },
              { name: 'Industries', path: '/industries' },
              { name: 'Our Process', path: '/process' },
              { name: 'Projects', path: '/projects' },
              { name: 'Blog & Insights', path: '/blog' },
              { name: 'Careers', path: '/careers' },
              { name: 'Get a Quote', path: '/quote' }
            ].map((link, idx) => (
              <li key={idx}>
                <Link
                  to={link.path}
                  style={{ color: '#334155', textDecoration: 'none', fontSize: '0.93rem', fontWeight: 500, transition: 'color 0.2s ease' }}
                  onMouseEnter={e => e.currentTarget.style.color = 'var(--orbit-orange)'}
                  onMouseLeave={e => e.currentTarget.style.color = '#334155'}
                >
                  {link.name}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        {/* Col 4: Contact */}
        <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'flex-start' }}>
          <h4 style={{ color: 'var(--text-primary)', fontSize: '1.05rem', fontWeight: 800, marginBottom: '20px', letterSpacing: '-0.01em' }}>Contact Us</h4>
          <div style={{ display: 'flex', flexDirection: 'column', gap: '16px', fontSize: '0.93rem', fontWeight: 500, color: '#334155' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
              <Mail size={16} color="var(--orbit-orange)" style={{ flexShrink: 0 }} />
              <span>{COMPANY_INFO.email}</span>
            </div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
              <Phone size={16} color="var(--orbit-orange)" style={{ flexShrink: 0 }} />
              <span>{COMPANY_INFO.phone}</span>
            </div>
            <div style={{ display: 'flex', alignItems: 'flex-start', gap: '10px' }}>
              <MapPin size={16} color="var(--orbit-orange)" style={{ marginTop: '3px', flexShrink: 0 }} />
              <span>{COMPANY_INFO.address}</span>
            </div>
          </div>
        </div>
      </div>

      {/* Bottom copyright bar */}
      <div
        style={{
          maxWidth: '1650px',
          margin: '0 auto',
          paddingTop: '28px',
          borderTop: '1px solid rgba(11, 25, 44, 0.12)',
          display: 'flex',
          flexWrap: 'wrap',
          alignItems: 'center',
          justifyContent: 'space-between',
          gap: '16px',
          fontSize: '0.88rem',
          fontWeight: 600,
          color: '#334155'
        }}
      >
        <div>© {new Date().getFullYear()} Orbitone Tech Solutions. All rights reserved.</div>
        <div style={{ display: 'flex', gap: '24px', color: '#475569', fontWeight: 500 }}>
          <span style={{ cursor: 'pointer' }}>Privacy Policy</span>
          <span style={{ cursor: 'pointer' }}>Terms of Service</span>
          <span style={{ cursor: 'pointer' }}>Security</span>
        </div>
      </div>
    </footer>
  );
}
