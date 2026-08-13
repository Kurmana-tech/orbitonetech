import React, { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { Menu, X, ArrowRight, Sun, Moon, ChevronDown } from 'lucide-react';
import { useTheme } from '../context/ThemeContext';

export default function Navbar() {
  const [scrolled, setScrolled] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [servicesOpen, setServicesOpen] = useState(false);
  const location = useLocation();
  const { theme, toggleTheme } = useTheme();

  useEffect(() => {
    const handleScroll = () => {
      setScrolled(window.scrollY > 40);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const navLinks = [
    { name: 'Home', path: '/' },
    { name: 'About', path: '/about' },
    {
      name: 'Services',
      path: '/services',
      hasDropdown: true,
      subLinks: [
        { name: 'Web Development', path: '/web-development', desc: 'High performance web applications' },
        { name: 'Application Development', path: '/app-development', desc: 'Mobile & enterprise software' },
        { name: 'AI Solutions', path: '/ai-solutions', desc: 'Chatbots, ML & automation' },
        { name: 'Data Analytics', path: '/data-analytics', desc: 'BI dashboards & insights' },
        { name: 'Marketing Analytics', path: '/marketing-analytics', desc: 'ROI & funnel intelligence' },
        { name: 'Digital Marketing', path: '/digital-marketing', desc: 'SEO, SEM & growth marketing' }
      ]
    },
    { name: 'Industries', path: '/industries' },
    { name: 'Our Process', path: '/process' },
    { name: 'Projects', path: '/projects' },
    { name: 'Insights', path: '/blog' },
    { name: 'Careers', path: '/careers' },
    { name: 'Contact', path: '/contact' }
  ];

  return (
    <header
      className={`navbar-fixed ${scrolled ? 'scrolled' : ''}`}
      style={{
        position: 'fixed',
        top: 0,
        left: 0,
        right: 0,
        zIndex: 1000,
        padding: scrolled ? '4px 5%' : '8px 5%',
        transition: 'all 0.4s cubic-bezier(0.16, 1, 0.3, 1)',
        background: scrolled ? 'var(--header-bg)' : 'transparent',
        backdropFilter: scrolled ? 'blur(16px)' : 'none',
        borderBottom: scrolled ? '1px solid var(--border-glass)' : 'none'
      }}
    >
      <div
        style={{
          maxWidth: '1650px',
          margin: '0 auto',
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'space-between'
        }}
      >
        {/* Brand Logo */}
        <Link
          to="/"
          style={{
            display: 'flex',
            alignItems: 'center',
            gap: '12px',
            textDecoration: 'none'
          }}
        >
          {/* Header Brand Logo — transparent, theme-aware */}
          <img
            src={theme === 'dark' ? '/assets/head2-transparent.png' : '/assets/head1-transparent.png'}
            alt="Orbitone Tech Solutions Logo"
            className="navbar-logo"
          />
        </Link>

        {/* Desktop Navigation */}
        <nav
          className="desktop-nav"
          style={{
            display: 'flex',
            alignItems: 'center',
            gap: '24px'
          }}
        >
          {navLinks.map((link) => {
            const isActive = location.pathname === link.path;

            if (link.hasDropdown) {
              return (
                <div
                  key={link.name}
                  style={{ position: 'relative' }}
                  onMouseEnter={() => setServicesOpen(true)}
                  onMouseLeave={() => setServicesOpen(false)}
                >
                  <Link
                    to={link.path}
                    style={{
                      color: isActive ? 'var(--orbit-orange)' : 'var(--text-primary)',
                      fontWeight: isActive ? '700' : '500',
                      fontSize: '0.92rem',
                      textDecoration: 'none',
                      display: 'flex',
                      alignItems: 'center',
                      gap: '4px',
                      padding: '6px 0'
                    }}
                  >
                    {link.name} <ChevronDown size={14} />
                  </Link>

                  {/* Mega Menu Dropdown */}
                  {servicesOpen && (
                    <div
                      className="glass-panel"
                      style={{
                        position: 'absolute',
                        top: '100%',
                        left: '-50px',
                        width: '320px',
                        padding: '16px',
                        display: 'flex',
                        flexDirection: 'column',
                        gap: '10px',
                        zIndex: 1100,
                        boxShadow: '0 20px 50px rgba(0,0,0,0.3)'
                      }}
                    >
                      {link.subLinks.map((sub) => (
                        <Link
                          key={sub.name}
                          to={sub.path}
                          style={{
                            textDecoration: 'none',
                            padding: '8px 12px',
                            borderRadius: '8px',
                            transition: 'background 0.2s ease',
                            display: 'block'
                          }}
                          onMouseEnter={(e) => (e.currentTarget.style.background = 'rgba(45, 140, 255, 0.12)')}
                          onMouseLeave={(e) => (e.currentTarget.style.background = 'transparent')}
                        >
                          <div style={{ fontWeight: '600', fontSize: '0.9rem', color: 'var(--text-primary)' }}>
                            {sub.name}
                          </div>
                          <div style={{ fontSize: '0.78rem', color: 'var(--text-secondary)' }}>
                            {sub.desc}
                          </div>
                        </Link>
                      ))}
                    </div>
                  )}
                </div>
              );
            }

            return (
              <Link
                key={link.name}
                to={link.path}
                style={{
                  color: isActive ? 'var(--orbit-orange)' : 'var(--text-primary)',
                  fontWeight: isActive ? '700' : '500',
                  fontSize: '0.92rem',
                  textDecoration: 'none',
                  position: 'relative',
                  padding: '6px 0'
                }}
              >
                {link.name}
                {isActive && (
                  <span
                    style={{
                      position: 'absolute',
                      bottom: 0,
                      left: 0,
                      right: 0,
                      height: '2px',
                      background: 'var(--orbit-orange)',
                      borderRadius: '2px'
                    }}
                  />
                )}
              </Link>
            );
          })}
        </nav>

        {/* Header Actions: Theme Switcher (Redirects to Orbitonetech Light Theme) & Quote Button */}
        <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
          {/* Theme Toggle Button */}
          <button
            onClick={toggleTheme}
            className="theme-toggle-btn header-theme-toggle"
            title={theme === 'light' ? 'Switch to Dark Theme' : 'Switch to Light Theme'}
          >
            {theme === 'light' ? (
              <>
                <Moon size={16} color="#2D8CFF" />
                <span>Dark</span>
              </>
            ) : (
              <>
                <Sun size={16} color="#F79300" />
                <span>Light</span>
              </>
            )}
          </button>

          <Link to="/quote" className="btn-primary header-quote-btn" style={{ padding: '10px 20px', fontSize: '0.88rem' }}>
            GET A QUOTE <ArrowRight size={16} />
          </Link>

          <button
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            style={{
              background: 'var(--bg-glass)',
              border: '1px solid var(--border-glass)',
              color: 'var(--text-primary)',
              width: '42px',
              height: '42px',
              borderRadius: '50%',
              alignItems: 'center',
              justifyContent: 'center',
              cursor: 'pointer',
              transition: 'all 0.3s ease'
            }}
            className="mobile-menu-btn"
            aria-label="Toggle Navigation"
          >
            {mobileMenuOpen ? <X size={20} /> : <Menu size={20} />}
          </button>
        </div>
      </div>

      {/* Mobile Drawer Navigation */}
      {mobileMenuOpen && (
        <div
          className="glass-panel"
          style={{
            position: 'absolute',
            top: '100%',
            left: 0,
            right: 0,
            borderBottom: '1px solid var(--border-glass)',
            padding: '24px 6%',
            display: 'flex',
            flexDirection: 'column',
            gap: '14px',
            borderRadius: '0 0 16px 16px'
          }}
        >
          {navLinks.map((link) => (
            <React.Fragment key={link.name}>
              <Link
                to={link.path}
                onClick={() => setMobileMenuOpen(false)}
                className="mobile-nav-link"
                style={{
                  color: location.pathname === link.path ? 'var(--orbit-orange)' : 'var(--text-primary)',
                  fontWeight: '700',
                  fontSize: '1.05rem',
                  textDecoration: 'none',
                  display: 'flex',
                  alignItems: 'center',
                  padding: '8px 12px',
                  borderRadius: '8px',
                  transition: 'all 0.25s ease'
                }}
              >
                {link.name}
              </Link>
              {link.hasDropdown &&
                link.subLinks.map((sub) => (
                  <Link
                    key={sub.name}
                    to={sub.path}
                    onClick={() => setMobileMenuOpen(false)}
                    className="mobile-nav-link-sub"
                    style={{
                      color: 'var(--text-secondary)',
                      fontSize: '0.9rem',
                      paddingLeft: '24px',
                      textDecoration: 'none',
                      display: 'block',
                      borderRadius: '6px',
                      paddingTop: '6px',
                      paddingBottom: '6px',
                      transition: 'all 0.25s ease'
                    }}
                  >
                    — {sub.name}
                  </Link>
                ))}
            </React.Fragment>
          ))}
          <div style={{ marginTop: '8px' }}>
            <button
              onClick={() => {
                toggleTheme();
                setMobileMenuOpen(false);
              }}
              className="theme-toggle-btn"
              style={{ width: '100%', justifyContent: 'center', padding: '10px' }}
            >
              {theme === 'light' ? (
                <>
                  <Moon size={16} color="#2D8CFF" style={{ marginRight: '6px' }} />
                  <span>Switch to Dark Theme</span>
                </>
              ) : (
                <>
                  <Sun size={16} color="#F79300" style={{ marginRight: '6px' }} />
                  <span>Switch to Light Theme</span>
                </>
              )}
            </button>
          </div>
        </div>
      )}
    </header>
  );
}

