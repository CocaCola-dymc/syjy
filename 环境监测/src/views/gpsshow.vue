<template>
    <div class="box">
        <!-- 头部区域 -->
        <div class="headbox">
            <div class="headtitle">
                <h1>环境监测</h1>
            </div>
        </div>
        <!-- 中间区域 -->
        <div class="middlebox">
            <!-- 侧边栏区域 -->
            <div class="asidebox">
                <div class="navbox">
                    <el-menu
                        router
                        :default-active="$route.path"
                        class="el-menu-vertical-demo"
                        background-color="#222d32"
                        text-color="white"
                        active-text-color="rgb(43, 153, 212)"
                        style="width:100%;height:100%;"
                    >
                        <!-- 没有下级菜单的菜单项 -->
                        <el-menu-item index="/showmsg">
                            <i class="el-icon-document"></i>
                            <span slot="title">环境数据</span>
                        </el-menu-item>
                        <!-- 没有下级菜单的菜单项 -->
                        <el-menu-item index="/gpsshow">
                            <i class="el-icon-location"></i>
                            <span slot="title">设备定位</span>
                        </el-menu-item>
                    </el-menu>
                </div>              
            </div>
            <div class="mapbox">
                <!-- <div class="map"> -->
                <template>
                    <baidu-map
                        class="bm-map"
                        :center="center"
                        :zoom="zoom"
                        :dragging="true"
                        :scroll-wheel-zoom="true"
                        @ready="handler"
                        @click="getClickInfo"
                        :key="timeKey"
                    >
                    <!-- 地图类型 -->
                        <bm-map-type :map-types="['BMAP_NORMAL_MAP','BMAP_HYBRID_MAP']" anchor="BMAP_ANCHOR_TOP_LEFT" ></bm-map-type>
                        <!-- 地图搜索 -->
                        <bm-navigation anchor="BMAP_ANCHOR_TOP_RIGHT"></bm-navigation>
                        <!-- <bm-control :offset="{width: '10px', height: '10px'}" class="searchbox">
                            <bm-auto-complete v-if="autoComplete" v-model="keyword" :sugStyle="{zIndex: 999999}" @confirm="handleConfirm" :key="`${timeKey}-BaiduMap`">
                                <input type="text" placeholder="请输入搜索关键字" class="serachinput">
                            </bm-auto-complete>
                        </bm-control> -->
                        <bm-marker :position="center" :dragging="false" animation="BMAP_ANIMATION_DROP"></bm-marker>
                    
                        <!-- 缩略图 -->
                        <bm-overview-map anchor="BMP_ANCHOR_BOTTOM_RIGHT" :isOpen="true"></bm-overview-map>

                    </baidu-map>
                </template>
            </div>

        </div>
        <!-- 地图区域 -->

    </div>
</template>

<script>
import axios from "axios";
import { connect } from "mqtt";
const mqttHost = "112.124.28.149";
const mqttPort = "8083";
const mqttUrl = `ws://${mqttHost}:${mqttPort}/mqtt`;

const subTopic = "environment";         //订阅主题

