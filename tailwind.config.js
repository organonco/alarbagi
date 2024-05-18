/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./packages/Organon/Delivery/**/*.blade.php",
      "./packages/Organon/Delivery/**/*.js",
      "./packages/Organon/Delivery/**/*.vue",
      "./node_modules/flowbite/**/*.js"
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: {"50":"#fff1f2","100":"#ffe4e6","200":"#fecdd3","300":"#fda4af","400":"#fb7185","500":"#f43f5e","600":"#e11d48","700":"#be123c","800":"#9f1239","900":"#881337","950":"#4c0519"}
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

