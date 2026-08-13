import React from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { Target, Eye, ShieldCheck, Award, Users, Globe2, Sparkles } from 'lucide-react';

export default function About() {
  return (
    <div style={{ position: 'relative', width: '100%', minHeight: '100vh', background: 'var(--bg-deep)' }}>
      <Navbar />
      <MainCanvas />

      <main className="content-wrapper" style={{ paddingTop: '140px', paddingBottom: '80px', maxWidth: '1240px', margin: '0 auto', paddingLeft: '5%', paddingRight: '5%' }}>
        <div style={{ textAlign: 'center', marginBottom: '60px' }}>
          <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>
            ABOUT ORBITONE TECH SOLUTIONS
          </div>
          <h1 className="section-title">
            Innovate. Integrate. <span className="gradient-text-orange">Elevate.</span>
          </h1>
          <p className="section-description" style={{ maxWidth: '750px', margin: '0 auto' }}>
            Orbitone Tech Solutions combines technology, artificial intelligence, data analytics, and digital marketing to build high-performance products and drive revenue growth.
          </p>
        </div>

        {/* Metrics Bar */}
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '20px', marginBottom: '60px' }}>
          {[
            { num: '45+', label: 'Enterprise Projects Delivered' },
            { num: '99.8%', label: 'On-Time Sprint Velocity' },
            { num: '12+', label: 'Industries Served Globally' },
            { num: '24/7', label: 'Continuous SLA Operations' }
          ].map((stat, idx) => (
            <div key={idx} className="glass-panel" style={{ padding: '24px', textAlign: 'center' }}>
              <div style={{ fontSize: '2.2rem', fontWeight: 800, color: 'var(--orbit-orange)', fontFamily: 'var(--font-display)' }}>
                {stat.num}
              </div>
              <div style={{ fontSize: '0.88rem', color: 'var(--text-secondary)', marginTop: '4px' }}>
                {stat.label}
              </div>
            </div>
          ))}
        </div>

        {/* Grid of Values */}
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))', gap: '28px', marginBottom: '80px' }}>
          <div className="glass-panel" style={{ padding: '36px' }}>
            <Target size={40} color="var(--orbit-orange)" style={{ marginBottom: '20px' }} />
            <h3 style={{ fontSize: '1.4rem', fontWeight: 700, color: 'var(--text-primary)', marginBottom: '12px' }}>Our Mission</h3>
            <p style={{ color: 'var(--text-secondary)', lineHeight: 1.6 }}>
              To engineer transformative digital solutions that automate complexities, accelerate growth, and deliver scalable enterprise impact.
            </p>
          </div>

          <div className="glass-panel" style={{ padding: '36px' }}>
            <Eye size={40} color="var(--electric-blue)" style={{ marginBottom: '20px' }} />
            <h3 style={{ fontSize: '1.4rem', fontWeight: 700, color: 'var(--text-primary)', marginBottom: '12px' }}>Our Vision</h3>
            <p style={{ color: 'var(--text-secondary)', lineHeight: 1.6 }}>
              To lead as a globally recognized ecosystem for technology innovation, shaping how modern enterprises connect with AI and cloud technology.
            </p>
          </div>

          <div className="glass-panel" style={{ padding: '36px' }}>
            <ShieldCheck size={40} color="var(--ai-purple)" style={{ marginBottom: '20px' }} />
            <h3 style={{ fontSize: '1.4rem', fontWeight: 700, color: 'var(--text-primary)', marginBottom: '12px' }}>Our Core Values</h3>
            <p style={{ color: 'var(--text-secondary)', lineHeight: 1.6 }}>
              Uncompromising quality, continuous innovation, transparent collaboration, and a relentless focus on client success.
            </p>
          </div>
        </div>
      </main>

      <Footer />
    </div>
  );
}

