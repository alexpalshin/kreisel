const webpack = require("webpack");
const Dotenv = require('dotenv-webpack');
const path = require("path");
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyPlugin = require("copy-webpack-plugin");

module.exports = {
    // Define the entry points of our application (can be multiple for different sections of a website)
    entry: {
        main: './src/js/main.js',
        main_red: './src/js/main-red.js',
        main_orange: './src/js/main-orange.js',
        main_blue: './src/js/main-blue.js',
        main_grey: './src/js/main-grey.js',
		custom: './src/js/custom.js',
    },

    // Define the destination directory and filenames of compiled resources
    output: {
        filename: "js/[name].js",
        path: path.resolve(__dirname, "./dist")
    },

    // Define development options
    devtool: "source-map",

    // Define loaders
    module: {
        rules: [
            // Use babel for JS files
            {
                test: /\.js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: "babel-loader",
                    options: {
                        presets: [
                            "@babel/preset-env"
                        ]
                    }
                }
            },
            // CSS, PostCSS, and Sass
            {
                test: /\.(scss|css)$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: "css-loader",
                        options: {
                            importLoaders: 2,
                            sourceMap: true,
                            url: false,
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: {
                                plugins: [
                                    'autoprefixer',
                                ]
                            }
                        }
                    },
                    'sass-loader'
                ],
            },
        ],
    },

    // Define used plugins
    plugins: [
        // Load .env file for environment variables in JS
        new Dotenv({
            path: "./.env"
        }),

        // Extracts CSS into separate files
        new MiniCssExtractPlugin({
            filename: "css/[name].css",
            chunkFilename: "[id].css"
        }),


        new CopyPlugin({
            patterns: [
                { from: "src/images", to: "images" },
            ],
        }),

    ],
};