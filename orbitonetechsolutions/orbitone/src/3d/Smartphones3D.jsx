import React, { useRef } from 'react';
import { useFrame } from '@react-three/fiber';
import { Html } from '@react-three/drei';
const smartphoneImg = '/assets/smartphone-clean-transparent.png';

export default function Smartphones3D({ position = [0, 0, 0], scale = 1 }) {
  const groupRef = useRef();

  useFrame((state, delta) => {
    if (groupRef.current) {
      groupRef.current.rotation.y = Math.sin(state.clock.elapsedTime * 0.8) * 0.08;
      groupRef.current.position.y = position[1] + Math.sin(state.clock.elapsedTime * 1.5) * 0.12;
    }
  });

  return (
    <group ref={groupRef} position={position} scale={scale}>
      {/* 3D Floating Dual Smartphones Artwork Container */}
      <Html
        transform
        distanceFactor={5.2}
        position={[0, 0, 0]}
        style={{
          width: '680px',
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
          {/* Ambient Stage Glow */}
          <div
            style={{
              position: 'absolute',
              bottom: '0%',
              left: '50%',
              transform: 'translateX(-50%)',
              width: '85%',
              height: '68%',
              background: 'radial-gradient(ellipse at center, rgba(45, 140, 255, 0.42) 0%, rgba(16, 185, 129, 0.22) 50%, rgba(6, 20, 47, 0) 75%)',
              borderRadius: '50%',
              filter: 'blur(45px)',
              pointerEvents: 'none'
            }}
          />

          {/* High-Res Transparent Artwork */}
          <img
            src={smartphoneImg}
            alt="Orbitone Application Development iOS and Android Engine"
            style={{
              width: '100%',
              height: 'auto',
              display: 'block',
              objectFit: 'contain',
              filter: 'drop-shadow(0 18px 38px rgba(45, 140, 255, 0.38))'
            }}
          />
        </div>
      </Html>
    </group>
  );
}
