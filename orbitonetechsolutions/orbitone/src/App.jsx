import React, { useEffect } from 'react';
import { HashRouter as Router, Routes, Route, useLocation } from 'react-router-dom';
import { ThemeProvider } from './context/ThemeContext';
import Home from './pages/Home';
import About from './pages/About';
import Services from './pages/Services';
import WebDevelopment from './pages/WebDevelopment';
import AppDevelopment from './pages/AppDevelopment';
import AISolutions from './pages/AISolutions';
import DataAnalytics from './pages/DataAnalytics';
import MarketingAnalytics from './pages/MarketingAnalytics';
import DigitalMarketing from './pages/DigitalMarketing';
import Industries from './pages/Industries';
import Process from './pages/Process';
import Projects from './pages/Projects';
import Careers from './pages/Careers';
import Quote from './pages/Quote';
import Blog from './pages/Blog';
import Contact from './pages/Contact';

function ScrollToTop() {
  const { pathname, hash } = useLocation();

  useEffect(() => {
    if (hash) {
      const id = hash.replace('#', '');
      const element = document.getElementById(id);
      if (element) {
        const yOffset = -96; // Offset for fixed header height
        const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;
        window.scrollTo({ top: y, behavior: 'smooth' });
        return;
      }
    }
    window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
  }, [pathname, hash]);

  return null;
}

export default function App() {
  return (
    <ThemeProvider>
      <Router>
        <ScrollToTop />
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/about" element={<About />} />
          <Route path="/services" element={<Services />} />
          <Route path="/web-development" element={<WebDevelopment />} />
          <Route path="/app-development" element={<AppDevelopment />} />
          <Route path="/ai-solutions" element={<AISolutions />} />
          <Route path="/data-analytics" element={<DataAnalytics />} />
          <Route path="/marketing-analytics" element={<MarketingAnalytics />} />
          <Route path="/digital-marketing" element={<DigitalMarketing />} />
          <Route path="/industries" element={<Industries />} />
          <Route path="/process" element={<Process />} />
          <Route path="/projects" element={<Projects />} />
          <Route path="/careers" element={<Careers />} />
          <Route path="/quote" element={<Quote />} />
          <Route path="/blog" element={<Blog />} />
          <Route path="/contact" element={<Contact />} />
        </Routes>
      </Router>
    </ThemeProvider>
  );
}

