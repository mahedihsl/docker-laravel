module.exports = {
    mode: "jit",
    content: ["**/*.blade.php", "**/*.vue"],
    darkMode: "media", // or 'class'
    corePlugins: {
        preflight: false,
    },
    prefix: "tw-",
    important: true,
    theme: {
        extend: {
            boxShadow: {
                DEFAULT: "0 0 20px rgb(0 0 0 / 12%)",
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
};
