import React from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import Laptop3D from '../3d/Laptop3D';
import { Code, Globe, Cpu, Zap, CheckCircle2, ArrowRight, ShieldCheck, Layers, Server, Search } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function WebDevelopment() {
  const spectrumList = [
    "Business & Corporate Websites",
    "High-Converting E-Commerce Platforms",
    "Complex SaaS & Web Applications",
    "Custom Client & Admin Dashboards",
    "REST & GraphQL API Integration",
    "Headless CMS Development",
    "Ongoing SLA Maintenance & Security Updates"
  ];

  const coreFeatures = [
    { title: "Responsive Design", desc: "Flawless display across mobile, tablet, desktop, and ultra-wide monitor screens.", icon: Globe },
    { title: "SEO-Friendly Architecture", desc: "Semantic HTML5 structure, schema JSON-LD markups, and fast SSR for maximum search indexing.", icon: Search },
    { title: "High Performance", desc: "Sub-second load times, optimized image assets, and 100/100 Core Web Vitals targets.", icon: Zap },
    { title: "Security & Compliance", desc: "SSL encryption, CSRF protection, OWASP security standards, and SOC2 compliance.", icon: ShieldCheck },
    { title: "Scalable Cloud Deployment", desc: "Containerized Docker builds, Kubernetes orchestration, and AWS/Vercel CI/CD pipelines.", icon: Server },
    { title: "CMS Integration", desc: "User-friendly Content Management Systems including Strapi, Contentful, and custom PHP admin suites.", icon: Layers }
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
              <Code size={14} /> WEB ENGINEERING
            </div>
            <h1 className="section-title">
              Build a Digital Presence <span className="gradient-text-orange">That Performs</span>
            </h1>
            <p className="section-description" style={{ maxWidth: '750px', margin: '0 auto' }}>
              We design and develop responsive, scalable, and high-performance websites and web applications tailored to enterprise business requirements.
            </p>
          </div>

          {/* 2-Column Overview & Spectrum Box */}
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(360px, 1fr))', gap: '40px', alignItems: 'center', marginBottom: '80px' }}>
            <div>
              <h2 style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '18px' }}>
                Enterprise-Grade Web Architectures
              </h2>
              <p style={{ color: 'var(--text-secondary)', lineHeight: 1.7, fontSize: '1rem', marginBottom: '24px' }}>
                In today's digital landscape, your website is your primary business engine. At Orbitone Tech Solutions, we combine modern frontend engineering with resilient backend systems to deliver lightning-fast, accessible, and conversion-focused web products.
              </p>

              {/* Eco Tag Badges */}
              <div style={{ display: 'flex', gap: '12px', flexWrap: 'wrap', marginBottom: '32px' }}>
                {["Sub-Second Load Times", "100/100 Core Web Vitals", "Mobile-First UX", "SOC2 Security Standard"].map((badge, idx) => (
                  <span key={idx} style={{ display: 'inline-flex', alignItems: 'center', gap: '6px', padding: '6px 14px', borderRadius: '20px', background: 'rgba(45, 140, 255, 0.12)', color: 'var(--electric-blue)', fontSize: '0.82rem', fontWeight: 600, border: '1px solid rgba(45, 140, 255, 0.25)' }}>
                    <CheckCircle2 size={14} color="var(--electric-blue)" /> {badge}
                  </span>
                ))}
              </div>

              <Link to="/quote" className="btn-primary" style={{ padding: '14px 28px' }}>
                BUILD MY WEBSITE <ArrowRight size={16} />
              </Link>
            </div>

            {/* Service Spectrum Glass Card */}
            <div className="glass-panel" style={{ padding: '36px', border: '1px solid rgba(45, 140, 255, 0.25)' }}>
              <h3 style={{ color: 'var(--electric-blue)', fontSize: '1.3rem', fontWeight: 800, marginBottom: '20px', borderBottom: '1px solid var(--border-glass)', paddingBottom: '12px' }}>
                Web Service Spectrum
              </h3>
              <div style={{ display: 'flex', flexDirection: 'column', gap: '14px' }}>
                {spectrumList.map((item, idx) => (
                  <div key={idx} style={{ display: 'flex', alignItems: 'center', gap: '12px', color: 'var(--text-secondary)', fontSize: '0.94rem', borderBottom: idx < spectrumList.length - 1 ? '1px solid var(--border-glass)' : 'none', paddingBottom: '10px' }}>
                    <CheckCircle2 size={16} color="var(--orbit-orange)" />
                    <span>{item}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>

          {/* Core Features Grid */}
          <div style={{ textAlign: 'center', marginBottom: '40px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>ENGINEERING EXCELLENCE</div>
            <h2 style={{ fontSize: '2.2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '12px' }}>Core Web Features</h2>
            <p style={{ color: 'var(--text-secondary)', maxWidth: '600px', margin: '0 auto' }}>Every web project we deliver is built upon six non-negotiable architectural standards.</p>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '28px', marginBottom: '80px' }}>
            {coreFeatures.map((feat, idx) => {
              const IconComp = feat.icon;
              return (
                <div key={idx} className="glass-panel" style={{ padding: '32px' }}>
                  <div style={{ display: 'flex', alignItems: 'center', gap: '14px', marginBottom: '16px' }}>
                    <div style={{ width: '44px', height: '44px', borderRadius: '12px', background: 'rgba(247, 147, 0, 0.15)', display: 'flex', alignItems: 'center', justifyContent: 'center', border: '1px solid rgba(247, 147, 0, 0.3)' }}>
                      <IconComp size={22} color="var(--orbit-orange)" />
                    </div>
                    <h4 style={{ fontSize: '1.2rem', fontWeight: 700, color: 'var(--text-primary)' }}>{feat.title}</h4>
                  </div>
                  <p style={{ color: 'var(--text-secondary)', lineHeight: 1.6, fontSize: '0.94rem' }}>{feat.desc}</p>
                </div>
              );
            })}
          </div>

          {/* CTA Banner */}
          <div className="glass-panel" style={{ padding: '48px 36px', textAlign: 'center', borderRadius: '24px', border: '1px solid rgba(247, 147, 0, 0.3)' }}>
            <h2 style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '16px' }}>Ready to Build Your Custom Web Platform?</h2>
            <p style={{ color: 'var(--text-secondary)', marginBottom: '28px', maxWidth: '600px', margin: '0 auto 28px auto' }}>
              Calculate your estimated project scope and timeline with our instant cost calculator.
            </p>
            <Link to="/quote" className="btn-primary">
              BUILD YOUR WEB ESTIMATE <ArrowRight size={18} />
            </Link>
          </div>

        </div>
      </main>

      <Footer />
    </div>
  );
}
