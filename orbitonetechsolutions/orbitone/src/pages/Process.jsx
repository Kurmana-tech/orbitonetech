import React from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { Layers, CheckCircle } from 'lucide-react';

export default function Process() {
  const steps = [
    { num: '01', title: 'Discovery & Strategic Scoping', desc: 'Requirements workshop, architecture roadmap, technical feasibility audit, and cost breakdown.' },
    { num: '02', title: 'UI/UX Design & Prototyping', desc: 'Wireframing, interactive Figma design prototypes, and user experience validation.' },
    { num: '03', title: 'Agile Software Engineering', desc: 'Iterative sprint development, test-driven development (TDD), and clean modular code.' },
    { num: '04', title: 'QA & Automated Testing', desc: 'Rigorous end-to-end testing, security penetration audits, and load testing.' },
    { num: '05', title: 'Cloud Infrastructure & DevOps', desc: 'CI/CD deployment pipelines, AWS/GCP cloud setup, and zero-downtime release.' },
    { num: '06', title: 'Launch & System Onboarding', desc: 'Production launch, team training, documentation handover, and telemetry monitoring.' },
    { num: '07', title: 'Continuous Evolution & SLA', desc: '24/7 infrastructure monitoring, feature enhancements, and SLA support.' }
  ];

  return (
    <div style={{ position: 'relative', width: '100%', minHeight: '100vh', background: 'var(--bg-deep)' }}>
      <Navbar />
      <MainCanvas />

      <main className="content-wrapper" style={{ paddingTop: '140px', paddingBottom: '80px' }}>
        <div style={{ maxWidth: '1100px', margin: '0 auto', padding: '0 5%' }}>
          
          <div style={{ textAlign: 'center', marginBottom: '60px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>
              <Layers size={14} /> 7-Step Lifecycle
            </div>
            <h1 className="section-title">
              Proven Software Delivery <span className="gradient-text-blue">Process</span>
            </h1>
            <p className="section-description" style={{ maxWidth: '720px', margin: '0 auto' }}>
              Our battle-tested Agile methodology ensures transparent communication, rapid sprint velocity, and enterprise reliability.
            </p>
          </div>

          <div style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
            {steps.map((s, idx) => (
              <div key={idx} className="glass-panel" style={{ padding: '28px', display: 'flex', alignItems: 'center', gap: '24px', flexWrap: 'wrap' }}>
                <div style={{ fontSize: '2.5rem', fontWeight: 800, color: 'var(--orbit-orange)', fontFamily: 'var(--font-display)', minWidth: '60px' }}>
                  {s.num}
                </div>
                <div style={{ flex: 1 }}>
                  <h3 style={{ fontSize: '1.25rem', color: 'var(--text-primary)', marginBottom: '6px' }}>{s.title}</h3>
                  <p style={{ color: 'var(--text-secondary)', fontSize: '0.95rem', lineHeight: 1.5 }}>{s.desc}</p>
                </div>
              </div>
            ))}
          </div>

        </div>
      </main>

      <Footer />
    </div>
  );
}
