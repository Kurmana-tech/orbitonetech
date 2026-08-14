import React, { useEffect, useRef } from 'react';
import { ArrowRight, TrendingUp } from 'lucide-react';
import { Link } from 'react-router-dom';
import Section3DVisual from './Section3DVisual';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { useTheme } from '../context/ThemeContext';

gsap.registerPlugin(ScrollTrigger);

export default function ServiceSection({ service }) {
  const { theme } = useTheme();
  const { id, sectionNumber, title, description, features, techBadges, metrics, ctaText, imageSrc, glowColor, imageMaxWidth } = service;

  const finalImageSrc = (theme === 'light' && service.imageSrcLight) ? service.imageSrcLight : imageSrc;
  const sectionContentRef = useRef(null);

  useEffect(() => {
    if (!sectionContentRef.current) return;

    const children = sectionContentRef.current.children;
    gsap.set(children, { opacity: 0, y: 25 });

    const anim = gsap.to(children, {
      opacity: 1,
      y: 0,
      duration: 0.8,
      stagger: 0.08,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: sectionContentRef.current,
        start: 'top 85%',
        once: true,
        toggleActions: 'play none none none'
      }
    });

    return () => {
      if (anim.scrollTrigger) anim.scrollTrigger.kill();
      anim.kill();
    };
  }, []);

  return (
    <section
      id={id}
      className="section-container"
      style={{
        minHeight: 'auto',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between',
        position: 'relative',
        paddingTop: '70px',
        paddingBottom: '60px',
        paddingLeft: '6.5%',
        paddingRight: '3%',
        maxWidth: '1650px',
        margin: '0 auto',
        gap: '20px'
      }}
    >
      {/* Left Side: Text Content with ScrollTrigger Entrance */}
      <div ref={sectionContentRef} className="section-content" style={{ flex: '1 1 45%', maxWidth: '560px', zIndex: 3 }}>
        {/* Section Number */}
        <div
          style={{
            fontSize: '1.5rem',
            fontWeight: '800',
            color: 'var(--orbit-orange)',
            marginBottom: '8px',
            fontFamily: 'var(--font-display)'
          }}
        >
          {sectionNumber}
        </div>

        {/* Title */}
        <h2 className="section-title" style={{ fontSize: 'clamp(2.5rem, 4.5vw, 3.8rem)', marginBottom: '20px' }}>
          {title}
        </h2>

        {/* Description */}
        <p className="section-description" style={{ fontSize: '1.15rem', lineHeight: '1.65', color: 'var(--text-secondary)', marginBottom: '32px' }}>
          {description}
        </p>

        {/* Features List */}
        <div className="feature-list" style={{ marginBottom: '32px', display: 'flex', flexDirection: 'column', gap: '14px' }}>
          {features.map((feature, idx) => (
            <div key={idx} className="feature-item" style={{ fontSize: '1.02rem' }}>
              <div className="feature-bullet" />
              <span>{feature}</span>
            </div>
          ))}
        </div>

        {/* Metrics Grid */}
        {metrics && (
          <div
            style={{
              display: 'grid',
              gridTemplateColumns: 'repeat(auto-fit, minmax(140px, 1fr))',
              gap: '16px',
              marginBottom: '32px'
            }}
          >
            {metrics.map((m, idx) => (
              <div
                key={idx}
                className="glass-panel"
                style={{
                  padding: '16px 20px',
                  borderColor: m.highlight ? 'rgba(247, 147, 0, 0.4)' : 'var(--border-glass)',
                  background: m.highlight ? 'rgba(247, 147, 0, 0.08)' : 'var(--bg-glass)'
                }}
              >
                <div style={{ fontSize: '0.78rem', color: 'var(--text-muted)', textTransform: 'uppercase', letterSpacing: '0.5px' }}>
                  {m.label}
                </div>
                <div
                  style={{
                    fontSize: '1.6rem',
                    fontWeight: '800',
                    color: m.highlight ? 'var(--orbit-orange)' : 'var(--text-primary)',
                    marginTop: '4px'
                  }}
                >
                  {m.value}
                </div>
                {m.change && (
                  <div style={{ fontSize: '0.78rem', color: '#10B981', display: 'flex', alignItems: 'center', gap: '4px', marginTop: '2px' }}>
                    <TrendingUp size={12} /> {m.change}
                  </div>
                )}
              </div>
            ))}
          </div>
        )}

        {/* Tech Badges */}
        {techBadges && (
          <div style={{ display: 'flex', flexWrap: 'wrap', gap: '10px', marginBottom: '36px' }}>
            {techBadges.map((badgeText, idx) => (
              <span
                key={idx}
                style={{
                  background: 'var(--bg-glass)',
                  border: '1px solid var(--border-glass)',
                  color: 'var(--electric-blue)',
                  padding: '6px 16px',
                  borderRadius: '20px',
                  fontSize: '0.85rem',
                  fontWeight: '600'
                }}
              >
                {badgeText}
              </span>
            ))}
          </div>
        )}

        {/* CTA Button */}
        <div>
          <Link to="/contact" className="btn-primary">
            {ctaText} <ArrowRight size={18} />
          </Link>
        </div>
      </div>

      {/* Right Side: Parallel Scrolling 3D Section Visual */}
      <div style={{ zIndex: 3, flex: '1.4 1 55%', display: 'flex', justifyContent: 'center', alignItems: 'center', width: '100%' }}>
        <Section3DVisual src={finalImageSrc} alt={title} glowColor={glowColor} maxWidth={imageMaxWidth || '780px'} />
      </div>
    </section>
  );
}
