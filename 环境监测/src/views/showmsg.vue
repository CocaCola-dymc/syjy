<template>
    <div class="msg_home">
        <div class="msgtopbox">
            <div class="topnamebox">
                <h1>环境监测</h1>
            </div>
            <!-- <div class="topmsgbox">
                <div class="userimgbox">
                    <img src="../assets/userimg.jpg" alt="">
                </div>
                <div class="username">
                    <h4>yonghumingchen</h4>
                </div>           
            </div> -->
        </div>
        <div class="container">
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
            <!-- 中间区域 -->
            <div class="middlebox">
                <div class="title">
                    <span>环境实时在线监测系统</span>
                </div>
                <div class="datetime">
                    <div class="date">{{ fulldate }}</div>
                    <div class="currenttime">{{ currentTime }}</div>
                </div>
                <div class="databox">
                    <div class="databox_left">
                        <div class="data">
                            <img class="icon" src="../assets/temp.png">
                            <div class="text">环境温度：</div>
                            <div class="num">{{ temp }}°C</div>
                        </div>
                        <div class="data">
                            <img class="icon" src="../assets/humi.png">
                            <div class="text">环境湿度：</div>
                            <div class="num">{{ humidity }}%</div>
                        </div>
                        <div class="data">
                            <img class="icon" src="../assets/atmopress.png">
                            <div class="text">大气压强：</div>
                            <div class="num">{{ atmos }}Kpa</div>
                        </div>
                        <div class="data">
                            <img class="icon" src="../assets/windspeed.png">
                            <div class="text">风速：</div>
                            <div class="num">{{ windspeed }}m/s</div>
                        </div>
                        <div class="data">
                            <img class="icon" src="../assets/windydirection.png">
                            <div class="text">风向：</div>
                            <div class="num">{{ winddirection }}</div>
                        </div>
                        <div class="data">
                            <img class="icon" src="../assets/nvh.png">
                            <div class="text">环境噪声：</div>
                            <div class="num">{{ noisy }}dB</div>
                        </div>
                    </div>
                    <div class="databox_right">
                        <div class="data">
                            <img class="icon" src="../assets/PM2.5.png">
                            <div class="text">PM2.5：</div>
                            <div class="num">{{ pm2_5 }}ppm</div>
                        </div>
                        <div class="data">
                            <img class="icon" src="../assets/PM10.png">
                            <div class="text">PM10：</div>
                            <div class="num">{{ pm10 }}ppm</div>
                        </div>
                        <div class="data">
                            <img class="icon" src="../assets/CO2.png">
                            <div class="text">CO2浓度：</div>
                            <div class="num">{{ co2 }}ppm</div>
                        </div>
                        <div class="data">
                            <img class="icon" src="../assets/O2.png">
                            <div class="text">O2浓度：</div>
                            <div class="num">{{ o2 }}ppm</div>
                        </div>
                        <div class="data">
                            <img class="icon" src="../assets/CO.png">
                            <div class="text">CO浓度：</div>
                            <div class="num">{{ co }}ppm</div>
                        </div>
                        <div class="data">
                            <img class="icon" src="../assets/H2S.png">
                            <div class="text">H2S浓度：</div>
                            <div class="num">{{ h2s }}ppm</div>
                        </div>
                    </div>
                    <div class="endtime" v-if="endtime_flag">本数据截止至：{{ createdTime }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { connect } from "mqtt";
const mqttHost = "112.124.28.149";
const mqttPort = "8083";
const mqttUrl = `ws://${mqttHost}:${mqttPort}/mqtt`;
// const pubTopic = "environment";         //发布主题
const subTopic = "environment";         //订阅主题

export default{
    data(){
        return{
            windspeed: 0,
            winddirection: "-",
            temp: 0,
            humidity: 0,
            pm2_5: 0,
            pm10: 0,
            atmos: 0,
            noisy: 0,
            o2: 0,
            co2: 0,
            co: 0,
            h2s: 0,
            client: {},
            dataFromDev: {},
            fulldate: '',
            currentTime: '',
            createdTime: '',
            endtime_flag: true,
        }
    },
    created() {

    },
    mounted() {
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
            this.endtime_flag = false
            let dataFromDev = {}
            dataFromDev = JSON.parse(message)
            this.windspeed = dataFromDev.windspeed
            this.winddirection = dataFromDev.winddirection
            this.temp = dataFromDev.temp
            this.humidity = dataFromDev.humidity
            this.pm2_5 = dataFromDev.pm2_5
            this.pm10 = dataFromDev.pm10
            this.atmos = dataFromDev.atmos
            this.noisy = dataFromDev.noisy 
            this.o2 = dataFromDev.o2
            this.co2 = dataFromDev.co2  
            this.co = dataFromDev.co
            this.h2s = dataFromDev.h2s
        })

        this.handler();

        setInterval(() => {
            this.currenttime();
        }, 10);

        // setInterval(() => {
        //     this.send();
        // }, 10000);
    },
    methods: {
        // send(){
        //     let a = (Math.random()*50).toFixed(1)                                   //风速
        //     let arr = ['正东','东南','正南','西南','正西','西北','正北','东北']
        //     let barr = Math.ceil(Math.random()*arr.length-1)
        //     let b = arr[barr]                                                       //风向
        //     let c = (Math.random()*80 - 40).toFixed(1)                              //温度
        //     let d = (Math.random()*100).toFixed(1)                                  //湿度
        //     let e = (Math.random()*20).toFixed(1)                                   //pm2.5
        //     let f = (Math.random()*20).toFixed(1)                                   //pm10
        //     let g = (Math.random()*200 + 900).toFixed(1)                            //大气压强
        //     let h = (Math.random()*100).toFixed(1)                                  //噪音
        //     let i = (Math.random()*2 + 19).toFixed(1)                               //o2
        //     let j = Math.floor(Math.random()*3 + 2)/100
        //     let k = Math.floor(Math.random()*3 + 2)/100
        //     let l = Math.floor(Math.random()*3 + 2)/100             

        //     let msg = {"windspeed":a, "winddirection":b, "temp":c, "humidity":d, "pm2_5":e, "pm10":f, "atmos":g, "noisy":h, "o2":i, "co2":j, "co":k, "h2s":l}
        //     let message = JSON.stringify(msg)
        //     this.client.publish(pubTopic,message,function(err){
        //         if(!err){
        //             console.log('发布成功')
        //         }
        //     })
        // },
        handler () {
            axios({
                method: 'GET',
                url: '/LMhj.php'
            }).then(res=>{
                let msg = JSON.parse(JSON.stringify(res.data));
                // console.log(res.data)
                // console.log(msg.users)
                // 将获取的数据转化为字符串
                let index = msg.users.length-1
                this.windspeed = msg.users[index].windspeed
                this.winddirection = msg.users[index].winddirection
                this.temp = msg.users[index].temp
                this.humidity = msg.users[index].humidity
                this.pm2_5 = msg.users[index].pm2_5
                this.pm10 = msg.users[index].pm10
                this.atmos = msg.users[index].atmos
                this.noisy = msg.users[index].noisy 
                this.o2 = msg.users[index].o2
                this.co2 = msg.users[index].co2  
                this.co = msg.users[index].co
                this.h2s = msg.users[index].h2s
                this.createdTime = msg.users[index].createdTime

            })
        },
        
        currenttime(){
            let datetime = new Date()
            let year = datetime.getFullYear()
            let month = datetime.getMonth() + 1
            let date = datetime.getDate()
            let arr = ['日','一','二','三','四','五','六']
            let week = datetime.getDay()
            let day = arr[week]
            let hour = datetime.getHours()
            let minute = datetime.getMinutes()
            let second = datetime.getSeconds()
            if (month < 10){
                month = '0' + month
            }
            if (date < 10){
                date = '0' + date
            }
            if(hour < 10){
                hour = '0' + hour
            }
            if(minute < 10){
                minute = '0' + minute
            }
            if(second < 10){
                second = '0' + second
            }
            let fulldate = `${year}-${month}-${date} 星期${day}`
            this.fulldate = fulldate
            let currentTime = `${hour}:${minute}:${second}`
            this.currentTime = currentTime
        }
    },
    watch: {

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
html,body, .msg_home{
    height: 100%;
    width: 100%;
}
.msgtopbox{
    height: 10%;
    width: 100%;
    background-color: rgb(40, 40, 41);
    display: flex;
    justify-content: space-between;
    color: #fff;
}
.topnamebox{
    display: flex;
    align-items: center;
    margin-left: 30px;
    font-size: 24px;
    /* 文字不可被选中 */
    user-select: none
}
/* .topmsgbox{
    display: flex;
    align-items: center;
    margin-right: 30px;
}
.userimgbox{
    width: 50px;
    height: 50px;
    margin-right: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.userimgbox img{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
} */
.container{
    background: url(../assets/environment.png) no-repeat center;
    background-size: cover;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    height: 90%;
    width: 100%;
    /* background-color: yellow; */
    font-weight: bold;
    color: #000;
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
/* 中间区域 */
.middlebox{
    width: 88.3%;
    height: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
.title{
    width: 85%;
    height: 100px;
    background-color: #5495f6;
    font-size: 64px;
    line-height: 100px;
    /* 文字之间的间隔 */
    letter-spacing: 40px;
    /* 文字不可被选中 */
    user-select: none
}
.title span{
    margin-left: 200px;
}
.datetime{
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    justify-content: center;
    width: 15%;
    height: 100px;
    background-color: #5495f6;
    font-size: 40px;
    color: #fff;
    /* 文字不可被选中 */
    user-select: none
}
.date{
    width: 85%;
    height: 40px;
    line-height: 50px;
    /* background-color: #5495f6; */
    font-size: 24px;
}
.currenttime{
    width: 100%;
    height: 40px;
    line-height: 40px;
    /* background-color: #5495f6; */
    font-size: 40px;
}
.databox{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    width: 80%;
    height: 60%;
    /* background-color: #a969c6; */
}
.databox_left{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    width: 50%;
    height: 100%;
    /* background-color: #f4cfcb; */
}
.databox_right{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    width: 50%;
    height: 100%;
    /* background-color: #41dc49; */
}
.data{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    width: 80%;
    height: 10%;
    /* background-color: #f65454; */
}
.icon{
    width: 10%;
    height: 100%;
    background-color: #5495f6;
    margin-left: 5%;
    /* 防止图片被拖拽 */
    -webkit-user-drag: none;
}
.text{
    width: 45%;
    height: 100%;
    background-color: #5495f6;
    font-size: 40px;
    font-weight: bold;
    /* 文字不可被选中 */
    user-select: none
}
.num{
    width: 40%;
    height: 100%;
    background-color: goldenrod;
    font-size: 40px;
    font-weight: bold;
    /* 文字不可被选中 */
    user-select: none;
    line-height: 60px;
}
.endtime{
    display: flex;
    justify-content: flex-end;
    font-size: 40px;
    font-weight: bold;
    
}
</style>