import React from 'react';
import { HashRouter as Router, Routes, Route } from 'react-router-dom';
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

export default function App() {
  return (
    <ThemeProvider>
      <Router>
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

