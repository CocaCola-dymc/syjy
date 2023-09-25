<template>
    <div class="homebox">
        <div class="container">
            <div class="introducebox"></div>
            <div class="loginbox">
                    <div class="login-formbox">
                        <div class="tab-box">
                            <el-tabs v-model="activeName" @tab-click="handleClick">
                                <el-tab-pane label="登录" name="first">
                                    <!-- <div class="titlebox">
                                        <h2>登录</h2>
                                    </div> -->
                                    <div class="formbox">
                                        <el-form :model="loginForm"
                                        :rules="rules" ref="loginForm">
                                            <div class="input-box">
                                                <el-form-item prop="tel" class="telbox">                                   
                                                    <el-input class="tel-input" type="text" v-model.trim="loginForm.tel"
                                                            autocomplete="off" placeholder="请输入手机号">
                                                    <i slot="prefix">
                                                            <img 
                                                            style="width: 27px;height: 27px;margin-top: 12px;margin-left: 5px;"
                                                            src="../assets/tel-before.png" alt="">
                                                    </i>
                                                    </el-input>
                                                </el-form-item>
                                            </div>
                                            <div class="input-box">
                                                <el-form-item prop="password" class="pwdbox">
                                                    <el-input type="password" v-model.trim="loginForm.password"
                                                            show-password autocomplete="off" placeholder="请输入密码">
                                                        <i slot="prefix">
                                                            <img 
                                                            style="width: 27px;height: 27px;margin-top: 12px;margin-left: 5px;"
                                                            src="../assets/pwd-before.png" alt="">
                                                    </i>
                                                    </el-input>
                                                </el-form-item>
                                            </div>
                                            <div class="forget">
                                                <p @click="toforget">忘记密码？</p>
                                            </div>
                                            <div class="formbtn-box">
                                                <el-form-item class="login-btn">
                                                    <el-button>登录</el-button>
                                                </el-form-item>                                
                                            </div>
                                            <!-- <div class="toregistbox">
                                                <p>还未有账号？前往注册</p>
                                            </div> -->
                                        </el-form>
                                    </div>
                                </el-tab-pane>
                                <el-tab-pane label="注册" name="second">
                                    <!-- <div class="titlebox">
                                        <h2>登录</h2>
                                    </div> -->
                                    <div class="formbox">
                                        <el-form :model="registForm"
                                        :rules="rules" ref="registForm">
                                            <div class="input-box">
                                                <el-form-item prop="tel" class="telbox">                                   
                                                    <el-input class="tel-input" type="text" v-model.trim="registForm.newtel"
                                                            autocomplete="off" maxlength="11" placeholder="请输入手机号">
                                                    <i slot="prefix">
                                                            <img 
                                                            style="width: 27px;height: 27px;margin-top: 12px;margin-left: 5px;"
                                                            src="../assets/tel-before.png" alt="">
                                                    </i>
                                                    </el-input>
                                                </el-form-item>
                                            </div>
                                            <div class="input-box">
                                                <el-form-item prop="password" class="pwdbox">
                                                    <el-input type="password" v-model.trim="registForm.newpwd"
                                                            show-password autocomplete="off" placeholder="请输入密码">
                                                        <i slot="prefix">
                                                            <img 
                                                            style="width: 27px;height: 27px;margin-top: 12px;margin-left: 5px;"
                                                            src="../assets/pwd-before.png" alt="">
                                                    </i>
                                                    </el-input>
                                                </el-form-item>
                                            </div>
                                            <div class="input-box">
                                                <el-form-item prop="renewpwd" class="pwdbox">
                                                    <el-input type="password" v-model.trim="registForm.renewpwd"
                                                            show-password autocomplete="off" placeholder="请确认密码">
                                                        <i slot="prefix">
                                                            <img 
                                                            style="width: 27px;height: 27px;margin-top: 12px;margin-left: 5px;"
                                                            src="../assets/pwd-before.png" alt="">
                                                    </i>
                                                    </el-input>
                                                </el-form-item>
                                            </div>
                                            <!-- <div class="forget">
                                                <p>忘记密码？</p>
                                            </div> -->
                                            <div class="formbtn-box">
                                                <el-form-item class="login-btn">
                                                    <el-button>注册</el-button>
                                                </el-form-item>                                
                                            </div>
                                            <!-- <div class="toregistbox">
                                                <p>还未有账号？前往注册</p>
                                            </div> -->
                                        </el-form>
                                    </div>
                                </el-tab-pane>
                            </el-tabs>
                        </div>
                        
                    </div>                    
            </div>
        </div>
    </div>
</template>

