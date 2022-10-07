const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    purge: [
        // prettier-ignore
        './src/App/Resources/**/*.blade.php',
        './src/App/Resources/**/*.js',
        './src/App/Resources/**/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {
        extend: {
            fill: ['focus', 'group-hover'],
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
