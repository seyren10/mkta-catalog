/** @type {import('tailwindcss').Config} */
import defaultTheme from "tailwindcss/defaultTheme";

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: "1rem",
                sm: "2rem",
                lg: "4rem",
                xl: "5rem",
                "2xl": "6rem",
            },
        },
        fontFamily: {
            sans: ['"Poppins"', ...defaultTheme.fontFamily.sans],
            serif: ["Teko", ...defaultTheme.fontFamily.serif],
        },
        extend: {
            colors: {
                // primary: "#334155",
                primary: "#04151f",
                // primary: "#083344",
                // accent: '#3b82f6' //blue
                accent: "#ae9a64", //gold
            },
            animation: {
                appear: "appear 800ms ease-out both",
                wiggle: "wiggle 1s ease-in-out infinite",
                "spin-slow": "spin 1.5s linear infinite",
            },
            keyframes: {
                appear: {
                    "0%": { transform: "translateY(5rem)", opacity: 0 },
                    "100%": { transform: "translateY(0)", opacity: 1 },
                },
                wiggle: {
                    "0%, 100%": { transform: "rotate(-3deg)" },
                    "50%": { transform: "rotate(3deg)" },
                },
            },
            backgroundImage: {
                "hero-background": "url('/mk-images/hero-background.jpg')",
            },
            fontSize: {
                head: "min(4vw + .5rem, 2rem)",
            },
        },
    },
    plugins: [],
};
