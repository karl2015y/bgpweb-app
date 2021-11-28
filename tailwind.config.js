module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        gray: {
          350: '#ADADAE',
          550: '#5B5B5B',
        },
        'brown': '#5D4537',
      }
    },
  },
  variants: {
    width: ["responsive", "hover", "focus"],
    height: ["responsive", "hover", "focus"],
    extend: {},
  },
  plugins: [],
}
