/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/**/*.view.php",
    "./public/**/*.html",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

