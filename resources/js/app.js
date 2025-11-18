// Import CSS so Vite bundles it / provides HMR
import '../css/app.css';

import './bootstrap';

// small client interactions
console.log('Vite: resources/js/app.js loaded');

const mobileToggle = document.getElementById('mobileMenuToggle');
const mobileNav = document.getElementById('mobileNav');
if (mobileToggle && mobileNav) {
  mobileToggle.addEventListener('click', () => {
    mobileNav.classList.toggle('hidden');
  });
}

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function () {
  const btn = document.getElementById('mobileMenuToggle');
  const mobileNav = document.getElementById('mobileNav');
  if (btn && mobileNav) {
    btn.addEventListener('click', () => {
      mobileNav.classList.toggle('hidden');
    });
  }
});