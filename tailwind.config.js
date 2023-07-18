/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/**/*.{html,js,twig}"],
    theme: {
      extend: {},
    },
    plugins: [
        require("@tailwindcss/forms"),
    ],
  }
