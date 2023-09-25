<template>
    <div class="home_container">
        <!-- 头部区域 -->
        <!-- @用于阻拦弹出框后页面底部滑动 -->
        <div class="header-bg"  @touchmove.prevent  @mousewheel.prevent>
            <!-- logo -->
            <div class="logo">
                <h1>水域救援系统</h1>
            </div>
            <!-- 登录、注册 -->
            <div class="role">
                <div class="login"  @touchmove.prevent @mousewheel.prevent>
                    <!-- <el-button type="text" @click="loginbox('Login')">登录</el-button> -->
                    <a @click="loginbox('Login')">登录</a>
                </div>
                
                <login-name v-if="Visiable" ref="login" center  @touchmove.prevent  @mousewheel.prevent></login-name>

                <div class="regist">
                   <!-- <el-button type="text" @click="registbox">注册</el-button>  -->
                   <a @click="registbox('Regist')">注册</a>
                </div>
                <regist-name v-if="registVisiable" ref="regist" center></regist-name>
                
            </div>

            
        </div>
        <!-- 内容区域 -->
        <div class="container">
            <!-- 背景图片 -->
            <div class="bg">
                <div class="drop-shadow">
                    <!-- 登录框 -->
                    <div class="loginbox">
                        <!-- 登录内容 -->
                        <div class="loginmsg">
                            
                        </div>
                        
                    </div>
                    
                </div>

            


            </div>
        </div>
        <!-- 底部区域 -->
        <!-- <div class="footer">

        </div> -->
        
    </div>


</template>

<script>
import loginName from "./loginName.vue";
import registName from "./registName.vue";
export default{
        components:{
            loginName,
            registName
        },
        // name:Login,    
    data(){
        return{
            offsetTop: 0,
            offsetHeight: 0,
            headerFixed: 0,
            dialogTableVisible: false,
            formLabelWidth: '80px',
            Visiable:false,
            registVisiable:false,
        }
    },

    mounted(){

        //     // 吸顶
        //     this.$nextTick(()=>{
        //     // 获取顶部元素dom
        //     let header = this.$refs.header;
        //     // 吸顶元素到top的距离
        //     this.offsetTop = header.offsetTop;
        //     // 元素自身高度
        //     this.offsetHeight = header.offsetHeight;

        //     // 监听滚动条
        //     window.addEventListener("scroll", this.handleScroll);
        // })
    },

    methods:{
        // 导航栏吸顶
        // handleScroll(){
        // // 得到页面滚动距离，兼容写法
        // let scrollTop = 
        //     window.pageYOffset ||
        //     document.documentElement.scrollTop ||
        //     document.body.scrollTop;

        // // 判断页面滚动距离是否大于吸顶元素位置
        // this.headerFixed = scrollTop > (this.offsetHeight - this.offsetTop)/2;
        // console.log(this.offsetTop);
        // console.log(this.offsetHeight);
        // console.log(this.headerFixed);
        // // this.headerFixed = scrollTop > 70;
        // },

        // 验证登录
        confirmlogin(){

        },

        registbox(data){
            this.registVisiable=true;
            this.$nextTick(()=>{
                this.$refs.regist.init(data);
            })
        },

        loginbox(data){
            this.Visiable=true;
            this.$nextTick(()=>{
                this.$refs.login.init(data);
            })
        }
    },

    // 销毁吸顶，以免影响其他页面
    destroyed(){
        window.removeEventListener('scroll', this.handleScroll);
    }

}
</script>

<style>
*{
    padding:0;
    margin:auto;
}
html,body,.home_container{
    /* height：100%后续设置有效 */
    height: 100%;
}
body{
    /* min-width: 1441px;
    min-height: 752px; */
    /* 解决弹框出现滚动条消失的布局空缺 两条联合解决message因滚动条抖动问题 */
    padding-right: 0px !important;
    overflow-y: auto !important;

    /* z-index: -1; */


   

}
li{
    list-style:none;
}


/* .home_container{
    width:1441px;
    margin: 0 auto;
} */

/* 头部区域 */
.header-bg{
    width:100%;
    height:9%;
    display:flex;
    justify-content: space-between;
    background-color: #30373b;

}
.isFixed{
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    z-index: 4;
}
.logo{
    margin-left: 40px;
}
.role{
    display: flex;
    justify-content: space-between;
    margin-right: 120px;
    font-size: 15px;
}
.login{
    margin-right: 10px;
    font-size: 17px;
    color: white;
    line-height: 70px;
}
.login a{
    color: #c6c7c8;
}
.login a:hover{
    color: rgb(239, 242, 244);
}
.regist{
    margin-left: 20px;
    /* font-size: 16.5px; */
    font-size: 17px;
    color: white;
    line-height: 70px;
}
.regist a{
    color: #c6c7c8;
}
.regist a:hover{
    color: rgb(239, 242, 244);
}
/* button.el-button.el-button--text{
    font-size: 15px;
    color: white;
    padding-right: 5px;
}
button.el-button.el-button--text:hover{
    color: cornflowerblue;
} */



/* 内容区域 */
.container{
    height: 91%;
    width: 100%;

}
/* 背景图片 */
.bg{
    height: 100%;
    width: 100%;
    /* background-image: url(../assets/bgp.jpg); */
    /* background-repeat: no-repeat; */
    /* background-position: center center; */
    /* background-size: cover; */
    /* background-color: #011633; */
}


/* 登录框 */
/* .loginbox{
    width: 400px;
    height: 600px;
    margin-top: 45px;
    background-color: rgb(255, 255, 255);
    float: right;
    margin-right: 100px;
    background-image: url(../assets/bgp.jpg);
    background-size: cover;
    background-position: right;
    filter: blur(20px);

} */

.loginmsg{
    color: white;
    filter: blur(0);
}
/* 底部区域 */
.footer{
    width: 100%;
    height: 100px;
    background-color: black;
}
</style>