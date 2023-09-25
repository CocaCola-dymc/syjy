<template>
    <div class="registbox">
        <!-- 注册表单 -->
        <el-dialog title="注册" :visible.sync="registFormVisible" center width="390px" top="5%" class="my-el-regist" :modal-append-to-body="false">
            <div class="line"></div>
            <!-- <el-input v-model="name" autocomplete="off" placeholder="账号/手机号"></el-input> -->
            <el-form :model="form">
                <el-form-item :label-width="formLabelWidth">
                    <el-input v-model="form.tel" autocomplete="off" placeholder="手机号"></el-input>
                </el-form-item>
                <!-- 验证码区域 -->
                <el-form-item class="captchaimg">
                    <slide-verify
                        :l="42"
                        :r="10"
                        :w="290"
                        :h="175"
                        slider-text="向右滑动"
                        @success="onSuccess"
                        @fail="onFail"
                    >            
                    </slide-verify>
                </el-form-item>

                <el-form-item :label-width="formLabelWidth">
                    <el-input v-model="form.captcha" autocomplete="off" placeholder="验证码"></el-input>
                </el-form-item>
                <el-form-item :label-width="formLabelWidth">
                    <el-input v-model="form.secret" autocomplete="off" placeholder="输入密码"></el-input>
                </el-form-item>
                <el-form-item :label-width="formLabelWidth">
                    <el-input v-model="form.resecret" autocomplete="off" placeholder="确认密码"></el-input>
                </el-form-item>
            </el-form>
                <div slot="footer" class="dialog-footer">
                    <!-- <el-button @click="dialogFormVisible = false">取 消</el-button> -->
                    <el-button  @click="confirmregist"
                        :disabled="!verified"
                        :loading="loading"  
                        class="my-el-registbtn"                  
                    >
                        <span v-if="!loading">注册</span>
                    </el-button>
                </div>
            

            <el-checkbox v-model="checked" class="mycheckbox">我同意并遵守服务条款</el-checkbox>
        </el-dialog>
    </div>
</template>

<script>
export default{
    name:'registName',
    data(){
        return{
            registFormVisible: false,
            checked:false,
            form:{
                tel:'',
                captcha:'',
                secret:'',
                resecret:'',
            },
            formLabelWidth: '60px',
            loading: false,
            verified: false
        }
    },
    methods:{
        confirmregist(){

        },

        init(data){
            this.registFormVisible=true;
            console.log(data);
        },

        onSuccess(){
            this.verified = true;
        },

        onFail(){
            this.verified = false;
        }
    }
        
}
</script>

<style scoped>
.el-form-item{
    margin-right: 50px;
}
.el-button{
    width: 295px;
    /* margin-left: 13px; */
}
/* .line{
    width: 100%;
    height: 1px;
    background-color: #030303;
    margin-bottom: 20px;
    margin-top: -15px;
} */
/* .el-input__inner{
    width:260px
} */
/* .el-dialog--center .el-dialog__body {
    padding: 25px 10px 25px;
} */
.my-dialog-footer /deep/ .el-dialog__footer{
    /* padding: 20px 20px 20px; */
    padding-top: 10px !important;
    padding-bottom: 20px !important;
    margin-top: -20px !important;
}
/* .el-dialog__wrapper /deep/{
    overflow: visible !important;

} */
html,body,.registbox{
    overflow: visible !important;
}
.my-el-regist{
    overflow: visible;
}
.my-el-regist /deep/ .el-dialog--center .el-dialog__body{
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}
.my-el-regist /deep/ .slide-verify-slider{
    margin-top: 2px !important;
}
.my-el-regist /deep/ .el-dialog--center .el-dialog__footer{
    padding-top: 5px !important;
    padding-bottom: 20px !important;
    margin-top: -10px !important;
}
.el-form-item{
    margin-right: 30px;
    margin-left: -20px;
}
.el-button{
    width: 275px;
    margin-left: 10px;
    margin-top: 10px;
}
/* 验证拼图区域 */
.slide-verify{
    margin-left: 50px;
}
.my-el-regist /deep/ .el-input .el-input__inner{
    border-color: #a8a8a8 !important;
}
.my-el-regist /deep/ .el-input .el-input__inner:hover{
    border-color: #030303 !important;
}
/* 勾选框文字变化 */
.mycheckbox /deep/ .el-checkbox__input.is-checked+.el-checkbox__label{
    color: #606266;
}

/* 右上角文本框 */
.my-el-regist /deep/ .el-dialog__close{
    color: #4d4c4c !important;
}
.my-el-regist /deep/ .el-dialog__close:focus{
    color: #111010 !important;
}
.my-el-regist /deep/ .el-dialog__close:hover{
    color: #111010 !important;
}

/* 按钮样式 */
.my-el-registbtn /deep/{
    color: #fff !important;
    background-color: #030303 !important;
    border-color: #030303 !important;
}
.my-el-registbtn:hover /deep/{
    color: #8a8a8a !important;
    background-color: #030303 !important;
    border-color: #030303 !important;
}
.my-el-registbtn:focus /deep/{
    color: #fff;
    background-color: #030303 !important;
    border-color: #030303 !important;
}
.my-el-registbtn.is-disabled /deep/{
    color: #fff;
    background-color: #656565 !important;
    border-color: #6c6c6c !important;
}
.my-el-registbtn.is-disabled:hover /deep/{
    color: #fff;
    background-color: #656565 !important;
    border-color: #6c6c6c !important;
}

</style>