const Encore = require('@symfony/webpack-encore');
const path = require('path')
const NodePolyfillPlugin = require("node-polyfill-webpack-plugin")

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
  .setOutputPath('public/assets/')
  .setPublicPath('/assets')
  .setManifestKeyPrefix('assets/')
  .copyFiles({
    from: './assets/images',
    to: 'images/[path][name].[hash:8].[ext]',
    pattern: /\.(png|jpg|jpeg|xml|ico|json)$/
  })
  .copyFiles({
    from: './assets/fonts',
    to: 'fonts/[path][name].[hash:8].[ext]',
    pattern: /\.(ttf)$/
  })
  .addEntry('app', './assets/app.js')
  .enableStimulusBridge('./assets/controllers.json')
  .splitEntryChunks()
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .configureBabel((config) => {
    config.plugins.push('@babel/plugin-proposal-class-properties')
  })
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = 'usage'
    config.corejs = 3
  })
  .enableStylusLoader()
  .enableSassLoader()
  //.enableTypeScriptLoader()
  //.enableReactPreset()
  .enablePostCssLoader((options) => {
    options.postcssOptions = { config: 'postcss.config.js' }
  })
  .enableIntegrityHashes(Encore.isProduction())
  .addPlugin(new NodePolyfillPlugin())
  .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
