import React, { useState, useEffect } from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { Calendar, User, ArrowRight } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function Blog() {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function fetchBlogs() {
      try {
        const res = await fetch('/api/blogs.php');
        const result = await res.json();
        if (result.success && Array.isArray(result.data)) {
          const formatted = result.data.map(b => ({
            id: b.id,
            title: b.title,
            category: b.category || 'AI & Tech',
            date: b.published_at || b.read_time || 'Recent',
            desc: b.snippet || b.content || ''
          }));
          setPosts(formatted);
        }
      } catch (err) {
        console.error('Error fetching blog posts:', err);
      } finally {
        setLoading(false);
      }
    }
    fetchBlogs();
  }, []);

  return (
    <div style={{ position: 'relative', width: '100%', minHeight: '100vh', background: 'var(--bg-deep)' }}>
      <Navbar />
      <MainCanvas />

      <main className="content-wrapper" style={{ paddingTop: '140px', paddingBottom: '80px', maxWidth: '1240px', margin: '0 auto', paddingLeft: '5%', paddingRight: '5%' }}>
        <div style={{ textAlign: 'center', marginBottom: '60px' }}>
          <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>INSIGHTS & INNOVATION</div>
          <h1 className="section-title">
            Technology & Industry <span className="gradient-text-orange">Blog</span>
          </h1>
          <p className="section-description" style={{ maxWidth: '750px', margin: '0 auto' }}>
            Stay updated with the latest trends in software engineering, artificial intelligence, and digital transformation.
          </p>
        </div>

        {loading ? (
          <div className="glass-panel" style={{ padding: '36px', textAlign: 'center', color: 'var(--text-secondary)' }}>
            Loading blog articles...
          </div>
        ) : posts.length === 0 ? (
          <div className="glass-panel" style={{ padding: '36px', textAlign: 'center', color: 'var(--text-secondary)' }}>
            No blog articles currently published. Check back soon for our latest technical insights!
          </div>
        ) : (
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(340px, 1fr))', gap: '28px', marginBottom: '80px' }}>
            {posts.map((post, idx) => (
              <div key={idx} className="glass-panel" style={{ padding: '36px', display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
                <div>
                  <div style={{ color: 'var(--orbit-orange)', fontWeight: 700, fontSize: '0.85rem', marginBottom: '8px' }}>
                    {post.category} • {post.date}
                  </div>
                  <h3 style={{ fontSize: '1.4rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '14px', lineHeight: 1.3 }}>{post.title}</h3>
                  <p style={{ color: 'var(--text-secondary)', lineHeight: 1.6, marginBottom: '24px', fontSize: '0.95rem' }}>{post.desc}</p>
                </div>
                <Link to="/quote" style={{ color: 'var(--electric-blue)', textDecoration: 'none', fontWeight: 700, display: 'flex', alignItems: 'center', gap: '6px', fontSize: '0.9rem' }}>
                  Read Article <ArrowRight size={16} />
                </Link>
              </div>
            ))}
          </div>
        )}
      </main>

      <Footer />
    </div>
  );
}

