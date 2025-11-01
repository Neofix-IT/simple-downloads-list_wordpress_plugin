const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require("path");

module.exports = {
  ...defaultConfig,
  entry: {
    // SDL Block Scripts
    //
    // Note: Index will import style.scss, edit.js and icon.js too -> webpack will compile this
    "blocks/sdl/index": "./assets/blocks/sdl/index.js",

    // Adminpanel
    "admin/admin-styles": "./assets/admin/admin.scss",
    "admin/admin-scripts": "./assets/admin/admin.js",
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "[name].js",
  },
};
