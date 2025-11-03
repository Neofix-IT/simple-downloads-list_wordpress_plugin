const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require("path");

const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");
const ZipPlugin = require("zip-webpack-plugin");

module.exports = (env, argv) => {
  if (env && env.package) {
    return [buildConfig, packageConfig];
  }
  return buildConfig;
};

buildConfig = {
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

BUILD_FILES = [
  "admin",
  "blocks",
  "dist",
  "languages",
  "lists",
  "setup",
  "templates",
  "readme.txt",
  "neofix_sdl.php",
];

const generatedPatterns = BUILD_FILES.map((folder) => ({
  from: path.resolve(__dirname, folder),
  to: folder,
}));

const packageConfig = {
  mode: "production",
  entry: {}, // No compilation needed
  output: {
    path: path.resolve(__dirname, "build/release"),
    filename: "[name].js", // Placeholder
  },
  plugins: [
    // 1. Clean the release folder
    new CleanWebpackPlugin(),

    // 2. Copy files from source folders to dist
    new CopyWebpackPlugin({
      patterns: [...generatedPatterns],
    }),

    // 3. Bundle everything into a ZIP
    new ZipPlugin({
      // **NEW OPTION:** Specifies the directory where the zip file will be saved.
      path: path.resolve("build"), // Example: Go up one level, then into 'release' folder

      // filename remains the name of the zip file
      filename: "simple-downloads-list.zip",

      // pathPrefix remains the root folder *inside* the zip file
      pathPrefix: "simple-downloads-list",
    }),
  ],
};
