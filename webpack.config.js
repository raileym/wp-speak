const path = require('path');
const RewireWebpackPlugin = require("rewire-webpack-plugin");
//const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
//const JavaScriptObfuscator = require('webpack-obfuscator');

module.exports = {
  // For now, I will not use 'watch'
  //watch: true,

  mode: 'development',
  plugins: [
    new RewireWebpackPlugin(),
  ],
  entry: {
    'wps-main':     path.join(__dirname, 'js/src', 'wps-main.js')//,
//     'wps-scss':     path.join(__dirname, 'js/src', 'wps-scss.js'),
//     'wps-spec':     path.join(__dirname, 'js/src', 'wps-spec.js')
  },
  node: { // See https://github.com/webpack-contrib/css-loader/issues/447
    fs: 'empty'
  },
  output: {
    path: path.resolve(__dirname, 'js/dist')
  },
  externals: {
    jquery:       'jQuery',
    backbone:     'Backbone',
    underscore:   '_',
  },
  resolve: {
    alias: {
      // SCSS
//       'scss/ctns-admin':  path.resolve(__dirname, 'scss/ctns-admin.scss'),
//       'scss/ctns-icon':   path.resolve(__dirname, 'scss/ctns-icon.scss'),
//       'scss/ctns-minimal':path.resolve(__dirname, 'scss/ctns-minimal.scss'),
//       'scss/ctns-mobile': path.resolve(__dirname, 'scss/ctns-mobile.scss'),
//       'scss/ctns':        path.resolve(__dirname, 'scss/ctns.scss'),
      

      'jplayer':                       path.resolve(__dirname, 'js/lib/jplayer/jquery.jplayer.js'),
      'wps-audio-ondemand':            path.resolve(__dirname, 'js/src/wps-audio-ondemand'),
      'wps-domready':                  path.resolve(__dirname, 'js/src/wps-domready'),
      'wps-localize':                  path.resolve(__dirname, 'js/src/wps-localize'),
      'wps-numbers':                   path.resolve(__dirname, 'js/src/wps-numbers'),
      'wps-problems':                  path.resolve(__dirname, 'js/src/wps-problems'),
      'md5':                           path.resolve(__dirname, 'js/lib/pajhome.org.uk/md5.js'),
    }
  },
  devtool: 'source-map',
  module: {
//    loaders: [
//        {
//            test: /\.html$/,
//            loader: "underscore-template-loader",
//            query: {
//                engine: 'underscore',
//            }
//        }
//    ]
//    rules: [
//      { test: /\.html$/, use: 'underscore-template-loader' },
//    ]
    rules: [
      // See https://wanago.io/2018/07/16/webpack-4-course-part-two-webpack-4-course-part-two-loaders/
      { test: /\.css$/,  use: ['style-loader', 'css-loader'] },
      { test: /\.scss$/, use: ['style-loader', 'css-loader', 'sass-loader'] },    
      { test: /\.html$/, use: 'html-loader' },
    ]
  },
}
