/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./admin/**/*.php",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      fontFamily: {
        'plusJakartaSans': ['Plus Jakarta Sans', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

