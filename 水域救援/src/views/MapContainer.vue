<template>
    <div id="container"></div>
  </template>
  
  <script>
  import AMapLoader from '@amap/amap-jsapi-loader';
  import bus from '../eventBus/eventBus.js';
    //   window._AMapSecurityConfig = {
    //         securityJsCode: '41e534cd0e9251839fbc4c9ee791bbf9'
    //   }
  export default {
    data() {
      return {
        map: null,
        lng: "113.535965",
        lat: "23.101752",
        autoOptions:{
            input: ''
        },
        auto: null,
      }
    },
    created() {
    bus.$on('share_id', val => {
      this.autoOptions.input = val
    })
  },

    methods: {
      initMap() {
        AMapLoader.load({
          key: 'f6c7a0cf30befbd96a9e35da908c0bc2', // 申请好的Web端开发者Key，首次调用 load 时必填
          version: '2.0', // 指定要加载的 JSAPI 的版本，缺省时默认为 1.4.15
          plugins: ['AMap.Scale' ,'AMap.ToolBar', 'AMap.HawkEye', 'AMap.MapType','AMap.ControlBar','AMap.AutoComplete'] // 需要使用的的插件列表，如比例尺'AMap.Scale'等
        })
          .then(AMap => {
            this.map = new AMap.Map('container', {
              //设置地图容器id
              viewMode: '3D', //是否为3D地图模式
              zoom: 18, //初始化地图级别
              center: [this.lng, this.lat] //初始化地图中心点位置
            })
                            // 比例尺
                            this.map.addControl(new AMap.Scale({
                    // position: 'LB'
                }))
                // 工具条
                this.map.addControl(new AMap.ToolBar({
                    // positoin:'RT'
                    position:{
                        top: '130px',
                        left: '50px'
                    }
                }))
                // 工具条方向盘
                this.map.addControl(new AMap.ControlBar({

                }))
                // 缩略图
                this.map.addControl(new AMap.HawkEye({
                    // position:'LT'
                }))
                // 图层切换
                this.map.addControl(new AMap.MapType({
                    // position: 'RT'
                }))
                // 定位
                // this.map.addControl( new AMap.Geolocation({
                //     // position:'RT'//right top
                // }))  
                this.map.setFeatures(['road','point','bg','building'])
                var marker = new AMap.Marker({
                    position: new AMap.LngLat(this.lng,this.lat)
                })  
                this.map.add(marker);  
                this.auto = new AMap.AutoComplete(this.autoOptions)
          })
          .catch(e => {
            console.log(e)
          })
      }
    },
    mounted() {
      //DOM初始化完成进行地图初始化
      this.initMap()
    },


  }
  </script>
  
  <style scoped>
  #container {
    padding: 0px;
    margin: 0px;
    width: 100%;
    height: 100%;
  }
  </style>
  
  