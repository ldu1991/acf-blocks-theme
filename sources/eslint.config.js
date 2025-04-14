import {defineConfig} from "eslint/config";
import js from "@eslint/js";
import globals from "globals";


export default defineConfig([
    {
        files: ['js/**/*.{js,mjs,cjs}', 'blocks/**/*.{js,mjs,cjs}'],
        ignores: ['blocks/__example/**'],
        ...js.configs.recommended,
        languageOptions: {
            globals: globals.browser
        },
        rules: {
            ...js.configs.recommended.rules,
            //semi: ['error', 'always'],
            //quotes: ['error', 'single'],
        },
    }
]);
