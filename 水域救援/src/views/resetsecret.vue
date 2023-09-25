<template>
    <div class="home_container">
        <!-- 头部区域 -->
        <!-- @用于阻拦弹出框后页面底部滑动 -->
        <div class="header-bg" ref="header" :class="headerFixed?'isFixed':''"   @touchmove.prevent  @mousewheel.prevent>
            <!-- logo -->
            <div class="logo">
                <h2>水域救援系统</h2>
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
        <div class="containbox">
            <!-- 表单内容 -->
            <div class="msgform">
                <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
                    <el-form-item label="手机号" prop="tel">
                        <el-input type="password" v-model="ruleForm.tel" autocomplete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="新密码" prop="Pass">
                        <el-input type="password" v-model="ruleForm.pass" autocomplete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="确认密码" prop="checkPass">
                        <el-input v-model.number="ruleForm.checkPass"></el-input>
                    </el-form-item>

                    <!-- 滑块验证 -->
                    <el-form-item label="滑动验证" prop="slider">
                        <!-- <SliderCheck :successFun="handleSuccessFun" :errorFun="handleErrorFun"></SliderCheck> -->
                        <!-- <JcRange status="status"></JcRange> -->
                        <div class="jc-component__range">
                            <div class="jc-range" :class="rangeStatus ? 'success' : '' ">
                                <div class="draggable_bg" ref="bg" :style="{ width: draggable }" ></div>
                                <i @mousedown="rangeMove" :class="rangeStatus ? successIcon : startIcon "></i>
                                {{rangeStatus ? successText :startText}}
                            </div>
                        </div>
                    </el-form-item>

                    <el-form-item>
                        <el-button  @click="submitForm('ruleForm')" class="my-el-checkbtn">提交</el-button>
                        <el-button @click="resetForm('ruleForm')" class="my-el-cancelbtn">重置</el-button>
                    </el-form-item>
                </el-form>
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
// import SliderCheck from "../components/SliderCheck.vue";
// import JcRange from "../components/JcRange.vue";

export default{
            props: {
            //成功图标
            successIcon: {
            type: String,
            default: "el-icon-success"
            },
            //成功文字
            successText: {
            type: String,
            default: "验证通过"
            },
            //开始的图标
            startIcon: {
            type: String,
            default: "el-icon-d-arrow-right"
            },
            //开始的文字
            startText: {
            type: String,
            default: "请按住滑块，拖动到最右边"
            }
        },
        components:{
            loginName,
            registName,
            // SliderCheck,
            // JcRange,
        },
        
        // name:Login,    
    data(){

        // 表单内容
        var checkTel = (rule, value, callback) => {
            if (!value) {
            return callback(new Error('手机号不能为空'));
            }
            setTimeout(() => {
            if (!Number.isInteger(value)) {
                callback(new Error('请输入数字值'));
            } else {
                if (value.length < 11) {
                callback(new Error('请输入正确的长度'));
                } else {
                callback();
                }
            }
            }, 1000);
        };
        var validatePass = (rule, value, callback) => {
            if (value === '') {
            callback(new Error('请输入密码'));
            } else {
            if (this.ruleForm.checkPass !== '') {
                this.$refs.ruleForm.validateField('checkPass');
            }
            callback();
            }
        };
        var validatePass2 = (rule, value, callback) => {
            if (value === '') {
            callback(new Error('请再次输入密码'));
            } else if (value !== this.ruleForm.pass) {
            callback(new Error('两次输入密码不一致!'));
            } else {
            callback();
            }
        };


        return{
            offsetTop: 0,
            offsetHeight: 0,
            headerFixed: 0,
            dialogTableVisible: false,
            formLabelWidth: '60px',
            Visiable:false,
            registVisiable:false,

            status: false,

            rangeStatus: "",
            draggable: 0,

            // 表单判定规则
            ruleForm: {
                pass: '',
                checkPass: '',
                tel: ''
            },
            rules: {
                pass: [
                    { validator: validatePass, trigger: 'blur' }
                ],
                checkPass: [
                    { validator: validatePass2, trigger: 'blur' }
                ],
                tel: [
                    { validator: checkTel, trigger: 'blur' }
                ],
                // 滑块


            }
        }
    },

    mounted(){

            // 吸顶
            this.$nextTick(()=>{
            // 获取顶部元素dom
            let header = this.$refs.header;
            // 吸顶元素到top的距离
            this.offsetTop = header.offsetTop;
            // 元素自身高度
            this.offsetHeight = header.offsetHeight;

            // 监听滚动条
            window.addEventListener("scroll", this.handleScroll);
        })
    },

    methods:{
        // 导航栏吸顶
        handleScroll(){
        // 得到页面滚动距离，兼容写法
        let scrollTop = 
            window.pageYOffset ||
            document.documentElement.scrollTop ||
            document.body.scrollTop;

        // 判断页面滚动距离是否大于吸顶元素位置
        this.headerFixed = scrollTop > (this.offsetHeight - this.offsetTop)/2;
        console.log(this.offsetTop);
        console.log(this.offsetHeight);
        console.log(this.headerFixed);
        // this.headerFixed = scrollTop > 70;
        },

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
        },

        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    alert('submit!');
                } else {
                    console.log('error submit!!');
                    return false;
                }
                });


        },

        resetForm(formName) {
            this.$refs[formName].resetFields();
        },

        // 滑块验证成功
        handleSuccessFun(){
            this.status = true
            console.log('成功');
        },

        // 验证失败
        handleErrorFun(){
            console.log('失败');
        },

        // 销毁吸顶，以免影响其他页面
        destroyed(){
            window.removeEventListener('scroll', this.handleScroll);
        },

        rangeMove(e) {
            let ele = e.target;
            let startX = e.clientX;
            let eleWidth = ele.offsetWidth;
            let parentWidth = ele.parentElement.offsetWidth;
            let MaxX = parentWidth - eleWidth;
            if (this.rangeStatus) {
                //不运行
                return false;
            }
            document.onmousemove = e => {
                let endX = e.clientX;
                this.disX = endX - startX;
                if (this.disX <= 0) {
                this.disX = 0;
                }
                if (this.disX >= MaxX - eleWidth) {
                //减去滑块的宽度
                this.disX = MaxX;
                }
                this.$refs.bg.style.transition = ".0s all";
                this.draggable = this.disX + 'px'; // 滑块中的背景
                ele.style.transform = "translateX(" + this.disX + "px)";
                ele.style.transition = ".0s all";
                e.preventDefault();
            };
            document.onmouseup = () => {
                if (this.disX !== MaxX) {
                ele.style.transition = ".5s all";
                ele.style.transform = "translateX(0)";
                this.$refs.bg.style.transition = ".5s all";
                this.draggable = 0 + 'px'; // 滑块中的背景
                //执行成功的函数
                this.$emit("errorFun", false);
                } else {
                this.rangeStatus = true;
                this.draggable = 0; // 滑块中的背景
                //执行成功的函数
                this.$emit("successFun", true);
                }
                document.onmousemove = null;
                document.onmouseup = null;
            };
        }
    }
}
</script>