import { BaiduMap, BmScale, BmControl, BmAutoComplete, BmGeolocation, BmlMarkerClusterer, BmlLushu, BmPolygon} from 'vue-baidu-map'
export default{
    components: {
      BaiduMap,
      BmControl,
      BmAutoComplete,
      BmScale,
      BmGeolocation,
      BmlMarkerClusterer,
      BmlLushu,
      BmPolygon
    },
    data(){
        return{
            baidumapSwitch: false,
            autoComplete: true,
            center: { lng: "", lat: "" },
            zoom: 18,
            location: '',
            keyword: '请输入搜索关键词',
            markers: [],
            position: {},
            timeKey: '',
            msg: [],
            map: null,
            choose_flag: false,
            show_flag: false,
            client: {},
            history_flag: false,
            play: true,
            path: [],
            
            today: '',
            dataFromDev: {},
        }
    },
    created(){
        this.axios();

    },
    watch:{

    },
    mounted(){
        //连接MQTT
        this.client = connect(mqttUrl)
        //连接成功时返回的信息
        this.client.on("connect",function(){
            console.log("connect successd!")
        })
        //订阅信息主题
        this.client.subscribe(subTopic,function(err){
            if(!err){
            console.log(`成功订阅${subTopic}`)
            }
        })
        //接受topic的信息并且打印
        this.client.on("message",(topic,message)=>{
            //message是16进制的Buffered字节流,使用dataFromDev接受传来的message
            this.dataFromDev = JSON.parse(message)
            let GPS = this.dataFromDev.GPS
            this.center.lng = GPS.split(' ')[1]
            this.center.lat = GPS.split(' ')[0]
        })
        this.handler();
        // setInterval(() => {
        //     this.handler();
        // }, 10000); 

    },
    methods:{
        querySearch (queryString, cb) {
            var that = this
            /* global BMap */
            var myGeo = new BMap.Geocoder()
            myGeo.getPoint(queryString, function (point) {
            if (point) {
                that.point = point
            }
            }, this.locationCity)
            setTimeout(function () {
            that.show(that.point.lng, that.point.lat)
            }, 500)
        },
        show (gpsLongitude, gpsLatitude) {
            if (gpsLongitude === undefined || (gpsLongitude === 0 && gpsLatitude === 0)) {
            gpsLongitude = this.center.lng
            gpsLatitude = this.center.lat
            }
            const position = { id: Math.random() * 40, lng: gpsLongitude, lat: gpsLatitude }
            this.center = { lng: gpsLongitude, lat: gpsLatitude }
            this.markers = []
            this.markers.push(position)
            this.position = position
        },
        // 百度地图初始化（这个一定要！否则地图回加载不出来）{BMap, map}
        handler () {
            //百度地图主题默认为白色，如上图所示
            //百度地图使用黑色主题
            //[百度地图更多主题](https://lbsyun.baidu.com/custom/list.htm)
            // var mapStyle = { style: 'light' }
            // map.setMapStyle(mapStyle)
            // this.map = map;
            // let that= this  
            axios({
                method: 'GET',
                url: '/LMhj.php'
            }).then(res=>{
                let msg = JSON.parse(JSON.stringify(res.data));
                // console.log(res.data)
                // console.log(msg.users)
                // 将获取的数据转化为字符串
                const str = (msg.users[msg.users.length-1].GPS).toString();
                // console.log(str);
                // 根据空格分隔字符
                this.center.lng = str.split(' ')[1];//经度
                this.center.lat = str.split(' ')[0];//纬度
                // console.log(that.center.lng);
                // console.log(that.center.lat);
                //测试数据
                // this.center.lng = 113.543
                // this.center.lat = 23.108

                // 如果定位点超出规定的范围，就会报警
                // if(that.center.lng < 113.539882 || that.center.lng > 113.544382 || that.center.lat < 23.107134 || that.center.lat > 23.111634){
                //     console.log("warning")
                // }
                // if( that.center.lng < this.polygonPath[0].lng ||        //小于左经度
                //     that.center.lng > this.polygonPath[2].lng ||        //大于右经度
                //     that.center.lat < this.polygonPath[1].lat ||        //小于下纬度
                //     that.center.lat > this.polygonPath[3].lat)          //大于上纬度
                // {
                //     console.log("warning")
                // }


            })
            // var point = new BMap.Point()

            this.today = new Date()
        },
        times(){

        },
        // 点击获取到当前经纬度
        getClickInfo (e) {
            const position = { id: Math.random() * 40, lng: e.point.lng, lat: e.point.lat }
            this.markers = []
            this.markers.push(position)
            this.position = position
        },
    },
    destroyed(){
        this.client.unsubscribe(subTopic,function(err){
            if(!err){
                console.log(`取消订阅${subTopic}`)
            }
        })
        this.client.end();
    }
}
</script>

