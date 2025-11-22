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

// === Header behavior: mobile search toggle + sticky shadow ===
// Append this to resources/js/app.js (or create file if not present)
document.addEventListener('DOMContentLoaded', function () {
  // Toggle mobile search bar
  const mobileSearchToggle = document.getElementById('mobileSearchToggle');
  const mobileSearchBar = document.getElementById('mobileSearchBar');
  if (mobileSearchToggle && mobileSearchBar) {
    mobileSearchToggle.addEventListener('click', function (e) {
      e.preventDefault();
      mobileSearchBar.classList.toggle('d-none');
      mobileSearchBar.classList.toggle('d-block');
      // focus input when shown
      const input = mobileSearchBar.querySelector('input[name="q"]');
      if (input && mobileSearchBar.classList.contains('d-block')) {
        setTimeout(() => input.focus(), 80);
      }
    });
  }

  // Add subtle shadow when scrolled
  const header = document.querySelector('.site-header');
  if (header) {
    const onScroll = () => {
      if (window.scrollY > 8) header.classList.add('is-stuck');
      else header.classList.remove('is-stuck');
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }
});