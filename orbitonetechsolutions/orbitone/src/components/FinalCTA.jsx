import React from 'react';
import { Link } from 'react-router-dom';
import { ArrowRight, Sparkles } from 'lucide-react';
import { useTheme } from '../context/ThemeContext';

export default function FinalCTA() {
  const { theme } = useTheme();
  const isDark = theme === 'dark';

  return (
    <section
      id="final-cta"
      className="section-container final-cta-section"
      style={{
        minHeight: 'auto',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        textAlign: 'center',
        position: 'relative',
        padding: '90px 20px'
      }}
    >
      {/* Floating outer glow layer */}
      <div
        style={{
          position: 'absolute',
          inset: 0,
          background: isDark
            ? 'radial-gradient(ellipse 70% 60% at 50% 50%, rgba(247, 147, 0, 0.12) 0%, transparent 70%)'
            : 'radial-gradient(ellipse 70% 60% at 50% 50%, rgba(247, 147, 0, 0.07) 0%, transparent 70%)',
          pointerEvents: 'none',
          zIndex: 2
        }}
      />

      <div
        className="final-cta-card"
        style={{
          maxWidth: '870px',
          width: '100%',
          padding: '64px 44px',
          background: isDark ? 'linear-gradient(145deg, #0e1e38 0%, #081220 100%)' : '#ffffff',
          border: isDark ? '1px solid rgba(255, 255, 255, 0.12)' : '1px solid rgba(11, 25, 44, 0.07)',
          borderRadius: '28px',
          boxShadow: isDark
            ? '0 12px 40px rgba(0,0,0,0.6), 0 0 0 1px rgba(247, 147, 0, 0.15)'
            : '0 8px 16px rgba(11, 25, 44, 0.04), 0 32px 80px rgba(11, 25, 44, 0.10), 0 0 0 1px rgba(247, 147, 0, 0.08)',
          position: 'relative',
          zIndex: 4,
          transform: 'translateY(0)',
          transition: 'all 0.4s ease'
        }}
      >
        {/* Top orange accent bar */}
        <div style={{
          position: 'absolute',
          top: 0,
          left: '50%',
          transform: 'translateX(-50%)',
          width: '80px',
          height: '4px',
          background: 'linear-gradient(90deg, #FFB03A, #F79300)',
          borderRadius: '0 0 8px 8px'
        }} />

        <div
          className="section-badge"
          style={{
            background: 'rgba(247, 147, 0, 0.12)',
            borderColor: 'rgba(247, 147, 0, 0.35)',
            color: 'var(--orbit-orange)',
            marginBottom: '24px',
            display: 'inline-flex'
          }}
        >
          <Sparkles size={14} /> CONNECT WITH ORBITONE
        </div>

        <h2
          style={{
            fontSize: 'clamp(2rem, 4vw, 3.2rem)',
            fontWeight: '800',
            fontFamily: 'var(--font-display)',
            lineHeight: 1.15,
            marginBottom: '18px',
            color: isDark ? '#ffffff' : '#0B192C'
          }}
        >
          Ready to <span className="gradient-text-orange">Start Your Project?</span>
        </h2>

        <p
          style={{
            fontSize: '1.14rem',
            color: isDark ? '#cbd5e1' : '#475569',
            maxWidth: '580px',
            margin: '0 auto 38px auto',
            lineHeight: 1.65
          }}
        >
          Let's build something amazing together. Transform your business with state-of-the-art software and digital solutions.
        </p>

        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '16px', justifyContent: 'center' }}>
          <Link to="/contact" className="btn-primary" style={{ padding: '15px 34px', fontSize: '0.98rem' }}>
            GET IN TOUCH <ArrowRight size={18} />
          </Link>
          <Link
            to="/services"
            className="btn-secondary"
            style={{
              padding: '15px 34px',
              fontSize: '0.98rem',
              color: isDark ? '#ffffff' : '#0B192C',
              borderColor: isDark ? 'rgba(255, 255, 255, 0.2)' : 'rgba(11, 25, 44, 0.15)',
              background: isDark ? 'rgba(255, 255, 255, 0.05)' : '#F8FAFC'
            }}
          >
            VIEW OUR SERVICES
          </Link>
        </div>
      </div>
    </section>
  );
}
