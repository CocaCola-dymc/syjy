<template>
    <div class="box">
        <!-- 头部区域 -->
        <div class="headbox">
            <div class="headtitle">
                <h1>水域救援系统</h1>
            </div>
            <div class="headuser">
                <!-- 文字链接 -->
                <!-- <el-button type="text" @click="dialogFormVisible = true" class="myelbtn">参数设置</el-button> -->
                <!-- 表单 -->
                <el-dialog title="参数设置" :visible.sync="dialogFormVisible" class="myeldialog">
                    <el-form class="myelform" label-width="80px">
                        <el-form-item label="写序列号">
                            <el-input v-model="name" clearable maxlength="10" auto-complete="off" placeholder="请输入1-10位设备序列号" label-width="80px"></el-input>
                            <el-button type="primary" @click="addName">确认</el-button>
                            <!-- <el-button>清空</el-button> -->
                        </el-form-item>
                        <el-form-item label="新卡确认">
                            <el-input v-model="card" disabled></el-input>
                            <el-button type="primary" @click="confirm">确认</el-button>
                        </el-form-item>
                        <el-form-item label="卡号读取">
                            <el-input v-model="card_id" readonly placeholder="等待读取"></el-input>
                            <el-button type="primary" @click="read">读取</el-button>
                        </el-form-item>
                        <el-form-item label="持卡人员">
                            <el-input v-model="card_keeper" maxlength="10" placeholder="此卡暂无使用人员,编辑后可添加" :readonly="addCard_flag"></el-input>
                            <el-button type="primary" @click="cardKeeper" :disabled="addCard_flag">添加</el-button>
                        </el-form-item>
                        <el-form-item label="发送间隔">
                            <el-select v-model="time" placeholder="请选择发送的时间间隔">
                                <el-option label="10" value="10"></el-option>
                                <el-option label="20" value="20"></el-option>
                                <el-option label="30" value="30"></el-option>
                                <el-option label="60" value="60"></el-option>
                                <el-option label="90" value="90"></el-option>
                                <el-option label="120" value="120"></el-option>
                            </el-select>
                            <span>&nbsp;秒/次</span>
                            <el-button type="primary" @click="timeInterval">确认</el-button>
                            <!-- <el-button>重置</el-button> -->
                        </el-form-item>
                    </el-form>

                    <div class="dialog-footer">
                        <el-button @click="dialogFormVisibleClose" class="myelconcel">取消</el-button>
                        <el-button @click="dialogFormVisibleClose" class="myelok">确定</el-button>
                    </div>
                </el-dialog>

                <el-dialog title="历史轨迹" :visible.sync="historyFormVisible">
                    <el-form :model="form">
                        <!-- 设备序列号选择 -->
                        <el-form-item label="设备序列号" label-width="100px">
                            <el-select v-model="device" placeholder="请选择设备序列号">
                                <el-option v-for="item,index in devicemarkers_key_sort" :key="index" :label="item" :value="item"></el-option>
                            </el-select>
                        </el-form-item>
                        <!-- 历史点个数选择 -->
                        <el-form-item label="历史个数点" label-width="100px">
                            <el-select v-model="historyPoint" placeholder="请选择历史点个数">
                                <el-option v-for="item,index in historyPointArr" :key="index" :label="item" :value="item"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-form>
                    <div slot="footer" class="dialog-footer">
                        <el-button @click="historyFormVisible=false">取 消</el-button>
                        <el-button type="primary" @click="historyposition();historyFormVisible=false">确 定</el-button>
                    </div>
                </el-dialog>

                <!-- 下拉菜单 -->
                <el-row class="block-col-2">
                    <el-col :span="16">
                        <el-dropdown class="my-el-dropdown">
                            <span class="el-dropdown-link" @click="gouserIndex">
                                <!-- <img src="../assets/userimage.jpg"> -->
                            </span>
                            <!-- 表单 -->
                            <el-dropdown-menu slot="dropdown" class="my-el-dropmenu">                          
                                <el-button type="text" @click="loginout">
                                    <el-dropdown-item icon="el-icon-plus">退出登录</el-dropdown-item>
                                </el-button>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </el-col>
                </el-row>
                <!-- <p>nianqingren</p> -->
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
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
                        <el-menu-item index="/gpsshow">
                            <i class="el-icon-location"></i>
                            <span slot="title">实时定位</span>
                        </el-menu-item>
                        <!-- 没有下级菜单的菜单项 -->
                        <el-menu-item index="/alertcontent">
                            <i class="el-icon-message-solid"></i>
                            <span slot="title">报警信息</span>
                        </el-menu-item>
                        <!-- 没有下级菜单的菜单项 -->
                        <el-menu-item @click="password">
                            <i class="el-icon-s-tools"></i>
                            <span slot="title">参数设置</span>
                        </el-menu-item>
                        <el-menu-item index="/cardmanage">
                            <i class="el-icon-postcard"></i>
                            <span slot="title">卡片管理</span>
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
                        <bm-control :offset="{width: '10px', height: '10px'}" class="searchbox">
                            <bm-auto-complete v-if="autoComplete" v-model="keyword" :sugStyle="{zIndex: 999999}" @confirm="handleConfirm" :key="`${timeKey}-BaiduMap`">
                                <input type="text" placeholder="请输入搜索关键字" class="serachinput">
                                <el-button class="myelbtn1" @click="machineposition" type="danger"><p>恢复初始状态</p></el-button>
                                <el-button class="myelbtn1" @click="historyFormVisible=true" type="success">显示历史轨迹</el-button>
                                <el-button class="myelbtn1" @click="markerPoint" type="success">{{ marker }}</el-button>
                                <el-button class="myelbtn1" @click="chooseRange" type="primary">电子围栏范围</el-button> 
                                <el-button class="myelbtn1" @click="showRange" type="primary">{{ show }}</el-button>
                                <!-- 范围选择器 -->
                                <el-slider
                                    v-if="choose_flag"
                                    v-model="value1"
                                    :min="0"
                                    :max="1000"
                                    :step="100"
                                    @change="changeValue">
                                </el-slider>
                            </bm-auto-complete>
                        </bm-control>
                    
                        <!-- 绘制多个点 -->
                        <div v-if="normal_flag">
                            <div v-for="item,index in devicemarkers" :key="index">
                                <!-- <bm-marker :key="item.devicename" :position="item.devicemarkerPoint" @click="look(item)" @open="infoWindowOpen"></bm-marker> -->
                                <bm-marker :key="index" :position="item.devicemarkerPoint" @click="look(item,index)" @open="infoWindowOpen"></bm-marker>
                                <bm-info-window :position="{lng:form.dePoint.lng,lat:form.dePoint.lat}" :show="infoWindow.show" @close="infoWindowClose" @open="infoWindowOpen" :offset="{height: -10}">
                                    <div style="width: 350px;display: flex;justify-content: space-between;padding-top: 12px">
                                        <div>
                                            <div class="font">
                                                <div class="font2">设备序列号：{{ form.devicename || '--' }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;报警信息：{{ form.warning || '--' }}</div>
                                            </div>
                                            <div class="font">
                                                坐标：
                                                <div class="font2">经度:{{ form.dePoint.lng || '--' }}&nbsp;&nbsp;&nbsp;&nbsp;纬度:{{ form.dePoint.lat || '--' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </bm-info-window>
                            </div>
                        </div>
                    
                        <!-- 绘制多个点 -->
                        <div v-else>
                            <div v-for="item,index in polylinePath" :key="index">
                                <!-- <bm-marker :key="item.devicename" :position="item.devicemarkerPoint" @click="look(item)" @open="infoWindowOpen"></bm-marker> -->
                                <bm-marker :key="index" :position="item.historyDataPoint" @click="look_history(item,index)" @open="infoWindowOpen"></bm-marker>
                                <bm-info-window :position="{lng:form_history.dePoint.lng,lat:form_history.dePoint.lat}" :show="infoWindow.show" @close="infoWindowClose" @open="infoWindowOpen" :offset="{height: -10}">
                                    <div style="width: 350px;display: flex;justify-content: space-between;padding-top: 12px">
                                        <div>
                                            <div class="font">
                                                <div class="font2">设备序列号：{{ form_history.devicename || '--' }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;报警信息：{{ form_history.warning || '--' }}</div>
                                            </div>
                                            <div class="font">
                                                坐标：
                                                <div class="font2">经度:{{ form_history.dePoint.lng || '--' }}&nbsp;&nbsp;&nbsp;&nbsp;纬度:{{ form_history.dePoint.lat || '--' }}</div>
                                            </div>
                                            <div class="font">
                                                时间：
                                                <div class="font2">{{ form_history.time || '--' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </bm-info-window>
                            </div>
                        </div>
                    
                    
                        <!-- 绘制历史轨迹 -->
                        <bm-polyline :path="polylinePaths" stroke-color="blue" :stroke-opacity="0.5" :stroke-weight="3" :show="polylinePath_flag"></bm-polyline>
                
                        <!-- 缩略图 -->
                        <bm-overview-map anchor="BMP_ANCHOR_BOTTOM_RIGHT" :isOpen="true"></bm-overview-map>

                        <!-- 在地图中添加可编辑的多边形 -->
                        <bm-polygon v-if="show_flag" :path="polygonPath" stroke-color="blue" :stroke-opacity="0.3" :stroke-weight="1"></bm-polygon>
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

const pubTopic = "device";      //发布主题
const subTopic = "aye";         //订阅主题

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
            normal_flag: true,
            value1: 500,
            client: {},
            // 十个坐标表示历史轨迹
            polylinePath:[],
            polylinePaths: [],
            device: "0",
            historyPoint: 10,
            historyPointArr: [5,10,20,30],
            history_flag: false,
            marker: '隐藏标志点',
            marker_flag: false,
            polylinePath_flag: false,
            lineList:[],
            play: true,
            path: [],
            // icon: {
            //     url: 'http://api.map.baidu.com/library/LuShu/1.2/examples/car.png',
            //     size: {width: 52, height: 26},
            //     opts: {anchor: {width: 27, height:13}}
            // },
            title: "显示历史轨迹",
            powerSips: "", //轨迹名称
            
            start: "", //起点
            end: "", //终点
            speed: 20, //轨迹速度
            powerShow: true, //轨迹显示隐藏
            
            show: "显示电子围栏",
            
            today: '',
            dialogFormVisible: false,
            historyFormVisible: false,
            name:"",
            card:"j20001",
            card_id: "",
            card_keeper: "等待读取",
            addCard_flag: true,
            swipe_flag: false,
            dataFromDev: {},
            time:20,
            // formLableWidth: '120px',
            
            // 信息窗口
            infoWindow:{
                show: false
            },
            ediotVisible: false,
            // 遍历的坐标点
            // devicemarkers: [{
                //     devicename: "",
                //     devicemarkerPoint: {lng: "", lat: ""},
                // }],
            devicemarkers:[],
            devicemarkers_key: [],
            devicemarkers_key_sort: [],
            device_position:{},
            historyData: [],
            form: {
                devicename: "", 
                dePoint:{lng: "", lat: ""}
            },
            form_history: {
                devicename: "", 
                dePoint:{lng: "", lat: ""},
                time: ""
            },
            polygonPath: [
                // {lng: 113.539882, lat: 23.111634},  //左上角
                // {lng: 113.539882, lat: 23.107134},  //左下角
                // {lng: 113.544382, lat: 23.107134},  //右下角
                // {lng: 113.544382, lat: 23.111634},  //右上角

                // {lng: 113.542132-this.value1*0.0000045, lat: 23.109384+this.value1*0.0000045},  //左上角
                // {lng: 113.542132-this.value1*0.0000045, lat: 23.109384-this.value1*0.0000045},  //左下角
                // {lng: 113.542132+this.value1*0.0000045, lat: 23.109384-this.value1*0.0000045},  //右下角
                // {lng: 113.542132+this.value1*0.0000045, lat: 23.109384+this.value1*0.0000045},  //右上角
            ]
        }
    },
    created(){
        this.axios();

    },
    watch:{

    },
    mounted(){
        this.handler();
        setInterval(() => {
            if(this.marker_flag == false){
                this.handler();
            }
        }, 2000); 
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
            let dataFromDev = {}
            this.dataFromDev = JSON.parse(message)
            this.read();
            // console.log(dataFromDev)
        })

    },
    methods:{
        handleConfirm ({ item }) {
            this.queryString = `${item.value.city}${item.value.district}${item.value.business}` 
            this.querySearch(this.queryString)
        },
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
                url: '/LM.php'
            }).then(res=>{
                let msg = JSON.parse(JSON.stringify(res.data));
                // console.log(res.data)
                // console.log(msg.users)
                // 将获取的数据转化为字符串
                const str = (msg.users[msg.users.length-1].GPS).toString();
                // console.log(str);
                // 根据空格分隔字符
                // that.center.lng = str.split(' ')[1];//经度
                // that.center.lat = str.split(' ')[0];//纬度
                // console.log(that.center.lng);
                // console.log(that.center.lat);
                this.center.lng = str.split(' ')[1];//经度
                this.center.lat = str.split(' ')[0];//纬度
                // console.log(this.center.lng);
                // console.log(this.center.lat);
                //测试数据
                // that.center.lng = 113.543
                // that.center.lat = 23.108

                // 循环显示点对象
                this.devicemarkers = [];
                this.devicemarkers_key = [];
                this.devicemarkers_key_sort = [];

                for (let i = 0; i < msg.users.length; i++) {
                    let str = msg.users[i].GPS;
                    let key = msg.users[i].devicename.trim();
                    if(i>0){
                        let index = this.devicemarkers_key.indexOf(key)
                        if(index != -1){
                            this.devicemarkers_key.splice(index,1)
                            this.devicemarkers.splice(index,1)
                        }
                    }
                    this.devicemarkers_key.push(key)
                    msg.users[i].longitude = str.split(' ')[1]
                    msg.users[i].latitude  = str.split(' ')[0]
                    var list = {
                        devicename: msg.users[i].devicename,
                        warning: msg.users[i].warning,
                        devicemarkerPoint: { lng: msg.users[i].longitude, lat: msg.users[i].latitude}
                    }
                    this.devicemarkers.push(list);
                    // var point = new BMap.Point(msg.users[i].GPS[1], msg.users[i].GPS[0])
                    // var marker = new BMap.Marker(point);//创建标注
                    // map.addOverlay(marker);
                }
                this.devicemarkers_key_sort = this.devicemarkers_key.sort()
                // console.log(this.devicemarkers_key)
                // console.log(this.devicemarkers)

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
        machineposition(){
            //重新显示初始标志点
            this.handler()
            this.normal_flag = true;
            //将显示/隐藏标志位的功能重置
            this.marker_flag = true;
            this.markerPoint()
            //清空历史轨迹的线
            this.polylinePaths = [];
        },

        password(){
            this.$prompt('请输入密码', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            inputPattern: /123456/,
            inputErrorMessage: '密码错误'
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: '密码正确',
                    center: true
                });
                this.dialogFormVisible = true
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '取消输入',
                    center: true
                });       
            });
        },

        addName(){    
            let that = this;
            let nameRegExp = /^[a-zA-Z0-9]{1,10}$/
            axios({
                method: 'post',
                url: "/LM.php",
                headers:{
                    'Content-type': 'application/x-www-form-urlencoded'
                },
                data:{
                    action: 'read_device',
                    devicename: that.name,
                },
            }).then((res)=>{
                let data = res.data.devices;

                if(that.name == ''){
                    this.$message({
                        message: '设备序列号不能为空',
                        type: 'error',
                        offset: 200,
                        center: true
                    });
                }else if(data.length == 1){
                    this.$message({
                        message: '设备序列号已存在',
                        type: 'error',
                        offset: 200,
                        center: true
                    })
                }else if(!nameRegExp.test(that.name)){
                    wx.showToast({
                        title: '设备序列号应由1~10字母和数字组成!',
                        icon: 'error',
                        offset: 200,
                        center: true
                    })
                }else{
                    axios({
                        method: "post",
                        url: "/LM.php",
                        headers:{
                            'Content-type': 'application/x-www-form-urlencoded'
                        },
                        data:{
                            action: 'insert',
                            devicename: that.name,
                            // GPS: 'wewew',
                            // warning: '0'
                        },
                    }).then((res)=>{
                        //发布主题
                        let message = {"devicename":that.name}
                        let msg = 'j1' + JSON.stringify(message);
                        //发布话题
                        this.client.publish(pubTopic,msg,function(err){
                            // if(!err){
                            //     console.log('成功发布pubPort')
                            // }
                        })
                        that.name = ''

                        this.$message({
                            message: '成功添加',
                            type: 'success',
                            offset: 200,
                            center: true
                        });
                    })
                }
            })
        },

        confirm(){
            let message = {"card":this.card}
            let msg = JSON.stringify(message);
            //发布话题
            this.client.publish(pubTopic,msg,function(err){
                // if(!err){
                //     console.log('成功发布pubPort')
                // }
            })
            this.$message({
                message: '已确认',
                type: 'success',
                offset: 200,
                center: true
            });
        },

        read(){
            // this.dataFromDev = dataFromDev
            let card_id = this.dataFromDev.warning
            // console.log(card_id)
            if(card_id > 10){
                this.swipe_flag = true          //该标志位用于判断是否已经刷过卡
                this.card_id = card_id - 10
                // console.log(this.card_id)
                axios({
                    method: "post",
                    url: "/LM.php",
                    // url: "/LMsy.php",
                    headers:{
                        'Content-type': 'application/x-www-form-urlencoded'
                    },
                    data:{
                        action: 'read_card',
                        card_id: this.card_id
                    },
                }).then((res)=>{
                    let card = JSON.parse(JSON.stringify(res.data));
                    if(card.cards.length != 0){
                        this.addCard_flag = true;
                        this.card_keeper = card.cards[0].username;
                    }else{
                        this.addCard_flag = false;
                        this.card_keeper = "";
                    }
                })
            }else{
                // this.$message({
                //     message: '未刷卡',
                //     type: 'error',
                //     offset: 200,
                //     center: true
                // });
                if(this.swipe_flag == false){
                    this.card_id = '未刷卡'
                    this.card_keeper = '等待读取'
                }
            }
        },

        cardKeeper(){
            let cardRegExp = /^[a-zA-Z0-9]{1,10}$/
            if(this.card_keeper == ''){
                this.$message({
                    message: '持卡人不能为空',
                    type: 'error',
                    offset: 200,
                    center: true
                });
            }else if(!cardRegExp.test(this.card_keeper)){
                this.$message({
                    message: '持卡人格式错误',
                    type: 'error',
                    offset: 200,
                    center: true
                });
            }else{
               axios({
                method: "post",
                url: "/LM.php",
                headers:{
                    'Content-type': 'application/x-www-form-urlencoded'
                },
                data:{
                    action: 'insert_card',
                    card_id: this.card_id,
                    username: this.card_keeper,
                },
                }).then((res)=>{
                    this.$message({
                        type: 'success',
                        message: '成功添加',
                        offset: 200,
                        center: true
                    });
                }) 
            }
            
        },

        timeInterval(){
            let message = {"time":this.time}
            let msg = JSON.stringify(message);
            //发布话题
            this.client.publish(pubTopic,msg,function(err){
                // if(!err){
                //     console.log('成功发布pubPort')
                // }
            })
            this.$message({
                message: '成功修改',
                type: 'success',
                center: true
            });
        },

        dialogFormVisibleClose(){
            this.dialogFormVisible = false;
            this.name = ''
            this.card_id = '等待读取'
            this.card_keeper = '等待读取'
        },

        gouserIndex(){
            this.$router.push('/userIndex')
        },
        historyposition(){
            // console.log(this.history_flag)
            // this.sum=0;
            // this.polylinePath = [];  
            let that= this
            that.play=true
            // let historyData = []
            let device = this.device                //设备序列号
            let historyPoint = this.historyPoint    //历史个数点，用于给用户选择显示多少个点
            this.normal_flag = false
            axios({
                method: 'GET',
                url: '/LM.php'
            }).then(res=>{
                this.historyData = [];
                let msg = JSON.parse(JSON.stringify(res.data));
                // console.log(device)
                for(let i=0; i<msg.users.length; i++){
                    let str = msg.users[i].GPS;
                    msg.users[i].longitude = str.split(' ')[1]
                    msg.users[i].latitude  = str.split(' ')[0]

                    if((msg.users[i].devicename).trim() == device){
                        var list = {
                            devicename: msg.users[i].devicename,
                            warning: msg.users[i].warning,
                            historyDataPoint: { lng: msg.users[i].longitude, lat: msg.users[i].latitude},
                            time: msg.users[i].time
                        }
                        this.historyData.push(list);
                    }
                }
                
                // console.log(res.data)
                // console.log(msg.users)
                // console.log(this.historyData)

                this.polylinePath = [];
                if(this.historyData.length > historyPoint){
                    for(let i=this.historyData.length-historyPoint; i<this.historyData.length; i++){
                        this.polylinePath.push(this.historyData[i])
                    }
                }else{
                    for(let i=0; i<this.historyData.length; i++){
                        this.polylinePath.push(this.historyData[i])
                    }
                }
                console.log(this.polylinePath);

                // 循环显示轨迹
                this.polylinePath_flag = !this.polylinePath_flag;
                this.polylinePaths=[];
                for(let i = 0; i < this.polylinePath.length; i++){
                    // arr.push(new BMap.Point(this.polylinePath[i].historyDataPoint))
                    this.polylinePaths.push(this.polylinePath[i].historyDataPoint)
                }
                console.log(this.polylinePaths)
            })
        },
        
        look(item,index){
            this.infoWindow.show = true;
            this.form.devicename = this.devicemarkers[index].devicename;
            this.form.warning = this.devicemarkers[index].warning;
            this.form.dePoint = this.devicemarkers[index].devicemarkerPoint;
        },

        look_history(item,index){
            this.infoWindow.show = true;
            this.form_history.devicename = this.polylinePath[index].devicename;
            this.form_history.warning = this.polylinePath[index].warning;
            this.form_history.dePoint = this.polylinePath[index].historyDataPoint;
            this.form_history.time = this.polylinePath[index].time;
        },

        // 信息窗口
        infoWindowClose(e){
            this.infoWindow.show = false;
        },
        infoWindowOpen(e){
            this.infoWindow.show = true;
        },
        // 历史轨迹
        historyline(k){
            // axios({
            //     url: '/LM.php',
            //     method: 'GET',
            // }).then(res =>{
            //     let msg = JSON.parse(JSON.stringify(res.data));
            //     console.log(res.data)
            //     console.log(msg.users)
            //     // 将获取的数据转化为字符串
            //     const str = (msg.users[msg.users.length-1].GPS).toString();
            //     console.log(str);
            //     // 循环显示轨迹
            //     let arr=[];
            //     for(var i = 0; i < this.path.length; i++){
            //         arr.push(new BMap.Point(msg.users[i].GPS.split(' ')[1], msg.users[i].GPS.split(' ')[0]))

            //     }
            //     this.polyline = new BMap.Polyline(arr, {strokeColor: "blue", strokeWeight: 2, strokeOpacity: 0.5});
            //     this.map.addOverlay(this.polyline);
            //     this.show = false;
            // })            
        },

        //显示隐藏标志点
        markerPoint(){
            this.marker_flag = !this.marker_flag
            if(this.marker_flag){
                this.marker = "显示标志点"
                this.devicemarkers = [];
                this.polylinePath = [];
            }else{
                this.marker = "隐藏标志点"
                if(this.normal_flag){
                    this.handler()
                }else{
                    this.historyposition()
                }
            }
        },
        
        //选择范围
        chooseRange(){
            this.choose_flag = !this.choose_flag
        },
        
        //显示/隐藏范围
        showRange(){
            this.show_flag = !this.show_flag
            //将中心点的经纬度从string转换成number
            this.center.lng = Number(this.center.lng)
            this.center.lat = Number(this.center.lat)
            if(this.show_flag){
                this.show = "隐藏电子围栏"
                this.polygonPath = [
                    // {lng: 113.542132-this.value1*0.0000045, lat: 23.109384+this.value1*0.0000045},  //左上角
                    // {lng: 113.542132-this.value1*0.0000045, lat: 23.109384-this.value1*0.0000045},  //左下角
                    // {lng: 113.542132+this.value1*0.0000045, lat: 23.109384-this.value1*0.0000045},  //右下角
                    // {lng: 113.542132+this.value1*0.0000045, lat: 23.109384+this.value1*0.0000045},  //右上角
                    {lng: this.center.lng-this.value1*0.0000045, lat: this.center.lat+this.value1*0.0000045},  //左上角
                    {lng: this.center.lng-this.value1*0.0000045, lat: this.center.lat-this.value1*0.0000045},  //左下角
                    {lng: this.center.lng+this.value1*0.0000045, lat: this.center.lat-this.value1*0.0000045},  //右下角
                    {lng: this.center.lng+this.value1*0.0000045, lat: this.center.lat+this.value1*0.0000045},  //右上角
                ]
            }else{
                this.show = "显示电子围栏"
                this.polygonPath = []
            }
        },

        //改变范围时触发
        changeValue(){
            if(!this.show_flag){
                this.showRange()
            }else{
                this.showRange()
                this.showRange()
            }
        },
        loginout(){
            this.$router.push('/login');
        },
        // 刷新定位
        nowposition(){

        },
                // 清楚所有的轨迹和标志点
        // clearOverlay(){
        //     let allOverlay = this.map.getOverlays();
        //     for (var i = 0; i < allOverlay.length; i++){
        //         if(allOverlay[i].toString().indexOf("Marker") > 0){//删除标志点
        //             this.map.removeOverlay(allOverlay[i]);
        //         }
        //         if(allOverlay[i].toString().indexOf("Polyline") > 0){//删除折线
        //             this.map.removeOverlay(allOverlay[i]);
        //         }
        //     }
        // },

  
        // reset(){
        //     this.play=false
        // }
    },
    // 销毁定时器
    beforeDestroy(){
        clearTimeout(this.times());
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
    height: 9%;
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
    height: 92%;
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
    background-color: #ffffff;
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


/* 信息窗口中的内容 */
.font{
    display: flex;
}
.fontimg{
    width: 20px;
    height: 20px;
    background-image: url('../assets/ediot.png');
    background-repeat: no-repeat;
    background-size: 100%;
}
.fontimg:hover{
    width: 20px;
    height: 20px;
    background-repeat: no-repeat;
    background-size: 100%;
    background-image: url('../assets/ediotblue.png');
}
.font2{
    width: 300px;
    height: 25px;
    /* background-color: rgb(224, 149, 149); */
    line-height: 25px;
    margin-bottom: 5px;
}

.history{
    width: 120px;
    height: 35px;
    /* background-color: #30373b; */
    display: flex;
    margin-top: 15px;
}
.historyimg{
    width: 18px;
    height: 18px;
    background-image: url('../assets/history.png');
    background-repeat: no-repeat;
    background-size: 100%;
    margin-top: 10px;
}
.historyimg:hover{
    background-image: url('../assets/historyhover.png');

}
.historytext{
    color: #30373b;
}
.historytext:hover{
    color: #39a8e9;

}
.newposition{
    width: 120px;
    height: 35px;
    /* background-color: #30373b; */
    margin-top: 15px;
    display: flex;
}

.noepositonimg{
    width: 18px;
    height: 18px;
    background-image: url('../assets/reset.png');
    background-repeat: no-repeat;
    background-size: 100%;
    margin-top: 10px;
}
.noepositonimg:hover{
    background-image: url('../assets/resethover.png');
}
.nowpositiontext{
    color: #30373b;
}
.nowpositiontext:hover{
    color: #39a8e9;
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
