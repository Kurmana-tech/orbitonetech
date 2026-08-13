/* Orbitone Tech Solutions - Hero Canvas Orbital Visualizer (Brand Logo Aligned) */

document.addEventListener('DOMContentLoaded', () => {
  const canvas = document.getElementById('heroCanvas');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width, height;
  let animationFrameId;

  // Nodes & Orbital Particles matching Logo (Gold + Amber + Navy)
  const nodes = [];
  const particleCount = 48;
  const orbitRings = [120, 220, 320, 420];
  let angleOffset = 0;

  let mouse = { x: null, y: null, targetX: null, targetY: null };

  function resize() {
    width = canvas.width = canvas.parentElement.offsetWidth;
    height = canvas.height = canvas.parentElement.offsetHeight;
    initNodes();
  }

  function initNodes() {
    nodes.length = 0;
    for (let i = 0; i < particleCount; i++) {
      nodes.push({
        x: Math.random() * width,
        y: Math.random() * height,
        vx: (Math.random() - 0.5) * 0.6,
        vy: (Math.random() - 0.5) * 0.6,
        radius: Math.random() * 2.5 + 1.5,
        pulse: Math.random() * Math.PI,
        color: i % 3 === 0 ? '#f59e0b' : (i % 3 === 1 ? '#d97706' : '#fbbf24')
      });
    }
  }

  window.addEventListener('resize', resize);
  resize();

  window.addEventListener('mousemove', (e) => {
    const rect = canvas.getBoundingClientRect();
    mouse.targetX = e.clientX - rect.left;
    mouse.targetY = e.clientY - rect.top;
  });

  function drawOrbitals(centerX, centerY) {
    angleOffset += 0.002;

    orbitRings.forEach((radius, idx) => {
      ctx.save();
      ctx.beginPath();
      ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
      ctx.strokeStyle = idx % 2 === 0 ? 'rgba(245, 158, 11, 0.15)' : 'rgba(30, 62, 98, 0.25)';
      ctx.lineWidth = 1.5;
      ctx.setLineDash([10, 14]);
      ctx.stroke();

      // Rotating satellite node on ring (Matching upper right dot on logo swoosh)
      const satelliteAngle = angleOffset * (idx % 2 === 0 ? 1 : -1.2) + (idx * Math.PI / 2);
      const satX = centerX + Math.cos(satelliteAngle) * radius;
      const satY = centerY + Math.sin(satelliteAngle) * radius;

      // Glow effect for orbital golden node
      ctx.beginPath();
      ctx.arc(satX, satY, 4.5, 0, Math.PI * 2);
      ctx.fillStyle = idx % 2 === 0 ? '#f59e0b' : '#fbbf24';
      ctx.shadowColor = '#f59e0b';
      ctx.shadowBlur = 14;
      ctx.fill();

      // Connecting beam from center to satellite
      ctx.beginPath();
      ctx.moveTo(centerX, centerY);
      ctx.lineTo(satX, satY);
      ctx.strokeStyle = 'rgba(245, 158, 11, 0.06)';
      ctx.setLineDash([]);
      ctx.stroke();

      ctx.restore();
    });
  }

  function render() {
    ctx.clearRect(0, 0, width, height);

    if (mouse.targetX !== null) {
      mouse.x += (mouse.targetX - mouse.x) * 0.05;
      mouse.y += (mouse.targetY - mouse.y) * 0.05;
    }

    const centerX = width * 0.7;
    const centerY = height * 0.5;

    // Draw central orbital system
    drawOrbitals(centerX, centerY);

    // Update & draw dynamic golden network nodes
    for (let i = 0; i < nodes.length; i++) {
      const p = nodes[i];
      p.x += p.vx;
      p.y += p.vy;

      if (p.x < 0 || p.x > width) p.vx *= -1;
      if (p.y < 0 || p.y > height) p.vy *= -1;

      p.pulse += 0.03;
      const currentRadius = p.radius + Math.sin(p.pulse) * 0.8;

      ctx.save();
      ctx.beginPath();
      ctx.arc(p.x, p.y, currentRadius, 0, Math.PI * 2);
      ctx.fillStyle = p.color;
      ctx.shadowColor = p.color;
      ctx.shadowBlur = 8;
      ctx.fill();
      ctx.restore();

      // Connect nodes in proximity
      for (let j = i + 1; j < nodes.length; j++) {
        const p2 = nodes[j];
        const dx = p.x - p2.x;
        const dy = p.y - p2.y;
        const dist = Math.sqrt(dx * dx + dy * dy);

        if (dist < 130) {
          ctx.beginPath();
          ctx.moveTo(p.x, p.y);
          ctx.lineTo(p2.x, p2.y);
          ctx.strokeStyle = `rgba(245, 158, 11, ${1 - dist / 130 * 0.85})`;
          ctx.lineWidth = 0.8;
          ctx.stroke();
        }
      }

      // Connect to mouse cursor
      if (mouse.x !== null) {
        const dx = p.x - mouse.x;
        const dy = p.y - mouse.y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < 160) {
          ctx.beginPath();
          ctx.moveTo(p.x, p.y);
          ctx.lineTo(mouse.x, mouse.y);
          ctx.strokeStyle = `rgba(251, 191, 36, ${1 - dist / 160 * 0.9})`;
          ctx.lineWidth = 1;
          ctx.stroke();
        }
      }
    }

    animationFrameId = requestAnimationFrame(render);
  }

  render();
});
