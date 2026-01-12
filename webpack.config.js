const webpack = require('webpack');
const path = require('path');

/*const autoprefixer = require('autoprefixer');*/


module.exports = (env, argv) => {
    return {
        context: path.resolve(__dirname, "./"),
        /*entry: {'style':"./scss/style.scss","scripts":"./js/main.js"},                */
        entry: {"app":"./js/app.js"},
        /*entry: {'style':"./scss/style.scss","scripts":"./js/main.js"},                */
        output: {
            path:  path.resolve(__dirname, "./js/"),
            filename: '[name].min.js'
        },
        module:{
            rules:[                 
                {
                    test: /\.(js|jsx)$/,
                    exclude: /(node_modules)/,
                    use:[
                        {
                            loader: 'babel-loader',
                            options: {
                                presets: ["@babel/preset-env","@babel/preset-react"]
                            }
                        },
                    ]
                },
           
            ]
        },    
    }   

}
