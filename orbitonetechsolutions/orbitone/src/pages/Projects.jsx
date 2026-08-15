import React, { useState, useEffect } from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { Briefcase, ArrowRight, X, CheckCircle2, ShieldCheck, Zap, Award } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function Projects() {
  const [activeFilter, setActiveFilter] = useState('all');
  const [selectedProject, setSelectedProject] = useState(null);
  const [projectsData, setProjectsData] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function fetchProjects() {
      try {
        const res = await fetch('/api/projects.php');
        const result = await res.json();
        if (result.success && Array.isArray(result.data)) {
          const formatted = result.data.map(p => ({
            id: p.id,
            title: p.title,
            category: p.category,
            filterCategory: p.category || 'Web Development',
            image: p.image_url || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80',
            description: p.description || '',
            challenge: p.challenge || 'Challenge details provided upon project discovery.',
            solution: p.solution || 'Custom architecture engineered by Orbitone Tech Solutions.',
            techStack: p.tech_stack || 'React, Node.js, Python, Cloud',
            results: p.results || 'Optimal performance and scalability achieved.',
            featured: Boolean(p.featured)
          }));
          setProjectsData(formatted);
        }
      } catch (err) {
        console.error('Error fetching projects:', err);
      } finally {
        setLoading(false);
      }
    }
    fetchProjects();
  }, []);

  const filterTabs = [
    { id: 'all', label: 'All Projects' },
    { id: 'Web Development', label: 'Web Development' },
    { id: 'Applications', label: 'Applications' },
    { id: 'AI Solutions', label: 'AI Solutions' },
    { id: 'Data Analytics', label: 'Data Analytics' },
    { id: 'Digital Marketing', label: 'Digital Marketing' }
  ];

  const filteredProjects = activeFilter === 'all'
    ? projectsData
    : projectsData.filter(p => p.filterCategory === activeFilter);

  return (
    <div style={{ position: 'relative', width: '100%', minHeight: '100vh', background: 'var(--bg-deep)' }}>
      <Navbar />
      <MainCanvas />

      <main className="content-wrapper" style={{ paddingTop: '140px', paddingBottom: '80px' }}>
        <div style={{ maxWidth: '1240px', margin: '0 auto', padding: '0 5%' }}>
          
          {/* Header */}
          <div style={{ textAlign: 'center', marginBottom: '40px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>
              <Briefcase size={14} /> CASE STUDIES
            </div>
            <h1 className="section-title">
              Ideas We've Turned Into <span className="gradient-text-orange">Digital Experiences</span>
            </h1>
            <p className="section-description" style={{ maxWidth: '750px', margin: '0 auto' }}>
              Explore a selection of high-impact software applications, AI models, and performance marketing campaigns we've engineered.
            </p>
          </div>

          {/* Filter Tabs */}
          <div style={{ display: 'flex', justifyContent: 'center', gap: '10px', flexWrap: 'wrap', marginBottom: '48px' }}>
            {filterTabs.map((tab) => {
              const isSelected = activeFilter === tab.id;
              return (
                <button
                  key={tab.id}
                  onClick={() => setActiveFilter(tab.id)}
                  style={{
                    padding: '10px 20px',
                    borderRadius: '24px',
                    border: isSelected ? '1px solid var(--orbit-orange)' : '1px solid var(--border-glass)',
                    background: isSelected ? 'var(--orbit-orange)' : 'var(--bg-surface-elevated)',
                    color: isSelected ? '#FFFFFF' : 'var(--text-secondary)',
                    fontWeight: 700,
                    cursor: 'pointer',
                    fontSize: '0.88rem',
                    transition: 'all 0.3s ease',
                    boxShadow: isSelected ? '0 4px 15px rgba(247, 147, 0, 0.3)' : 'none'
                  }}
                >
                  {tab.label}
                </button>
              );
            })}
          </div>

          {/* Portfolio Grid */}
          {loading ? (
            <div className="glass-panel" style={{ padding: '36px', textAlign: 'center', color: 'var(--text-secondary)' }}>
              Loading portfolio case studies...
            </div>
          ) : filteredProjects.length === 0 ? (
            <div className="glass-panel" style={{ padding: '36px', textAlign: 'center', color: 'var(--text-secondary)' }}>
              No portfolio projects currently published. Check back soon!
            </div>
          ) : (
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(340px, 1fr))', gap: '32px', marginBottom: '80px' }}>
              {filteredProjects.map((p) => (
              <div key={p.id} className="glass-panel" style={{ padding: '0', overflow: 'hidden', display: 'flex', flexDirection: 'column', borderRadius: '20px' }}>
                
                {/* Project Image */}
                <div style={{ position: 'relative', width: '100%', height: '220px', overflow: 'hidden' }}>
                  <img
                    src={p.image}
                    alt={p.title}
                    style={{ width: '100%', height: '100%', objectFit: 'cover', transition: 'transform 0.5s ease' }}
                  />
                  <div style={{ position: 'absolute', top: '14px', left: '14px' }}>
                    <span style={{ fontSize: '0.74rem', fontWeight: 800, padding: '4px 12px', borderRadius: '12px', background: 'rgba(7, 25, 54, 0.85)', backdropFilter: 'blur(8px)', color: 'var(--orbit-orange)', border: '1px solid rgba(247, 147, 0, 0.4)', letterSpacing: '0.04em' }}>
                      {p.filterCategory}
                    </span>
                  </div>
                </div>

                {/* Card Content */}
                <div style={{ padding: '28px', display: 'flex', flexDirection: 'column', flexGrow: 1, justifyContent: 'space-between' }}>
                  <div>
                    <h3 style={{ fontSize: '1.3rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '10px', lineHeight: 1.3 }}>
                      {p.title}
                    </h3>
                    <p style={{ color: 'var(--text-secondary)', fontSize: '0.92rem', lineHeight: 1.6, marginBottom: '20px' }}>
                      {p.description}
                    </p>

                    {/* Tech Stack Badge */}
                    <div style={{ marginBottom: '24px' }}>
                      <div style={{ fontSize: '0.75rem', fontWeight: 700, color: 'var(--text-muted)', textTransform: 'uppercase', marginBottom: '4px', letterSpacing: '0.05em' }}>
                        TECH STACK
                      </div>
                      <div style={{ fontSize: '0.88rem', fontWeight: 700, color: 'var(--orbit-orange)' }}>
                        {p.techStack}
                      </div>
                    </div>
                  </div>

                  {/* View Case Study Button */}
                  <button
                    onClick={() => setSelectedProject(p)}
                    className="btn-secondary"
                    style={{ width: '100%', justifyContent: 'center', padding: '12px', fontSize: '0.9rem', fontWeight: 700 }}
                  >
                    View Case Study <ArrowRight size={16} />
                  </button>
                </div>

              </div>
            ))}
          </div>
          )}

          {/* Detailed Case Study Modal Popup */}
          {selectedProject && (
            <div
              style={{
                position: 'fixed',
                top: 0,
                left: 0,
                right: 0,
                bottom: 0,
                background: 'rgba(4, 15, 36, 0.9)',
                backdropFilter: 'blur(16px)',
                zIndex: 2500,
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                padding: '20px'
              }}
              onClick={() => setSelectedProject(null)}
            >
              <div
                className="glass-panel"
                style={{ maxWidth: '640px', width: '100%', padding: '36px', maxHeight: '90vh', overflowY: 'auto', borderRadius: '24px', position: 'relative', border: '1px solid rgba(247, 147, 0, 0.4)' }}
                onClick={(e) => e.stopPropagation()}
              >
                {/* Close Button */}
                <button
                  onClick={() => setSelectedProject(null)}
                  style={{ position: 'absolute', top: '20px', right: '20px', background: 'rgba(255, 255, 255, 0.1)', border: 'none', color: '#FFFFFF', width: '36px', height: '36px', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', cursor: 'pointer' }}
                >
                  <X size={20} />
                </button>

                {/* Modal Content */}
                <img
                  src={selectedProject.image}
                  alt={selectedProject.title}
                  style={{ width: '100%', height: '220px', objectFit: 'cover', borderRadius: '16px', marginBottom: '24px' }}
                />

                <span style={{ fontSize: '0.78rem', fontWeight: 800, padding: '4px 12px', borderRadius: '12px', background: 'rgba(247, 147, 0, 0.15)', color: 'var(--orbit-orange)', border: '1px solid rgba(247, 147, 0, 0.4)', textTransform: 'uppercase' }}>
                  {selectedProject.filterCategory}
                </span>

                <h3 style={{ fontSize: '1.6rem', fontWeight: 800, color: 'var(--text-primary)', marginTop: '12px', marginBottom: '20px' }}>
                  {selectedProject.title}
                </h3>

                {/* Challenge */}
                <div style={{ marginBottom: '18px' }}>
                  <h4 style={{ color: 'var(--orbit-orange)', textTransform: 'uppercase', fontSize: '0.8rem', fontWeight: 800, letterSpacing: '0.06em' }}>
                    THE CHALLENGE
                  </h4>
                  <p style={{ color: 'var(--text-secondary)', fontSize: '0.94rem', marginTop: '4px', lineHeight: 1.6 }}>
                    {selectedProject.challenge}
                  </p>
                </div>

                {/* Solution */}
                <div style={{ marginBottom: '18px' }}>
                  <h4 style={{ color: 'var(--text-primary)', textTransform: 'uppercase', fontSize: '0.8rem', fontWeight: 800, letterSpacing: '0.06em' }}>
                    ORBITONE SOLUTION
                  </h4>
                  <p style={{ color: 'var(--text-secondary)', fontSize: '0.94rem', marginTop: '4px', lineHeight: 1.6 }}>
                    {selectedProject.solution}
                  </p>
                </div>

                {/* Tech Stack */}
                <div style={{ marginBottom: '20px' }}>
                  <h4 style={{ color: 'var(--ai-purple)', textTransform: 'uppercase', fontSize: '0.8rem', fontWeight: 800, letterSpacing: '0.06em' }}>
                    TECHNOLOGIES USED
                  </h4>
                  <p style={{ color: 'var(--orbit-orange)', fontWeight: 700, fontSize: '0.95rem', marginTop: '4px' }}>
                    {selectedProject.techStack}
                  </p>
                </div>

                {/* Measurable Results */}
                <div style={{ background: 'rgba(16, 185, 129, 0.1)', border: '1px dashed #10B981', padding: '18px', borderRadius: '12px' }}>
                  <h4 style={{ color: '#10B981', textTransform: 'uppercase', fontSize: '0.8rem', fontWeight: 800, letterSpacing: '0.06em' }}>
                    MEASURABLE RESULTS
                  </h4>
                  <p style={{ color: 'var(--text-primary)', fontWeight: 700, fontSize: '0.96rem', marginTop: '4px' }}>
                    {selectedProject.results}
                  </p>
                </div>

              </div>
            </div>
          )}

          {/* CTA Banner */}
          <div className="glass-panel" style={{ padding: '48px 36px', textAlign: 'center', borderRadius: '24px', border: '1px solid rgba(247, 147, 0, 0.3)' }}>
            <h2 style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '16px' }}>Have a High-Impact Project in Mind?</h2>
            <p style={{ color: 'var(--text-secondary)', marginBottom: '28px', maxWidth: '600px', margin: '0 auto 28px auto' }}>
              Let's engineer a custom software solution tailored to your operational goals.
            </p>
            <Link to="/quote" className="btn-primary">
              START YOUR PROJECT <ArrowRight size={18} />
            </Link>
          </div>

        </div>
      </main>

      <Footer />
    </div>
  );
}
