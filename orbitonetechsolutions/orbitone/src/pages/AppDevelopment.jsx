import React from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import Smartphones3D from '../3d/Smartphones3D';
import { Smartphone, Cloud, Layers, CheckCircle2, ArrowRight, Code, ShieldCheck, Cpu } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function AppDevelopment() {
  const pillars = [
    {
      title: "Mobile Applications",
      desc: "Native iOS (Swift), Android (Kotlin), and Flutter cross-platform mobile app development with offline capabilities and push notification servers.",
      icon: Smartphone,
      color: "var(--electric-blue)"
    },
    {
      title: "SaaS & Cloud Platforms",
      desc: "Multi-tenant Software-as-a-Service platforms built on resilient AWS/GCP cloud infrastructure with automated subscription billing integrations.",
      icon: Cloud,
      color: "var(--ai-purple)"
    },
    {
      title: "Enterprise Software",
      desc: "Custom ERP/CRM tools, internal enterprise portals, workflow automation software, and legacy system modernization.",
      icon: Layers,
      color: "var(--orbit-orange)"
    }
  ];

  const lifecycleSteps = [
    { num: "01", title: "Idea", desc: "Scoping & Requirements" },
    { num: "02", title: "UI/UX", desc: "Wireframes & Prototypes" },
    { num: "03", title: "Development", desc: "Agile Sprints & Code" },
    { num: "04", title: "Testing", desc: "QA & Security Audits" },
    { num: "05", title: "Deployment", desc: "App Store & Cloud Release" },
    { num: "06", title: "Maintenance", desc: "Updates & SLA Support" }
  ];

  return (
    <div style={{ position: 'relative', width: '100%', minHeight: '100vh', background: 'var(--bg-deep)' }}>
      <Navbar />
      <MainCanvas />

      <main className="content-wrapper" style={{ paddingTop: '140px', paddingBottom: '80px' }}>
        <div style={{ maxWidth: '1240px', margin: '0 auto', padding: '0 5%' }}>
          
          {/* Header */}
          <div style={{ textAlign: 'center', marginBottom: '60px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>
              <Smartphone size={14} /> SOFTWARE ENGINEERING
            </div>
            <h1 className="section-title">
              Application Development <span className="gradient-text-orange">Engineered for Scale</span>
            </h1>
            <p className="section-description" style={{ maxWidth: '750px', margin: '0 auto' }}>
              Custom mobile software, enterprise SaaS applications, microservices, and cross-platform mobile solutions tailored to your business needs.
            </p>
          </div>

          {/* 3 Pillars Grid */}
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '28px', marginBottom: '80px' }}>
            {pillars.map((p, idx) => {
              const IconComp = p.icon;
              return (
                <div key={idx} className="glass-panel" style={{ padding: '36px' }}>
                  <div style={{ width: '48px', height: '48px', borderRadius: '12px', background: 'rgba(255, 255, 255, 0.06)', display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '20px', border: '1px solid var(--border-glass)' }}>
                    <IconComp size={24} color={p.color} />
                  </div>
                  <h3 style={{ fontSize: '1.4rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '12px' }}>{p.title}</h3>
                  <p style={{ color: 'var(--text-secondary)', lineHeight: 1.6, fontSize: '0.95rem' }}>{p.desc}</p>
                </div>
              );
            })}
          </div>

          {/* Lifecycle Steps */}
          <div style={{ textAlign: 'center', marginBottom: '40px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>LIFECYCLE JOURNEY</div>
            <h2 style={{ fontSize: '2.2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '12px' }}>
              Application Development Process
            </h2>
            <p style={{ color: 'var(--text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
              A systematic 6-stage engineering lifecycle that minimizes risk and guarantees quality.
            </p>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(170px, 1fr))', gap: '16px', marginBottom: '80px' }}>
            {lifecycleSteps.map((step, idx) => (
              <div key={idx} className="glass-panel" style={{ padding: '24px 16px', textAlign: 'center', background: 'var(--bg-surface-elevated)' }}>
                <div style={{ fontSize: '0.8rem', fontWeight: 800, color: 'var(--orbit-orange)', marginBottom: '8px', letterSpacing: '0.05em' }}>
                  STEP {step.num}
                </div>
                <h4 style={{ fontSize: '1.1rem', fontWeight: 700, color: 'var(--text-primary)', marginBottom: '4px' }}>{step.title}</h4>
                <p style={{ fontSize: '0.8rem', color: 'var(--text-muted)' }}>{step.desc}</p>
              </div>
            ))}
          </div>

          {/* CTA Banner */}
          <div className="glass-panel" style={{ padding: '48px 36px', textAlign: 'center', borderRadius: '24px', border: '1px solid rgba(247, 147, 0, 0.3)' }}>
            <h2 style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '16px' }}>Ready to Launch Your Mobile or Cloud SaaS App?</h2>
            <p style={{ color: 'var(--text-secondary)', marginBottom: '28px', maxWidth: '600px', margin: '0 auto 28px auto' }}>
              Our engineering team is ready to scope your software project.
            </p>
            <Link to="/quote" className="btn-primary">
              START APPLICATION PROJECT <ArrowRight size={18} />
            </Link>
          </div>

        </div>
      </main>

      <Footer />
    </div>
  );
}
