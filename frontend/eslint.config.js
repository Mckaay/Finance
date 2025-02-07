import pluginVue from "eslint-plugin-vue";
import unusedImports from "eslint-plugin-unused-imports";

export default [
  // add more generic rulesets here, such as:
  // js.configs.recommended,
  ...pluginVue.configs["flat/recommended"],
  // ...pluginVue.configs['flat/vue2-recommended'], // Use this if you are using Vue.js 2.x.
  {
    plugins: {
      "unused-imports": unusedImports,
    },
    rules: {
      "no-unused-vars": "off",
      "unused-imports/no-unused-imports": "error",
      "unused-imports/no-unused-vars": [
        "warn",
        {
          vars: "all",
          varsIgnorePattern: "^_",
          args: "after-used",
          argsIgnorePattern: "^_",
        },
      ],
    },
  },
];
