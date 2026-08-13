import React, { useState } from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { Megaphone, Search, Share2, Calculator, CheckCircle2, ArrowRight, TrendingUp } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function DigitalMarketing() {
  const [adBudget, setAdBudget] = useState(50000);

  const estimatedClicks = Math.round(adBudget / 30);
  const estimatedLeads = Math.round(estimatedClicks * 0.07);

  const seoChecklist = [
    "In-Depth Keyword Research",
    "On-Page SEO & Content Audits",
    "Technical SEO & Page Speed",
    "Schema Markup & Indexing",
    "Local SEO & Google Business"
  ];

  const semChecklist = [
    "Google Ads Search Campaigns",
    "High-Converting Remarketing",
    "Google Shopping & Display",
    "Negative Keyword Hygiene",
    "Bid Strategy Optimization"
  ];

  const socialChecklist = [
    "LinkedIn B2B Ad Strategies",
    "Instagram & Facebook Ads",
    "Strategic Content Creation",
    "Campaign Analytics Tracking",
    "Audience Demographics Tuning"
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
              <Megaphone size={14} /> GROWTH MARKETING
            </div>
            <h1 className="section-title">
              Get Found. Get Noticed. <span className="gradient-text-orange">Grow.</span>
            </h1>
            <p className="section-description" style={{ maxWidth: '750px', margin: '0 auto' }}>
              Data-driven SEO, SEM, and social media campaigns designed to improve online visibility, audience engagement, and sales conversions.
            </p>
          </div>

          {/* 3 Pillar Marketing Services Grid */}
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '28px', marginBottom: '80px' }}>
            
            {/* SEO Card */}
            <div className="glass-panel" style={{ padding: '36px' }}>
              <div style={{ width: '48px', height: '48px', borderRadius: '12px', background: 'rgba(6, 182, 212, 0.15)', display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '20px', border: '1px solid rgba(6, 182, 212, 0.3)' }}>
                <Search size={24} color="#06B6D4" />
              </div>
              <h3 style={{ fontSize: '1.4rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '10px' }}>
                Search Engine Optimization (SEO)
              </h3>
              <p style={{ color: 'var(--text-secondary)', fontSize: '0.92rem', marginBottom: '20px', lineHeight: 1.5 }}>
                Dominate organic search rankings and drive high-intent traffic.
              </p>
              <div style={{ display: 'flex', flexDirection: 'column', gap: '10px' }}>
                {seoChecklist.map((item, idx) => (
                  <div key={idx} style={{ display: 'flex', alignItems: 'center', gap: '10px', fontSize: '0.88rem', color: 'var(--text-secondary)' }}>
                    <CheckCircle2 size={16} color="#06B6D4" />
                    <span>{item}</span>
                  </div>
                ))}
              </div>
            </div>

            {/* SEM Card */}
            <div className="glass-panel" style={{ padding: '36px' }}>
              <div style={{ width: '48px', height: '48px', borderRadius: '12px', background: 'rgba(247, 147, 0, 0.15)', display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '20px', border: '1px solid rgba(247, 147, 0, 0.3)' }}>
                <TrendingUp size={24} color="var(--orbit-orange)" />
              </div>
              <h3 style={{ fontSize: '1.4rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '10px' }}>
                Search Engine Marketing (SEM)
              </h3>
              <p style={{ color: 'var(--text-secondary)', fontSize: '0.92rem', marginBottom: '20px', lineHeight: 1.5 }}>
                Instant targeted leads through hyper-focused PPC advertising.
              </p>
              <div style={{ display: 'flex', flexDirection: 'column', gap: '10px' }}>
                {semChecklist.map((item, idx) => (
                  <div key={idx} style={{ display: 'flex', alignItems: 'center', gap: '10px', fontSize: '0.88rem', color: 'var(--text-secondary)' }}>
                    <CheckCircle2 size={16} color="var(--orbit-orange)" />
                    <span>{item}</span>
                  </div>
                ))}
              </div>
            </div>

            {/* Social Media Card */}
            <div className="glass-panel" style={{ padding: '36px' }}>
              <div style={{ width: '48px', height: '48px', borderRadius: '12px', background: 'rgba(108, 92, 231, 0.15)', display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '20px', border: '1px solid rgba(108, 92, 231, 0.3)' }}>
                <Share2 size={24} color="var(--ai-purple)" />
              </div>
              <h3 style={{ fontSize: '1.4rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '10px' }}>
                Social Media Marketing
              </h3>
              <p style={{ color: 'var(--text-secondary)', fontSize: '0.92rem', marginBottom: '20px', lineHeight: 1.5 }}>
                Build brand equity and convert followers into loyal customers.
              </p>
              <div style={{ display: 'flex', flexDirection: 'column', gap: '10px' }}>
                {socialChecklist.map((item, idx) => (
                  <div key={idx} style={{ display: 'flex', alignItems: 'center', gap: '10px', fontSize: '0.88rem', color: 'var(--text-secondary)' }}>
                    <CheckCircle2 size={16} color="var(--ai-purple)" />
                    <span>{item}</span>
                  </div>
                ))}
              </div>
            </div>

          </div>

          {/* Interactive Digital Marketing Campaign ROI Estimator */}
          <div className="glass-panel" style={{ padding: '40px', borderRadius: '24px', marginBottom: '80px', border: '1px solid rgba(45, 140, 255, 0.3)' }}>
            <h3 style={{ fontSize: '1.5rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '10px', display: 'flex', alignItems: 'center', gap: '10px' }}>
              <Calculator size={22} color="var(--electric-blue)" /> Digital Marketing Campaign ROI Estimator
            </h3>
            <p style={{ color: 'var(--text-secondary)', fontSize: '0.95rem', marginBottom: '32px' }}>
              Adjust the monthly ad spend to estimate potential lead volume and revenue growth:
            </p>

            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))', gap: '40px', alignItems: 'center' }}>
              <div>
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '12px' }}>
                  <span style={{ color: 'var(--text-primary)', fontWeight: 600, fontSize: '1rem' }}>Monthly Ad Budget:</span>
                  <strong style={{ color: 'var(--electric-blue)', fontSize: '1.4rem', fontFamily: 'var(--font-display)' }}>
                    ₹{adBudget.toLocaleString('en-IN')} / mo
                  </strong>
                </div>
                <input
                  type="range"
                  min="10000"
                  max="500000"
                  step="10000"
                  value={adBudget}
                  onChange={(e) => setAdBudget(parseInt(e.target.value))}
                  style={{ width: '100%', accentColor: 'var(--electric-blue)', cursor: 'pointer', height: '8px' }}
                />
              </div>

              {/* Dynamic Estimates Output Card */}
              <div style={{ background: 'var(--bg-surface-elevated)', border: '1px solid var(--border-glass)', borderRadius: '16px', padding: '24px', display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', textAlign: 'center' }}>
                <div>
                  <div style={{ fontSize: '0.78rem', color: 'var(--text-secondary)', fontWeight: 700, textTransform: 'uppercase' }}>Est. Monthly Clicks</div>
                  <div style={{ fontSize: '2.2rem', fontWeight: 800, color: 'var(--orbit-orange)', fontFamily: 'var(--font-display)', marginTop: '4px' }}>
                    {estimatedClicks.toLocaleString('en-IN')}
                  </div>
                </div>

                <div>
                  <div style={{ fontSize: '0.78rem', color: 'var(--text-secondary)', fontWeight: 700, textTransform: 'uppercase' }}>Est. Qualified Leads</div>
                  <div style={{ fontSize: '2.2rem', fontWeight: 800, color: '#10B981', fontFamily: 'var(--font-display)', marginTop: '4px' }}>
                    {estimatedLeads.toLocaleString('en-IN')}
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* CTA Banner */}
          <div className="glass-panel" style={{ padding: '48px 36px', textAlign: 'center', borderRadius: '24px', border: '1px solid rgba(247, 147, 0, 0.3)' }}>
            <h2 style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '16px' }}>Ready to Scale Your Online Revenue?</h2>
            <p style={{ color: 'var(--text-secondary)', marginBottom: '28px', maxWidth: '600px', margin: '0 auto 28px auto' }}>
              Launch high-ROI Search, Social, and Performance Marketing campaigns with Orbitone.
            </p>
            <Link to="/quote" className="btn-primary" style={{ padding: '14px 32px' }}>
              GROW MY BUSINESS <ArrowRight size={18} />
            </Link>
          </div>

        </div>
      </main>

      <Footer />
    </div>
  );
}
