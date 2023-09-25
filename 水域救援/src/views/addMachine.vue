<template>
    <div class="home_container">
        <!-- 头部区域 -->
        <div class="header" ref="head" :class="headFixed?'isFixed':''">
            <!-- 项目名称 -->
            <div class="proname">
                <h2>水域救援系统</h2>
            </div>
            <!-- 用户 -->
            <div class="users">
                <!-- 下拉菜单 -->
                <el-row class="block-col-2">
                    <el-col :span="12">
                        <el-dropdown class="my-el-dropdown">
                            <span class="el-dropdown-link">
                                <!-- <img src="../assets/userimage.jpg"> -->
                            </span>
                            <!-- 表单 -->
                            <!-- <el-dropdown-menu slot="dropdown" class="my-el-dropmenu">                            
                                <el-button type="text" @click="addmachine">
                                    <el-dropdown-item icon="el-icon-plus" >参数设置</el-dropdown-item>
                                </el-button>
                            </el-dropdown-menu> -->
                        </el-dropdown>
                    </el-col>
                </el-row>
                <!-- <img src="../assets/userimage.jpg" alt=""> -->
                <!-- <p>nianqingren</p> -->
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </div>
        </div>
        
        <!-- 内容部分 -->
        <div class="containbox">
            <!-- 侧边导航栏 -->
            <div class="asidebox">
                <div class="navbox">
                    <el-menu
                        router
                        :default-active="$route.path"
                        class="el-menu-vertical-demo"
                        background-color="#222d32"
                        text-color="white"
                        active-text-color="rgb(43, 153, 212)"
                        style="width:180px;height:100%;"
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
                        <el-menu-item @click="dialogFormVisible = true">
                            <i class="el-icon-s-tools"></i>
                            <span slot="title">参数设置</span>
                        </el-menu-item>
                    </el-menu>
                </div>
            </div>
            <!-- 中间内容 -->
            <div class="msg">

                <!-- 百度地图 -->
                <div class="Map">
                    <baidu-map
                    :center="center"
                    :zoom="zoom"
                    :scroll-wheel-zoom="true"
                    style="width:99.8%;height: 99%;margin-left: 10px;"
                    @ready="handler"
                    @click="getClickInfo"
                    @moving="syncCenterAndZoom"
                    @moveend="syncCenterAndZoom"
                    @zoomend="syncCenterAndZoom"
                    >
                    <!-- 必须给容器指高度，不然地图将显示在一个高度为0的容器中，看不到 -->
                        <bm-navigation anchor="BMAP_ANCHOR_TOP_RIGHT"></bm-navigation>
                        <bm-geolocation
                        anchor="BMAP_ANCHOR_BOTTOM_LEFT"
                        :showAddressBar="true"
                        :autoLocation="true"
                        >     
                        </bm-geolocation>
                        <bm-city-list anchor="BMAP_ANCHOR_TOP_LEFT"></bm-city-list>
                    <!-- 绘制坐标点 -->
                        <bm-marker :position="center" :dragging="false" animation="BMP_ANIMATION_BOUNCE"></bm-marker> 

                    <!-- 缩略图 -->
                        <bm-overview-map anchor="BMP_ANCHOR_BOTTOM_RIGHT" :isOpen="true"></bm-overview-map>
                    </baidu-map>
                </div>
            </div>
        </div>

        <!-- 底部部分 -->
        <div class="foot">

        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data(){
        return{
            offsetTop: 0,
            offsetHeight: 0,
            headFixed: 0,
            // 地图信息
            address: null,
            center: { lng: "", lat: "" },
            //地图展示级别
            zoom: 11,
            client: {},
        }
    },

    methods:{
        //获取后台数据
        handler({ BMap ,map }){
            let that =this;
            axios({                
                method: "get",
                url:"/zhandian.php"
            }).then(res =>{               
                // 解决数据格式{_ob_:Observe}问题
                let msg = JSON.parse(JSON.stringify(res.data));
                console.log(res.data);
                console.log(msg.users);
                // 获取数组字段长度
                console.log(msg.users.length);
                console.log(msg.users[msg.users.length-1].temp);
                console.log(msg.users[msg.users.length-1].humi);
                console.log(msg.users[msg.users.length-1].GPS);
                // 另一种写法
                that.tempdata = msg.users[msg.users.length-1].temp;
                that.humidata = msg.users[msg.users.length-1].humi;

                // 将获取的数据转化为字符串
                const str = (msg.users[msg.users.length-1].GPS).toString();
                console.log(str);
                // str.subString(0,5);
                // 根据数据的位置分隔字符串
                // console.log(str.substring(0,15));
                // console.log(str.substring(16,31));
                // that.center.lng = str.substring(0,15);//经度
                // that.center.lat = str.substring(16,31);

                // 根据逗号分隔字符串
                console.log(str.split(',')); 
                that.center.lng = str.split(',')[0];//经度
                that.center.lat = str.split(',')[1];//纬度
                console.log(that.center.lng);
                console.log(that.center.lat);




                this.today = new Date()
            })
            // let ggPoint = new BMap.Point(that.center.lng, that.center.lat);
            // let Geocoder = new BMap.Convertor();
            // var pointArr = [];
            // pointArr.push(ggPoint);
            // Geocoder.translate(pointArr, 1 ,5 , this.translateCallback);
        },

        // 吸顶
        handleScroll(){
            // 得到页面滚动距离，兼容写法
            let scrollTop = 
                window.pageYOffset ||
                document.documentElement.scrollTop ||
                document.body.scrollTop;

            // 判断页面滚动距离是否大于吸顶元素位置
            this.headFixed = scrollTop > (this.offsetHeight - this.offsetTop);
            console.log(this.offsetTop);
            console.log(this.offsetHeight);
            console.log(this.headFixed);
            // this.headerFixed = scrollTop > 70;
        },

        // 百度地图相关组件，点击地图位置后台显示坐标
        syncCenterAndZoom(e) {
            console.log(e.target, 'e.target-->>>>')
            const { lng, lat } = e.target.getCenter();
            this.zoom = e.target.getZoom();
        },

        getClickInfo(e) {
            // 创建地理编码实例
            const myGeo = new BMap.Geocoder();
            // 根据坐标逆解析地址
            myGeo.getLocation(new BMap.Point(e.point.lng, e.point.lat), (result) => {
            console.log(result, "result-->>>>");
            if (result) {
                this.address = result.address;
            }
            });
            this.center.lng = e.point.lng;
            this.center.lat = e.point.lat;
        },

        // 添加设备
        addmachine(){
            this.$prompt('请输入产品序列号', '提示', {
                showCancelButton: true,
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                cancelButtonClass: 'messageBoxP_cancelBtn',
                confirmButtonClass: 'messageBoxP_confirmBtn',
                customClass:'mymsgadd',
                inputPattern: /[\w!#$%&'*+/=?^_`{|}~-]+(?:\.[\w!#$%&'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?/,
                inputErrorMessage: '序列号格式不正确'
                }).then(({ value }) => {
                    this.$message({
                        type: 'success',
                        message: '您的产品序列号是: ' + value,
                        duration:1000,
                        center: true
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '取消输入',
                        duration:1000,  
                        center: true                                 
                    });      
                });
        },
    },

    mounted() {
        this.$nextTick(()=>{
            // 获取顶部元素dom
            let head = this.$refs.head;
            // 吸顶元素到top的距离
            this.offsetTop = head.offsetTop;
            // 元素自身高度
            this.offsetHeight = head.offsetHeight;

            // 监听滚动条
            window.addEventListener("scroll", this.handleScroll);

        })
    },
    destroyed(){
        window.removeEventListener('scroll', this.handleScroll);
    }

  }


