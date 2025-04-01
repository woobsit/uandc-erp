const { defineConfig } = require('@vue/cli-service');
module.exports = defineConfig({
  transpileDependencies: true,
  configureWebpack: {
    entry: './src/main.ts', // Explicitly set the entry point
  },
  css: {
    loaderOptions: {
      sass: {
        additionalData: `@import "@/assets/styles/globals.scss";`,
      },
    },
  },
});