<script>
export default{
    data(){
        return{
            activeName: "first",
            loginForm:{
                tel:'',
                password:''
            },
            registForm:{
                newtel: '',
                newpwd: '',
                renewpwd: ''
            },
            rules:{
                tel:[
                    {
                        required: true,
                        message: '请输入手机号',
                        trigger: 'blur'
                    },
                    // {
                    //     pattern: /^((1[3456789]\d{9}))$/,
                    //     message: '请输入正确的手机号'
                    // }
                ],
                password:[
                    {
                        required: true,
                        message: '请输入密码',
                        trigger: 'blur'
                    }
                ],
                newtel:[
                    {
                        required: true,
                        message: '请输入手机号',
                        trigger: 'blur'
                    },
                    {
                        pattern: /^((1[3456789]\d{9}))$/,
                        message: '请输入正确的手机号'
                    }
                ],
                newpwd: [
                    {
                        required: true,
                        message: '请输入密码',
                        // validator: checkPwd,
                        trigger: 'blur'
                    }
                ],
                renewpwd: [
                    {
                        required: true,
                        message: '请确认密码',
                        // validator: checkRepwd,
                        trigger: 'blur'
                    }
                ]
            }
        }
    },
    methods: {
        handleClick(tab, event) {
            console.log(tab, event);
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
        toforget(){
            this.$router.replace('./forget')
        }
    }
}
</script>

<style scoped>
*{
    margin: 0;
    padding: 0;
}
html,body,.homebox{
    height: 100%;
    width: 100%;
}
.container{
    width: 100%;
    height: 100%;
    display: flex;
}
.introducebox{
    width: 65%;
    height: 100%;
    /* background-color: aqua; */
}
.loginbox{
    width: 35%;
    height: 100%;
    /* background-color: antiquewhite; */
}
.login-formbox{
    width: 450px;
    height: 600px;
    /* background: #000; */
    margin: 75px auto;
    border-radius: 30px;
    background-color: #fff;
    /* animation: hideLogin 2s ease; */
}
.titlebox{
    width: 100%;
    height: 100px;
    /* background: #000; */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}
.formbox{
    width: 100%;
    height: 400px;
    /* background: #000; */
    display: flex;
    flex-direction: column;
    margin-top: 20px;
}
.input-box{
   width: 360px;
   height: 55px;
   /* background: #000; */
   margin: 20px auto;
   border-radius: 20px;
}
.telbox{
    width: 100%;
    height: 100%;
    /* background-color: red; */
}
.pwdbox{
    width: 100%;
    height: 100%;
}
.el-input /deep/ .el-input__inner {
    width: 100%;
    height: 50px;
    line-height: 55px;
    font-size: 1rem;
    border-radius: 10px;
    padding-left: 45px;
}
.el-input /deep/ .el-input__clear{
    font-size: 18px;
}
.pwdbox /deep/ .el-input__icon {
    line-height: 55px;
}

.forget{
    width: 360px;
    height: 40px;
    margin: 10px auto;
    /* background-color: #000; */
    /* float: right; */
}
.forget p{
    float: right;
    margin-top: 10px;
    color: black;
    cursor: pointer;
}
.forget p:hover{
    color:rgb(115, 185, 243);
}
/* .formbtn-box{ */
    /* width: 300px;
    height: 50px; */
    /* margin: 0 auto; */
    /* margin: 0 auto; */
    /* margin-top: 30px; */
    /* margin-top: 30px;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center; */
/* } */

/* .login-btn{
    width: 200px;
    height: 50px;
    background-color: #000;
} */
.login-btn /deep/ .el-button{
    width: 300px;
    height: 45px;
    background-color: rgb(56, 168, 224);
    color: #fff;
    font-size: 1.1rem;
    border-radius: 10px;
    box-shadow: 0 0 5px rgb(201, 201, 201);
    margin-top: 20px;
}
.login-btn /deep/ .el-button:hover{
    background-color: rgb(35, 170, 238);
    box-shadow: 0 0 8px 0 rgb(182, 181, 181);
}
.tab-box{
    /* background-color: antiquewhite; */
    width: 100%;
    /* height: 100px; */
}
.tab-box /deep/ .el-tabs__nav-scroll{
    display: flex;
    height: 80px;
}
.tab-box /deep/ .el-tabs__nav-wrap{
    height: 80px;
}
.tab-box /deep/ .el-tabs__item{
    font-size: 20px;
    height: 80px;
    line-height: 80px;
}
/* 改变下划线 */
/* .tab-box /deep/ .el-tabs__active-bar{
    background-color: black;
} */
.tab-box /deep/ .el-tabs__item:hover{
    color: grey;
}
.toregistbox{
    width: 360px;
    height: 50px;
    /* background: #000; */
    margin: 0 auto;
    font-weight: 600;
}
.toregistbox p:hover{
    color: rgb(115, 185, 243);
}
/* .tel-input /deep/ .el-input__inner{
    margin-left: 10px;
}  */
/* .formbox input{
    width: 320px;
    height: 40px;
    padding: 0 5px;
} */

.login-leave-active,
.login-enter-active{
    animation: hideLogin 2s ease;
}

@keyframes hideLogin{
    0%{
        transform: scale(1,1);
    }
    25%{
        transform: scale(.9,1.1);
    }
    50%{
        transform: scale(1.1,.9);
    }
    75%{
        transform: scale(.95,1.05);
    }
    100%{
        transform: scale(0,0);
    }
}
</style>