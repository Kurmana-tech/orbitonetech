import React, { useState, useEffect } from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { Users, Briefcase, MapPin, Send, CheckCircle2, DollarSign, Award, Terminal, Brain, Rocket, Palette, X, User, Mail, Link as LinkIcon, FileUp, FileText, AlertCircle } from 'lucide-react';

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
  const [viewingJob, setViewingJob] = useState(null);
  const [applied, setApplied] = useState(false);
  const [applyError, setApplyError] = useState('');
  const [jobs, setJobs] = useState([]);
  const [loading, setLoading] = useState(true);
  const [selectedFileName, setSelectedFileName] = useState('');
  const [selectedDemoFileName, setSelectedDemoFileName] = useState('');

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
      const demoFileInput = formEl.elements['demo_file'];
      const demoFile = demoFileInput?.files?.[0];

      if (!name.trim() || !email.trim()) {
        setApplyError('Please enter your Name and Email address.');
        return;
      }

      if (!file) {
        setApplyError('Please select a resume file (PDF, DOC, or DOCX) to upload.');
        return;
      }

      const requiresDemo = Boolean(selectedJob && Number(selectedJob.requires_demo_file) === 1);
      if (requiresDemo && !demoFile) {
        setApplyError('Please upload your Portfolio Demo Reel / Video / Image file required for this position.');
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
      if (demoFile) {
        body.append('demo_file', demoFile);
      }

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
                  <div key={job.id} className="glass-panel" style={{ padding: '28px', display: 'flex', justifyContent: 'space-between', alignItems: 'center', flexWrap: 'wrap', gap: '20px' }}>
                    <div style={{ flex: '1 1 60%', minWidth: '280px' }}>
                      <div style={{ display: 'flex', flexWrap: 'wrap', gap: '10px', alignItems: 'center', marginBottom: '10px' }}>
                        <span style={{
                          fontSize: '0.72rem',
                          fontWeight: 700,
                          color: colors.text,
                          background: colors.bg,
                          border: `1px solid ${colors.border}`,
                          padding: '3px 12px',
                          borderRadius: '20px',
                          textTransform: 'uppercase',
                          letterSpacing: '0.05em'
                        }}>
                          {job.department}
                        </span>
                        <span style={{ fontSize: '0.82rem', color: 'var(--text-secondary)' }}>📍 {job.location} ({job.type})</span>
                        <span style={{ fontSize: '0.82rem', color: 'var(--text-secondary)' }}>⏱️ {job.experience}</span>
                        {job.stipend && (
                          <span style={{ fontSize: '0.82rem', fontWeight: 700, color: 'var(--orbit-orange)' }}>
                            💼 {job.stipend}
                          </span>
                        )}
                      </div>
                      <h3 style={{ fontSize: '1.35rem', color: 'var(--text-primary)', fontWeight: 800, marginBottom: '8px' }}>{job.title}</h3>
                      <p style={{ color: 'var(--text-secondary)', fontSize: '0.92rem', maxWidth: '700px', lineHeight: '1.6', margin: 0 }}>
                        {job.description && job.description.length > 140 ? job.description.substring(0, 140) + '...' : job.description}
                      </p>
                    </div>

                    <div style={{ display: 'flex', gap: '12px', alignItems: 'center', flexWrap: 'wrap' }}>
                      <button 
                        onClick={() => setViewingJob(job)} 
                        style={{
                          padding: '10px 18px',
                          fontSize: '0.88rem',
                          fontWeight: 700,
                          borderRadius: '12px',
                          background: 'rgba(255, 255, 255, 0.05)',
                          border: '1px solid rgba(255, 255, 255, 0.15)',
                          color: 'var(--text-primary)',
                          cursor: 'pointer',
                          transition: 'all 0.2s ease'
                        }}
                        onMouseEnter={(e) => e.currentTarget.style.background = 'rgba(255, 255, 255, 0.12)'}
                        onMouseLeave={(e) => e.currentTarget.style.background = 'rgba(255, 255, 255, 0.05)'}
                      >
                        View Details
                      </button>
                      <button 
                        onClick={() => { setSelectedJob(job); setApplied(false); }} 
                        className="btn-primary" 
                        style={{ padding: '10px 22px', fontSize: '0.88rem' }}
                      >
                        Apply Now
                      </button>
                    </div>
                  </div>
                );
              })
            )}
          </div>

          {/* View Job Details Modal Popup */}
          {viewingJob && (
            <div
              style={{
                position: 'fixed',
                top: 0,
                left: 0,
                right: 0,
                bottom: 0,
                background: 'rgba(4, 12, 28, 0.85)',
                backdropFilter: 'blur(20px)',
                WebkitBackdropFilter: 'blur(20px)',
                zIndex: 2400,
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                padding: '20px',
                overflowY: 'auto'
              }}
              onClick={() => setViewingJob(null)}
            >
              <div
                className="glass-panel"
                style={{
                  maxWidth: '680px',
                  width: '100%',
                  maxHeight: '85vh',
                  padding: '36px',
                  position: 'relative',
                  borderRadius: '24px',
                  boxShadow: '0 30px 80px rgba(0, 0, 0, 0.6), 0 0 50px rgba(247, 147, 0, 0.12)',
                  border: '1px solid rgba(255, 255, 255, 0.15)',
                  overflowY: 'auto'
                }}
                onClick={(e) => e.stopPropagation()}
              >
                {/* Close Button */}
                <button
                  type="button"
                  onClick={() => setViewingJob(null)}
                  style={{
                    position: 'absolute',
                    top: '20px',
                    right: '20px',
                    width: '36px',
                    height: '36px',
                    borderRadius: '50%',
                    background: 'rgba(255, 255, 255, 0.08)',
                    border: '1px solid rgba(255, 255, 255, 0.15)',
                    color: 'var(--text-primary)',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    cursor: 'pointer',
                    transition: 'all 0.2s ease'
                  }}
                  onMouseEnter={(e) => e.currentTarget.style.background = 'rgba(239, 68, 68, 0.2)'}
                  onMouseLeave={(e) => e.currentTarget.style.background = 'rgba(255, 255, 255, 0.08)'}
                >
                  <X size={18} />
                </button>

                <div style={{ marginBottom: '20px', paddingRight: '40px' }}>
                  <span style={{
                    fontSize: '0.72rem',
                    fontWeight: 700,
                    color: 'var(--orbit-orange)',
                    background: 'rgba(247, 147, 0, 0.12)',
                    border: '1px solid rgba(247, 147, 0, 0.25)',
                    padding: '4px 12px',
                    borderRadius: '20px',
                    textTransform: 'uppercase',
                    letterSpacing: '0.05em',
                    display: 'inline-block',
                    marginBottom: '10px'
                  }}>
                    {viewingJob.department}
                  </span>
                  <h2 style={{ fontSize: '1.6rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '8px' }}>
                    {viewingJob.title}
                  </h2>
                  <div style={{ display: 'flex', flexWrap: 'wrap', gap: '16px', fontSize: '0.88rem', color: 'var(--text-secondary)' }}>
                    <span>📍 {viewingJob.location}</span>
                    <span>💼 {viewingJob.type}</span>
                    <span>⏱️ Duration / Exp: {viewingJob.experience}</span>
                    {viewingJob.stipend && <span style={{ color: 'var(--orbit-orange)', fontWeight: 700 }}>💰 {viewingJob.stipend}</span>}
                  </div>
                </div>

                <hr style={{ border: 'none', height: '1px', background: 'rgba(255, 255, 255, 0.1)', margin: '20px 0' }} />

                {/* Full Description & Roles */}
                <div style={{ marginBottom: '24px' }}>
                  <h3 style={{ fontSize: '1.05rem', fontWeight: 700, color: 'var(--text-primary)', marginBottom: '10px' }}>Job Overview & Responsibilities</h3>
                  <p style={{ color: 'var(--text-secondary)', fontSize: '0.92rem', lineHeight: '1.7', whiteSpace: 'pre-line' }}>
                    {viewingJob.description}
                  </p>
                </div>

                {/* Key Requirements & Skills */}
                {viewingJob.requirements && (
                  <div style={{ marginBottom: '28px', background: 'rgba(255, 255, 255, 0.02)', padding: '20px', borderRadius: '14px', border: '1px solid rgba(255, 255, 255, 0.08)' }}>
                    <h3 style={{ fontSize: '0.98rem', fontWeight: 700, color: 'var(--text-primary)', marginBottom: '12px' }}>Key Requirements & Qualifications</h3>
                    <ul style={{ paddingLeft: '20px', margin: 0, fontSize: '0.9rem', color: 'var(--text-secondary)', lineHeight: '1.7' }}>
                      {viewingJob.requirements.split('\n').map((req, idx) => req.trim() && (
                        <li key={idx} style={{ marginBottom: '6px' }}>{req.trim()}</li>
                      ))}
                    </ul>
                  </div>
                )}

                <div style={{ display: 'flex', justifyContent: 'flex-end', gap: '12px' }}>
                  <button 
                    onClick={() => setViewingJob(null)}
                    style={{
                      padding: '12px 24px',
                      fontSize: '0.9rem',
                      fontWeight: 700,
                      borderRadius: '12px',
                      background: 'rgba(255, 255, 255, 0.05)',
                      border: '1px solid rgba(255, 255, 255, 0.15)',
                      color: 'var(--text-primary)',
                      cursor: 'pointer'
                    }}
                  >
                    Close
                  </button>
                  <button 
                    onClick={() => { 
                      setSelectedJob(viewingJob); 
                      setViewingJob(null); 
                      setApplied(false); 
                    }} 
                    className="btn-primary" 
                    style={{ padding: '12px 28px', fontSize: '0.9rem' }}
                  >
                    Apply Now
                  </button>
                </div>
              </div>
            </div>
          )}

          {/* Application Modal Popup */}
          {selectedJob && (
            <div
              style={{
                position: 'fixed',
                top: 0,
                left: 0,
                right: 0,
                bottom: 0,
                background: 'rgba(4, 12, 28, 0.82)',
                backdropFilter: 'blur(20px)',
                WebkitBackdropFilter: 'blur(20px)',
                zIndex: 2500,
                display: 'flex',
                alignItems: 'flex-start',
                justifyContent: 'center',
                paddingTop: '105px',
                paddingBottom: '40px',
                paddingLeft: '20px',
                paddingRight: '20px',
                overflowY: 'auto'
              }}
              onClick={() => { setSelectedJob(null); setSelectedFileName(''); setApplyError(''); }}
            >
              <div
                className="glass-panel"
                style={{
                  maxWidth: '580px',
                  width: '100%',
                  padding: '36px',
                  position: 'relative',
                  borderRadius: '24px',
                  boxShadow: '0 30px 80px rgba(0, 0, 0, 0.6), 0 0 50px rgba(247, 147, 0, 0.12)',
                  border: '1px solid rgba(255, 255, 255, 0.15)',
                  margin: 'auto 0'
                }}
                onClick={(e) => e.stopPropagation()}
              >
                {/* Close Button */}
                <button
                  type="button"
                  onClick={() => { setSelectedJob(null); setSelectedFileName(''); setApplyError(''); }}
                  style={{
                    position: 'absolute',
                    top: '20px',
                    right: '20px',
                    width: '36px',
                    height: '36px',
                    borderRadius: '50%',
                    background: 'rgba(255, 255, 255, 0.08)',
                    border: '1px solid rgba(255, 255, 255, 0.15)',
                    color: 'var(--text-primary)',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    cursor: 'pointer',
                    transition: 'all 0.2s ease'
                  }}
                  onMouseEnter={(e) => e.currentTarget.style.background = 'rgba(239, 68, 68, 0.2)'}
                  onMouseLeave={(e) => e.currentTarget.style.background = 'rgba(255, 255, 255, 0.08)'}
                >
                  <X size={18} />
                </button>

                {!applied ? (
                  <form onSubmit={handleApply}>
                    {/* Header */}
                    <div style={{ marginBottom: '24px', paddingRight: '36px' }}>
                      <div style={{ display: 'inline-flex', alignItems: 'center', gap: '6px', fontSize: '0.75rem', fontWeight: 700, color: 'var(--orbit-orange)', background: 'rgba(247, 147, 0, 0.12)', padding: '4px 12px', borderRadius: '20px', marginBottom: '10px', border: '1px solid rgba(247, 147, 0, 0.25)' }}>
                        <Briefcase size={12} /> {selectedJob.department}
                      </div>
                      <h2 style={{ fontSize: '1.5rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '4px', letterSpacing: '-0.02em' }}>
                        Apply for <span className="gradient-text-orange">{selectedJob.title}</span>
                      </h2>
                      <p style={{ color: 'var(--text-secondary)', fontSize: '0.88rem' }}>
                        {selectedJob.location} • {selectedJob.type} {selectedJob.experience ? `• Exp: ${selectedJob.experience}` : ''}
                      </p>
                    </div>

                    {applyError && (
                      <div style={{ background: 'rgba(239, 68, 68, 0.15)', border: '1px solid rgba(239, 68, 68, 0.35)', color: '#fca5a5', padding: '12px 16px', borderRadius: '12px', fontSize: '0.86rem', marginBottom: '20px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                        <AlertCircle size={16} flexShrink={0} />
                        <span>{applyError}</span>
                      </div>
                    )}

                    <div style={{ display: 'flex', flexDirection: 'column', gap: '16px', marginBottom: '24px' }}>
                      {/* Full Name */}
                      <div>
                        <label style={{ display: 'flex', alignItems: 'center', gap: '6px', fontSize: '0.82rem', fontWeight: 700, color: 'var(--text-secondary)', marginBottom: '6px' }}>
                          <User size={14} color="var(--orbit-orange)" /> Full Name <span style={{ color: 'var(--orbit-orange)' }}>*</span>
                        </label>
                        <input
                          type="text"
                          name="applicant_name"
                          placeholder="e.g. Alexander Wright"
                          required
                          className="form-input"
                          style={{
                            width: '100%',
                            background: 'rgba(255, 255, 255, 0.04)',
                            border: '1px solid var(--border-glass)',
                            borderRadius: '10px',
                            padding: '12px 16px',
                            color: 'var(--text-primary)',
                            fontSize: '0.92rem'
                          }}
                        />
                      </div>

                      {/* Email Address */}
                      <div>
                        <label style={{ display: 'flex', alignItems: 'center', gap: '6px', fontSize: '0.82rem', fontWeight: 700, color: 'var(--text-secondary)', marginBottom: '6px' }}>
                          <Mail size={14} color="var(--orbit-orange)" /> Email Address <span style={{ color: 'var(--orbit-orange)' }}>*</span>
                        </label>
                        <input
                          type="email"
                          name="email"
                          placeholder="alexander@example.com"
                          required
                          className="form-input"
                          style={{
                            width: '100%',
                            background: 'rgba(255, 255, 255, 0.04)',
                            border: '1px solid var(--border-glass)',
                            borderRadius: '10px',
                            padding: '12px 16px',
                            color: 'var(--text-primary)',
                            fontSize: '0.92rem'
                          }}
                        />
                      </div>

                      {/* LinkedIn / Portfolio */}
                      <div>
                        <label style={{ display: 'flex', alignItems: 'center', gap: '6px', fontSize: '0.82rem', fontWeight: 700, color: 'var(--text-secondary)', marginBottom: '6px' }}>
                          <LinkIcon size={14} color="var(--orbit-orange)" /> LinkedIn / Portfolio / GitHub Link
                        </label>
                        <input
                          type="url"
                          name="linkedin"
                          placeholder="https://linkedin.com/in/yourprofile"
                          className="form-input"
                          style={{
                            width: '100%',
                            background: 'rgba(255, 255, 255, 0.04)',
                            border: '1px solid var(--border-glass)',
                            borderRadius: '10px',
                            padding: '12px 16px',
                            color: 'var(--text-primary)',
                            fontSize: '0.92rem'
                          }}
                        />
                      </div>

                      {/* File Upload Dropzone */}
                      <div>
                        <label style={{ display: 'flex', alignItems: 'center', gap: '6px', fontSize: '0.82rem', fontWeight: 700, color: 'var(--text-secondary)', marginBottom: '6px' }}>
                          <FileUp size={14} color="var(--orbit-orange)" /> Upload Resume <span style={{ color: 'var(--orbit-orange)' }}>*</span>
                        </label>
                        <div
                          style={{
                            border: '2px dashed rgba(247, 147, 0, 0.4)',
                            background: selectedFileName ? 'rgba(34, 197, 94, 0.08)' : 'rgba(247, 147, 0, 0.04)',
                            borderRadius: '12px',
                            padding: '18px',
                            textAlign: 'center',
                            position: 'relative',
                            cursor: 'pointer',
                            transition: 'all 0.3s ease'
                          }}
                        >
                          <input
                            type="file"
                            name="resume_file"
                            accept=".pdf,.doc,.docx"
                            required
                            onChange={(e) => {
                              const file = e.target.files?.[0];
                              if (file) setSelectedFileName(file.name);
                            }}
                            style={{
                              position: 'absolute',
                              top: 0,
                              left: 0,
                              width: '100%',
                              height: '100%',
                              opacity: 0,
                              cursor: 'pointer'
                            }}
                          />
                          <FileUp size={28} color={selectedFileName ? '#22c55e' : 'var(--orbit-orange)'} style={{ margin: '0 auto 8px auto' }} />
                          {selectedFileName ? (
                            <div>
                              <span style={{ fontSize: '0.9rem', fontWeight: 700, color: '#4ade80', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '6px' }}>
                                <CheckCircle2 size={16} /> Selected: {selectedFileName}
                              </span>
                              <span style={{ fontSize: '0.75rem', color: 'var(--text-secondary)', marginTop: '2px', display: 'block' }}>Click to choose a different file</span>
                            </div>
                          ) : (
                            <div>
                              <span style={{ fontSize: '0.9rem', fontWeight: 700, color: 'var(--text-primary)', display: 'block' }}>Click or drop your resume here</span>
                              <span style={{ fontSize: '0.75rem', color: 'var(--text-secondary)', marginTop: '4px', display: 'block' }}>Supports PDF, DOC, or DOCX formats (Max 10MB)</span>
                            </div>
                          )}
                        </div>
                      </div>

                      {/* Optional or Mandatory Demo Reel / Portfolio Upload */}
                      {selectedJob && Number(selectedJob.requires_demo_file) === 1 && (
                        <div>
                          <label style={{ display: 'flex', alignItems: 'center', gap: '6px', fontSize: '0.82rem', fontWeight: 700, color: '#a855f7', marginBottom: '6px' }}>
                            <FileUp size={14} color="#a855f7" /> {selectedJob.demo_file_label || 'Upload Demo Reel / Portfolio Video/Image'} <span style={{ color: '#a855f7' }}>*</span>
                          </label>
                          <div
                            style={{
                              border: '2px dashed rgba(168, 85, 247, 0.4)',
                              background: selectedDemoFileName ? 'rgba(34, 197, 94, 0.08)' : 'rgba(168, 85, 247, 0.04)',
                              borderRadius: '12px',
                              padding: '18px',
                              textAlign: 'center',
                              position: 'relative',
                              cursor: 'pointer',
                              transition: 'all 0.3s ease'
                            }}
                          >
                            <input
                              type="file"
                              name="demo_file"
                              accept=".mp4,.mov,.avi,.mkv,.png,.jpg,.jpeg,.webp,.pdf,.zip,.rar"
                              required
                              onChange={(e) => {
                                const file = e.target.files?.[0];
                                if (file) setSelectedDemoFileName(file.name);
                              }}
                              style={{
                                position: 'absolute',
                                top: 0,
                                left: 0,
                                width: '100%',
                                height: '100%',
                                opacity: 0,
                                cursor: 'pointer'
                              }}
                            />
                            <FileUp size={28} color={selectedDemoFileName ? '#22c55e' : '#a855f7'} style={{ margin: '0 auto 8px auto' }} />
                            {selectedDemoFileName ? (
                              <div>
                                <span style={{ fontSize: '0.9rem', fontWeight: 700, color: '#4ade80', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '6px' }}>
                                  <CheckCircle2 size={16} /> Selected Demo File: {selectedDemoFileName}
                                </span>
                                <span style={{ fontSize: '0.75rem', color: 'var(--text-secondary)', marginTop: '2px', display: 'block' }}>Click to choose a different file</span>
                              </div>
                            ) : (
                              <div>
                                <span style={{ fontSize: '0.9rem', fontWeight: 700, color: 'var(--text-primary)', display: 'block' }}>Upload Portfolio Demo Reel / Video / Image / Zip *</span>
                                <span style={{ fontSize: '0.75rem', color: 'var(--text-secondary)', marginTop: '4px', display: 'block' }}>Supports MP4, MOV, PNG, JPG, WEBP, PDF, ZIP (Max 50MB)</span>
                              </div>
                            )}
                          </div>
                        </div>
                      )}

                      {/* Cover Note / Additional Info */}
                      <div>
                        <label style={{ display: 'flex', alignItems: 'center', gap: '6px', fontSize: '0.82rem', fontWeight: 700, color: 'var(--text-secondary)', marginBottom: '6px' }}>
                          <FileText size={14} color="var(--orbit-orange)" /> Cover Note / Brief Introduction
                        </label>
                        <textarea
                          name="resume_note"
                          placeholder="Tell us briefly about your experience, background, or availability..."
                          rows="3"
                          className="form-textarea"
                          style={{
                            width: '100%',
                            background: 'rgba(255, 255, 255, 0.04)',
                            border: '1px solid var(--border-glass)',
                            borderRadius: '10px',
                            padding: '12px 16px',
                            color: 'var(--text-primary)',
                            fontSize: '0.9rem',
                            resize: 'vertical'
                          }}
                        />
                      </div>
                    </div>

                    {/* Action Buttons */}
                    <div style={{ display: 'flex', gap: '12px', justifyContent: 'flex-end', paddingTop: '12px', borderTop: '1px solid rgba(255,255,255,0.08)' }}>
                      <button
                        type="button"
                        onClick={() => { setSelectedJob(null); setSelectedFileName(''); setApplyError(''); }}
                        className="btn-secondary"
                        style={{ padding: '11px 22px', fontSize: '0.88rem' }}
                      >
                        Cancel
                      </button>
                      <button
                        type="submit"
                        className="btn-primary"
                        style={{ padding: '11px 24px', fontSize: '0.88rem', gap: '8px' }}
                      >
                        Submit Application <Send size={16} />
                      </button>
                    </div>
                  </form>
                ) : (
                  <div style={{ textAlign: 'center', padding: '24px 12px' }}>
                    <div style={{ width: '64px', height: '64px', borderRadius: '50%', background: 'rgba(34, 197, 94, 0.15)', border: '1px solid rgba(34, 197, 94, 0.3)', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 16px auto' }}>
                      <CheckCircle2 size={36} color="#22c55e" />
                    </div>
                    <h3 style={{ fontSize: '1.5rem', color: 'var(--text-primary)', fontWeight: 800, marginBottom: '8px' }}>Application Submitted!</h3>
                    <p style={{ color: 'var(--text-secondary)', fontSize: '0.94rem', maxWidth: '420px', margin: '0 auto 24px auto', lineHeight: '1.6' }}>
                      Thank you for applying for the <strong style={{ color: 'var(--orbit-orange)' }}>{selectedJob.title}</strong> role. Our talent engineering team will review your resume and contact you soon.
                    </p>
                    <button
                      onClick={() => { setSelectedJob(null); setSelectedFileName(''); setApplied(false); }}
                      className="btn-primary"
                      style={{ padding: '12px 28px' }}
                    >
                      Done / Close Window
                    </button>
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
