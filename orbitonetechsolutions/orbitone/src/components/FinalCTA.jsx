import React from 'react';
import { Link } from 'react-router-dom';
import { ArrowRight, Sparkles } from 'lucide-react';

export default function FinalCTA() {
  return (
    <section
      id="final-cta"
      className="section-container"
      style={{
        minHeight: 'auto',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        textAlign: 'center',
        position: 'relative',
        padding: '100px 20px'
      }}
    >
      {/* Floating outer glow layer */}
      <div
        style={{
          position: 'absolute',
          inset: 0,
          background: 'radial-gradient(ellipse 70% 60% at 50% 50%, rgba(247, 147, 0, 0.07) 0%, transparent 70%)',
          pointerEvents: 'none',
          zIndex: 2
        }}
      />

      <div
        style={{
          maxWidth: '870px',
          width: '100%',
          padding: '70px 50px',
          background: '#ffffff',
          border: '1px solid rgba(11, 25, 44, 0.07)',
          borderRadius: '28px',
          boxShadow: '0 8px 16px rgba(11, 25, 44, 0.04), 0 32px 80px rgba(11, 25, 44, 0.10), 0 0 0 1px rgba(247, 147, 0, 0.08)',
          position: 'relative',
          zIndex: 4,
          transform: 'translateY(0)',
          transition: 'box-shadow 0.4s ease, transform 0.4s ease'
        }}
        onMouseEnter={e => {
          e.currentTarget.style.boxShadow = '0 16px 32px rgba(11, 25, 44, 0.07), 0 48px 100px rgba(11, 25, 44, 0.14), 0 0 0 1px rgba(247, 147, 0, 0.18)';
          e.currentTarget.style.transform = 'translateY(-6px)';
        }}
        onMouseLeave={e => {
          e.currentTarget.style.boxShadow = '0 8px 16px rgba(11, 25, 44, 0.04), 0 32px 80px rgba(11, 25, 44, 0.10), 0 0 0 1px rgba(247, 147, 0, 0.08)';
          e.currentTarget.style.transform = 'translateY(0)';
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
            background: 'rgba(247, 147, 0, 0.08)',
            borderColor: 'rgba(247, 147, 0, 0.3)',
            color: 'var(--orbit-orange)',
            marginBottom: '28px',
            display: 'inline-flex'
          }}
        >
          <Sparkles size={14} /> CONNECT WITH ORBITONE
        </div>

        <h2
          style={{
            fontSize: 'clamp(2.2rem, 4.5vw, 3.5rem)',
            fontWeight: '800',
            fontFamily: 'var(--font-display)',
            lineHeight: 1.15,
            marginBottom: '20px',
            color: '#0B192C'
          }}
        >
          Ready to <span className="gradient-text-orange">Start Your Project?</span>
        </h2>

        <p
          style={{
            fontSize: '1.18rem',
            color: '#475569',
            maxWidth: '580px',
            margin: '0 auto 44px auto',
            lineHeight: 1.7
          }}
        >
          Let's build something amazing together. Transform your business with state-of-the-art software and digital solutions.
        </p>

        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '16px', justifyContent: 'center' }}>
          <Link to="/contact" className="btn-primary" style={{ padding: '16px 36px', fontSize: '1rem' }}>
            GET IN TOUCH <ArrowRight size={18} />
          </Link>
          <Link to="/services" className="btn-secondary" style={{ padding: '16px 36px', fontSize: '1rem', color: '#0B192C', borderColor: 'rgba(11,25,44,0.15)', background: '#F8FAFC' }}>
            VIEW OUR SERVICES
          </Link>
        </div>
      </div>
    </section>
  );
}
