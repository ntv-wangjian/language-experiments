const path = require('path');
const HtmlWebPackPlugin = require("html-webpack-plugin");
module.exports = {
  entry: './src/main.js',
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'dist')
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader'
        }
      },
      {
        test: /\.html$/,
        use: {
          loader: 'html-loader'
        }
      },
      {test: /\.css$/,
       use: [
         {loader: 'style-loader'},
         {loader: 'css-loader',options: { modules: {localIdentName: "[path][name]-[local]-[hash:5]"}}} ]
      },   //打包处理css样式表的第三方loader
      {
        test: /\.(png|svg|jpe?g)$/,
        use: [
          {
            loader: 'url-loader',
            options: {
              limit: 8192,
              name: 'images/[name].[hash:7].[ext]',
              publicPath: './'
            }
          }
        ]
      },
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/,
        loader: 'file-loader'
      }
    ]
  },
  devServer: {
      contentBase: './dist'
  },
  plugins: [
    new HtmlWebPackPlugin({
      titel: 'react app',
      filename: 'index.html',
      template: './src/index.html'
    })
  ]
};

