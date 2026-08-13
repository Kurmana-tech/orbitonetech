import React, { useRef } from 'react';
import { useFrame } from '@react-three/fiber';
import { Html } from '@react-three/drei';
const dashboardImg = '/assets/dashboard-clean-transparent.png';

export default function Dashboard3D({ position = [0, 0, 0], scale = 1 }) {
  const groupRef = useRef();

  useFrame((state, delta) => {
    if (groupRef.current) {
      groupRef.current.rotation.y = Math.sin(state.clock.elapsedTime * 0.8) * 0.08;
      groupRef.current.position.y = position[1] + Math.sin(state.clock.elapsedTime * 1.5) * 0.12;
    }
  });

  return (
    <group ref={groupRef} position={position} scale={scale}>
      {/* 3D Floating Dashboard Artwork Container */}
      <Html
        transform
        distanceFactor={5.2}
        position={[0, 0, 0]}
        style={{
          width: '720px',
          display: 'flex',
          justifyContent: 'center',
          alignItems: 'center',
          pointerEvents: 'none'
        }}
      >
        <div
          style={{
            position: 'relative',
            width: '100%',
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center'
          }}
        >
          {/* Ambient Blue Analytics Stage Glow */}
          <div
            style={{
              position: 'absolute',
              bottom: '0%',
              left: '50%',
              transform: 'translateX(-50%)',
              width: '85%',
              height: '68%',
              background: 'radial-gradient(ellipse at center, rgba(45, 140, 255, 0.45) 0%, rgba(108, 92, 231, 0.22) 50%, rgba(6, 20, 47, 0) 75%)',
              borderRadius: '50%',
              filter: 'blur(45px)',
              pointerEvents: 'none'
            }}
          />

          {/* High-Res Transparent Artwork */}
          <img
            src={dashboardImg}
            alt="Orbitone Data Analytics Dashboard Engine"
            style={{
              width: '100%',
              height: 'auto',
              display: 'block',
              objectFit: 'contain',
              filter: 'drop-shadow(0 18px 38px rgba(45, 140, 255, 0.4))'
            }}
          />
        </div>
      </Html>
    </group>
  );
}
