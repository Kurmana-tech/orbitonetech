import React from 'react';
import { Link } from 'react-router-dom';
import { ArrowRight, Play } from 'lucide-react';
import Hero3DVisual from './Hero3DVisual';

export default function HeroSection({ onWatchStory }) {
  return (
    <section
      id="hero-section"
      className="section-container"
      style={{
        minHeight: 'auto',
        position: 'relative',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between',
        paddingTop: '30px',
        paddingBottom: '40px',
        paddingLeft: '6.5%',
        paddingRight: '3%',
        maxWidth: '1650px',
        margin: '0 auto',
        gap: '20px'
      }}
    >
      {/* Left Side: Copywriting & CTAs - Shifted slightly to the right */}
      <div className="section-content" style={{ flex: '1 1 38%', maxWidth: '520px', zIndex: 3 }}>
        {/* Main Heading */}
        <h1
          style={{
            fontSize: 'clamp(2.5rem, 4.5vw, 4.0rem)',
            fontWeight: 800,
            lineHeight: 1.1,
            marginBottom: '20px',
            fontFamily: 'var(--font-display)',
            letterSpacing: '-0.02em'
          }}
        >
          Innovate. <br />
          Integrate. <br />
          Elevate <span className="gradient-text-orange">Your Business.</span>
        </h1>

        {/* Supporting text */}
        <p
          style={{
            fontSize: '1.12rem',
            lineHeight: 1.6,
            color: 'var(--text-secondary)',
            marginBottom: '36px',
            fontWeight: 400
          }}
        >
          End-to-end technology and digital solutions that drive growth, efficiency and innovation.
        </p>

        {/* CTA Buttons */}
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '16px', alignItems: 'center', marginBottom: '36px' }}>
          <a href="#web-development" className="btn-primary">
            OUR SERVICES <ArrowRight size={18} />
          </a>
          <Link to="/contact" className="btn-secondary">
            CONTACT US
          </Link>
        </div>

        {/* Watch Story Action */}
        <div style={{ display: 'flex', alignItems: 'center', gap: '14px' }}>
          <button
            onClick={onWatchStory}
            style={{
              width: '48px',
              height: '48px',
              borderRadius: '50%',
              background: 'rgba(45, 140, 255, 0.15)',
              border: '1px solid rgba(45, 140, 255, 0.4)',
              color: 'var(--electric-blue)',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              cursor: 'pointer',
              boxShadow: '0 0 20px rgba(45, 140, 255, 0.3)',
              transition: 'all 0.3s ease'
            }}
            className="pulse-glow"
            aria-label="Watch Our Story"
          >
            <Play size={20} fill="currentColor" style={{ marginLeft: '3px' }} />
          </button>
          <div>
            <div style={{ fontWeight: '700', fontSize: '0.95rem', color: 'var(--text-primary)' }}>WATCH OUR STORY</div>
            <div style={{ fontSize: '0.85rem', color: 'var(--text-secondary)' }}>See how we create impact</div>
          </div>
        </div>
      </div>

      {/* Right Side: 3D Robot Visual */}
      <div style={{ zIndex: 3, flex: '1.5 1 60%', display: 'flex', justifyContent: 'center', alignItems: 'center', width: '100%' }}>
        <Hero3DVisual />
      </div>
    </section>
  );
}
