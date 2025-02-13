const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  mode: 'production',
  entry: './sources/public/assets/css/main.css', // Entrée = ton fichier CSS
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'bundle.js', // Webpack demande un JS, mais ce sera vide
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
        ],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'styles.css', 
    }),
  ],
};
