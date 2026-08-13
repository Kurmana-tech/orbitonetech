import React, { useState } from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { BarChart3, Database, LineChart, TrendingUp, Filter, Bell, ArrowRight } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function DataAnalytics() {
  const [activeMetric, setActiveMetric] = useState('revenue');

  const metricData = {
    revenue: {
      val: "$1,480,000",
      revChange: "+34.2% MoM",
      growth: "+34.2%",
      desc: "Real-time revenue attribution aggregated across multi-channel SaaS & enterprise licensing.",
      bars: [40, 65, 80, 55, 90, 75, 100]
    },
    customers: {
      val: "28,900 Active Users",
      revChange: "+42.1% MoM",
      growth: "+52.1%",
      desc: "Active user retention and cohorts segmented across mid-market and enterprise tiers.",
      bars: [30, 45, 60, 75, 85, 95, 110]
    },
    conversion: {
      val: "8.40% Funnel Efficiency",
      revChange: "+22.0% MoM",
      growth: "+28.4%",
      desc: "End-to-end inbound conversion efficiency tracking from initial impression to paid contract.",
      bars: [50, 70, 65, 85, 90, 95, 100]
    },
    performance: {
      val: "99.99% Throughput SLA",
      revChange: "42ms API Latency",
      growth: "+99.9%",
      desc: "High-availability data pipeline latency tracking processing over 12M daily transactions.",
      bars: [95, 98, 99, 97, 100, 99, 100]
    }
  };

  const current = metricData[activeMetric] || metricData.revenue;

  const features = [
    { title: "Data Cleaning & Preprocessing", desc: "Automated removal of duplicates, missing value imputation, and schema standardization.", icon: Database },
    { title: "Automated Data Pipelines (ETL)", desc: "Scheduled data ingestion workflows connecting Snowflake, PostgreSQL, BigQuery, and APIs.", icon: LineChart },
    { title: "Interactive Data Visualization", desc: "Custom executive BI dashboards built in Power BI, Tableau, and embedded React chart frameworks.", icon: BarChart3 },
    { title: "Business Intelligence (BI)", desc: "Consolidate sales, operations, and financial metrics into a single unified executive view.", icon: TrendingUp },
    { title: "Predictive Data Analytics", desc: "Leverage statistical models to anticipate market trends, seasonal demand, and customer behavior.", icon: Filter },
    { title: "KPI Tracking & Automated Alerts", desc: "Real-time Slack/Email alerts triggered when performance metrics breach operational thresholds.", icon: Bell }
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
              <BarChart3 size={14} /> BUSINESS INTELLIGENCE
            </div>
            <h1 className="section-title">
              Turn Data Into <span className="gradient-text-orange">Decisions</span>
            </h1>
            <p className="section-description" style={{ maxWidth: '750px', margin: '0 auto' }}>
              Businesses generate enormous amounts of data. We help transform that raw data into actionable insights through analytics, visualization, and executive reporting.
            </p>
          </div>

          {/* Interactive BI Console */}
          <div className="glass-panel" style={{ padding: '36px', borderRadius: '24px', marginBottom: '80px', border: '1px solid rgba(45, 140, 255, 0.3)' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', flexWrap: 'wrap', gap: '16px', marginBottom: '28px' }}>
              <div>
                <h3 style={{ fontSize: '1.4rem', color: 'var(--text-primary)', fontWeight: 700 }}>
                  Interactive BI Dashboard Preview
                </h3>
                <p style={{ color: 'var(--text-secondary)', fontSize: '0.9rem' }}>
                  Click tabs below to test live metric switching and chart rendering:
                </p>
              </div>

              {/* Metric Tabs */}
              <div style={{ display: 'flex', gap: '10px', flexWrap: 'wrap' }}>
                {[
                  { key: 'revenue', label: 'Revenue Stream' },
                  { key: 'customers', label: 'Customer Acquisition' },
                  { key: 'conversion', label: 'Conversion Funnel' },
                  { key: 'performance', label: 'System Performance' }
                ].map(t => (
                  <button
                    key={t.key}
                    onClick={() => setActiveMetric(t.key)}
                    style={{
                      padding: '8px 16px',
                      borderRadius: '20px',
                      border: activeMetric === t.key ? '1px solid var(--orbit-orange)' : '1px solid var(--border-glass)',
                      background: activeMetric === t.key ? 'var(--orbit-orange)' : 'var(--bg-surface-elevated)',
                      color: '#FFFFFF',
                      fontWeight: 600,
                      cursor: 'pointer',
                      fontSize: '0.86rem',
                      transition: 'all 0.3s'
                    }}
                  >
                    {t.label}
                  </button>
                ))}
              </div>
            </div>

            {/* Dashboard Metric Highlight */}
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))', gap: '20px', marginBottom: '36px' }}>
              <div style={{ padding: '20px', borderRadius: '12px', background: 'var(--bg-surface-elevated)', border: '1px solid var(--border-glass)' }}>
                <div style={{ fontSize: '0.85rem', color: 'var(--text-muted)', marginBottom: '4px' }}>SELECTED METRIC</div>
                <div style={{ fontSize: '1.8rem', fontWeight: 800, color: 'var(--text-primary)', fontFamily: 'var(--font-display)' }}>
                  {current.val}
                </div>
                <div style={{ fontSize: '0.85rem', color: '#10B981', fontWeight: 600, marginTop: '4px' }}>
                  {current.growth} Growth Benchmark
                </div>
              </div>

              <div style={{ padding: '20px', borderRadius: '12px', background: 'var(--bg-surface-elevated)', border: '1px solid var(--border-glass)', gridColumn: 'span 2' }}>
                <div style={{ fontSize: '0.85rem', color: 'var(--text-muted)', marginBottom: '4px' }}>INSIGHT SUMMARY</div>
                <div style={{ fontSize: '0.95rem', color: 'var(--text-primary)', lineHeight: 1.5 }}>
                  {current.desc}
                </div>
              </div>
            </div>

            {/* Animated Bar Chart Render */}
            <div style={{ height: '220px', display: 'flex', alignItems: 'flex-end', gap: '16px', padding: '20px 10px', background: 'var(--bg-surface-elevated)', borderRadius: '12px', border: '1px solid var(--border-glass)' }}>
              {current.bars.map((h, i) => (
                <div key={i} style={{ flex: 1, display: 'flex', flexDirection: 'column', alignItems: 'center', height: '100%', justifyContent: 'flex-end' }}>
                  <div
                    style={{
                      width: '100%',
                      maxWidth: '48px',
                      height: `${h}%`,
                      background: i === 6 ? 'var(--gradient-orange-blue)' : 'rgba(45, 140, 255, 0.4)',
                      borderRadius: '6px 6px 0 0',
                      transition: 'height 0.6s cubic-bezier(0.16, 1, 0.3, 1)',
                      boxShadow: '0 0 15px rgba(45, 140, 255, 0.3)'
                    }}
                  />
                  <div style={{ fontSize: '0.75rem', color: 'var(--text-muted)', marginTop: '8px' }}>
                    Day {i + 1}
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* 6 Feature Cards Grid */}
          <div style={{ textAlign: 'center', marginBottom: '40px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>DATA SPECTRUM</div>
            <h2 style={{ fontSize: '2.2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '12px' }}>
              Data Analytics Services
            </h2>
            <p style={{ color: 'var(--text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
              Unifying fragmented database tables into structured, actionable insights.
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
            <h2 style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '16px' }}>Ready to Build Your Executive BI Dashboard?</h2>
            <p style={{ color: 'var(--text-secondary)', marginBottom: '28px', maxWidth: '600px', margin: '0 auto 28px auto' }}>
              We transform complex data pipelines into real-time business telemetry.
            </p>
            <Link to="/quote" className="btn-primary">
              REQUEST ANALYTICS PROPOSAL <ArrowRight size={18} />
            </Link>
          </div>

        </div>
      </main>

      <Footer />
    </div>
  );
}
