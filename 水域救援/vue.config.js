module.exports = {

     // webpack-dev-server 相关配置
  devServer:{

    //省略其他配置信息
     proxy: {  
         '/api':{ //路径中有/api的请求都会走这个代理，可以自己随便定义一个，不用api也可以
             target: "http://112.124.28.149",//目标代理接口地址，实际跨域要访问的接口
             changeOrigin: true,//是否跨域，开启代理，在本地创建一个虚拟服务器
             pathRewrite: { //是否重写路径
                 '^/api': '/'    
              }
            }
          }
    },


}