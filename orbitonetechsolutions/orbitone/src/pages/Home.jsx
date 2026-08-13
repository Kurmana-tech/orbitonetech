import React, { useState } from 'react';
import Navbar from '../components/Navbar';
import MainCanvas from '../3d/MainCanvas';
import HeroSection from '../components/HeroSection';
import ServiceSection from '../components/ServiceSection';
import FinalCTA from '../components/FinalCTA';
import Footer from '../components/Footer';
import { SERVICES_DATA } from '../data/services';
import { X, Play } from 'lucide-react';

export default function Home() {
  const [showVideoModal, setShowVideoModal] = useState(false);

  return (
    <div style={{ position: 'relative', width: '100%', background: 'var(--bg-deep)', minHeight: '100vh' }}>
      {/* Fixed Sticky Top Navbar */}
      <Navbar />

      {/* Background Interactive 3D Canvas */}
      <MainCanvas />

      {/* 2D Scroll-Driven Content Overlay */}
      <main className="content-wrapper">
        {/* Section 01: Hero */}
        <HeroSection onWatchStory={() => setShowVideoModal(true)} />

        {/* Sections 02 - 07: Services */}
        {SERVICES_DATA.map((service) => (
          <ServiceSection key={service.id} service={service} />
        ))}

        {/* Section 08: Final CTA */}
        <FinalCTA />

        {/* Footer */}
        <Footer />
      </main>

      {/* Story Video Modal Overlay */}
      {showVideoModal && (
        <div
          style={{
            position: 'fixed',
            top: 0,
            left: 0,
            width: '100vw',
            height: '100vh',
            background: 'rgba(4, 15, 36, 0.95)',
            backdropFilter: 'blur(20px)',
            zIndex: 2000,
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            padding: '20px'
          }}
          onClick={() => setShowVideoModal(false)}
        >
          <div
            style={{
              position: 'relative',
              width: '100%',
              maxWidth: '900px',
              aspectRatio: '16/9',
              background: '#071936',
              borderRadius: '16px',
              overflow: 'hidden',
              border: '1px solid rgba(247, 147, 0, 0.3)',
              boxShadow: '0 25px 60px rgba(0,0,0,0.8)'
            }}
            onClick={(e) => e.stopPropagation()}
          >
            <button
              onClick={() => setShowVideoModal(false)}
              style={{
                position: 'absolute',
                top: '16px',
                right: '16px',
                background: 'rgba(0,0,0,0.6)',
                border: 'none',
                color: 'white',
                borderRadius: '50%',
                width: '40px',
                height: '40px',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                cursor: 'pointer',
                zIndex: 10
              }}
            >
              <X size={24} />
            </button>

            <iframe
              width="100%"
              height="100%"
              src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1"
              title="Orbitone Story"
              frameBorder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowFullScreen
            ></iframe>
          </div>
        </div>
      )}
    </div>
  );
}