<style scoped>
*{
    margin: 0;
    padding: 0;
}
html,body{
    height: 100%;
}
.box{
    height: 100%;
    width: 100%;
}
/* 头部区域 */
.headbox{
    width: 100%;
    height: 10%;
    background-color: #30373b;
    display: flex;
    justify-content: space-between;
}
.headtitle{
    margin-left: 40px;
    color: #ffffff;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 24px;
    user-select: none
    /* text-align: center; */
}
/* .headtitle h2{
    margin-top: 13%;
} */
.headuser{
    margin-right: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.headuser img{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 20px;
    /* margin-top: 7%; */
}
.headuser p{
    color: #ffffff;
    /* margin-top: 13%; */
}
.myelbtn{
    margin-right: 50px;
    color: rgb(227, 227, 227);
}
.myelbtn:hover{
    color: #6a9df6;
}
.myeldialog{
    width: 100% !important;
    margin: auto;
}
.myelform{
    width: 80% !important;
    height: 480px !important;
    /* background-color: #30373b !important; */
    margin: auto;
}
.el-input{
    width: 70%;
    margin-right: 40px;
}
.el-form-item{
    margin-top: 50px;
}


.el-select{
    width: 65%;
    /* margin-right: 40px; */
}

.el-form-item span{
    margin-right: 40px;
}

.myaddline{
    margin-right: 50px;
    color: #fff !important;
}
.myaddline:hover{
    color: #6a9df6 !important;
}
.myelconcel{
    background-color: #6a9df6 !important;
    color: #ffffff !important;
    
}
.myelok{
    background-color: #6a9df6 !important;
    color: #ffffff !important;
}
/* 头部区域下拉菜单 */
/* 表单内容 */
.tablebox{
    width: 99%;
    height: 92%;
    /* background-color: #83b5e7; */
    margin-left: 8px;
    border-color: white;
}

/* 中间区域 */
.middlebox{
    width: 100%;
    height: 90%;
    display: flex;
    background-color: #d9dbdb;
}
.asidebox{
    width: 11.7%;
    height: 100%;
    background-color: rgb(212, 124, 10);
}
.navbox{
    width: 100%;
    height: 100%;
    /* background-color: aqua; */
}

.el-menu-item, .el-submenu__title {
    height: 100px;
    line-height: 100px;
    list-style: none;
    font-size: 24px;
    font-weight: bold;
}

.el-menu-item [class^=el-icon-] {
    margin-right: 5px;
    width: 24px;
    text-align: center;
    font-size: 24px;
    vertical-align: middle;
}

.mapbox{
    width: 88.3%;
    height: 100%;
    background-color: #fff;
}
.bm-map{
    width: 99.75%;
    height: 99.5%;
    margin-top: 1px;
    margin-left: 2px;
    margin-right: 5px;
    margin-bottom: 5px;
    background-color: #5099c3;
}
.searchbox{
    margin-top: 5px;
    width: 1400px;
    height: 70px;
    /* background-color: #30373b; */
}
.searchbox .serachinput{
    width: 200px;
    height: 35px;
    padding-left: 10px;
    margin-left: 100px;

    /* margin-top: 5px !important; */
}

.form_button{
    width: 150px;
    height: 50px;
    font-size: 20px;
    color: #ffffff;
    background-color: #39a8e9;
    margin-left: 5px; 
    border-color: #39a8e9;
}
.searchbox .myelbtn{
    width: 150px;
    height: 50px;
    font-size: 20px;
    color: #ffffff;
    background-color: #39a8e9;
    margin-left: 5px; 
    border-color: #39a8e9;

    /* margin-top: 8px !important; */

}
.searchbox .myelbtn1 {
    width: 200px;
    height: 50px;
    font-size: 20px;
    /* color: #ffffff; */
    /* background-color: #39a8e9; */
    margin-left: 5px; 
    /* border-color: #39a8e9; */

}
</style>


<!-- 下拉菜单弹窗部分 -->
<style>
/* 输入框 */
.mymsgadd,.el-input,.el-input__inner{
    border-color: #8e8d8d !important;
}
.mymsgadd,.el-input,.el-input__inner:hover{
    border-color: #1a1a1b !important;
}
/* .mymsgadd,.el-input,.el-input__inner:focus{
    border-color: #1a1a1b !important;
} */
/* 确认按键 */
.messageBoxP_confirmBtn{
    border-color: #6a9df6 !important;
    background-color: #6591df !important;
}
.messageBoxP_confirmBtn:hover{
    border-color: #7ba3e9 !important;
    background-color: #7ba3e9 !important;
}
/* .messageBoxP_confirmBtn:focus{
    border-color: #a4b4cf !important;
    background-color: #a4b4cf !important;
} */
.messageBoxP_confirmBtn span{
    font-size: 13px !important;
    text-align: center !important;
}

/* 取消按键 */
.messageBoxP_cancelBtn{
    border-color: #6a9df6 !important;
}
.messageBoxP_cancelBtn:hover{
    border-color: #7ba3e9 !important;
    background-color: #9abaf3 !important;
    
}
.messageBoxP_cancelBtn span{
    font-size: 13px !important;
    text-align: center !important;
    /* color: white  !important; */
    color: #1a1a1b !important;
    
}

/* 关闭按键 */
.mymsgadd,.el-message-box__close{
    color: rgb(133, 133, 133) !important;
}
.mymsgadd,.el-message-box__close:hover{
    color: black !important;
}
</style>

<style>
.my-datebox,.el-table th.el-table__cell>.cell{
    padding-left: 20px !important;
}

.my-searchbox,.el-input--mini .el-input__inner{
    height: 35px !important;
    width: 200px !important;
    /* margin-left: -20px !important; */
}

</style>

<!-- <template>
    <div>
      <div class="mask" v-if="showModal" @click="showModal=false"></div>
      <div class="pop" v-if="showModal">
          <button @click="showModal=false" class="btn">点击出现弹框</button>
      </div>
      <button @click="showModal=true" class="btn">点击出现弹框</button>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        showModal: false
      };
    }
  };
  </script>
  
  <style scoped>
  .mask {
    background-color: #000;
    opacity: 0.3;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1
  }
  .pop {
    background-color: #fff;
   
    position: fixed;
    top: 100px;
    left: 300px;
    width: calc(100% - 600px);
    height:calc(100% - 200px);
    z-index: 2
  }
  .btn {
    background-color: #fff;
    border-radius: 4px;
    border: 1px solid blue;
    padding: 4px 12px;
  }
  </style> -->

<!-- <template>
    <div id="container">
           <map-container></map-container>
   </div>
</template>
<script>
import MapContainer from "./MapContainer.vue";
export default {
components: {MapContainer}
}
</script>
<style scoped>
*{
    margin: 0;
    padding: 0;
}
html,body{
    height: 100%;
}
#container{
    height: 100%;
    width: 100%;
}

</style> -->
