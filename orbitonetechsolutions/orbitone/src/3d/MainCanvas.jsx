import React, { Suspense } from 'react';
import { Canvas } from '@react-three/fiber';
import ContinuousJourneyScene from './ContinuousJourneyScene';

export default function MainCanvas() {
  return (
    <div id="canvas-container">
      <Canvas
        camera={{ position: [0, 0, 7], fov: 50 }}
        gl={{ antialias: true, alpha: true }}
        style={{ width: '100vw', height: '100vh' }}
      >
        <Suspense fallback={null}>
          <ContinuousJourneyScene />
        </Suspense>
      </Canvas>
    </div>
  );
}
