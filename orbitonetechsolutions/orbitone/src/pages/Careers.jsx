import React, { useState, useEffect } from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { Users, Briefcase, MapPin, Send, CheckCircle2, DollarSign, Award, Terminal, Brain, Rocket, Palette } from 'lucide-react';

const getDeptIcon = (dept) => {
  const d = (dept || '').toLowerCase();
  if (d.includes('engineer') || d.includes('tech') || d.includes('code')) return <Terminal size={22} />;
  if (d.includes('ai') || d.includes('data') || d.includes('machine')) return <Brain size={22} />;
  if (d.includes('marketing') || d.includes('growth') || d.includes('sales')) return <Rocket size={22} />;
  if (d.includes('design') || d.includes('ui') || d.includes('creative') || d.includes('photo') || d.includes('video')) return <Palette size={22} />;
  return <Briefcase size={22} />;
};

const getDeptColors = (dept) => {
  const d = (dept || '').toLowerCase();
  if (d.includes('engineer') || d.includes('tech') || d.includes('code')) {
    return { bg: 'rgba(59, 130, 246, 0.12)', text: '#60a5fa', border: 'rgba(59, 130, 246, 0.25)' };
  }
  if (d.includes('ai') || d.includes('data') || d.includes('machine')) {
    return { bg: 'rgba(168, 85, 247, 0.12)', text: '#c084fc', border: 'rgba(168, 85, 247, 0.25)' };
  }
  if (d.includes('marketing') || d.includes('growth') || d.includes('sales')) {
    return { bg: 'rgba(247, 147, 0, 0.12)', text: '#fca5a5', border: 'rgba(247, 147, 0, 0.25)' };
  }
  if (d.includes('design') || d.includes('ui') || d.includes('creative') || d.includes('photo') || d.includes('video')) {
    return { bg: 'rgba(236, 72, 153, 0.12)', text: '#f472b6', border: 'rgba(236, 72, 153, 0.25)' };
  }
  return { bg: 'rgba(255, 255, 255, 0.05)', text: 'var(--text-secondary)', border: 'var(--border-glass)' };
};

