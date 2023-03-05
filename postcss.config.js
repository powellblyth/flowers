const defaultTheme = require("tailwindcss/defaultTheme")
module.exports = {
    plugins: {
        'postcss-import': {},
        tailwindcss: {
            content: [
                "./resources/**/*.blade.php",
                "./resources/**/*.js",
                "./resources/**/*.vue",
                './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
                './storage/framework/views/*.php',
            ],

            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                    },
                },
            },

            plugins: [
                require('@tailwindcss/forms')
            ],
        },
        autoprefixer: {},
    },
}
