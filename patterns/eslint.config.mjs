import js from "@eslint/js";
import globals from "globals";
import json from "@eslint/json";
import { defineConfig } from "eslint/config";

export default defineConfig([
  { 
    files: ["assets/js/**/*.{js,mjs,cjs}"], 
    plugins: { js }, 
    extends: ["js/recommended"], 
    languageOptions: { globals: globals.browser },
    rules: {
			"no-unused-vars": "warn",
      "complexity": ["warn", { "max": 2 }],
      "no-extra-boolean-cast": "warn",
      "no-useless-assignment": "warn",
      "no-undef": "warn",
      "no-empty": "warn",
      "no-prototype-builtins": "warn",
		},
  },
  { files: ["assets/js/**/*.js"], languageOptions: { sourceType: "commonjs" } },
  { files: ["source/_patterns/**/*.json"], plugins: { json }, language: "json/json", extends: ["json/recommended"] },
]);
