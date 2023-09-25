<template>
    <div class="box">
        <!-- 头部区域 -->
        <div class="header">
            <div class="headername">
                <h2>水域救援系统</h2>
            </div>
            <div class="yonghu">
                <el-row class="block-col-2">
                    <el-col :span="12">
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
                <p>nianqingren</p>
            </div>
        </div>
        <!-- 内容区域 -->
        <div class="midbox">
            <!-- 侧边栏 -->
            <div class="asidebox">
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
                </el-menu>
            </div>
            <!-- 中间内容 -->
            <div class="msgbox">
                <div class="msg">
                    <div class="usermsgbox">
                        <!-- 取消父元素的影响 -->
                        <div class="usermsgboxtop">
                            <!-- 头像 -->
                            <div class="touxiang">
                                <!-- <img src="../assets/userimage.jpg" alt=""> -->
                            </div>
                            <!-- 用户名称 -->
                            <div class="name">
                                <h1>nianqingren</h1>
                                <div class="line" @click="dialogVisible = true">
                                    <p>查看关联设备</p>
                                </div>                               
                            </div>
                        </div>
                    </div>
                    <div class="usermsgboxmid">
                        <div class="msgmid">
                            <div class="midename">
                                <h3>用户资料</h3>
                            </div>                                                     
                        </div>
                        <!-- 分隔线 --> 
                        <div class="line1"></div>
                        <div class="textbox">
                            <!-- 用户名称 -->
                            <div class="nicknamebox">
                                <p class="title1">用户名称：</p>
                                <p class="content1">nianqingren</p>
                            </div>
                            <!-- 用户ID -->
                            <div class="userid">
                                <p class="title2">用户ID：</p>
                                <p class="content2">1</p>
                            </div>
                            <!-- 用户账号 -->
                            <div class="useraccount">
                                <p class="title3">用户账号：</p>
                                <p class="content3">euodaeifiaiasndi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 关联设备弹出框 -->
        <el-dialog
            title="提示"
            :visible.sync="dialogVisible"
            width="50%"
            :before-close="handleClose">
           <!-- machine盒子 在lookbox里面写v-for="item in chineList" :key="item" 在相应的内容区域写{{ item.xx }} -->
           <div class="lookbox">
                <div class="lookarea">
                    <div class="chinebox">
                        <!-- 图片区域 -->
                        <div class="chineimg">
                            <img src="../assets/mschinepng.png" alt="">
                        </div>
                        <!-- 状态序列号区域 -->
                        <div class="chinetype">
                            <div class="idokbox">
                                <div class="chineid">
                                    <div class="chinetitle">设备序列号：</div>
                                    <div class="chinetext">DJsiofjdsifnd</div>
                                </div>
                                <div class="chineisok">
                                    <div class="chinetitle">设备状态：</div>
                                    <div class="chinetext">正常</div>
                                </div>                                
                            </div>
                            <div class="ediotbox">
                                <!-- <img src="../assets/ediot.png" alt=""> -->
                                <p class="del" @click="del">移除</p>
                                <p class="repair" @click="repair">报修</p>
                            </div>
                            <!-- 编辑框区域 -->
                                <!-- <img src="../assets/ediot.png" alt=""> -->                                                        
                        </div>  
                    </div>
                </div>
            </div>
            
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
export default{
    data(){
        return{
            dialogVisible: false
        }
    },
    methods: {
      handleClose(done) {
        this.$confirm('确认关闭？')
          .then(_ => {
            done();
          })
          .catch(_ => {});
      },
      repair() {
        this.$message('报修成功');
      },
      del() {
        this.$confirm('此操作将永久删除该设备, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.$message({
            type: 'success',
            message: '删除成功!'
          });
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除'
          });          
        });
      },
      loginout(){
        this.$router.push('/login');
      },
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
    width: 100%;
    height: 100%;
}

