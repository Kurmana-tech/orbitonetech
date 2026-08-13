import React, { useState } from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { Filter, Target, DollarSign, Repeat, Activity, ShieldCheck, ArrowRight } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function MarketingAnalytics() {
  const [activeStage, setActiveStage] = useState('reach');

  const funnelStages = [
    { id: 'reach', title: '1. Reach & Impression Intelligence', metrics: '1.2M Impressions (ROAS 4.2x)', width: '100%', detail: 'Stage 1: Reach — Driving targeted impressions through high-intent SEO, Google Search Ads, and LinkedIn campaign awareness.', color: '#06B6D4' },
    { id: 'engagement', title: '2. Engagement & Site Telemetry', metrics: '185K Clicks (15.4% CTR)', width: '85%', detail: 'Stage 2: Engagement — Tracking user interaction speed, heatmaps, bounce rates, and session durations.', color: '#2D8CFF' },
    { id: 'leads', title: '3. Qualified Inbound Leads', metrics: '12,400 Inquiries (6.7% Conv)', width: '70%', detail: 'Stage 3: Leads — Filtering high-intent enterprise form submissions and scoring lead readiness for sales reps.', color: '#6C5CE7' },
    { id: 'conversion', title: '4. Sales Conversion & Revenue', metrics: '1,850 Customers ($480k ARR)', width: '55%', detail: 'Stage 4: Conversion — Connecting multi-touch attribution credit directly to Stripe/CRM closed-won deals.', color: '#10B981' },
    { id: 'retention', title: '5. Retention & LTV Expansion', metrics: '94% Retention ($1.2M LTV)', width: '40%', detail: 'Stage 5: Retention — Analyzing repeat purchase cohorts, upsells, and long-term customer life value.', color: '#F59E0B' }
  ];

  const currentStageObj = funnelStages.find(s => s.id === activeStage) || funnelStages[0];

  const features = [
    { title: "Multi-Touch Attribution", desc: "Distribute revenue credit accurately across first-touch, linear, and time-decay ad models.", icon: Target },
    { title: "Return On Ad Spend (ROAS)", desc: "Real-time campaign tracking linking Google Ads, Meta Ads, and LinkedIn Ads directly to sales CRM.", icon: DollarSign },
    { title: "Customer Lifetime Value (CLV)", desc: "Cohort analysis mapping long-term repeat purchase frequency and customer retention value.", icon: Repeat },
    { title: "GA4 & Tag Management", desc: "Custom Google Analytics 4 event tracking, Google Tag Manager server-side containers, and privacy compliance.", icon: Activity },
    { title: "Conversion Rate Optimization (CRO)", desc: "A/B testing landing page variants, heatmaps, session recordings, and checkout friction analysis.", icon: Filter },
    { title: "Lead Scoring & Pipeline Analytics", desc: "Automated lead quality scoring connecting web form submissions to sales rep conversion speed.", icon: ShieldCheck }
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
              <Filter size={14} /> PERFORMANCE INTELLIGENCE
            </div>
            <h1 className="section-title">
              Measure <span className="gradient-text-orange">What Matters</span>
            </h1>
            <p className="section-description" style={{ maxWidth: '750px', margin: '0 auto' }}>
              Understand exactly where your marketing investment is generating revenue and where it needs data-driven optimization.
            </p>
          </div>

          {/* Interactive Customer Acquisition Funnel */}
          <div style={{ marginBottom: '80px' }}>
            <div style={{ textAlign: 'center', marginBottom: '32px' }}>
              <h2 style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '8px' }}>
                Interactive Customer Acquisition Funnel
              </h2>
              <p style={{ color: 'var(--text-secondary)', fontSize: '0.95rem' }}>
                Click any funnel stage below to inspect telemetry and conversion metrics:
              </p>
            </div>

            {/* Funnel Steps Stack */}
            <div style={{ display: 'flex', flexDirection: 'column', gap: '14px', maxWidth: '850px', margin: '0 auto' }}>
              {funnelStages.map((stage) => {
                const isSelected = activeStage === stage.id;
                return (
                  <div
                    key={stage.id}
                    onClick={() => setActiveStage(stage.id)}
                    style={{
                      width: stage.width,
                      margin: '0 auto',
                      padding: '20px 24px',
                      borderRadius: '16px',
                      background: isSelected ? 'rgba(247, 147, 0, 0.12)' : 'var(--bg-surface-elevated)',
                      border: isSelected ? '2px solid var(--orbit-orange)' : '1px solid var(--border-glass)',
                      cursor: 'pointer',
                      display: 'flex',
                      alignItems: 'center',
                      justifyContent: 'space-between',
                      flexWrap: 'wrap',
                      gap: '12px',
                      transition: 'all 0.3s ease',
                      boxShadow: isSelected ? '0 8px 25px rgba(247, 147, 0, 0.2)' : 'none'
                    }}
                  >
                    <h4 style={{ fontSize: '1.05rem', fontWeight: 700, color: 'var(--text-primary)', display: 'flex', alignItems: 'center', gap: '10px' }}>
                      <span style={{ color: stage.color }}>●</span> {stage.title}
                    </h4>
                    <span style={{ fontSize: '0.85rem', fontWeight: 700, padding: '4px 12px', borderRadius: '12px', background: 'rgba(255, 255, 255, 0.08)', color: 'var(--orbit-orange)' }}>
                      {stage.metrics}
                    </span>
                  </div>
                );
              })}
            </div>

            {/* Funnel Stage Detail Card */}
            <div className="glass-panel" style={{ marginTop: '24px', maxWidth: '850px', margin: '24px auto 0 auto', padding: '24px', textAlign: 'center', border: '1px solid rgba(247, 147, 0, 0.3)' }}>
              <div style={{ color: 'var(--text-primary)', fontWeight: 700, fontSize: '1.05rem', lineHeight: 1.6 }}>
                {currentStageObj.detail}
              </div>
            </div>
          </div>

          {/* 6 Feature Cards Grid */}
          <div style={{ textAlign: 'center', marginBottom: '40px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>MEASUREMENT CAPABILITIES</div>
            <h2 style={{ fontSize: '2.2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '12px' }}>
              Marketing Analytics Spectrum
            </h2>
            <p style={{ color: 'var(--text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
              Multi-touch attribution models and campaign intelligence software.
            </p>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '28px', marginBottom: '80px' }}>
            {features.map((f, idx) => {
              const IconComp = f.icon;
              return (
                <div key={idx} className="glass-panel" style={{ padding: '32px' }}>
                  <div style={{ display: 'flex', alignItems: 'center', gap: '14px', marginBottom: '16px' }}>
                    <div style={{ width: '44px', height: '44px', borderRadius: '12px', background: 'rgba(247, 147, 0, 0.15)', display: 'flex', alignItems: 'center', justifyContent: 'center', border: '1px solid rgba(247, 147, 0, 0.3)' }}>
                      <IconComp size={22} color="var(--orbit-orange)" />
                    </div>
                    <h4 style={{ fontSize: '1.2rem', fontWeight: 700, color: 'var(--text-primary)' }}>{f.title}</h4>
                  </div>
                  <p style={{ color: 'var(--text-secondary)', lineHeight: 1.6, fontSize: '0.94rem' }}>{f.desc}</p>
                </div>
              );
            })}
          </div>

          {/* CTA Banner */}
          <div className="glass-panel" style={{ padding: '48px 36px', textAlign: 'center', borderRadius: '24px', border: '1px solid rgba(247, 147, 0, 0.3)' }}>
            <h2 style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '16px' }}>Ready to Optimize Your Marketing Funnel ROAS?</h2>
            <p style={{ color: 'var(--text-secondary)', marginBottom: '28px', maxWidth: '600px', margin: '0 auto 28px auto' }}>
              Connect your Google Ads, Meta Ads, and CRM data into a single multi-touch attribution engine.
            </p>
            <Link to="/quote" className="btn-primary">
              GET MARKETING ANALYTICS <ArrowRight size={18} />
            </Link>
          </div>

        </div>
      </main>

      <Footer />
    </div>
  );
}
