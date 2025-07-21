/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/views/**/*.view.php",
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

