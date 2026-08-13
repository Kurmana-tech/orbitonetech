import React, { useState, useRef } from 'react';
import { useTheme } from '../context/ThemeContext';

const roboImg = '/assets/robo-clean-transparent.png';

export default function Hero3DVisual() {
  const { theme } = useTheme();
  const [rotate, setRotate] = useState({ x: 0, y: 0 });
  const [isHovered, setIsHovered] = useState(false);
  const containerRef = useRef(null);

  const handleMouseMove = (e) => {
    if (!containerRef.current) return;
    const rect = containerRef.current.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const centerX = rect.width / 2;
    const centerY = rect.height / 2;
    const rotateX = ((y - centerY) / centerY) * -12;
    const rotateY = ((x - centerX) / centerX) * 12;
    setRotate({ x: rotateX, y: rotateY });
  };

  const handleMouseLeave = () => {
    setIsHovered(false);
    setRotate({ x: 0, y: 0 });
  };

  return (
    <div
      ref={containerRef}
      onMouseMove={handleMouseMove}
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={handleMouseLeave}
      style={{
        position: 'relative',
        width: '100%',
        maxWidth: '1050px',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        perspective: '1500px'
      }}
    >
      {/* Expanded Ambient Electric Blue & Orange Glow Aura (adapted for theme) */}
      <div
        style={{
          position: 'absolute',
          bottom: '10%',
          left: '50%',
          transform: 'translateX(-50%)',
          width: '80%',
          height: '70%',
          background: theme === 'light'
            ? 'radial-gradient(circle at center, rgba(45, 140, 255, 0.12) 0%, rgba(247, 147, 0, 0.06) 50%, var(--glow-fade) 80%)'
            : 'radial-gradient(circle at center, rgba(45, 140, 255, 0.35) 0%, rgba(247, 147, 0, 0.18) 50%, var(--glow-fade) 80%)',
          borderRadius: '50%',
          filter: 'blur(70px)',
          pointerEvents: 'none',
          zIndex: 1,
          animation: 'pulseAura 5s ease-in-out infinite alternate'
        }}
      />

      {/* Floating 3D Artwork Container */}
      <div
        className="floating-hero-artwork"
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
          src={theme === 'light' ? '/assets/robo-light.png' : roboImg}
          alt="Orbitone Technology Ecosystem"
          className="floating-image"
          style={{
            width: '100%',
            height: 'auto',
            maxHeight: '82vh',
            display: 'block',
            objectFit: 'contain',
            opacity: 1,
            transform: 'translateZ(45px)',
            filter: theme === 'light'
              ? (isHovered
                ? `drop-shadow(${-rotate.y * 2}px ${-rotate.x * 2}px 25px rgba(11, 25, 44, 0.15))`
                : 'drop-shadow(0 14px 28px rgba(11, 25, 44, 0.08))')
              : (isHovered
                ? `drop-shadow(${-rotate.y * 2.5}px ${-rotate.x * 2.5}px 45px rgba(45, 140, 255, 0.5))`
                : 'drop-shadow(0 18px 35px rgba(0, 0, 0, 0.45))'),
            transition: 'filter 0.2s ease-out, transform 0.2s ease-out'
          }}
        />
      </div>

      <style>{`
        @keyframes floatHero {
          0%, 100% {
            transform: translateY(0px) rotate(0deg) scale(1);
          }
          50% {
            transform: translateY(-18px) rotate(0.8deg) scale(1.01);
          }
        }
        @keyframes pulseAura {
          0% {
            opacity: 0.7;
            transform: translateX(-50%) scale(0.96);
          }
          100% {
            opacity: 1.0;
            transform: translateX(-50%) scale(1.04);
          }
        }
        .floating-hero-artwork {
          animation: floatHero 6s ease-in-out infinite;
        }
      `}</style>
    </div>
  );
}