</script>
<style scoped>
*{
    margin: 0;
    padding: 0;
}
html,body,.home_container{
    /* height：100%后续设置有效 */
    height: 100%;
}
body{
    min-width: 1441px;
    min-height: 752px;
    /* 解决弹框出现滚动条消失的布局空缺 两条联合解决message因滚动条抖动问题 */
    padding-right: 0px !important;
    overflow-y: auto !important;
}
li{
    list-style:none;
}
/* 头部区域 */

.header{
    width: 100%;
    height: 70px;
    background-color: #30373b;
    display: flex;
    justify-content: space-between;
    line-height: 70px;
}
.isFixed{
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    z-index: 4;
}
/* 项目名称 */
.proname{
    color: white;
    margin-left: 30px;
    user-select: none
}
/* 用户头像与姓名 */
.users{
    display: flex;
    justify-content: space-between;
    margin-right: 40px;
}
.users img{
    width: 50px;
    height: 50px;
    line-height: 50px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 20px;
    margin-top: 10px;
}
.users p{
    color: white;
}
/* 下拉菜单 */
.el-dropdown-link {
  cursor: pointer;
  color: #83b5e7;
}
.el-icon-arrow-down {
  font-size: 12px;
}
.demonstration {
  display: block;
  color: #8492a6;
  font-size: 14px;
  margin-bottom: 20px;
}
.my-el-dropdown.el-dropdown /deep/ {
    height: 60px !important;
}

/* 修改菜单背景色 */
.el-dropdown-menu /deep/{
    /* cursor: pointer; */
    color: white;
    background-color: #f1f3f0;
}

.el-dropdown-menu__item:hover /deep/{
    background-color: #a4b4cf !important;
    color: rgb(72, 72, 72) !important;
}


/* 内容部分 */
.containbox{
    display: flex;
    width: 100%;
    height: 100%;
    background-color: rgb(244, 242, 242);
    /* justify-content: space-between; */
}

/* 侧边栏 */
.asidebox{
    /* height:682px; */
    height: 100% ;
    width: 180px;
    margin-left:0;
    margin-right:0;
    background-color: #acaeae;
}

.navbox{
    background-color:#B3C0D1;
    height:100% !important;
    /* height:682px; */
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

.navbox.el-menu-vertical-demo.el-menu /deep/{
  border-right: none !important;
  background-color:#B3C0D1 !important;
  position:fixed !important;
  height:100% !important;
  /* 去除白色边框 */
  border: 0!important;
}
.msg{
    background-color:white;
    width:100%;
    /* height:675px; */
    height: 99%;
    /* width:85.35%; */
    /* height:100%; */
    /* float:left; */
    margin-left:5px;
    margin-top:5px;
    /* justify-content: space-between; */
}

/* 百度地图 */
.Map{
    width: 99%;
    height: 99%;
    margin-top: 10px;
    /* padding-left: 15px; */

}
/* 底部部分 */
.foot{
    width: 100%;
    height: 100px;
    background-color: black;
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