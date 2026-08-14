import React, { useState } from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { 
  Calculator, CheckCircle2, ArrowRight, ArrowLeft, Send, 
  Globe, Terminal, Smartphone, Bot, PieChart, Rocket, 
  Zap, Calendar, Building2, Repeat, ShieldCheck, User, Mail, Phone, Building 
} from 'lucide-react';

export default function Quote() {
  const [step, setStep] = useState(1);
  const [selectedServices, setSelectedServices] = useState(['website', 'webapp']);
  const [requirementsText, setRequirementsText] = useState('');
  const [selectedTimeline, setSelectedTimeline] = useState('Standard (1-3 Months)');
  const [selectedBudget, setSelectedBudget] = useState('Not Sure');
  const [formData, setFormData] = useState({ name: '', email: '', phone: '', company: '' });
  const [formError, setFormError] = useState('');
  const [submitting, setSubmitting] = useState(false);
  const [submitted, setSubmitted] = useState(false);

  const capabilities = [
    {
      id: 'website',
      title: 'Website & Portals',
      desc: 'Corporate brand presence, responsive UI & high-performance frontend',
      tag: 'FAST DELIVERY',
      badgeBg: 'rgba(247, 147, 0, 0.15)',
      badgeColor: '#F79300',
      icon: Globe,
      iconBg: '#F79300',
      baseCost: 2500
    },
    {
      id: 'webapp',
      title: 'Web Application & SaaS',
      desc: 'Scalable cloud SaaS, client portals, APIs & microservices architecture',
      tag: 'HIGH SCALE',
      badgeBg: 'rgba(16, 185, 129, 0.15)',
      badgeColor: '#10B981',
      icon: Terminal,
      iconBg: '#10B981',
      baseCost: 4500
    },
    {
      id: 'mobile',
      title: 'Mobile Application',
      desc: 'Native & cross-platform iOS & Android mobile applications',
      tag: 'IOS / ANDROID',
      badgeBg: 'rgba(45, 140, 255, 0.15)',
      badgeColor: '#2D8CFF',
      icon: Smartphone,
      iconBg: '#2D8CFF',
      baseCost: 4000
    },
    {
      id: 'ai',
      title: 'AI & ML Solutions',
      desc: 'Custom LLM applications, RAG pipelines, agents & predictive models',
      tag: 'INTELLIGENT',
      badgeBg: 'rgba(108, 92, 231, 0.15)',
      badgeColor: '#6C5CE7',
      icon: Bot,
      iconBg: '#6C5CE7',
      baseCost: 3500
    },
    {
      id: 'data',
      title: 'Data & Telemetry Insights',
      desc: 'Executive BI dashboards, automated ETL pipelines & analytics',
      tag: 'TELEMETRY',
      badgeBg: 'rgba(6, 182, 212, 0.15)',
      badgeColor: '#06B6D4',
      icon: PieChart,
      iconBg: '#06B6D4',
      baseCost: 3000
    },
    {
      id: 'digital',
      title: 'Digital Growth & Marketing',
      desc: 'Conversion engineering, SEO optimization & performance campaigns',
      tag: 'GROWTH',
      badgeBg: 'rgba(236, 72, 153, 0.15)',
      badgeColor: '#EC4899',
      icon: Rocket,
      iconBg: '#EC4899',
      baseCost: 2000
    }
  ];

  const timelineOptions = [
    { title: 'Urgent Sprint', desc: '< 1 Month', val: 'Urgent (< 1 Month)', icon: Zap },
    { title: 'Standard Phase', desc: '1 – 3 Months', val: 'Standard (1-3 Months)', icon: Calendar },
    { title: 'Strategic Build', desc: '3 – 6 Months', val: 'Strategic (3-6 Months)', icon: Building2 },
    { title: 'Flexible / Ongoing', desc: 'Continuous Agile', val: 'Flexible / Ongoing', icon: Repeat }
  ];

  const budgetTiers = [
    { tag: 'Starter', amount: '₹25K – ₹50K', desc: 'Basic prototype, landing portal, or architectural audit', val: '₹25K – ₹50K' },
    { tag: 'Growth', amount: '₹50K – ₹1L', desc: 'Custom web application, AI prototype, or mobile MVP', val: '₹50K – ₹1L' },
    { tag: 'Most Popular', amount: '₹1L – ₹5L', desc: 'Full-scale mobile app, SaaS platform, or enterprise BI system', val: '₹1L – ₹5L', popular: true },
    { tag: 'Enterprise', amount: '₹5L+', desc: 'Comprehensive cloud ecosystem, microservices & full-cycle AI', val: '₹5L+' },
    { tag: 'Consultative', amount: 'Not Sure Yet', desc: 'Need architectural advice and custom scope estimation', val: 'Not Sure' }
  ];

  const quickTags = [
    '+ Rapid MVP (4-6 wks)',
    '+ Custom AI / RAG',
    '+ Cloud Microservices',
    '+ Executive BI Dashboard',
    '+ Payment Gateway'
  ];

  const toggleService = (sId) => {
    if (selectedServices.includes(sId)) {
      if (selectedServices.length > 1) {
        setSelectedServices(selectedServices.filter(id => id !== sId));
      }
    } else {
      setSelectedServices([...selectedServices, sId]);
    }
  };

  const appendQuickTag = (tagText) => {
    const cleanTag = tagText.replace('+ ', '');
    if (!requirementsText.includes(cleanTag)) {
      setRequirementsText(prev => prev ? `${prev}, ${cleanTag}` : cleanTag);
    }
  };

  // Calculate total base estimation
  const totalBaseCost = selectedServices.reduce((sum, sId) => {
    const found = capabilities.find(c => c.id === sId);
    return sum + (found ? found.baseCost : 0);
  }, 0);

  const handleSubmit = async (e) => {
    if (e && e.preventDefault) e.preventDefault();
    setFormError('');

    if (!formData.name || !formData.name.trim()) {
      setFormError('Full Name is mandatory to submit a quote proposal (Step 4).');
      return;
    }

    if (!formData.email || !formData.email.trim() || !/\S+@\S+\.\S+/.test(formData.email)) {
      setFormError('A valid Work Email is mandatory to submit a quote proposal (Step 4).');
      return;
    }

    if (!formData.phone || !formData.phone.trim()) {
      setFormError('Phone / WhatsApp Number is mandatory to submit a quote proposal (Step 4).');
      return;
    }

    if (!formData.company || !formData.company.trim()) {
      setFormError('Company / Organization Name is mandatory to submit a quote proposal (Step 4).');
      return;
    }

    if (selectedServices.length === 0) {
      setFormError('Please select at least one service capability (Step 1).');
      return;
    }

    setSubmitting(true);
    try {
      const body = new FormData();
      selectedServices.forEach(sId => {
        const found = capabilities.find(c => c.id === sId);
        if (found) body.append('services[]', found.title);
      });
      body.append('requirements', requirementsText);
      body.append('budget', selectedBudget || 'Not Sure');
      body.append('contact_name', formData.name.trim());
      body.append('contact_email', formData.email.trim());
      body.append('contact_phone', formData.phone ? formData.phone.trim() : '');
      body.append('company', formData.company ? formData.company.trim() : '');

      const res = await fetch('/api/quote.php', {
        method: 'POST',
        body: body
      });
      const result = await res.json();
      if (result.success) {
        setSubmitted(true);
        setFormError('');
      } else {
        setFormError(result.message || 'Failed to submit proposal request.');
      }
    } catch (err) {
      setFormError('Network error. Please try submitting again.');
    } finally {
      setSubmitting(false);
    }
  };

  const stepsList = [
    { num: 1, label: 'Services', sublabel: 'Select Capabilities' },
    { num: 2, label: 'Scope', sublabel: 'Timeline & Goals' },
    { num: 3, label: 'Budget', sublabel: 'Estimated Range' },
    { num: 4, label: 'Contact', sublabel: 'Proposal Delivery' }
  ];

  return (
    <div style={{ position: 'relative', width: '100%', minHeight: '100vh', background: 'var(--bg-deep)' }}>
      <Navbar />
      <MainCanvas />

      <main className="content-wrapper" style={{ paddingTop: '140px', paddingBottom: '80px' }}>
        <div style={{ maxWidth: '1140px', margin: '0 auto', padding: '0 5%' }}>
          
          {/* Header */}
          <div style={{ textAlign: 'center', marginBottom: '40px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>
              <Calculator size={14} /> ENTERPRISE SCOPING &amp; ESTIMATION
            </div>
            <h1 className="section-title">
              Tell Us What You <span className="gradient-text-orange">Want to Build</span>
            </h1>
            <p className="section-description" style={{ maxWidth: '680px', margin: '0 auto' }}>
              Complete our 4-step project scoping wizard to receive an architectural breakdown and tailored proposal.
            </p>
          </div>

          {/* Main Scoping Wizard Card */}
          <div className="glass-panel" style={{ padding: '40px', borderRadius: '24px' }}>
            
            {/* Step Progress Tracker Bar */}
            <div style={{ marginBottom: '40px', position: 'relative' }}>
              
              {/* Progress Line */}
              <div style={{ position: 'absolute', top: '24px', left: '8%', right: '8%', height: '3px', background: 'var(--input-bg)', zIndex: 1 }}>
                <div style={{ height: '100%', width: `${((step - 1) / 3) * 100}%`, background: 'var(--gradient-orange-blue)', transition: 'width 0.4s ease', borderRadius: '3px' }} />
              </div>

              <div style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', position: 'relative', zIndex: 2 }}>
                {stepsList.map((s) => {
                  const isActive = step === s.num;
                  const isCompleted = step > s.num;
                  return (
                    <div
                      key={s.num}
                      onClick={() => setStep(s.num)}
                      style={{
                        display: 'flex',
                        flexDirection: 'column',
                        alignItems: 'center',
                        cursor: 'pointer',
                        textAlign: 'center'
                      }}
                    >
                      <div
                        style={{
                          width: '48px',
                          height: '48px',
                          borderRadius: '50%',
                          background: isActive ? 'var(--orbit-orange)' : (isCompleted ? 'var(--electric-blue)' : 'var(--bg-surface-elevated)'),
                          border: isActive ? '3px solid rgba(247, 147, 0, 0.4)' : '2px solid var(--border-glass)',
                          color: '#FFFFFF',
                          fontWeight: 800,
                          display: 'flex',
                          alignItems: 'center',
                          justifyContent: 'center',
                          fontSize: '1.1rem',
                          marginBottom: '10px',
                          boxShadow: isActive ? '0 0 20px rgba(247, 147, 0, 0.4)' : 'none',
                          transition: 'all 0.3s'
                        }}
                      >
                        {isCompleted ? <CheckCircle2 size={24} color="#FFFFFF" /> : s.num}
                      </div>

                      <div style={{ fontWeight: isActive ? '700' : '600', fontSize: '0.95rem', color: isActive ? 'var(--text-primary)' : 'var(--text-secondary)' }}>
                        {s.label}
                      </div>
                      <div style={{ fontSize: '0.76rem', color: 'var(--text-muted)', marginTop: '2px' }}>
                        {s.sublabel}
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>

            {/* Step 1: Capabilities Checklist */}
            {step === 1 && (
              <div>
                <div style={{ marginBottom: '28px' }}>
                  <span style={{ fontSize: '0.78rem', fontWeight: 700, padding: '4px 12px', borderRadius: '12px', background: 'rgba(247, 147, 0, 0.15)', color: 'var(--orbit-orange)', border: '1px solid rgba(247, 147, 0, 0.3)' }}>
                    STEP 1 OF 4
                  </span>
                  <h3 style={{ fontSize: '1.6rem', fontWeight: 800, color: 'var(--text-primary)', marginTop: '12px', marginBottom: '6px' }}>
                    What capabilities does your project require?
                  </h3>
                  <p style={{ color: 'var(--text-secondary)', fontSize: '0.94rem' }}>
                    Select all services that apply. We can combine multiple disciplines into a unified solution.
                  </p>
                </div>

                {/* 6 Capabilities Cards Grid */}
                <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '20px', marginBottom: '32px' }}>
                  {capabilities.map((cap) => {
                    const isSelected = selectedServices.includes(cap.id);
                    const IconComp = cap.icon;
                    return (
                      <div
                        key={cap.id}
                        onClick={() => toggleService(cap.id)}
                        style={{
                          padding: '24px',
                          borderRadius: '16px',
                          border: isSelected ? '2px solid var(--orbit-orange)' : '1px solid var(--border-glass)',
                          background: isSelected ? 'rgba(247, 147, 0, 0.08)' : 'var(--bg-surface-elevated)',
                          cursor: 'pointer',
                          position: 'relative',
                          display: 'flex',
                          alignItems: 'flex-start',
                          gap: '16px',
                          transition: 'all 0.3s ease',
                          boxShadow: isSelected ? '0 8px 25px rgba(247, 147, 0, 0.15)' : 'none'
                        }}
                      >
                        {/* Custom Checkbox */}
                        <div
                          style={{
                            width: '24px',
                            height: '24px',
                            borderRadius: '6px',
                            border: isSelected ? 'none' : '2px solid var(--input-border)',
                            background: isSelected ? 'var(--orbit-orange)' : 'transparent',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            marginTop: '2px',
                            flexShrink: 0
                          }}
                        >
                          {isSelected && <CheckCircle2 size={18} color="#FFFFFF" />}
                        </div>

                        {/* Icon Badge */}
                        <div
                          style={{
                            width: '44px',
                            height: '44px',
                            borderRadius: '12px',
                            background: cap.badgeBg,
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            flexShrink: 0
                          }}
                        >
                          <IconComp size={22} color={cap.badgeColor} />
                        </div>

                        {/* Title & Desc */}
                        <div style={{ flexGrow: 1 }}>
                          <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', gap: '8px', marginBottom: '6px' }}>
                            <h4 style={{ fontSize: '1.05rem', fontWeight: 700, color: 'var(--text-primary)' }}>{cap.title}</h4>
                            <span style={{ fontSize: '0.68rem', fontWeight: 700, padding: '3px 8px', borderRadius: '10px', background: cap.badgeBg, color: cap.badgeColor, letterSpacing: '0.04em' }}>
                              {cap.tag}
                            </span>
                          </div>
                          <p style={{ color: 'var(--text-secondary)', fontSize: '0.86rem', lineHeight: 1.5 }}>
                            {cap.desc}
                          </p>
                        </div>
                      </div>
                    );
                  })}
                </div>
              </div>
            )}

            {/* Step 2: Scope & Requirements */}
            {step === 2 && (
              <div>
                <div style={{ marginBottom: '28px' }}>
                  <span style={{ fontSize: '0.78rem', fontWeight: 700, padding: '4px 12px', borderRadius: '12px', background: 'rgba(45, 140, 255, 0.15)', color: 'var(--electric-blue)', border: '1px solid rgba(45, 140, 255, 0.3)' }}>
                    STEP 2 OF 4
                  </span>
                  <h3 style={{ fontSize: '1.6rem', fontWeight: 800, color: 'var(--text-primary)', marginTop: '12px', marginBottom: '6px' }}>
                    Scope &amp; Expected Timeline
                  </h3>
                  <p style={{ color: 'var(--text-secondary)', fontSize: '0.94rem' }}>
                    Tell us about your objectives and target delivery timeframe.
                  </p>
                </div>

                <div style={{ marginBottom: '32px' }}>
                  <label style={{ display: 'block', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '10px', fontSize: '0.95rem' }}>
                    Project Objectives &amp; Description
                  </label>
                  <textarea
                    rows="4"
                    className="form-textarea"
                    placeholder="Describe the core features, business challenges, or user workflow you want to build..."
                    value={requirementsText}
                    onChange={(e) => setRequirementsText(e.target.value)}
                    style={{ marginBottom: '14px' }}
                  />

                  {/* Quick Tags */}
                  <div style={{ display: 'flex', alignItems: 'center', gap: '10px', flexWrap: 'wrap' }}>
                    <span style={{ fontSize: '0.82rem', color: 'var(--text-muted)', fontWeight: 600 }}>Quick suggestions:</span>
                    {quickTags.map((tag, idx) => (
                      <button
                        key={idx}
                        type="button"
                        onClick={() => appendQuickTag(tag)}
                        style={{
                          fontSize: '0.78rem',
                          padding: '6px 12px',
                          borderRadius: '16px',
                          background: 'var(--bg-surface-elevated)',
                          border: '1px solid var(--border-glass)',
                          color: 'var(--text-secondary)',
                          cursor: 'pointer',
                          transition: 'all 0.2s'
                        }}
                      >
                        {tag}
                      </button>
                    ))}
                  </div>
                </div>

                {/* Target Timeline Cards */}
                <div>
                  <label style={{ display: 'block', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '14px', fontSize: '0.95rem' }}>
                    Target Delivery Timeline
                  </label>
                  <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))', gap: '16px' }}>
                    {timelineOptions.map((tl, idx) => {
                      const isSelected = selectedTimeline === tl.val;
                      const IconComp = tl.icon;
                      return (
                        <div
                          key={idx}
                          onClick={() => setSelectedTimeline(tl.val)}
                          style={{
                            padding: '20px',
                            borderRadius: '14px',
                            border: isSelected ? '2px solid var(--electric-blue)' : '1px solid var(--border-glass)',
                            background: isSelected ? 'rgba(45, 140, 255, 0.08)' : 'var(--bg-surface-elevated)',
                            cursor: 'pointer',
                            textAlign: 'center',
                            transition: 'all 0.3s'
                          }}
                        >
                          <IconComp size={24} color={isSelected ? 'var(--electric-blue)' : 'var(--text-secondary)'} style={{ margin: '0 auto 8px auto' }} />
                          <div style={{ fontWeight: 700, color: 'var(--text-primary)', fontSize: '0.98rem' }}>{tl.title}</div>
                          <div style={{ fontSize: '0.82rem', color: 'var(--text-secondary)', marginTop: '4px' }}>{tl.desc}</div>
                        </div>
                      );
                    })}
                  </div>
                </div>
              </div>
            )}

            {/* Step 3: Investment Tier */}
            {step === 3 && (
              <div>
                <div style={{ marginBottom: '28px' }}>
                  <span style={{ fontSize: '0.78rem', fontWeight: 700, padding: '4px 12px', borderRadius: '12px', background: 'rgba(108, 92, 231, 0.15)', color: 'var(--ai-purple)', border: '1px solid rgba(108, 92, 231, 0.3)' }}>
                    STEP 3 OF 4
                  </span>
                  <h3 style={{ fontSize: '1.6rem', fontWeight: 800, color: 'var(--text-primary)', marginTop: '12px', marginBottom: '6px' }}>
                    What is your planned investment tier?
                  </h3>
                  <p style={{ color: 'var(--text-secondary)', fontSize: '0.94rem' }}>
                    This helps us calibrate architectural depth and technology stack recommendations.
                  </p>
                </div>

                <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '16px', marginBottom: '32px' }}>
                  {budgetTiers.map((b, idx) => {
                    const isSelected = selectedBudget === b.val;
                    return (
                      <div
                        key={idx}
                        onClick={() => setSelectedBudget(b.val)}
                        style={{
                          padding: '24px 18px',
                          borderRadius: '16px',
                          border: isSelected ? '2px solid var(--orbit-orange)' : '1px solid var(--border-glass)',
                          background: isSelected ? 'rgba(247, 147, 0, 0.08)' : 'var(--bg-surface-elevated)',
                          cursor: 'pointer',
                          position: 'relative',
                          textAlign: 'center',
                          transition: 'all 0.3s'
                        }}
                      >
                        <span style={{ fontSize: '0.7rem', fontWeight: 700, padding: '3px 10px', borderRadius: '10px', background: b.popular ? 'var(--orbit-orange)' : 'rgba(255, 255, 255, 0.1)', color: b.popular ? '#FFFFFF' : 'var(--text-secondary)', display: 'inline-block', marginBottom: '12px' }}>
                          {b.tag}
                        </span>
                        <div style={{ fontSize: '1.25rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '8px' }}>{b.amount}</div>
                        <div style={{ fontSize: '0.82rem', color: 'var(--text-secondary)', lineHeight: 1.4 }}>{b.desc}</div>
                      </div>
                    );
                  })}
                </div>
              </div>
            )}

            {/* Step 4: Contact & Proposal Delivery */}
            {step === 4 && (
              <div>
                <div style={{ marginBottom: '28px' }}>
                  <span style={{ fontSize: '0.78rem', fontWeight: 700, padding: '4px 12px', borderRadius: '12px', background: 'rgba(16, 185, 129, 0.15)', color: '#10B981', border: '1px solid rgba(16, 185, 129, 0.3)' }}>
                    STEP 4 OF 4
                  </span>
                  <h3 style={{ fontSize: '1.6rem', fontWeight: 800, color: 'var(--text-primary)', marginTop: '12px', marginBottom: '6px' }}>
                    Where should we deliver your custom proposal?
                  </h3>
                  <p style={{ color: 'var(--text-secondary)', fontSize: '0.94rem' }}>
                    Our solutions architect will review your submission and reach out within 24 hours.
                  </p>
                </div>

                {!submitted ? (
                  <form onSubmit={handleSubmit}>
                    {formError && (
                      <div style={{ background: 'rgba(239, 68, 68, 0.15)', border: '1px solid rgba(239, 68, 68, 0.3)', color: '#fca5a5', padding: '12px 16px', borderRadius: '10px', fontSize: '0.88rem', fontWeight: 600, marginBottom: '20px' }}>
                        {formError}
                      </div>
                    )}
                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))', gap: '20px', marginBottom: '24px' }}>
                      <div>
                        <label style={{ display: 'block', fontSize: '0.88rem', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '8px' }}>
                          Your Full Name *
                        </label>
                        <input
                          type="text"
                          required
                          placeholder="Alex Turner"
                          className="form-input"
                          value={formData.name}
                          onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                        />
                      </div>

                      <div>
                        <label style={{ display: 'block', fontSize: '0.88rem', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '8px' }}>
                          Work Email *
                        </label>
                        <input
                          type="email"
                          required
                          placeholder="alex@company.com"
                          className="form-input"
                          value={formData.email}
                          onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                        />
                      </div>

                      <div>
                        <label style={{ display: 'block', fontSize: '0.88rem', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '8px' }}>
                          Phone / WhatsApp Number *
                        </label>
                        <input
                          type="tel"
                          required
                          placeholder="+91 98765 43210"
                          className="form-input"
                          value={formData.phone}
                          onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                        />
                      </div>

                      <div>
                        <label style={{ display: 'block', fontSize: '0.88rem', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '8px' }}>
                          Company / Organization *
                        </label>
                        <input
                          type="text"
                          required
                          placeholder="Acme Technologies Inc."
                          className="form-input"
                          value={formData.company}
                          onChange={(e) => setFormData({ ...formData, company: e.target.value })}
                        />
                      </div>
                    </div>

                    {/* Trust Assurance Box */}
                    <div style={{ background: 'rgba(16, 185, 129, 0.08)', border: '1px solid rgba(16, 185, 129, 0.25)', padding: '16px 20px', borderRadius: '12px', display: 'flex', alignItems: 'center', gap: '14px', marginBottom: '28px' }}>
                      <ShieldCheck size={28} color="#10B981" style={{ flexShrink: 0 }} />
                      <div style={{ fontSize: '0.86rem', color: 'var(--text-secondary)', lineHeight: 1.5 }}>
                        <strong style={{ color: 'var(--text-primary)' }}>100% Confidential &amp; Secure:</strong> All project discussions and requirements are strictly protected under mutual confidentiality. We provide a transparent scope breakdown with zero obligation.
                      </div>
                    </div>
                  </form>
                ) : (
                  <div style={{ textAlign: 'center', padding: '40px 20px' }}>
                    <CheckCircle2 size={56} color="var(--orbit-orange)" style={{ margin: '0 auto 16px auto' }} />
                    <h3 style={{ fontSize: '1.6rem', color: 'var(--text-primary)', marginBottom: '12px' }}>
                      Proposal Request Submitted!
                    </h3>
                    <p style={{ color: 'var(--text-secondary)', maxWidth: '520px', margin: '0 auto' }}>
                      Thank you, {formData.name}. Our solutions architect will analyze your project scope (${totalBaseCost.toLocaleString()} USD Est.) and contact you at {formData.email} within 24 hours.
                    </p>
                  </div>
                )}
              </div>
            )}

            {/* Bottom Controls */}
            <div
              style={{
                marginTop: '36px',
                padding: '20px 24px',
                borderRadius: '16px',
                background: 'rgba(7, 25, 54, 0.95)',
                border: '1px solid var(--border-glass)',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'space-between',
                flexWrap: 'wrap',
                gap: '16px'
              }}
            >
              <div>
                {step > 1 && (
                  <button onClick={() => { setFormError(''); setStep(step - 1); }} className="btn-secondary" style={{ padding: '12px 24px', fontSize: '0.9rem' }}>
                    <ArrowLeft size={16} /> Previous Step
                  </button>
                )}
              </div>

              <div>
                {step < 4 ? (
                  <button onClick={() => { setFormError(''); setStep(step + 1); }} className="btn-primary" style={{ padding: '12px 28px', fontSize: '0.9rem' }}>
                    Next Step <ArrowRight size={16} />
                  </button>
                ) : (
                  !submitted && (
                    <button onClick={handleSubmit} disabled={submitting} className="btn-primary" style={{ padding: '12px 32px', fontSize: '0.95rem' }}>
                      {submitting ? 'Submitting Proposal...' : <>Submit &amp; Generate Proposal <Send size={16} /></>}
                    </button>
                  )
                )}
              </div>
            </div>

          </div>
        </div>
      </main>

      <Footer />
    </div>
  );
}
