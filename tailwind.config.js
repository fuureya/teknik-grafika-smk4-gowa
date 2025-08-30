/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}", // biar Tailwind scan semua file
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