export default function Careers() {
  const [selectedJob, setSelectedJob] = useState(null);
  const [applied, setApplied] = useState(false);
  const [applyError, setApplyError] = useState('');
  const [jobs, setJobs] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function fetchJobs() {
      try {
        const res = await fetch('/api/career.php');
        const result = await res.json();
        if (result.success && result.data) {
          setJobs(result.data);
        }
      } catch (err) {
        console.error('Error fetching jobs:', err);
      } finally {
        setLoading(false);
      }
    }
    fetchJobs();
  }, []);

  const handleApply = async (e) => {
    e.preventDefault();
    setApplyError('');
    try {
      const formEl = e.target;
      const name = formEl.elements['applicant_name']?.value || '';
      const email = formEl.elements['email']?.value || '';
      const linkedin = formEl.elements['linkedin']?.value || '';
      const note = formEl.elements['resume_note']?.value || '';
      const fileInput = formEl.elements['resume_file'];
      const file = fileInput?.files?.[0];

      if (!name.trim() || !email.trim()) {
        setApplyError('Please enter your Name and Email address.');
        return;
      }

      if (!file) {
        setApplyError('Please select a resume file (PDF, DOC, or DOCX) to upload.');
        return;
      }

      const body = new FormData();
      body.append('job_id', selectedJob ? selectedJob.id : 1);
      body.append('role', selectedJob ? selectedJob.title : 'Software Engineer');
      body.append('applicant_name', name.trim());
      body.append('email', email.trim());
      body.append('phone', '');
      body.append('experience', linkedin.trim());
      body.append('resume_note', note.trim());
      body.append('resume_file', file);

      const res = await fetch('/api/career.php', {
        method: 'POST',
        body: body
      });
      const result = await res.json();
      if (result.success) {
        setApplied(true);
        setApplyError('');
      } else {
        setApplyError(result.message || 'Failed to submit job application.');
      }
    } catch (err) {
      setApplyError('Network error while submitting application.');
    }
  };

  return (
    <div style={{ position: 'relative', width: '100%', minHeight: '100vh', background: 'var(--bg-deep)' }}>
      <Navbar />
      <MainCanvas />

      <main className="content-wrapper" style={{ paddingTop: '140px', paddingBottom: '80px' }}>
        <div style={{ maxWidth: '1100px', margin: '0 auto', padding: '0 5%' }}>
          
          <div style={{ textAlign: 'center', marginBottom: '60px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>
              <Users size={14} /> Join Orbitone Tech Solutions
            </div>
            <h1 className="section-title">
              Build the Future of <span className="gradient-text-orange">Technology & AI</span>
            </h1>
            <p className="section-description" style={{ maxWidth: '720px', margin: '0 auto' }}>
              We are a team of passionate software engineers, data scientists, and growth experts building software that impacts millions.
            </p>
          </div>

          {/* Open Positions List */}
          <div style={{ display: 'flex', flexDirection: 'column', gap: '20px', marginBottom: '60px' }}>
            {loading ? (
              <div className="glass-panel" style={{ padding: '28px', textAlign: 'center', color: 'var(--text-secondary)' }}>
                Loading available positions...
              </div>
            ) : jobs.length === 0 ? (
              <div className="glass-panel" style={{ padding: '28px', textAlign: 'center', color: 'var(--text-secondary)' }}>
                No career openings are currently published. Check back soon!
              </div>
            ) : (
              jobs.map((job) => {
                const colors = getDeptColors(job.department);
                return (
                  <div key={job.id} className="glass-panel" style={{ padding: '28px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', flexWrap: 'wrap', gap: '24px' }}>
                    <div style={{ display: 'flex', gap: '20px', alignItems: 'flex-start', flex: '1 1 65%', flexWrap: 'wrap' }}>
                      <div style={{
                        background: colors.bg,
                        color: colors.text,
                        border: `1px solid ${colors.border}`,
                        width: '52px',
                        height: '52px',
                        borderRadius: '12px',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                        flexShrink: 0
                      }}>
                        {getDeptIcon(job.department)}
                      </div>
                      <div style={{ flex: 1, minWidth: '240px' }}>
                        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '10px', alignItems: 'center', marginBottom: '8px' }}>
                          <span style={{
                            fontSize: '0.7rem',
                            fontWeight: 700,
                            color: colors.text,
                            background: colors.bg,
                            border: `1px solid ${colors.border}`,
                            padding: '3px 10px',
                            borderRadius: '20px',
                            textTransform: 'uppercase',
                            letterSpacing: '0.05em'
                          }}>
                            {job.department}
                          </span>
                          <span style={{ fontSize: '0.78rem', color: 'var(--text-secondary)' }}>• {job.location} ({job.type})</span>
                          <span style={{ fontSize: '0.78rem', color: 'var(--text-secondary)' }}>• Exp: {job.experience}</span>
                          {job.stipend && (
                            <>
                              <span style={{ fontSize: '0.78rem', color: 'var(--text-secondary)' }}>•</span>
                              <span style={{ fontSize: '0.78rem', fontWeight: 700, color: 'var(--orbit-orange)', display: 'inline-flex', alignItems: 'center', gap: '4px' }}>
                                <DollarSign size={13} /> Stipend: {job.stipend}
                              </span>
                            </>
                          )}
                        </div>
                        <h3 style={{ fontSize: '1.3rem', color: 'var(--text-primary)', fontWeight: 800, marginBottom: '8px' }}>{job.title}</h3>
                        <p style={{ color: 'var(--text-secondary)', fontSize: '0.92rem', maxWidth: '650px', lineHeight: '1.6', marginBottom: job.requirements ? '12px' : '0' }}>{job.description}</p>
                        {job.requirements && (
                          <div style={{ marginTop: '16px', background: 'rgba(255, 255, 255, 0.02)', padding: '16px', borderRadius: '12px', border: '1px solid var(--border-glass)' }}>
                            <div style={{ fontSize: '0.85rem', fontWeight: 700, color: 'var(--text-primary)', marginBottom: '8px', display: 'flex', alignItems: 'center', gap: '6px' }}>
                              <Award size={14} color="var(--orbit-orange)" />
                              <span>Key Requirements & Skills:</span>
                            </div>
                            <ul style={{ paddingLeft: '18px', margin: 0, fontSize: '0.88rem', color: 'var(--text-secondary)', lineHeight: '1.6' }}>
                              {job.requirements.split('\n').map((req, index) => req.trim() && (
                                <li key={index} style={{ marginBottom: '3px' }}>{req.trim()}</li>
                              ))}
                            </ul>
                          </div>
                        )}
                      </div>
                    </div>
                    <button onClick={() => { setSelectedJob(job); setApplied(false); }} className="btn-primary" style={{ padding: '10px 20px', fontSize: '0.88rem', alignSelf: 'center' }}>
                      Apply Now <Briefcase size={16} />
                    </button>
                  </div>
                );
              })
            )}
          </div>

          {/* Application Modal Popup */}
          {selectedJob && (
            <div
              style={{
                position: 'fixed',
                top: 0,
                left: 0,
                right: 0,
                bottom: 0,
                background: 'rgba(4, 15, 36, 0.9)',
                backdropFilter: 'blur(16px)',
                zIndex: 2000,
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                padding: '20px'
              }}
              onClick={() => setSelectedJob(null)}
            >
              <div className="glass-panel" style={{ maxWidth: '550px', width: '100%', padding: '36px' }} onClick={(e) => e.stopPropagation()}>
                {!applied ? (
                  <form onSubmit={handleApply}>
                    <h3 style={{ fontSize: '1.4rem', color: 'var(--text-primary)', marginBottom: '6px' }}>Apply for {selectedJob.title}</h3>
                    <p style={{ color: 'var(--text-secondary)', fontSize: '0.88rem', marginBottom: '20px' }}>{selectedJob.location} • {selectedJob.type}</p>
                    
                    {applyError && (
                      <div style={{ background: 'rgba(239, 68, 68, 0.15)', border: '1px solid rgba(239, 68, 68, 0.3)', color: '#fca5a5', padding: '10px 14px', borderRadius: '10px', fontSize: '0.85rem', marginBottom: '16px' }}>
                        {applyError}
                      </div>
                    )}

                    <div style={{ display: 'flex', flexDirection: 'column', gap: '14px', marginBottom: '20px' }}>
                      <div>
                        <label style={{ display: 'block', fontSize: '0.82rem', fontWeight: 700, color: 'var(--text-secondary)', marginBottom: '6px' }}>Full Name *</label>
                        <input type="text" name="applicant_name" placeholder="John Doe" required className="form-input" />
                      </div>

                      <div>
                        <label style={{ display: 'block', fontSize: '0.82rem', fontWeight: 700, color: 'var(--text-secondary)', marginBottom: '6px' }}>Email Address *</label>
                        <input type="email" name="email" placeholder="john@example.com" required className="form-input" />
                      </div>

                      <div>
                        <label style={{ display: 'block', fontSize: '0.82rem', fontWeight: 700, color: 'var(--text-secondary)', marginBottom: '6px' }}>LinkedIn / GitHub / Portfolio URL</label>
                        <input type="url" name="linkedin" placeholder="https://linkedin.com/in/username" className="form-input" />
                      </div>

                      <div>
                        <label style={{ display: 'block', fontSize: '0.82rem', fontWeight: 700, color: 'var(--text-secondary)', marginBottom: '6px' }}>Upload Resume (PDF, DOC, DOCX) *</label>
                        <input type="file" name="resume_file" accept=".pdf,.doc,.docx" required className="form-input" style={{ padding: '8px 12px' }} />
                      </div>

                      <div>
                        <label style={{ display: 'block', fontSize: '0.82rem', fontWeight: 700, color: 'var(--text-secondary)', marginBottom: '6px' }}>Cover Note / Additional Details</label>
                        <textarea name="resume_note" placeholder="Briefly introduce yourself & experience..." rows="3" className="form-textarea" />
                      </div>
                    </div>

                    <div style={{ display: 'flex', gap: '12px', justifyContent: 'flex-end' }}>
                      <button type="button" onClick={() => { setSelectedJob(null); setApplyError(''); }} className="btn-secondary" style={{ padding: '10px 20px' }}>Cancel</button>
                      <button type="submit" className="btn-primary" style={{ padding: '10px 20px' }}>Submit Application <Send size={16} /></button>
                    </div>
                  </form>
                ) : (
                  <div style={{ textAlign: 'center', padding: '20px' }}>
                    <CheckCircle2 size={48} color="var(--orbit-orange)" style={{ margin: '0 auto 12px auto' }} />
                    <h3 style={{ fontSize: '1.4rem', color: 'var(--text-primary)', marginBottom: '8px' }}>Application Submitted!</h3>
                    <p style={{ color: 'var(--text-secondary)', fontSize: '0.92rem', marginBottom: '20px' }}>Our talent team will review your profile and reach out shortly.</p>
                    <button onClick={() => setSelectedJob(null)} className="btn-primary">Close Window</button>
                  </div>
                )}
              </div>
            </div>
          )}

        </div>
      </main>

      <Footer />
    </div>
  );
}
