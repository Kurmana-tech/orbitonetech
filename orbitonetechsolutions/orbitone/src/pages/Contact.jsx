import React, { useState } from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { COMPANY_INFO } from '../data/services';
import { Mail, Phone, MapPin, Send, CheckCircle2 } from 'lucide-react';

export default function Contact() {
  const [submitted, setSubmitted] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [errorMsg, setErrorMsg] = useState('');
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    company: '',
    service: 'Web Development',
    message: ''
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrorMsg('');

    if (!formData.name.trim()) {
      setErrorMsg('Please enter your full name.');
      return;
    }
    if (!formData.email.trim() || !/\S+@\S+\.\S+/.test(formData.email)) {
      setErrorMsg('Please enter a valid email address.');
      return;
    }
    if (!formData.message.trim()) {
      setErrorMsg('Please describe your project or enquiry.');
      return;
    }

    setSubmitting(true);
    try {
      const body = new FormData();
      body.append('name', formData.name.trim());
      body.append('email', formData.email.trim());
      body.append('phone', formData.phone ? formData.phone.trim() : '');
      body.append('company', formData.company ? formData.company.trim() : '');
      body.append('service', formData.service);
      body.append('message', formData.message.trim());

      const res = await fetch('/api/contact.php', {
        method: 'POST',
        body: body
      });
      const result = await res.json();
      if (result.success) {
        setSubmitted(true);
        setErrorMsg('');
      } else {
        setErrorMsg(result.message || 'Failed to submit contact message.');
      }
    } catch (err) {
      setErrorMsg('Network error. Please try again.');
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <div style={{ position: 'relative', width: '100%', minHeight: '100vh', background: 'var(--bg-deep)' }}>
      <Navbar />
      <MainCanvas />

      <main className="content-wrapper" style={{ paddingTop: '140px', paddingBottom: '80px', maxWidth: '1240px', margin: '0 auto', paddingLeft: '5%', paddingRight: '5%' }}>
        <div style={{ textAlign: 'center', marginBottom: '60px' }}>
          <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>GET IN TOUCH</div>
          <h1 className="section-title">
            Let's Build <span className="gradient-text-orange">Something Amazing.</span>
          </h1>
          <p className="section-description" style={{ maxWidth: '750px', margin: '0 auto' }}>
            Have a project in mind or need expert technology advice? Send us a message and our team will get back to you within 24 hours.
          </p>
        </div>

        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(340px, 1fr))', gap: '40px' }}>
          {/* Form */}
          <div className="glass-panel" style={{ padding: '40px' }}>
            {submitted ? (
              <div style={{ textAlign: 'center', padding: '40px 20px' }}>
                <CheckCircle2 size={60} color="var(--orbit-orange)" style={{ marginBottom: '20px' }} />
                <h3 style={{ fontSize: '2rem', fontWeight: 800, marginBottom: '12px' }}>Enquiry Received!</h3>
                <p style={{ color: 'var(--text-secondary)', fontSize: '1.1rem' }}>
                  Thank you for reaching out to Orbitone Tech Solutions. Our technical team will review your message and contact you shortly.
                </p>
              </div>
            ) : (
              <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
                {errorMsg && (
                  <div style={{ background: 'rgba(239, 68, 68, 0.15)', border: '1px solid rgba(239, 68, 68, 0.3)', color: '#fca5a5', padding: '12px 16px', borderRadius: '10px', fontSize: '0.88rem', fontWeight: 600 }}>
                    {errorMsg}
                  </div>
                )}
                <div>
                  <label style={{ display: 'block', fontSize: '0.9rem', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '8px' }}>Your Name *</label>
                  <input
                    type="text"
                    required
                    placeholder="John Doe"
                    value={formData.name}
                    onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                    className="form-input"
                  />
                </div>

                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px' }}>
                  <div>
                    <label style={{ display: 'block', fontSize: '0.9rem', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '8px' }}>Email Address *</label>
                    <input
                      type="email"
                      required
                      placeholder="john@company.com"
                      value={formData.email}
                      onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                      className="form-input"
                    />
                  </div>
                  <div>
                    <label style={{ display: 'block', fontSize: '0.9rem', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '8px' }}>Phone Number</label>
                    <input
                      type="tel"
                      placeholder="+1 (555) 000-0000"
                      value={formData.phone}
                      onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                      className="form-input"
                    />
                  </div>
                </div>

                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px' }}>
                  <div>
                    <label style={{ display: 'block', fontSize: '0.9rem', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '8px' }}>Company</label>
                    <input
                      type="text"
                      placeholder="Acme Corp"
                      value={formData.company}
                      onChange={(e) => setFormData({ ...formData, company: e.target.value })}
                      className="form-input"
                    />
                  </div>
                  <div>
                    <label style={{ display: 'block', fontSize: '0.9rem', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '8px' }}>Service Interest</label>
                    <select
                      value={formData.service}
                      onChange={(e) => setFormData({ ...formData, service: e.target.value })}
                      className="form-select"
                    >
                      <option value="Web Development">Web Development</option>
                      <option value="Application Development">Application Development</option>
                      <option value="AI & Machine Learning">AI & Machine Learning</option>
                      <option value="Data Analytics">Data Analytics</option>
                      <option value="Marketing Analytics">Marketing Analytics</option>
                      <option value="Digital Marketing">Digital Marketing</option>
                    </select>
                  </div>
                </div>

                <div>
                  <label style={{ display: 'block', fontSize: '0.9rem', fontWeight: 600, color: 'var(--text-primary)', marginBottom: '8px' }}>Your Message *</label>
                  <textarea
                    required
                    rows={4}
                    placeholder="Tell us about your project requirements..."
                    value={formData.message}
                    onChange={(e) => setFormData({ ...formData, message: e.target.value })}
                    className="form-textarea"
                    style={{ resize: 'vertical' }}
                  />
                </div>

                <button type="submit" className="btn-primary" style={{ padding: '16px', justifyContent: 'center', fontSize: '1.05rem', marginTop: '10px' }}>
                  Send Enquiry <Send size={18} />
                </button>
              </form>
            )}
          </div>

          {/* Contact Details Card */}
          <div className="glass-panel" style={{ padding: '40px', display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
            <div>
              <h3 style={{ fontSize: '1.8rem', fontWeight: 800, marginBottom: '24px' }}>Contact Information</h3>

              <div style={{ display: 'flex', flexDirection: 'column', gap: '24px', marginBottom: '40px' }}>
                <div style={{ display: 'flex', gap: '16px' }}>
                  <Mail color="var(--orbit-orange)" size={24} style={{ flexShrink: 0 }} />
                  <div>
                    <div style={{ fontSize: '0.85rem', color: 'var(--text-muted)', textTransform: 'uppercase' }}>Email Us</div>
                    <div style={{ fontSize: '1.1rem', fontWeight: 600 }}>{COMPANY_INFO.email}</div>
                  </div>
                </div>

                <div style={{ display: 'flex', gap: '16px' }}>
                  <Phone color="var(--orbit-orange)" size={24} style={{ flexShrink: 0 }} />
                  <div>
                    <div style={{ fontSize: '0.85rem', color: 'var(--text-muted)', textTransform: 'uppercase' }}>Call Us</div>
                    <div style={{ fontSize: '1.1rem', fontWeight: 600 }}>{COMPANY_INFO.phone}</div>
                  </div>
                </div>

                <div style={{ display: 'flex', gap: '16px' }}>
                  <MapPin color="var(--orbit-orange)" size={24} style={{ flexShrink: 0 }} />
                  <div>
                    <div style={{ fontSize: '0.85rem', color: 'var(--text-muted)', textTransform: 'uppercase' }}>Headquarters</div>
                    <div style={{ fontSize: '1.1rem', fontWeight: 600 }}>{COMPANY_INFO.address}</div>
                  </div>
                </div>
              </div>
            </div>

            <div style={{ padding: '20px', background: 'var(--bg-surface-elevated)', borderRadius: '12px', border: '1px solid var(--border-glass)' }}>
              <div style={{ color: 'var(--orbit-orange)', fontWeight: 700, fontSize: '0.9rem', marginBottom: '4px' }}>Business Hours</div>
              <div style={{ fontSize: '0.95rem', color: 'var(--text-secondary)' }}>Monday – Friday: 9:00 AM – 6:00 PM EST</div>
              <div style={{ fontSize: '0.85rem', color: 'var(--text-muted)', marginTop: '4px' }}>24/7 Priority Support for Enterprise Clients</div>
            </div>
          </div>
        </div>
      </main>

      <Footer />
    </div>
  );
}
