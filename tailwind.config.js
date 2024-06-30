import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.jsx",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                comic: ["Comic Neue", "sans-serif"],
            },
            screens: {
                mobile: "370px", // Custom mobile breakpoint
                tablet: "768px", // Custom tablet breakpoint
                desktop: "1024px", // Custom desktop breakpoint
            },
        },
    },

    plugins: [forms],
    // require('@tailwindcss/forms'),
};