<style scoped>
*{
    padding:0;
    margin:auto;
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
    height:70px;
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
.containbox{
    width: 100%;
    height: 80%;
    /* background-color: #30373b; */
    background-color: rgb(245, 244, 244);
}
.msgform{
    padding-top: 100px;
    width: 23%;
}

/* 确认按钮 */
.my-el-checkbtn /deep/{
    background-color: #030303 !important;
    border-color: #030303 !important;
    color: #fff !important;
}
.my-el-checkbtn:hover /deep/{
    background-color: #030303 !important;
    border-color: #030303 !important;
    color: #8a8a8a !important;
}
.my-el-checkbtn:focus /deep/{
    background-color: #030303 !important;
    border-color: #030303 !important;
    color: #fff !important;
}
/* 重置按钮 */
.my-el-cancelbtn:hover /deep/{
    background-color: rgb(144, 142, 142) !important;
    border-color: rgb(144, 142, 142) !important;
    color: #030303 !important;
}
.my-el-cancelbtn:focus /deep/{
    background-color: #fff !important;
    border-color: #dcdfe6 !important;
    color: #606266 !important;
}

.jc-range {
  background-color: #e8e8e8;
  position: relative;
  transition: 1s all;
  user-select: none;
  color: #333;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 45px;
  border-radius: 1px;
  /* z-index: 9999; */
  z-index: 5;
  /*no*/
}

.draggable_bg {
  position: absolute;
  left: 0;
  height: 100%; 
  background-color: #7ac23c;
  z-index: -1;
}

.jc-range i {
  position: absolute;
  left: 0;
  width: 60px;
  /*no*/
  height: 100%;
  color: #919191;
  background-color: #fff;
  border: 1px solid #bbb;
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
  /* z-index: 9999; */
  z-index: 5;
}

.jc-range.success {
  background-color: #7ac23c;
  color: #fff;
  border-radius: 1px;
  /* z-index: 99999; */
  z-index: 5;
}

.jc-range.success i {
  color: #7ac23c;
}

</style>

