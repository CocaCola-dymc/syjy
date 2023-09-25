<template>
  <div class="home_container">
      <!-- 头部区域 -->
      <div class="header" :class="headerFixed == true ? 'navBarWrap' : ''" :style="style">
          <!-- logo -->
          <div class="logo">
              <h2>水域救援系统</h2>
          </div>
          <!-- 用户界面 -->
          <div class="user">
              <!-- <img src="../assets/userimage.jpg"> -->
              <!-- <p>nianqingren</p>         -->
              <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>        
          </div>
      </div>
      <!-- 页面内容 -->
      <div class="container">
        <!-- 侧边栏 -->
        <!-- <div class="aside">
          <div class="nav">
            <el-menu
              router
              :default-active="$route.path"
              class="el-menu-vertical-demo"
              background-color="#222d32"
              text-color="white"
              active-text-color="rgb(43, 153, 212)"
              style="width:180px;height:100%;"
            >
              <el-menu-item index="/gpsshow">
                <i class="el-icon-location"></i>
                <span slot="title">实时定位</span>
              </el-menu-item>
              <el-menu-item index="/alertcontent">
                <i class="el-icon-message-solid"></i>
                <span slot="title">报警信息</span>
              </el-menu-item>
              <el-menu-item index="/cardmanage">
                <i class="el-icon-postcard"></i>
                <span slot="title">卡片管理</span>
              </el-menu-item>
            </el-menu>
          </div>
        </div> -->
        <!-- 中间内容 -->
        <div class="message">
            <!-- <p>这是中间部分</p> -->
            <div class="headtitle">欢迎使用水域救援系统</div>
            <div class="classical">
              <div class="functionbox" @click="gpsshow">
                <li class="location"></li>
                <div class="title_location">实时定位</div>
              </div>
              <div class="functionbox" @click="alertcontent">
                <li class="alarm"></li>
                <div class="title_alarm">报警信息</div>
              </div>
              <div class="functionbox" @click="cardmanage">
                <li class="card"></li>
                <div class="title_card">卡片管理</div>
              </div>
            </div>
        </div>
      </div>
  </div>
  
</template>

<script>
  export default {
    data() { 
        return {
            dataapi: [],
            headerFixed: false,
            style:{},
            opacity: 0,
            client:{},
        };
  },
  methods: {
    // 标签页面跳转
    gpsshow(){
      this.$router.push('/gpsshow')
    },
    alertcontent(){
      this.$router.push('/alertcontent')
    },
    cardmanage(){
      this.$router.push('/cardmanage')
    }
  },
  mounted: function(){

  },

  
}; 

</script>


<style scoped>
*{
  padding:0;
  margin:auto;
}
html,body,.home_container{
  height: 100%;
}
body{
  min-width: 1441px;
  min-height: 752px;
}
li{
  list-style:none;
}

.home_container{
  width:100%;
  height: 90%;
  margin: 0 auto;
}

/* 头部区域 */
.header{
  width:100%;
  height: 10%;
  display:flex;
  justify-content: space-between;
  background-color: #30373b;

}
.logo{
  margin-left: 40px;
  color: white;
  font-size: 32px;
  user-select: none;
}
.user{
margin-right: 40px;
display:flex;
justify-content: space-between;
}
.user p{
  color:white;
}
.user img{
width: 50px;
height: 50px;
border-radius: 50%;
overflow: hidden;
margin-right: 10px;  
}

/* 内容区域（包括导航栏） */
.container{
  /* height:682px; */
  height: 100%;
  background-color: #d9dbdb;
  width:100%;
  display:flex;
  /* flex: 1; */
}
.aside{
  /* height:682px; */
  height: 100%;
  margin-left:0;
  margin-right:0;
  background-color: #acaeae;
}

.nav{
  background-color:#B3C0D1;
  height:100%;
  /* height:682px; */
}
.message{
  background: url(../assets/background.png) no-repeat center;
  background-size: cover;
  width:100%;
  /* height:675px; */
  height: 99%;
  /* width:85.35%; */
  /* height:100%; */
  /* float:left; */
  margin-left:5px;
  margin-top:5px;

}


.headtitle{
  margin-top: 50px;
  font-size: 72px;
  font-weight: bold;
  /* 文字之间的间隔 */
  letter-spacing: 24px;
  text-shadow: white 3px 0 0, white 0 3px 0, white -3px 0 0, white 0 -3px 0;
  /* 文字不可被选中 */
  user-select: none
}

/* 功能显示区域 */
.classical{
  display: flex;
  margin-top: 100px;
  height:270px;
  width: 80%;
  /* background-color:gray; */
}
.functionbox{
  width: 350px;
  height: 270px;
}
.classical li{
  height:200px;
  width:350px;
  border-radius: 20px;
}

.location{
  /* background-image: linear-gradient(to top, #27d758, #a7d91b); */
  background: url('../assets/location.jpeg') no-repeat center;
  background-size: cover;
}
.alarm{
  /* background-image: linear-gradient(to top, #ef2982, #f696eb); */
  background: url('../assets/alarm.jpeg') no-repeat center;
  background-size: cover;
}
.card{
  /* background-image: linear-gradient(to top, #fda001, #ffc164); */
  background: url('../assets/card.jpeg') no-repeat center;
  background-size: cover;
}

.title_location{
  font-size:35px;
  font-weight: bold;
  color:#34ba06;
  height:70px;
  width:50%;
  line-height:70px;
  user-select: none
}
.title_alarm{
  font-size:35px;
  font-weight: bold;
  color:#f45821;
  height:70px;
  width:100%;
  line-height:70px;
  user-select: none
}
.title_card{
  font-size:35px;
  font-weight: bold;
  color:#ff8a00;
  height:70px;
  width:100%;
  line-height:70px;
  user-select: none
}
.Num{
  font-size:80px;
  color:white;
  height:100px;
  width:100%;
  line-height:100px;
  text-align:center;
  /* margin-top:45px; */
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
</style>