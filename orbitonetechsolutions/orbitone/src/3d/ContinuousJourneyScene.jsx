import React from 'react';
import ParticleField from './ParticleField';

export default function ContinuousJourneyScene() {
  return (
    <group>
      {/* Ambient & Directional Lighting */}
      <ambientLight intensity={0.9} />
      <directionalLight position={[10, 10, 10]} intensity={1.8} color="#FFFFFF" />
      <directionalLight position={[-10, -10, -5]} intensity={1.0} color="#2D8CFF" />
      <pointLight position={[0, 0, 5]} intensity={2.5} color="#F79300" />

      {/* Global Ambient Particle Universe */}
      <ParticleField count={1400} />
    </group>
  );
}
