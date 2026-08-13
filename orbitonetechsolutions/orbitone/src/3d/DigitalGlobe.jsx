import React, { useRef } from 'react';
import { useFrame } from '@react-three/fiber';
import * as THREE from 'three';

export default function DigitalGlobe({ scale = 1, position = [0, 0, 0] }) {
  const globeGroup = useRef();
  const wireframeRef = useRef();

  useFrame((state, delta) => {
    if (globeGroup.current) {
      globeGroup.current.rotation.y += delta * 0.2;
    }
    if (wireframeRef.current) {
      wireframeRef.current.rotation.y -= delta * 0.1;
    }
  });

  return (
    <group ref={globeGroup} position={position} scale={scale}>
      {/* Inner Globe Body */}
      <mesh>
        <sphereGeometry args={[2.2, 32, 32]} />
        <meshStandardMaterial
          color="#071936"
          roughness={0.2}
          metalness={0.8}
          emissive="#0B1F4D"
          emissiveIntensity={0.5}
        />
      </mesh>

      {/* Outer Network Grid */}
      <mesh ref={wireframeRef}>
        <sphereGeometry args={[2.25, 24, 24]} />
        <meshBasicMaterial
          color="#2D8CFF"
          wireframe
          transparent
          opacity={0.3}
        />
      </mesh>

      {/* Equatorial Orbit Ring */}
      <mesh rotation={[Math.PI / 3, 0, 0]}>
        <torusGeometry args={[3.2, 0.03, 16, 100]} />
        <meshBasicMaterial color="#F79300" transparent opacity={0.8} />
      </mesh>

      <mesh rotation={[-Math.PI / 4, Math.PI / 6, 0]}>
        <torusGeometry args={[3.5, 0.02, 16, 100]} />
        <meshBasicMaterial color="#2D8CFF" transparent opacity={0.6} />
      </mesh>

      {/* Atmospheric Glow Halo */}
      <mesh>
        <sphereGeometry args={[2.4, 32, 32]} />
        <meshBasicMaterial
          color="#2D8CFF"
          transparent
          opacity={0.15}
          side={THREE.BackSide}
          blending={THREE.AdditiveBlending}
        />
      </mesh>
    </group>
  );
}
