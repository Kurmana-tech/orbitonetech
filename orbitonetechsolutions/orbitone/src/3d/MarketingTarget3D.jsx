import React, { useRef } from 'react';
import { useFrame } from '@react-three/fiber';
import { Html } from '@react-three/drei';
const marketingImg = '/assets/marketing-clean-transparent.png';

export default function MarketingTarget3D({ position = [0, 0, 0], scale = 1 }) {
  const groupRef = useRef();

  useFrame((state, delta) => {
    if (groupRef.current) {
      groupRef.current.rotation.y = Math.sin(state.clock.elapsedTime * 0.8) * 0.08;
      groupRef.current.position.y = position[1] + Math.sin(state.clock.elapsedTime * 1.5) * 0.12;
    }
  });

  return (
    <group ref={groupRef} position={position} scale={scale}>
      {/* 3D Floating Marketing Target Artwork Container */}
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
          {/* Ambient Orange/Blue Marketing Stage Glow */}
          <div
            style={{
              position: 'absolute',
              bottom: '0%',
              left: '50%',
              transform: 'translateX(-50%)',
              width: '85%',
              height: '68%',
              background: 'radial-gradient(ellipse at center, rgba(247, 147, 0, 0.45) 0%, rgba(45, 140, 255, 0.25) 50%, rgba(6, 20, 47, 0) 75%)',
              borderRadius: '50%',
              filter: 'blur(45px)',
              pointerEvents: 'none'
            }}
          />

          {/* High-Res Transparent Artwork */}
          <img
            src={marketingImg}
            alt="Orbitone Marketing Analytics Target Engine"
            style={{
              width: '100%',
              height: 'auto',
              display: 'block',
              objectFit: 'contain',
              filter: 'drop-shadow(0 18px 38px rgba(247, 147, 0, 0.4))'
            }}
          />
        </div>
      </Html>
    </group>
  );
}
