import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// Base path is a build parameter: '/' for a custom domain, '/EuropianUnion/' for GitHub Pages.
export default defineConfig({
  base: process.env.VITE_BASE || '/',
  plugins: [react()],
})
