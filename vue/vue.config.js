const path = require("path");

module.exports = {
  // https://cli.vuejs.org/config/#productionsourcemap
  productionSourceMap: false,
  outputDir: path.resolve(__dirname, "../backend/public/build"),
  publicPath: process.env.VUE_APP_PUBLIC_DIR || "/",
  // https://cli.vuejs.org/config/#css-extract
  css: {
    extract: { ignoreOrder: true },
    loaderOptions: {
      sass: {
        prependData: "@import '~@/assets/scss/vuetify/variables'"
      },
      scss: {
        prependData: "@import '~@/assets/scss/vuetify/variables';"
      }
    }
  },

  chainWebpack: config => {
    // Remove the following lines to add Vue Prefetch and Preload on index.html
    // https://cli.vuejs.org/guide/html-and-static-assets.html#disable-index-generation
    config.plugins.delete("preload");
    config.plugins.delete("prefetch");
  },

  // https://cli.vuejs.org/config/#transpiledependencies
  transpileDependencies: ["vue-echarts", "resize-detector", "vuetify"]
};
