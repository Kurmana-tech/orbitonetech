import React from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { ArrowRight, Cpu, BarChart3, Globe, Smartphone, Bot, BarChart, Filter, Megaphone, CheckCircle2 } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function Services() {
  const techStack = [
    {
      title: "Web Development",
      path: "/web-development",
      desc: "High-performance, responsive websites, progressive web applications, enterprise portals, and headless CMS integrations.",
      tags: ["React & Next.js", "REST / GraphQL APIs", "Sub-Second Speed", "Headless CMS"]
    },
    {
      title: "Application Development",
      path: "/app-development",
      desc: "Cross-platform Android/iOS mobile applications, SaaS products, microservices, and custom enterprise software.",
      tags: ["Swift (iOS)", "Kotlin (Android)", "React Native", "Flutter"]
    },
    {
      title: "AI Solutions",
      path: "/ai-solutions",
      desc: "Machine learning pipelines, custom RAG chat assistants, computer vision, recommendation engines, and workflow automation.",
      tags: ["TensorFlow & PyTorch", "LLM Integration", "RAG Assistants", "Computer Vision"]
    }
  ];

  const dataGrowthStack = [
    {
      title: "Data Analytics",
      path: "/data-analytics",
      desc: "Centralized BI dashboards, automated data ETL pipelines, data cleaning, and real-time executive KPI monitoring.",
      tags: ["Executive BI Dashboards", "ETL Data Pipelines", "Predictive Models", "Real-Time Tracking"]
    },
    {
      title: "Marketing Analytics",
      path: "/marketing-analytics",
      desc: "Multi-touch attribution modeling, conversion funnel intelligence, Customer Acquisition Cost (CAC) and ROAS optimization.",
      tags: ["Attribution Modeling", "CAC & ROAS Optimization", "5-Stage Funnel AI", "Customer LTV"]
    },
    {
      title: "Digital Marketing",
      path: "/digital-marketing",
      desc: "Data-driven SEO, Google Ads SEM campaigns, targeted LinkedIn/Social ad strategies, and content growth marketing.",
      tags: ["Technical SEO", "Google Ads SEM", "Social Media Campaigns", "Conversion Growth"]
    }
  ];

  return (
    <div style={{ position: 'relative', width: '100%', minHeight: '100vh', background: 'var(--bg-deep)' }}>
      <Navbar />
      <MainCanvas />

      <main className="content-wrapper" style={{ paddingTop: '140px', paddingBottom: '80px', maxWidth: '1240px', margin: '0 auto', paddingLeft: '5%', paddingRight: '5%' }}>
        
        {/* Page Header */}
        <div style={{ textAlign: 'center', marginBottom: '60px' }}>
          <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>
            <Cpu size={14} /> COMPREHENSIVE OFFERINGS
          </div>
          <h1 className="section-title">
            Technology &amp; Digital Solutions <span className="gradient-text-orange">Under One Roof</span>
          </h1>
          <p className="section-description" style={{ maxWidth: '760px', margin: '0 auto' }}>
            From initial architecture design to full-scale digital growth campaigns, we provide end-to-end expertise across software engineering and digital marketing.
          </p>
        </div>

        {/* 2-Column Stack Grid */}
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(360px, 1fr))', gap: '32px', marginBottom: '60px' }}>
          
          {/* Tech & AI Column */}
          <div className="glass-panel" style={{ padding: '36px' }}>
            <h3 style={{ color: 'var(--ai-purple)', fontSize: '1.4rem', fontWeight: 800, marginBottom: '24px', display: 'flex', alignItems: 'center', gap: '10px', borderBottom: '1px solid var(--border-glass)', paddingBottom: '16px' }}>
              <Cpu size={22} color="var(--ai-purple)" /> Technology &amp; AI Stack
            </h3>

            <div style={{ display: 'flex', flexDirection: 'column', gap: '24px' }}>
              {techStack.map((item, idx) => (
                <div key={idx} style={{ background: 'var(--bg-surface-elevated)', padding: '24px', borderRadius: '12px', border: '1px solid var(--border-glass)' }}>
                  <h4 style={{ fontSize: '1.25rem', fontWeight: 700, color: 'var(--text-primary)', marginBottom: '8px' }}>{item.title}</h4>
                  <p style={{ color: 'var(--text-secondary)', fontSize: '0.92rem', lineHeight: 1.6, marginBottom: '16px' }}>{item.desc}</p>
                  
                  <div style={{ display: 'flex', gap: '8px', flexWrap: 'wrap', marginBottom: '20px' }}>
                    {item.tags.map((tag, tIdx) => (
                      <span key={tIdx} style={{ fontSize: '0.75rem', padding: '4px 10px', borderRadius: '12px', background: 'rgba(108, 92, 231, 0.15)', color: 'var(--text-primary)', border: '1px solid rgba(108, 92, 231, 0.3)' }}>
                        {tag}
                      </span>
                    ))}
                  </div>

                  <Link to={item.path} className="btn-secondary" style={{ padding: '8px 16px', fontSize: '0.85rem' }}>
                    Explore {item.title} <ArrowRight size={14} />
                  </Link>
                </div>
              ))}
            </div>
          </div>

          {/* Data & Growth Column */}
          <div className="glass-panel" style={{ padding: '36px' }}>
            <h3 style={{ color: 'var(--electric-blue)', fontSize: '1.4rem', fontWeight: 800, marginBottom: '24px', display: 'flex', alignItems: 'center', gap: '10px', borderBottom: '1px solid var(--border-glass)', paddingBottom: '16px' }}>
              <BarChart3 size={22} color="var(--electric-blue)" /> Data &amp; Growth Stack
            </h3>

            <div style={{ display: 'flex', flexDirection: 'column', gap: '24px' }}>
              {dataGrowthStack.map((item, idx) => (
                <div key={idx} style={{ background: 'var(--bg-surface-elevated)', padding: '24px', borderRadius: '12px', border: '1px solid var(--border-glass)' }}>
                  <h4 style={{ fontSize: '1.25rem', fontWeight: 700, color: 'var(--text-primary)', marginBottom: '8px' }}>{item.title}</h4>
                  <p style={{ color: 'var(--text-secondary)', fontSize: '0.92rem', lineHeight: 1.6, marginBottom: '16px' }}>{item.desc}</p>
                  
                  <div style={{ display: 'flex', gap: '8px', flexWrap: 'wrap', marginBottom: '20px' }}>
                    {item.tags.map((tag, tIdx) => (
                      <span key={tIdx} style={{ fontSize: '0.75rem', padding: '4px 10px', borderRadius: '12px', background: 'rgba(45, 140, 255, 0.15)', color: 'var(--text-primary)', border: '1px solid rgba(45, 140, 255, 0.3)' }}>
                        {tag}
                      </span>
                    ))}
                  </div>

                  <Link to={item.path} className="btn-secondary" style={{ padding: '8px 16px', fontSize: '0.85rem' }}>
                    Explore {item.title} <ArrowRight size={14} />
                  </Link>
                </div>
              ))}
            </div>
          </div>

        </div>

        {/* Quick Custom Proposal CTA Banner */}
        <div className="glass-panel" style={{ padding: '48px 36px', textAlign: 'center', borderRadius: '20px', border: '1px solid rgba(247, 147, 0, 0.3)', background: 'linear-gradient(135deg, rgba(7, 25, 54, 0.9) 0%, rgba(11, 31, 77, 0.9) 100%)' }}>
          <h3 style={{ fontSize: '1.8rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '12px' }}>
            Need a Custom Tailored Technology Solution?
          </h3>
          <p style={{ color: 'var(--text-secondary)', maxWidth: '640px', margin: '0 auto 28px auto', fontSize: '1rem', lineHeight: 1.6 }}>
            Our engineering team can combine multiple services into a bespoke digital transformation proposal for your business.
          </p>
          <Link to="/quote" className="btn-primary" style={{ padding: '14px 32px', fontSize: '0.95rem' }}>
            REQUEST A CUSTOM PROPOSAL <ArrowRight size={18} />
          </Link>
        </div>

      </main>

      <Footer />
    </div>
  );
}

