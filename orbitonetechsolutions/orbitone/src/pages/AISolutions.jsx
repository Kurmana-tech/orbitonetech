import React, { useState } from 'react';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import MainCanvas from '../3d/MainCanvas';
import { Bot, Cpu, Sparkles, MessageSquare, Mic, Radar, ThumbsUp, Languages, Scan, Settings, ArrowRight } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function AISolutions() {
  const [query, setQuery] = useState('How can AI automate our e-commerce inventory forecasting?');
  const [analyzing, setAnalyzing] = useState(false);
  const [aiOutput, setAiOutput] = useState(null);

  const aiFeatures = [
    { title: "AI Chatbots & RAG", desc: "Custom LLM chatbots trained on your internal documentation delivering sub-second accurate responses.", icon: MessageSquare, color: "#2D8CFF" },
    { title: "AI Virtual Assistants", desc: "Intelligent workflow assistants automating scheduling, email triage, and customer support ticket resolution.", icon: Mic, color: "#6C5CE7" },
    { title: "Machine Learning", desc: "Supervised and unsupervised ML models engineered for classification, anomaly detection, and clustering.", icon: Cpu, color: "#F79300" },
    { title: "Predictive Analytics", desc: "Forecast demand trends, customer churn probability, inventory replenishment, and financial risks.", icon: Radar, color: "#06B6D4" },
    { title: "Recommendation Systems", desc: "Personalized product and content recommendation algorithms driving high cross-sell conversion rates.", icon: ThumbsUp, color: "#10B981" },
    { title: "Natural Language Processing", desc: "Entity extraction, sentiment analysis, document parsing, and automated multi-lingual translation.", icon: Languages, color: "#EC4899" },
    { title: "Computer Vision", desc: "Facial recognition, object detection, quality control image inspection, and OCR document scanning.", icon: Scan, color: "#3B82F6" },
    { title: "AI Automation Pipelines", desc: "End-to-end Robotic Process Automation (RPA) powered by intelligent decision-making logic.", icon: Settings, color: "#8B5CF6" },
    { title: "Generative AI Integration", desc: "Seamless OpenAI, Claude, Llama 3, and custom fine-tuned model API integrations into your existing web apps.", icon: Sparkles, color: "#F59E0B" }
  ];

  const pipeline = [
    { num: 1, title: "Data Ingestion", desc: "ETL & Normalization", color: "var(--orbit-orange)" },
    { num: 2, title: "Model Training", desc: "Fine-tuning & Evaluation", color: "var(--orbit-orange)" },
    { num: 3, title: "Intelligence Layer", desc: "API Inference Engine", color: "var(--ai-purple)" },
    { num: 4, title: "Automation", desc: "App Integration", color: "#10B981" },
    { num: 5, title: "Business Value", desc: "Efficiency & Revenue", color: "var(--electric-blue)" }
  ];

  const handleAnalyze = () => {
    setAnalyzing(true);
    setAiOutput(null);
    setTimeout(() => {
      setAnalyzing(false);
      setAiOutput({
        solution: "Implement a Time-Series LSTM model coupled with automated supplier REST API webhooks.",
        dataNeeded: "12 months historical order logs + SKU stock levels.",
        impact: "42% decrease in out-of-stock events, saving $120K annually in emergency freight."
      });
    }, 800);
  };

  return (
    <div style={{ position: 'relative', width: '100%', minHeight: '100vh', background: 'var(--bg-deep)' }}>
      <Navbar />
      <MainCanvas />

      <main className="content-wrapper" style={{ paddingTop: '140px', paddingBottom: '80px' }}>
        <div style={{ maxWidth: '1240px', margin: '0 auto', padding: '0 5%' }}>
          
          <div style={{ textAlign: 'center', marginBottom: '60px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>
              <Bot size={14} /> ARTIFICIAL INTELLIGENCE
            </div>
            <h1 className="section-title">
              Make Your Business <span className="gradient-text-orange">Smarter With AI</span>
            </h1>
            <p className="section-description" style={{ maxWidth: '750px', margin: '0 auto' }}>
              We develop and integrate AI-powered solutions that automate processes, uncover insights, and create intelligent digital experiences.
            </p>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))', gap: '24px', marginBottom: '80px' }}>
            {aiFeatures.map((f, idx) => {
              const IconComp = f.icon;
              return (
                <div key={idx} className="glass-panel" style={{ padding: '30px' }}>
                  <div style={{ width: '44px', height: '44px', borderRadius: '12px', background: 'rgba(255, 255, 255, 0.06)', display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '16px', border: '1px solid var(--border-glass)' }}>
                    <IconComp size={22} color={f.color} />
                  </div>
                  <h3 style={{ fontSize: '1.25rem', fontWeight: 700, color: 'var(--text-primary)', marginBottom: '10px' }}>{f.title}</h3>
                  <p style={{ color: 'var(--text-secondary)', fontSize: '0.92rem', lineHeight: 1.6 }}>{f.desc}</p>
                </div>
              );
            })}
          </div>

          <div style={{ textAlign: 'center', marginBottom: '40px' }}>
            <div className="section-badge" style={{ margin: '0 auto 16px auto' }}>ARCHITECTURE PIPELINE</div>
            <h2 style={{ fontSize: '2.2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '12px' }}>
              AI Deployment Workflow
            </h2>
            <p style={{ color: 'var(--text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
              How raw enterprise datasets transform into predictable commercial ROI.
            </p>
          </div>

          <div className="glass-panel" style={{ padding: '36px 24px', display: 'flex', justifyContent: 'space-around', alignItems: 'center', flexWrap: 'wrap', gap: '20px', marginBottom: '80px' }}>
            {pipeline.map((p, idx) => (
              <React.Fragment key={idx}>
                <div style={{ textAlign: 'center', minWidth: '130px' }}>
                  <div style={{ width: '48px', height: '48px', borderRadius: '50%', background: 'rgba(255, 255, 255, 0.08)', color: p.color, border: `2px solid ${p.color}`, display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 10px auto', fontWeight: 800, fontSize: '1.1rem' }}>
                    {p.num}
                  </div>
                  <h4 style={{ color: 'var(--text-primary)', fontSize: '1rem', fontWeight: 700 }}>{p.title}</h4>
                  <p style={{ fontSize: '0.8rem', color: 'var(--text-muted)' }}>{p.desc}</p>
                </div>
                {idx < pipeline.length - 1 && (
                  <ArrowRight size={20} color="var(--orbit-orange)" style={{ opacity: 0.7 }} />
                )}
              </React.Fragment>
            ))}
          </div>

          <div className="glass-panel" style={{ padding: '36px', marginBottom: '80px', border: '1px solid rgba(45, 140, 255, 0.3)' }}>
            <h3 style={{ fontSize: '1.4rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '10px', display: 'flex', alignItems: 'center', gap: '10px' }}>
              <Sparkles size={22} color="var(--electric-blue)" /> Orbitone AI Agent Sandbox
            </h3>
            <p style={{ color: 'var(--text-secondary)', fontSize: '0.95rem', marginBottom: '24px' }}>
              Test our instant AI workflow analysis engine below:
            </p>

            <div style={{ display: 'flex', gap: '12px', flexWrap: 'wrap', marginBottom: '20px' }}>
              <input
                type="text"
                className="form-input"
                style={{ flexGrow: 1, minWidth: '280px' }}
                value={query}
                onChange={(e) => setQuery(e.target.value)}
                placeholder="Ask AI: e.g. How can AI reduce customer support response time by 80%?"
              />
              <button onClick={handleAnalyze} className="btn-primary" style={{ padding: '12px 24px' }}>
                <Cpu size={18} /> Analyze
              </button>
            </div>

            <div style={{ background: 'var(--bg-surface-elevated)', border: '1px solid var(--border-glass)', borderRadius: '12px', padding: '20px', fontFamily: 'monospace', fontSize: '0.92rem', color: 'var(--text-primary)', minHeight: '100px' }}>
              {analyzing ? (
                <div style={{ color: 'var(--electric-blue)' }}>
                  [Processing via Orbitone LLM Node...] Running vector search and predictive forecasting calculation...
                </div>
              ) : aiOutput ? (
                <div>
                  <div style={{ color: 'var(--electric-blue)', fontWeight: 700, marginBottom: '8px' }}>[AI Recommendation Report Generated]</div>
                  <div style={{ marginBottom: '6px' }}>• <strong>Solution:</strong> {aiOutput.solution}</div>
                  <div style={{ marginBottom: '6px' }}>• <strong>Data Needed:</strong> {aiOutput.dataNeeded}</div>
                  <div>• <strong>Estimated Impact:</strong> {aiOutput.impact}</div>
                </div>
              ) : (
                <div style={{ color: 'var(--text-muted)' }}>
                  [System Ready] Click 'Analyze' to simulate Orbitone AI pipeline response...
                </div>
              )}
            </div>
          </div>

          <div className="glass-panel" style={{ padding: '48px 36px', textAlign: 'center', borderRadius: '24px', border: '1px solid rgba(247, 147, 0, 0.3)' }}>
            <h2 style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--text-primary)', marginBottom: '16px' }}>Ready to Integrate Custom AI Models into Your System?</h2>
            <p style={{ color: 'var(--text-secondary)', marginBottom: '28px', maxWidth: '600px', margin: '0 auto 28px auto' }}>
              We build production-ready machine learning pipelines and RAG chat assistants tailored for your data.
            </p>
            <Link to="/quote" className="btn-primary">
              REQUEST AI PROPOSAL <ArrowRight size={18} />
            </Link>
          </div>

        </div>
      </main>

      <Footer />
    </div>
  );
}
