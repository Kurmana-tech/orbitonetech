import React, { useState, useEffect, useRef } from 'react';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { useTheme } from '../context/ThemeContext';

gsap.registerPlugin(ScrollTrigger);

export default function Section3DVisual({ src, alt, glowColor = 'rgba(45, 140, 255, 0.4)', maxWidth = '780px' }) {
  const { theme } = useTheme();
  const containerRef = useRef(null);
  const imageRef = useRef(null);
  const [rotate, setRotate] = useState({ x: 0, y: 0 });
  const [isHovered, setIsHovered] = useState(false);

  // Mouse Parallax
  useEffect(() => {
    const handleMouseMove = (e) => {
      const x = (e.clientX / window.innerWidth - 0.5) * 14;
      const y = (e.clientY / window.innerHeight - 0.5) * -14;
      setRotate({ x: y, y: x });
    };

    window.addEventListener('mousemove', handleMouseMove);
    return () => window.removeEventListener('mousemove', handleMouseMove);
  }, []);

  // ScrollTrigger Scroll-Driven Animation (Fade, Scale & Depth Tilt on Scroll)
  useEffect(() => {
    if (!containerRef.current || !imageRef.current) return;

    const el = containerRef.current;
    const img = imageRef.current;

    gsap.set(img, { opacity: 0.2, scale: 0.9, y: 40 });

    const anim = gsap.to(img, {
      opacity: 1,
      scale: 1,
      y: 0,
      duration: 1.2,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: el,
        start: 'top 82%',
        end: 'bottom 20%',
        toggleActions: 'play reverse play reverse'
      }
    });

    return () => {
      if (anim.scrollTrigger) anim.scrollTrigger.kill();
      anim.kill();
    };
  }, []);

  const adaptedGlow = theme === 'light'
    ? glowColor.replace('0.45', '0.12').replace('0.5', '0.12').replace('0.4', '0.12')
    : glowColor;

  const hoverShadowColor = theme === 'light'
    ? glowColor.replace('0.45', '0.22').replace('0.5', '0.22').replace('0.4', '0.22')
    : glowColor.replace('0.45', '0.5').replace('0.5', '0.55').replace('0.4', '0.5');

  const defaultShadowColor = theme === 'light'
    ? glowColor.replace('0.45', '0.12').replace('0.5', '0.12').replace('0.4', '0.12')
    : 'rgba(0, 0, 0, 0.45)';

  return (
    <div
      ref={containerRef}
      style={{
        position: 'relative',
        width: '100%',
        maxWidth: maxWidth,
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        perspective: '1400px'
      }}
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => {
        setIsHovered(false);
        setRotate({ x: 0, y: 0 });
      }}
    >
      {/* Section Ambient Glow Aura */}
      <div
        style={{
          position: 'absolute',
          bottom: '10%',
          left: '50%',
          transform: 'translateX(-50%)',
          width: '80%',
          height: '65%',
          background: `radial-gradient(circle at center, ${adaptedGlow} 0%, var(--glow-fade) 75%)`,
          borderRadius: '50%',
          filter: 'blur(60px)',
          pointerEvents: 'none',
          zIndex: 1,
          animation: 'pulseSectionAura 4.5s ease-in-out infinite alternate'
        }}
      />

      {/* Floating 3D Artwork Container with Scroll-Triggered Animation */}
      <div
        className="floating-section-artwork"
        style={{
          position: 'relative',
          width: '100%',
          zIndex: 2,
          transform: `rotateX(${rotate.x}deg) rotateY(${rotate.y}deg) ${isHovered ? 'scale(1.035)' : 'scale(1)'}`,
          transition: isHovered ? 'transform 0.15s ease-out' : 'transform 0.8s cubic-bezier(0.16, 1, 0.3, 1)',
          display: 'flex',
          justifyContent: 'center',
          alignItems: 'center',
          transformStyle: 'preserve-3d'
        }}
      >
        <img
          ref={imageRef}
          src={src}
          alt={alt}
          className="floating-image"
          style={{
            width: '100%',
            height: 'auto',
            maxHeight: '82vh',
            display: 'block',
            objectFit: 'contain',
            opacity: 1,
            transform: 'translateZ(35px)',
            filter: theme === 'light'
              ? (isHovered
                ? `drop-shadow(${-rotate.y * 1.8}px ${-rotate.x * 1.8}px 25px rgba(11, 25, 44, 0.12))`
                : 'drop-shadow(0 12px 26px rgba(11, 25, 44, 0.07))')
              : (isHovered
                ? `drop-shadow(${-rotate.y * 2.2}px ${-rotate.x * 2.2}px 35px ${hoverShadowColor})`
                : `drop-shadow(0 15px 30px ${defaultShadowColor})`),
            transition: 'filter 0.2s ease-out, transform 0.2s ease-out'
          }}
        />
      </div>

      <style>{`
        @keyframes floatSectionVisual {
          0%, 100% {
            transform: translateY(0px) rotate(0deg) scale(1);
          }
          50% {
            transform: translateY(-14px) rotate(-0.8deg) scale(1.01);
          }
        }
        @keyframes pulseSectionAura {
          0% {
            opacity: 0.6;
            transform: translateX(-50%) scale(0.95);
          }
          100% {
            opacity: 1.0;
            transform: translateX(-50%) scale(1.05);
          }
        }
        .floating-section-artwork {
          animation: floatSectionVisual 6s ease-in-out infinite;
        }
      `}</style>
    </div>
  );
}
