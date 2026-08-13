import React from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import { ArrowUpRight } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function CaseStudies() {
  const projects = [
    {
      title: "FinTech Automated AI Trading Engine",
      category: "AI & Machine Learning",
      metrics: "340% Efficiency Gain",
      desc: "Architected a real-time neural market prediction platform handling 50k transactions/sec.",
      tech: ["Python", "TensorFlow", "React", "AWS"]
    },
    {
      title: "Global E-Commerce Omnichannel Platform",
      category: "Web & Mobile Development",
      metrics: "$12M Revenue Scale",
      desc: "Built a high-conversion mobile-first web app with headless Shopify API integration.",
      tech: ["React", "Node.js", "GraphQL", "Tailwind"]
    },
    {
      title: "Healthcare Enterprise Analytics Suite",
      category: "Data Analytics",
      metrics: "99.9% Uptime Analytics",
      desc: "Designed real-time hospital patient intelligence dashboards across 45 regional centers.",
      tech: ["Three.js", "PostgreSQL", "Python", "Docker"]
    }
  ];

  return (
    <div style={{ background: 'var(--deep-navy)', minHeight: '100vh', color: 'white' }}>
      <Navbar />

      <main style={{ paddingTop: '160px', paddingBottom: '80px', maxWidth: '1200px', margin: '0 auto', paddingLeft: '4%', paddingRight: '4%' }}>
        <div style={{ textAlign: 'center', marginBottom: '60px' }}>
          <div className="section-badge">PROVEN CLIENT SUCCESS</div>
          <h1 className="section-title" style={{ fontSize: '3.5rem' }}>
            Featured <span className="gradient-text-orange">Case Studies</span>
          </h1>
          <p style={{ fontSize: '1.2rem', color: '#94A3B8', maxWidth: '750px', margin: '0 auto', lineHeight: 1.6 }}>
            Discover how Orbitone Tech Solutions helps industry leaders innovate and achieve measurable results.
          </p>
        </div>

        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(340px, 1fr))', gap: '32px', marginBottom: '80px' }}>
          {projects.map((p, idx) => (
            <div key={idx} className="glass-panel" style={{ padding: '36px', display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
              <div>
                <div style={{ color: 'var(--electric-blue)', fontWeight: 700, fontSize: '0.85rem', marginBottom: '8px' }}>
                  {p.category}
                </div>
                <h3 style={{ fontSize: '1.6rem', fontWeight: 800, marginBottom: '14px' }}>{p.title}</h3>
                <div style={{ color: 'var(--orbit-orange)', fontWeight: 800, fontSize: '1.1rem', marginBottom: '14px' }}>
                  {p.metrics}
                </div>
                <p style={{ color: '#94A3B8', lineHeight: 1.6, marginBottom: '24px' }}>{p.desc}</p>
              </div>
              <div style={{ display: 'flex', gap: '8px', flexWrap: 'wrap' }}>
                {p.tech.map((t, tIdx) => (
                  <span key={tIdx} style={{ background: 'rgba(45,140,255,0.1)', color: 'var(--electric-blue)', padding: '4px 10px', borderRadius: '12px', fontSize: '0.78rem', fontWeight: 600 }}>
                    {t}
                  </span>
                ))}
              </div>
            </div>
          ))}
        </div>
      </main>

      <Footer />
    </div>
  );
}
