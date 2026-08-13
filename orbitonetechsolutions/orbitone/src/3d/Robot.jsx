import React, { useRef } from 'react';
import { useFrame } from '@react-three/fiber';
import * as THREE from 'three';

export default function Robot({ position = [0, 0, 0], scale = 1 }) {
  const robotGroup = useRef();
  const leftArmRef = useRef();

  useFrame((state) => {
    if (robotGroup.current) {
      const t = state.clock.getElapsedTime();
      // Floating motion
      robotGroup.current.position.y = position[1] + Math.sin(t * 1.8) * 0.12;
      robotGroup.current.rotation.y = Math.sin(t * 0.9) * 0.12;
    }
  });

  return (
    <group ref={robotGroup} position={position} scale={scale}>
      {/* Robot Head */}
      <group position={[0, 1.35, 0]}>
        {/* White Glossy Outer Head */}
        <mesh>
          <sphereGeometry args={[0.7, 32, 32]} />
          <meshStandardMaterial
            color="#FFFFFF"
            roughness={0.1}
            metalness={0.8}
            envMapIntensity={1}
          />
        </mesh>

        {/* Black Glass Visor */}
        <mesh position={[0, 0.05, 0.46]} rotation={[0.08, 0, 0]}>
          <boxGeometry args={[0.85, 0.38, 0.3]} />
          <meshStandardMaterial
            color="#040F24"
            roughness={0.05}
            metalness={0.9}
          />
        </mesh>

        {/* Glowing Blue Eyes */}
        <mesh position={[-0.22, 0.07, 0.62]}>
          <capsuleGeometry args={[0.07, 0.12, 16, 16]} rotation={[0, 0, Math.PI / 2]} />
          <meshStandardMaterial
            color="#00F0FF"
            emissive="#00F0FF"
            emissiveIntensity={2.5}
          />
        </mesh>
        <mesh position={[0.22, 0.07, 0.62]}>
          <capsuleGeometry args={[0.07, 0.12, 16, 16]} rotation={[0, 0, Math.PI / 2]} />
          <meshStandardMaterial
            color="#00F0FF"
            emissive="#00F0FF"
            emissiveIntensity={2.5}
          />
        </mesh>

        {/* Side Ear Headphones with Orange Accent Rings */}
        <group position={[-0.72, 0, 0]} rotation={[0, 0, Math.PI / 2]}>
          <cylinderGeometry args={[0.16, 0.16, 0.15, 32]} />
          <meshStandardMaterial color="#071936" metalness={0.9} />
          <mesh position={[0, 0.08, 0]}>
            <torusGeometry args={[0.15, 0.03, 16, 32]} />
            <meshStandardMaterial color="#F79300" emissive="#F79300" emissiveIntensity={1.5} />
          </mesh>
        </group>
        <group position={[0.72, 0, 0]} rotation={[0, 0, -Math.PI / 2]}>
          <cylinderGeometry args={[0.16, 0.16, 0.15, 32]} />
          <meshStandardMaterial color="#071936" metalness={0.9} />
          <mesh position={[0, 0.08, 0]}>
            <torusGeometry args={[0.15, 0.03, 16, 32]} />
            <meshStandardMaterial color="#F79300" emissive="#F79300" emissiveIntensity={1.5} />
          </mesh>
        </group>
      </group>

      {/* Neck Joint */}
      <mesh position={[0, 0.75, 0]}>
        <cylinderGeometry args={[0.25, 0.28, 0.25, 32]} />
        <meshStandardMaterial color="#071936" metalness={0.9} roughness={0.2} />
      </mesh>

      {/* Torso Body */}
      <group position={[0, 0, 0]}>
        {/* Main Body Armor */}
        <mesh>
          <cylinderGeometry args={[0.68, 0.48, 1.25, 32]} />
          <meshStandardMaterial color="#FFFFFF" roughness={0.12} metalness={0.8} />
        </mesh>

        {/* Chest Plate Detail */}
        <mesh position={[0, 0.15, 0.52]}>
          <boxGeometry args={[0.55, 0.45, 0.1]} />
          <meshStandardMaterial color="#071936" metalness={0.8} />
        </mesh>

        {/* Orange Orbitone Emblem Core */}
        <mesh position={[0, 0.15, 0.58]} rotation={[Math.PI / 2, 0, 0]}>
          <cylinderGeometry args={[0.15, 0.15, 0.04, 32]} />
          <meshStandardMaterial color="#F79300" emissive="#F79300" emissiveIntensity={1.8} />
        </mesh>
      </group>

      {/* Left Arm Pointing Left/Up toward Tech Elements */}
      <group position={[-0.75, 0.3, 0]} rotation={[0, 0, 0.6]}>
        <mesh position={[-0.3, -0.2, 0]} rotation={[0, 0, 0.4]}>
          <capsuleGeometry args={[0.14, 0.6, 16, 16]} />
          <meshStandardMaterial color="#FFFFFF" metalness={0.85} roughness={0.15} />
        </mesh>
        {/* Hand */}
        <mesh position={[-0.6, -0.4, 0.1]}>
          <sphereGeometry args={[0.12, 16, 16]} />
          <meshStandardMaterial color="#071936" metalness={0.9} />
        </mesh>
      </group>

      {/* Right Arm Holding Tech Tablet */}
      <group position={[0.75, 0.3, 0]} rotation={[0, 0, -0.3]}>
        <mesh position={[0.2, -0.3, 0.2]} rotation={[0.4, 0, -0.2]}>
          <capsuleGeometry args={[0.14, 0.6, 16, 16]} />
          <meshStandardMaterial color="#FFFFFF" metalness={0.85} roughness={0.15} />
        </mesh>
        {/* Laptop Tablet held in hand */}
        <group position={[0.35, -0.5, 0.4]} rotation={[-0.3, 0.4, 0.2]}>
          <mesh>
            <boxGeometry args={[0.6, 0.45, 0.05]} />
            <meshStandardMaterial color="#071936" metalness={0.9} />
          </mesh>
          <mesh position={[0, 0, 0.03]}>
            <planeGeometry args={[0.54, 0.38]} />
            <meshStandardMaterial color="#2D8CFF" emissive="#2D8CFF" emissiveIntensity={1.2} />
          </mesh>
        </group>
      </group>

      {/* Multi-Ring Base Pedestal Platform beneath Robot */}
      <group position={[0, -0.9, 0]}>
        <mesh rotation={[Math.PI / 2, 0, 0]}>
          <cylinderGeometry args={[1.2, 1.4, 0.15, 32]} />
          <meshStandardMaterial color="#071936" roughness={0.2} metalness={0.8} />
        </mesh>

        <mesh position={[0, 0.08, 0]} rotation={[Math.PI / 2, 0, 0]}>
          <torusGeometry args={[1.25, 0.04, 16, 64]} />
          <meshStandardMaterial color="#2D8CFF" emissive="#2D8CFF" emissiveIntensity={2} />
        </mesh>

        <mesh position={[0, 0.14, 0]} rotation={[Math.PI / 2, 0, 0]}>
          <torusGeometry args={[0.95, 0.03, 16, 64]} />
          <meshStandardMaterial color="#F79300" emissive="#F79300" emissiveIntensity={2} />
        </mesh>
      </group>
    </group>
  );
}
