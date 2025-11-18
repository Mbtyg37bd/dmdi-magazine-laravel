module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        display: ['Playfair Display', 'serif'],
      },
      colors: {
        accent: '#c9a961',
      },
      maxWidth: {
        article: '1100px',
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
};