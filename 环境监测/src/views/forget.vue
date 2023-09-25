<template>
    <div class="forgetbox">
        <div class="forget-header">
            <div class="header-name">
                <h1>环境监测</h1>
            </div>
        </div>
        <div class="forget-page">
            <el-page-header @back="goBack" content="忘记密码"></el-page-header>
        </div>
        <div class="forget-content">
            <div class="forget-form">
                <el-form  :model="forgetForm" :rules="rules" ref="forgetForm" label-width="90px">
                    <div class="input-box">
                        <el-form-item label="手机号" class="telbox" prop="tel">
                            <el-input v-model.trim="forgetForm.tel" type="text" placeholder="请输入手机号"></el-input>
                        </el-form-item>                        
                    </div>
                    <div class="input-box">
                        <el-form-item label="新密码" class="pwdbox" prop="newpwd">
                            <el-input v-model.trim="forgetForm.newpwd" type="password" placeholder="请输入新密码"></el-input>
                        </el-form-item>                        
                    </div>
                    <div class="input-box">
                        <el-form-item label="确认密码" class="repwdbox" prop="renewpwd">
                            <el-input v-model.trim="forgetForm.renewpwd" type="password" placeholder="请确认密码"></el-input>
                        </el-form-item>                        
                    </div>
                    <div class="btnbox">
                        <el-button @click="submit">确认</el-button>
                    </div>
                </el-form>
            </div>
        </div>
    </div>
</template>

<script>
export default{
    data(){
        let reg=/^(((13[0-9]{1})|(15[0-9]{1})|(16[0-9]{1})|(17[3-8]{1})|(18[0-9]{1})|(19[0-9]{1})|(14[5-7]{1}))+\d{8})$/

        let checkPwd=((rule, value, callback)=>{
            if (value.trim().length == 0) {
                callback(new Error("密码输入不能为空"));
            }else if (value != this.forgetForm.newpwd) {
                callback(new Error("两次密码输入不一致"));
            }else {
                callback();
            }
        })
        let checkPhone = ((rule, value, callback)=>{
            if (value === '' || value.trim().length == 0) {
                callback(new Error("手机号不能为空"));
            }else if (!reg.test(value)) {
                callback(new Error("手机号格式不正确"));
            }else {
                callback();
            }
        })
        let checkNewpwd = ((rule, value, callback)=>{
            if (value === '' || value.trim().length == 0) {
                callback(new Error("密码不能为空"));
            }else {
                callback();
            }
        })
        return{
            forgetForm: {
                tel: '',
                newpwd: '',
                renewpwd: ''
            },
            rules: {
                tel: [
                    {
                        // required: true,
                        validator: checkPhone,
                        // message: '请输入手机号',
                        trigger: 'blur'
                    },
                    // {
                    //     pattern: /^((1[3456789]\d{9}))$/,
                    //     message: '请输入正确的手机号',
                    //     trigger: 'blur'
                    // }
                ],
                newpwd: [
                    {
                        validator: checkNewpwd,
                        // message: '请输入密码',
                        trigger: 'blur'
                    }
                ],
                renewpwd: [
                    {
                        validator: checkPwd,
                        // message: '两次输入密码不一致',
                        trigger: 'blur'
                    }
                ]
            }
        }
    },
    methods: {
        goBack(){
            this.$router.replace('./login')
        },
        submit(){
            console.log(this.forgetForm);
        }
    }
}
</script>

<style scoped>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.forgetbox{
    width: 100%;
    height: 100%;
    background-color: rgb(250, 250, 250);
}
.forget-header{
    width: 100%;
    height: 9%;
    background-color: rgb(35, 35, 35);
    display: flex;
    /* align-items: center; */
}
.header-name{
    width: 50%;
    height: 100%;
    /* background-color: #fff; */
    display: flex;
    align-items: center;
}
.header-name h1{
    margin-left: 20px;
    color: #fff;
}
.forget-page{
    width: 100%;
    height: 5%;
    /* background: #000; */
    margin-top: 10px;
    display: flex;
    align-items: center;
}
.forget-page /deep/ .el-page-header{
    margin-left: 40px;
}
.forget-content{
    width: 100%;
    height: 70%;
    /* background: #000; */
    display: flex;
    /* align-items: center; */
    justify-content: center;
}
.forget-form{
    width: 500px;
    height: 350px;
    /* background-color: #fff; */
    /* border: 1px solid rgb(205, 204, 204); */
    /* box-shadow: 0 0 5px 0 rgb(185, 185, 185); */
    /* background-color: #000; */
    margin-top: 50px;
}
.input-box{
    width: 100%;
    height: 70px;
    /* background: #000; */
    display: flex;
    justify-content: center;
    align-items: center;
}
.telbox{
    margin-top: 23px;
}
.telbox /deep/ .el-input__inner{
    width: 300px;
    background-color: #fafafa;
}
.pwdbox{
    margin-top: 23px;
}
.pwdbox /deep/ .el-input__inner{
    width: 300px;
    background-color: #fafafa;
}
.repwdbox{
    margin-top: 23px;
}
.repwdbox /deep/ .el-input__inner{
    width: 300px;
    background-color: #fafafa;
}
.btnbox{
    width: 400px;
    height: 50px;
    /* background: #000; */
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 70px;
}
.btnbox .el-button{
    width: 300px;
    border-radius: 10px;
    /* background-color: black; */
    background: linear-gradient(-200deg ,#1f3141, #51697b);
    color: #fff;
    transition: 0.5s;
}
.btnbox .el-button:hover{
    background: linear-gradient(-200deg ,#51697b, #1f3141);
    background-position-x: -300px;
}
</style>