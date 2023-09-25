<template>
    <div class="dialogcontainer"  @touchmove.prevent @mousewheel.prevent>
            <!-- 登录表单 -->
            <el-dialog title="登录" :visible.sync="dialogFormVisible" center width="390px" top="15%" class="my-el-dialog"  :modal-append-to-body="false">
                <!-- <el-divider></el-divider> -->
                <!-- <el-input v-model="name" autocomplete="off" placeholder="账号/手机号"></el-input> -->
                <el-form :model="form">
                    <el-form-item :label-width="formLabelWidth">
                        <el-input v-model="form.name" autocomplete="off" placeholder="账号/手机号"></el-input>
                    </el-form-item>
                    <el-form-item :label-width="formLabelWidth">
                        <el-input v-model="form.secret" autocomplete="off" placeholder="密码"></el-input>

                    </el-form-item>
                </el-form>
                <div class="forget">
                    <a @click="resetsecret">忘记密码?</a>
                </div>               
                <div slot="footer" class="dialog-footer">
                    <!-- <el-button @click="dialogFormVisible = false">取 消</el-button> -->
                    <el-button  @click="confirmlogin" class="my-el-button">登录</el-button>
                </div>
            </el-dialog>
    </div>
</template>

<script>
export default{
name: 'loginName',
data(){
    return{
        dialogFormVisible: false,
        form: {
            name: '',
            secret:'',
        },
        formLabelWidth: '60px'
    }
},



methods:{

    showPwd() {
      if (this.passwordType === "password") {
        this.passwordType = "";
      } else {
        this.passwordType = "password";
      }
      this.$nextTick(() => {
        this.$refs.password.focus();
      });
    },

    confirmlogin(){
        this.$router.push('/show');

    },

    init(data){
        this.dialogFormVisible=true;
        console.log(data);
    },
    // 忘记密码
    resetsecret(){
        this.$router.push('/resetsecret')
    }
}
}
</script>

<style scoped>
/* 登录表单 */
/* .el-dialog .el-dialog--center{
    top: 15%;
    margin: 0 auto;
    width: 390px;
} */
.el-form-item[data-v-532faeea]{
    margin-right: 50px;
}
.el-button[data-v-532faeea]{
    width: 295px;
    /* margin-left: 13px; */
}
/* .el-input__inner{
    width:260px
} */
/* .el-dialog--center .el-dialog__body {
    padding: 25px 10px 25px;
} */
.el-dialog__footer[data-v-532faeea]{
    padding: 20px 20px 20px;
}

.el-form-item[data-v-532faeea]{
    margin-right: 30px;
    margin-left: -20px;
}
.el-button[data-v-532faeea]{
    width: 275px;
    margin-left: 10px;
    margin-top: 10px;
}
.el-dialog--center .el-dialog__body[data-v-532faeea]{
    padding: 25px 50px 30px;
}
/* input.el-input__inner:hover[data-v-532faeea]{
    border-color: #222324;
} */
/* 去除选中文本框后的淡蓝色边框 */
.my-el-dialog /deep/ .el-input .el-input__inner{
    border-color: #8a8a8a !important;
}
.my-el-dialog[data-v-532faeea] /deep/ .el-input .el-input__inner:hover{
    border-color: #030303 !important;
}
/* 忘记密码 */
.forget a{
    margin-right: 30px;
    float: right;
}
.forget a:hover{
    color: black;
}

/* 按钮颜色 */
.my-el-button /deep/{
    color: #fff !important;
    background-color: #030303 !important;
    border-color: #030303 !important;
}
/* 鼠标悬浮 */
.my-el-button:hover /deep/{
    color: #8a8a8a !important;
    background-color: #030303 !important;
    border-color: #030303 !important;
}
/* 鼠标点击 */
.my-el-button:focus /deep/{
    color: #fff;
    background-color: #030303 !important;
    border-color: #030303 !important;
}

/* 文本框右上角x */
.my-el-dialog /deep/ .el-dialog__close{
    color: #4d4c4c !important;
}
.my-el-dialog /deep/ .el-dialog__close:focus{
    color: #111010 !important;
}
.my-el-dialog /deep/ .el-dialog__close:hover{
    color: #111010 !important;
}


/* .my-el-dialog /deep/ .el-dialog__headerbtn:focus{
    color: #030303 !important;
}
.my-el-dialog /deep/ .el-dialog__headerbtn:hover{
    color: #030303 !important;
} */


</style>