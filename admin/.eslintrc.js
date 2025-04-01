module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: [
    'plugin:vue/vue3-essential', // or 'plugin:vue/vue3-recommended' for stricter rules
    'eslint:recommended',
    '@vue/typescript/recommended',
    'plugin:prettier/recommended', // Add this line to integrate Prettier with ESLint
    'prettier', // Add this line to extend eslint-config-prettier
  ],
  parserOptions: {
    ecmaVersion: 2020,
    parser: '@typescript-eslint/parser',
  },
  plugins: [
    // ... other plugins
    'prettier', // Recommended, but not strictly necessary with the 'extends' config.
  ],
  rules: {
    'prettier/prettier': [
      'error',
      {
        // Your Prettier options here (e.g., printWidth, tabWidth, etc.)
        // These will override any .prettierrc config you have.
        endOfLine: 'auto',
      },
    ],
  },
};
