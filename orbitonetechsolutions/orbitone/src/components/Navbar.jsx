import React, { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { Menu, X, ArrowRight, Sun, Moon, ChevronDown, ChevronUp } from 'lucide-react';
import { useTheme } from '../context/ThemeContext';

export default function Navbar() {
  const [scrolled, setScrolled] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [activeDropdown, setActiveDropdown] = useState(null);
  const [mobileExpanded, setMobileExpanded] = useState({});
  const location = useLocation();
  const { theme, toggleTheme } = useTheme();

  useEffect(() => {
    const handleScroll = () => {
      setScrolled(window.scrollY > 40);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  // Close dropdowns on page route change
  useEffect(() => {
    setActiveDropdown(null);
    setMobileMenuOpen(false);
  }, [location.pathname]);

  const navLinks = [
    { name: 'Home', path: '/' },
    {
      name: 'Company',
      path: '/about',
      hasDropdown: true,
      subLinks: [
        { name: 'About Us', path: '/about', desc: 'Who we are & our mission' },
        { name: 'Our Process', path: '/process', desc: '7-step software lifecycle' },
        { name: 'Careers', path: '/careers', desc: 'Join our engineering team' }
      ]
    },
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
    { name: 'Projects', path: '/projects' },
    { name: 'Insights', path: '/blog' },
    { name: 'Contact', path: '/contact' }
  ];

  const toggleMobileSub = (name) => {
    setMobileExpanded((prev) => ({
      ...prev,
      [name]: !prev[name]
    }));
  };

  return (
    <header
      className={`navbar-fixed ${scrolled ? 'scrolled' : ''}`}
      style={{
        position: 'fixed',
        top: 0,
        left: 0,
        right: 0,
        zIndex: 1000,
        padding: scrolled ? '2px 12px' : '4px 16px',
        transition: 'all 0.3s cubic-bezier(0.16, 1, 0.3, 1)',
        background: theme === 'dark' ? '#0b192c' : '#ffffff',
        borderBottom: theme === 'dark' ? '1px solid rgba(255, 255, 255, 0.1)' : '1px solid rgba(11, 25, 44, 0.1)',
        boxShadow: theme === 'dark' ? '0 4px 30px rgba(0, 0, 0, 0.5)' : '0 4px 25px rgba(0, 0, 0, 0.08)'
      }}
    >
      <div
        style={{
          width: '100%',
          maxWidth: '1240px',
          margin: '0 auto',
          padding: '0 5%',
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'space-between',
          gap: '24px'
        }}
      >
        {/* Brand Logo */}
        <Link
          to="/"
          style={{
            display: 'inline-flex',
            alignItems: 'center',
            textDecoration: 'none',
            flexShrink: 0,
            padding: 0,
            margin: 0,
            marginLeft: '-20px',
            lineHeight: 0
          }}
        >
          {/* Desktop Logo */}
          <img
            src={theme === 'dark' ? '/assets/head2-transparent.png' : '/assets/head1-transparent.png'}
            alt="Orbitone Tech Solutions Logo"
            className="navbar-logo navbar-logo-desktop"
            style={{
              height: scrolled ? '64px' : '82px',
              maxHeight: '92px',
              width: 'auto',
              objectFit: 'contain'
            }}
          />
          {/* Mobile Phone View Nucleus Logo */}
          <div className="navbar-logo-mobile-wrapper">
            <img
              src={theme === 'dark' ? '/assets/orbitone-icon-dark.png' : '/assets/orbitone-icon-light.png'}
              alt="Orbitone Brand Icon"
              className="navbar-logo-mobile"
            />
            <span className="navbar-mobile-brand-text">
              <span style={{ color: theme === 'dark' ? '#ffffff' : '#0b192c', WebkitTextFillColor: theme === 'dark' ? '#ffffff' : '#0b192c' }}>ORBIT</span>
              <span style={{ color: 'var(--orbit-orange, #F79300)', WebkitTextFillColor: 'var(--orbit-orange, #F79300)' }}>ONE</span>
            </span>
          </div>
        </Link>

        {/* Desktop Navigation */}
        <nav
          className="desktop-nav"
          style={{
            display: 'flex',
            alignItems: 'center',
            gap: '26px',
            position: 'relative',
            marginLeft: 'auto',
            marginRight: '20px'
          }}
        >
          {navLinks.map((link) => {
            const isDirectActive = location.pathname === link.path;
            const isSubActive = link.subLinks?.some((sub) => location.pathname === sub.path);
            const isActive = isDirectActive || isSubActive;

            if (link.hasDropdown) {
              return (
                <div
                  key={link.name}
                  style={{ position: 'relative' }}
                  onMouseEnter={() => setActiveDropdown(link.name)}
                  onMouseLeave={() => setActiveDropdown(null)}
                >
                  <button
                    type="button"
                    onClick={(e) => {
                      e.preventDefault();
                      setActiveDropdown((prev) => (prev === link.name ? null : link.name));
                    }}
                    style={{
                      background: 'transparent',
                      border: 'none',
                      cursor: 'pointer',
                      color: isActive ? 'var(--orbit-orange)' : 'var(--text-primary)',
                      fontWeight: isActive ? '700' : '600',
                      fontSize: '0.94rem',
                      display: 'flex',
                      alignItems: 'center',
                      gap: '4px',
                      padding: '8px 4px',
                      transition: 'color 0.2s ease'
                    }}
                  >
                    {link.name} <ChevronDown size={14} style={{ transition: 'transform 0.2s ease', transform: activeDropdown === link.name ? 'rotate(180deg)' : 'rotate(0deg)' }} />
                  </button>

                  {/* Mega Dropdown */}
                  {activeDropdown === link.name && (
                    <div
                      className="glass-panel"
                      style={{
                        position: 'absolute',
                        top: 'calc(100% + 4px)',
                        left: link.name === 'Company' ? '0' : '50%',
                        transform: link.name === 'Company' ? 'none' : 'translateX(-50%)',
                        width: link.subLinks.length > 4 ? '340px' : '260px',
                        padding: '12px',
                        display: 'flex',
                        flexDirection: 'column',
                        gap: '6px',
                        zIndex: 1200,
                        boxShadow: '0 20px 40px rgba(0,0,0,0.4)',
                        borderRadius: '12px',
                        background: theme === 'dark' ? '#0b192c' : '#ffffff',
                        border: theme === 'dark' ? '1px solid rgba(255, 255, 255, 0.12)' : '1px solid rgba(11, 25, 44, 0.12)'
                      }}
                    >
                      {link.subLinks.map((sub) => {
                        const isThisSubActive = location.pathname === sub.path;
                        return (
                          <Link
                            key={sub.name}
                            to={sub.path}
                            onClick={() => setActiveDropdown(null)}
                            style={{
                              textDecoration: 'none',
                              padding: '8px 12px',
                              borderRadius: '8px',
                              transition: 'all 0.2s ease',
                              display: 'block',
                              background: isThisSubActive ? 'rgba(247, 147, 0, 0.15)' : 'transparent'
                            }}
                            onMouseEnter={(e) => {
                              if (!isThisSubActive) e.currentTarget.style.background = 'rgba(45, 140, 255, 0.12)';
                            }}
                            onMouseLeave={(e) => {
                              if (!isThisSubActive) e.currentTarget.style.background = 'transparent';
                            }}
                          >
                            <div style={{ fontWeight: '600', fontSize: '0.88rem', color: isThisSubActive ? 'var(--orbit-orange)' : (theme === 'dark' ? '#ffffff' : '#0b192c') }}>
                              {sub.name}
                            </div>
                            <div style={{ fontSize: '0.75rem', color: theme === 'dark' ? '#94a3b8' : '#64748b', marginTop: '2px' }}>
                              {sub.desc}
                            </div>
                          </Link>
                        );
                      })}
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
                  fontWeight: isActive ? '700' : '600',
                  fontSize: '0.94rem',
                  textDecoration: 'none',
                  position: 'relative',
                  padding: '8px 4px',
                  transition: 'color 0.2s ease'
                }}
              >
                {link.name}
                {isActive && (
                  <span
                    style={{
                      position: 'absolute',
                      bottom: 0,
                      left: '4px',
                      right: '4px',
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

        {/* Header Actions */}
        <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
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

          <Link to="/quote" className="btn-primary header-quote-btn" style={{ padding: '9px 18px', fontSize: '0.85rem', whiteSpace: 'nowrap' }}>
            GET A QUOTE <ArrowRight size={15} />
          </Link>

          <button
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            style={{
              background: 'var(--bg-glass)',
              border: '1px solid var(--border-glass)',
              color: 'var(--text-primary)',
              width: '44px',
              height: '44px',
              borderRadius: '50%',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              cursor: 'pointer',
              transition: 'all 0.3s ease'
            }}
            className="mobile-menu-btn"
            aria-label="Toggle Navigation"
          >
            {mobileMenuOpen ? <X size={22} /> : <Menu size={22} />}
          </button>
        </div>
      </div>

      {/* Mobile Drawer Navigation */}
      {mobileMenuOpen && (
        <div
          className="glass-panel mobile-drawer-panel"
          style={{
            position: 'absolute',
            top: '100%',
            left: 0,
            right: 0,
            maxHeight: 'calc(90vh - 70px)',
            overflowY: 'auto',
            borderBottom: '1px solid var(--border-glass)',
            padding: '20px 6%',
            display: 'flex',
            flexDirection: 'column',
            gap: '8px',
            borderRadius: '0 0 20px 20px',
            boxShadow: '0 25px 50px rgba(0,0,0,0.4)',
            background: 'var(--header-bg, #0b192c)'
          }}
        >
          {navLinks.map((link) => {
            const isDirectActive = location.pathname === link.path;

            if (link.hasDropdown) {
              const isExpanded = mobileExpanded[link.name];
              return (
                <div key={link.name} style={{ display: 'flex', flexDirection: 'column' }}>
                  <div
                    style={{
                      display: 'flex',
                      alignItems: 'center',
                      justifyContent: 'space-between',
                      padding: '10px 12px',
                      borderRadius: '8px',
                      background: 'rgba(255,255,255,0.03)'
                    }}
                  >
                    <Link
                      to={link.path}
                      onClick={() => setMobileMenuOpen(false)}
                      style={{
                        color: isDirectActive ? 'var(--orbit-orange)' : 'var(--text-primary)',
                        fontWeight: '700',
                        fontSize: '1.05rem',
                        textDecoration: 'none'
                      }}
                    >
                      {link.name}
                    </Link>
                    <button
                      onClick={() => toggleMobileSub(link.name)}
                      style={{
                        background: 'transparent',
                        border: 'none',
                        color: 'var(--text-primary)',
                        cursor: 'pointer',
                        padding: '4px'
                      }}
                      aria-label={`Toggle ${link.name} submenu`}
                    >
                      {isExpanded ? <ChevronUp size={18} /> : <ChevronDown size={18} />}
                    </button>
                  </div>

                  {isExpanded && (
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '4px', paddingLeft: '16px', marginTop: '4px', marginBottom: '6px' }}>
                      {link.subLinks.map((sub) => (
                        <Link
                          key={sub.name}
                          to={sub.path}
                          onClick={() => setMobileMenuOpen(false)}
                          style={{
                            color: location.pathname === sub.path ? 'var(--orbit-orange)' : 'var(--text-secondary)',
                            fontSize: '0.92rem',
                            fontWeight: '500',
                            padding: '8px 12px',
                            textDecoration: 'none',
                            borderRadius: '6px',
                            transition: 'all 0.2s ease',
                            display: 'block'
                          }}
                        >
                          • {sub.name}
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
                onClick={() => setMobileMenuOpen(false)}
                className="mobile-nav-link"
                style={{
                  color: isDirectActive ? 'var(--orbit-orange)' : 'var(--text-primary)',
                  fontWeight: '700',
                  fontSize: '1.05rem',
                  textDecoration: 'none',
                  display: 'flex',
                  alignItems: 'center',
                  padding: '10px 12px',
                  borderRadius: '8px',
                  transition: 'all 0.25s ease'
                }}
              >
                {link.name}
              </Link>
            );
          })}

          <div style={{ marginTop: '12px', paddingTop: '12px', borderTop: '1px solid var(--border-glass)' }}>
            <button
              onClick={() => {
                toggleTheme();
                setMobileMenuOpen(false);
              }}
              className="theme-toggle-btn"
              style={{ width: '100%', justifyContent: 'center', padding: '12px' }}
            >
              {theme === 'light' ? (
                <>
                  <Moon size={16} color="#2D8CFF" style={{ marginRight: '8px' }} />
                  <span>Switch to Dark Theme</span>
                </>
              ) : (
                <>
                  <Sun size={16} color="#F79300" style={{ marginRight: '8px' }} />
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


