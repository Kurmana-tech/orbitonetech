import React from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { Building2, Landmark, HeartPulse, ShoppingBag, Truck, ShieldCheck } from 'lucide-react';

export default function Industries() {
  const sectors = [
    { icon: Landmark, title: 'FinTech & Banking', desc: 'Secure payment gateways, fraud detection algorithms, and real-time ledger compliance.' },
    { icon: HeartPulse, title: 'Healthcare & Life Sciences', desc: 'HIPAA-compliant patient portals, telemedicine software, and AI diagnostic tooling.' },
    { icon: ShoppingBag, title: 'E-Commerce & Retail', desc: 'Headless commerce architecture, personalized product recommendations, and inventory sync.' },
    { icon: Truck, title: 'Logistics & Supply Chain', desc: 'Fleet tracking telematics, route optimization algorithms, and warehouse management.' },
    { icon: Building2, title: 'Real Estate & PropTech', desc: 'Virtual 3D property tours, automated tenant screening, and CRM integration.' },
    { icon: ShieldCheck, title: 'Cybersecurity & Defense', desc: 'Zero-trust architecture, threat monitoring, and automated penetration testing.' }
  ];

  return (
    <div style={{ position: 'relative', width: '100%', minHeight: '100vh', background: 'var(--bg-deep)' }}>
      <Navbar />
      <MainCanvas />

      <main className="content-wrapper" style={{ paddingTop: '140px', paddingBottom: '80px' }}>
        <div style={{ maxWidth: '1240px', margin: '0 auto', padding: '0 5%' }}>
          
          <div style={{ textAlign: 'center', marginBottom: '60px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>
              <Building2 size={14} /> Sector Solutions Matrix
            </div>
            <h1 className="section-title">
              Tailored Industry <span className="gradient-text-orange">Expertise</span>
            </h1>
            <p className="section-description" style={{ maxWidth: '720px', margin: '0 auto' }}>
              Deep domain expertise engineering compliant, high-security software across regulated and fast-growing industries.
            </p>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '28px' }}>
            {sectors.map((sec, idx) => (
              <div key={idx} className="glass-panel" style={{ padding: '32px' }}>
                <sec.icon size={36} color="var(--orbit-orange)" style={{ marginBottom: '20px' }} />
                <h3 style={{ fontSize: '1.3rem', color: 'var(--text-primary)', marginBottom: '12px' }}>{sec.title}</h3>
                <p style={{ color: 'var(--text-secondary)', lineHeight: 1.6, fontSize: '0.95rem' }}>{sec.desc}</p>
              </div>
            ))}
          </div>

        </div>
      </main>

      <Footer />
    </div>
  );
}
