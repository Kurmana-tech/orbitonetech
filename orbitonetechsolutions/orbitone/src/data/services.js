const laptopImg = '/assets/laptop-clean-transparent.png';
const smartphoneImg = '/assets/smartphone-clean-transparent.png';
const neuralBrainImg = '/assets/neuralbrain-clean-transparent.png';
const dashboardImg = '/assets/dashboard-clean-transparent.png';
const marketingImg = '/assets/marketing-clean-transparent.png';
const megaphoneImg = '/assets/megaphone-clean-transparent.png';

export const SERVICES_DATA = [
  {
    id: "web-development",
    sectionNumber: "02",
    title: "Web Development",
    tagline: "High-Performance Digital Experiences",
    description: "We build fast, secure and scalable web solutions tailored to your business needs.",
    imageSrc: laptopImg,
    glowColor: "rgba(45, 140, 255, 0.45)",
    features: [
      "Responsive Websites",
      "Web Applications",
      "E-Commerce Solutions",
      "CMS Development",
      "API Integration",
      "Performance Optimization"
    ],
    techBadges: ["HTML5", "CSS3", "JavaScript", "React", "Node.js", "PHP"],
    ctaText: "Explore Web Development",
    ctaLink: "/services#web-development"
  },
  {
    id: "application-development",
    sectionNumber: "03",
    title: "Application Development",
    tagline: "Mobile Excellence & Cross-Platform Speed",
    description: "Custom mobile and cross-platform applications that drive engagement and accelerate growth.",
    imageSrc: smartphoneImg,
    glowColor: "rgba(16, 185, 129, 0.45)",
    features: [
      "iOS Development",
      "Android Development",
      "Cross Platform Apps",
      "UI/UX Design",
      "API Integration"
    ],
    techBadges: ["Swift (iOS)", "Kotlin (Android)", "React Native", "Flutter", "REST APIs"],
    ctaText: "Explore Application Development",
    ctaLink: "/services#application-development"
  },
  {
    id: "ai-machine-learning",
    sectionNumber: "04",
    title: "AI & Machine Learning",
    tagline: "Intelligent Automation & Neural Systems",
    description: "Smart AI solutions to automate processes, predict outcomes and enable intelligent decisions.",
    imageSrc: neuralBrainImg,
    glowColor: "rgba(108, 92, 231, 0.5)",
    features: [
      "Predictive Analytics",
      "NLP Solutions",
      "Computer Vision",
      "AI Model Development",
      "Intelligent Automation"
    ],
    techBadges: ["TensorFlow", "PyTorch", "OpenAI APIs", "Neural Networks", "LLM Integration"],
    ctaText: "Explore AI Solutions",
    ctaLink: "/services#ai-machine-learning"
  },
  {
    id: "data-analytics",
    sectionNumber: "05",
    title: "Data Analytics",
    tagline: "Actionable Insights & Big Data Intelligence",
    description: "Turn your data into actionable insights using advanced analytics and visualization.",
    imageSrc: dashboardImg,
    glowColor: "rgba(45, 140, 255, 0.45)",
    features: [
      "Data Visualization",
      "Business Intelligence",
      "Reporting & Dashboards",
      "Big Data Analytics",
      "Predictive Analytics"
    ],
    metrics: [
      { label: "Total Users", value: "24,578", change: "+12.5%" },
      { label: "Sessions", value: "63,248", change: "+18.7%" },
      { label: "Conversion Rate", value: "8.42%", change: "+6.3%" }
    ],
    ctaText: "Explore Data Analytics",
    ctaLink: "/services#data-analytics"
  },
  {
    id: "marketing-analytics",
    sectionNumber: "06",
    title: "Marketing Analytics",
    tagline: "ROI Optimization & Conversion Precision",
    description: "Measure, optimize and maximize your marketing performance with data-driven strategies.",
    imageSrc: marketingImg,
    glowColor: "rgba(247, 147, 0, 0.5)",
    features: [
      "Campaign Tracking",
      "ROI Measurement",
      "Customer Insights",
      "Performance Optimization"
    ],
    metrics: [
      { label: "ROI Boost", value: "+215%", highlight: true },
      { label: "Conversion", value: "3.67%", highlight: false },
      { label: "Revenue", value: "$48,750", highlight: true }
    ],
    ctaText: "Explore Marketing Analytics",
    ctaLink: "/services#marketing-analytics"
  },
  {
    id: "digital-marketing",
    sectionNumber: "07",
    title: "Digital Marketing",
    tagline: "Omnichannel Growth & Audience Acquisition",
    description: "Grow your brand, reach the right audience and achieve measurable results.",
    imageSrc: megaphoneImg,
    glowColor: "rgba(247, 147, 0, 0.5)",
    imageMaxWidth: "880px",
    features: [
      "SEO (Search Engine Optimization)",
      "SEM (Search Engine Marketing)",
      "Social Media Marketing",
      "Content Marketing",
      "Campaign Management"
    ],
    metrics: [
      { label: "Organic Traffic", value: "+156%" },
      { label: "Engagement", value: "+82%" },
      { label: "Conversions", value: "+47%" }
    ],
    ctaText: "Explore Digital Marketing",
    ctaLink: "/services#digital-marketing"
  }
];

export const COMPANY_INFO = {
  name: "Orbitone Tech Solutions",
  tagline: "Innovate. Integrate. Elevate Your Business.",
  email: "info@orbitonetech.com",
  phone: "+1 (800) 555-ORBIT",
  address: "Innovation Tower, Suite 1200, Silicon Hub, Tech City",
  socials: {
    linkedin: "https://linkedin.com",
    twitter: "https://twitter.com",
    facebook: "https://facebook.com",
    instagram: "https://instagram.com"
  }
};