.header{
    width: 100%;
    height: 8%;
    background-color: #30373b;
    display: flex;
    justify-content: space-between;
}
.headername{
    color: #ffffff;
    margin-left: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.yonghu{
    margin-right: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.yonghu img{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 20px;
}
.yonghu p{
    color: #ffffff;
}
/* 内容区域 */
.midbox{
    width: 100%;
    height: 92%;
    background-color: #e9ebec;
    display: flex;
}
.asidebox{
    width: 11.7%;
    height: 100%;
    background-color: antiquewhite;
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
/* 用户信息 */
.msgbox{
    width: 88.3%;
    height: 100%;
    background-color: rgb(254, 252, 252);
    display: flex;
}
.msg{
    width: 99.75%;
    height: 99.5%;
    /* background-color: aquamarine; */
    margin-top: 2px;
    margin-left: 2px;
}
/* 用户头部信息 */
.usermsgbox{
    width: 80%;
    height: 20%;
    /* background-color: aqua; */
    margin: auto;
    /* margin-top: 10px; */
}
.usermsgboxtop{
    display: flex;
    /* justify-content: center; */
    /* align-items: center; */
}
.touxiang{
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    margin-top: 30px;
    margin-left: 30px;
    /* display: flex; */
}
.name{
    color: #1b1a1a;
    margin-top: 40px;
    margin-left: 30px;
}
.line{
    color: #30373b;
    width: 150px;
    height: 30px;
    background-color: #e9e6e69c;
    border-radius: 40px;
    line-height: 30px;
    margin-top: 10px;
}
.usermsgboxmid{
    width: 80%;
    height: 75%;
    /* background-color: #c0c381; */
    margin: auto;
    margin-top: 10px;
}
.msgmid{
    display: flex;
    
}
.midename{
    margin-top: 10px;
    margin-left: 20px;
    /* background-color: #81c3b8; */
}
.line1{
    width: 100%;
    height: 1px;
    background-color: #d4d5d5;
    margin-top: 10px;
}
.textbox{
    width: 90%;
    height: 90%;
    /* margin: auto; */
    margin-top: 10px;
    /* background-color: #a6d9f7; */
}
.nicknamebox{
    width: 100%;
    height: 70px;
    /* background-color: #30373b; */
    line-height: 70px;
    display: flex;
    margin-left: 20px;
    font-size: 18px;
    /* margin-right: 40px; */
}
.title1{
    color: gray;
}
.content1{
    margin-left: 40px;
}
.userid{
    width: 100%;
    height: 70px;
    /* background-color: #30373b; */
    line-height: 70px;
    display: flex;
    margin-left: 20px;
    font-size: 18px;
    /* margin-right: 40px; */
}
.title2{
    color: gray;
}
.content2{
    margin-left: 60px;
}
.useraccount{
    width: 100%;
    height: 70px;
    /* background-color: #30373b; */
    line-height: 70px;
    display: flex;
    margin-left: 20px;
    font-size: 18px;
    /* margin-right: 40px; */
}
.title3{
    color: gray;
}
.content3{
    margin-left: 40px;
}
/* 弹出框 */
.lookbox{
    display: flex;
    flex-direction: column;
    margin-top: 10px;

}
.lookarea{
    width: 650px;
    height: 90px;
    /* background-color: #30373b; */
    border: 1px solid #cacaca;
    margin-top: 5px;
    margin: auto;
}
.chinebox{
    display: flex;
}
.chineimg{
    width: 70px;
    height: 70px;
    margin-top: 10px;
    margin-left: 10px;
    /* border: 1px solid #cacaca; */
}
.chineimg img{
    width: 65px;
    height: 65px;
    margin-top: 2px;
    /* margin-left: 5px; */
}
.chinetype{
    width: 550px;
    height: 70px;
    /* border: 1px solid #cacaca; */
    margin-top: 10px;
    margin-left: 10px;

    display: flex;
    /* flex-direction: column; */
}
.idokbox{
    width: 400px;
    height: 70px;
}
.chineid{
    display: flex;
    width: 450px;
    height: 25px;
    line-height: 18px;
    /* font-size: 18px; */
}
.chinetitle{
    /* margin-left: 5px;
    width: 100px;
    height: 25px;
    background-color: #30373b;
    line-height: 25px;
    font-size: 16px; */
    /* margin-top: 5px; */
    margin-top: 5px;
    font-size: 16px;
}
.chinetext{
    /* width: 300px;
    height: 25px;
    line-height: 25px;
    background-color: #5faddb;
    font-size: 16px; */
    /* font-size: 18px; */
    /* margin-top: 3px; */
    /* margin-left: 10px; */
    margin-top: 5px;
    font-size: 16px;
}
.chineisok{
    display: flex;
    width: 450px;
    height: 30px;
    line-height: 18px;
}
.box1{
    width: 40px;
    height: 40px;
    background-color: #30373b;
}

.ediotbox{
    width: 250px;
    height: 45px;
    margin-top: 12px;
    /* margin-right: 15px; */
    display: flex;
    margin-left: auto;
    /* border: 1px solid #cacaca; */
    line-height: 45px;
}
.del{
    color: grey;
    margin-right: 15px;
    margin-left: 35px;
    display: none;
}
.del:hover{
    color: #1296db;
}
.repair{
    color: grey;
    display: none;
}
.repair:hover{
    color: #1296db;
}
.ediotbox img{
    width: 45px;
    height: 45px;
    display: none;
}
.chinetype:hover  .del{
    display: block;
}
.chinetype:hover .repair{
    display: block;
}

</style>