const path = require("path");
const fs = require("fs");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

class CopyThemeCssPlugin {
  apply(compiler) {
    compiler.hooks.afterEmit.tap("CopyThemeCssPlugin", () => {
      const cssFiles = ["style.css", "editor-blocks.css"];
      const destinationDir = path.resolve(__dirname, "../assets/css");

      fs.mkdirSync(destinationDir, { recursive: true });

      cssFiles.forEach((fileName) => {
        const source = path.resolve(__dirname, "source/css", fileName);
        const destination = path.join(destinationDir, fileName);

        if (fs.existsSync(source)) {
          fs.copyFileSync(source, destination);
        }
      });
    });
  }
}

class CopyThemeJsPlugin {
  apply(compiler) {
    compiler.hooks.afterEmit.tap("CopyThemeJsPlugin", () => {
      const source = path.resolve(__dirname, "source/js/bundle/bundle.js");
      const destinationDir = path.resolve(__dirname, "../assets/js");
      const destination = path.join(destinationDir, "bundle.js");

      if (!fs.existsSync(source)) {
        return;
      }

      fs.mkdirSync(destinationDir, { recursive: true });
      fs.copyFileSync(source, destination);
    });
  }
}

class CopyThemeGsapPlugin {
  apply(compiler) {
    compiler.hooks.afterEmit.tap("CopyThemeGsapPlugin", () => {
      const source = path.resolve(__dirname, "source/js/bundle/gsap.bundle.js");
      const destinationDir = path.resolve(__dirname, "../assets/js");
      const destination = path.join(destinationDir, "gsap.bundle.js");

      if (!fs.existsSync(source)) {
        return;
      }

      fs.mkdirSync(destinationDir, { recursive: true });
      fs.copyFileSync(source, destination);
    });
  }
}

class RemoveStandaloneFormJsPlugin {
  apply(compiler) {
    compiler.hooks.afterEmit.tap("RemoveStandaloneFormJsPlugin", () => {
      const generatedJs = path.resolve(
        __dirname,
        "zlecenie-ksiegowosci-form-package/form-styles.js",
      );

      if (fs.existsSync(generatedJs)) {
        fs.unlinkSync(generatedJs);
      }
    });
  }
}

class RemoveStandaloneLoginJsPlugin {
  apply(compiler) {
    compiler.hooks.afterEmit.tap("RemoveStandaloneLoginJsPlugin", () => {
      const generatedJs = path.resolve(
        __dirname,
        "stronalogowania/login-styles.js",
      );

      if (fs.existsSync(generatedJs)) {
        fs.unlinkSync(generatedJs);
      }
    });
  }
}

/* ===================== JS - Main Bundle ===================== */
const jsConfig = {
  entry: "./src/ts/index.ts",
  output: {
    filename: "bundle.js",
    path: path.resolve(__dirname, "source/js/bundle"),
    clean: false,
  },
  resolve: {
    extensions: [".ts", ".js"],
  },
  module: {
    rules: [
      {
        test: /\.ts$/,
        use: "ts-loader",
        exclude: /node_modules/,
      },
    ],
  },
  devtool: "source-map",
  mode: "production",
  plugins: [new CopyThemeJsPlugin()],
};

/* ===================== JS - GSAP Bundle ===================== */
const gsapConfig = {
  entry: "./src/ts/gsap-bundle.ts",
  output: {
    filename: "gsap.bundle.js",
    path: path.resolve(__dirname, "source/js/bundle"),
    clean: false, // Ważne! Nie czyść, bo main bundle już to zrobił
  },
  resolve: {
    extensions: [".ts", ".js"],
  },
  module: {
    rules: [
      {
        test: /\.ts$/,
        use: "ts-loader",
        exclude: /node_modules/,
      },
    ],
  },
  devtool: "source-map",
  mode: "production",
  plugins: [new CopyThemeGsapPlugin()],
};

/* ===================== SCSS ===================== */
const scssConfig = {
  entry: {
    style: "./source/css/style.scss",
    "editor-blocks": "./source/css/editor-blocks.scss",
  },
  output: {
    filename: "[name].js",
    path: path.resolve(__dirname, "source/css"),
    clean: false,
  },
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/i,
        use: [
          MiniCssExtractPlugin.loader,
          { loader: "css-loader", options: { sourceMap: true, url: false } },
          {
            loader: "sass-loader",
            options: {
              sourceMap: true,
              implementation: require("sass"),
            },
          },
        ],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({ filename: "[name].css" }),
    new CopyThemeCssPlugin(),
  ],
  optimization: {
    minimizer: [
      "...",
      new CssMinimizerPlugin({
        minimizerOptions: {
          preset: [
            "default",
            {
              discardDuplicates: false,
            },
          ],
        },
      }),
    ],
  },
  mode: "production",
  devtool: "source-map",
};

/* ===================== SCSS - Standalone Zlecenie Form ===================== */
const zlecenieFormScssConfig = {
  entry: {
    "form-styles": "./source/css/zlecenie-ksiegowosci-form.scss",
  },
  output: {
    filename: "[name].js",
    path: path.resolve(__dirname, "zlecenie-ksiegowosci-form-package"),
    clean: false,
  },
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/i,
        use: [
          MiniCssExtractPlugin.loader,
          { loader: "css-loader", options: { sourceMap: false, url: false } },
          {
            loader: "sass-loader",
            options: {
              sourceMap: false,
              implementation: require("sass"),
            },
          },
        ],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({ filename: "form.css" }),
    new RemoveStandaloneFormJsPlugin(),
  ],
  optimization: {
    minimizer: ["...", new CssMinimizerPlugin()],
  },
  mode: "production",
  devtool: false,
};

/* ===================== SCSS - Standalone Login ===================== */
const loginScssConfig = {
  entry: {
    "login-styles": "./source/css/logowanie.scss",
  },
  output: {
    filename: "[name].js",
    path: path.resolve(__dirname, "stronalogowania"),
    clean: false,
  },
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/i,
        use: [
          MiniCssExtractPlugin.loader,
          { loader: "css-loader", options: { sourceMap: false, url: false } },
          {
            loader: "sass-loader",
            options: {
              sourceMap: false,
              implementation: require("sass"),
            },
          },
        ],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({ filename: "login.css" }),
    new RemoveStandaloneLoginJsPlugin(),
  ],
  optimization: {
    minimizer: ["...", new CssMinimizerPlugin()],
  },
  mode: "production",
  devtool: false,
};

/* ===================== EXPORT ===================== */
module.exports = (env = {}) => {
  if (env.target === "js") return jsConfig;
  if (env.target === "gsap") return gsapConfig;
  if (env.target === "styles") return scssConfig;
  if (env.target === "zk-form-styles") return zlecenieFormScssConfig;
  if (env.target === "login-styles") return loginScssConfig;
  return [jsConfig, gsapConfig, scssConfig]; // Wszystkie bundlesy
};
