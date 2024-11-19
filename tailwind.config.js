/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['*/*.{html,js,php}'],
  theme: {
    extend: {
      colors: {
        primary: '#3B82F6',
        secondary: '#1E40AF',
        accent: '#F59E0B',
        light: '#ECF0F1',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
