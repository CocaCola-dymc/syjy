<template>
    <div class="box">
        <div class="head">
            <div class="headtitle">
                <h1>水域救援系统</h1>
            </div>
            <div class="headuser">
                <!-- 文字链接 -->
                <!-- <el-button type="text" @click="dialogFormVisible = true" class="myelbtn">参数设置</el-button> -->
                <!-- 表单 -->
                <el-dialog title="参数设置" :visible.sync="dialogFormVisible" class="myeldialog">
                    <el-form class="myelform" label-width="80px">
                        <el-form-item label="写序列号">
                            <el-input v-model="name" clearable maxlength="10" auto-complete="off" placeholder="请输入1-10位设备序列号" label-width="80px"></el-input>
                            <el-button type="primary" @click="addName">确认</el-button>
                        </el-form-item>
                        <el-form-item label="新卡确认">
                            <el-input v-model="card" disabled></el-input>
                            <el-button type="primary" @click="confirm">确认</el-button>
                        </el-form-item>
                        <el-form-item label="卡号读取">
                            <el-input v-model="card_id" readonly placeholder="等待读取"></el-input>
                            <el-button type="primary" @click="read">读取</el-button>
                        </el-form-item>
                        <el-form-item label="持卡人员">
                            <el-input v-model="card_keeper" maxlength="10" placeholder="此卡暂无使用人员,编辑后可添加" :readonly="addCard_flag"></el-input>
                            <el-button type="primary" @click="cardKeeper" :disabled="addCard_flag">添加</el-button>
                        </el-form-item>
                        <el-form-item label="发送间隔">
                            <el-select v-model="time">
                                <el-option label="10" value="10"></el-option>
                                <el-option label="20" value="20"></el-option>
                                <el-option label="30" value="30"></el-option>
                                <el-option label="60" value="60"></el-option>
                                <el-option label="90" value="90"></el-option>
                                <el-option label="120" value="120"></el-option>
                            </el-select>
                            <span>&nbsp;秒/次</span>
                            <el-button type="primary" @click="timeInterval">确认</el-button>
                            <!-- <el-button>重置</el-button> -->
                        </el-form-item>
                    </el-form>

                    <div class="dialog-footer">
                        <el-button @click="dialogFormVisibleClose" class="myelconcel">取消</el-button>
                        <el-button @click="dialogFormVisibleClose" class="myelok">确定</el-button>
                    </div>
                </el-dialog>
                <!-- 下拉菜单 -->
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
                <!-- <p>nianqingren</p> -->
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </div>
        </div>
        <!-- 内容区域 -->
        <div class="contentbox">
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
                        <el-menu-item @click="password">
                            <i class="el-icon-s-tools"></i>
                            <span slot="title">参数设置</span>
                        </el-menu-item>
                        <!-- 没有下级菜单的菜单项 -->
                        <el-menu-item index="/cardmanage">
                            <i class="el-icon-postcard"></i>
                            <span slot="title">卡片管理</span>
                        </el-menu-item>
                    </el-menu>
                </div>     
            </div> 
            
            <!-- 表单区域 -->
            <div class="tablebox">
                <div class="table">
                    <div class="sumbox">
                        <span class="sumText">警报次数：</span>
                        <span class="sumNum">{{ sum }}</span>                    
                    </div>
                    <div class="tablebox1">                   
                        <el-table
                            :data="tableData.slice((currentPage-1)*pageSize,currentPage*pageSize)"
                            style="width: 100%"
                            ref="filterTable"
                            height="100%"
                            :default-sort="{ prop:'time' , order: '' }" 
                            >
                            <el-table-column
                            prop="time"
                            sortable                                                      
                            label="日期"                           
                            width="280"
                            column-key="time"
                            class="my-datebox"
                            >
                            <template slot-scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.time }}</span>
                            </template>

                            </el-table-column>

                            <el-table-column
                            prop="devicename"                           
                            label="设备号"
                            width="480">
                            <template slot-scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.devicename }}</span>
                            </template>
                            </el-table-column>

                            <el-table-column label="报警状态"
                            :filters="[{text: '1', value: '1'}, {text: '2',value: '2'}]"
                            :filter-method="filterwarning"
                            width="250"
                            prop="warning"
                            >
                                <template slot-scope="scope">
                                    <el-tag
                                    :type="scope.row.warning ==='1'?'danger':'danger'"
                                    disable-transitions
                                    style="margin-left: 10px"
                                    >
                                    {{ scope.row.warning }}
                                    </el-tag>
                                </template>
                            </el-table-column>
                            <el-table-column label="删除"
                                width="250"
                                prop="delete"
                            >
                                <template slot-scope="scope">
                                    <el-button type="danger" @click="deleteData(id=scope.row.id)">删除</el-button>
                                </template>
                            </el-table-column>                            
                            <el-table-column
                            align="center"
                            class="my-searchbox"
                            >
                                <!-- <template slot="header" slot-scope="scope"> -->
                                <template slot="header">
                                    <el-input
                                    v-model="search"
                                    size="mini"
                                    @keyup.native="gosearch"
                                    placeholder="输入关键字搜索"/>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                    <div class="yebox">
                        <el-pagination
                            background
                            @size-change="handleSizeChange"
                            @current-change="handleCurrentChange"
                            :current-page="currentPage"
                            :page-sizes="[10,20,30,40,50]"
                            :page-size="pageSize"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="total"
                        >

                        </el-pagination>
                    </div>           
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { connect } from "mqtt";
const mqttHost = "112.124.28.149";
const mqttPort = "8083";
const mqttUrl = `ws://${mqttHost}:${mqttPort}/mqtt`;

const pubTopic = "device";      //发布主题
const subTopic = "aye";         //订阅主题
export default{
    data(){
        return{
            msg:[],
            sum:0,
            // 表格内容
            tableData: [],
            ListData: [],
            searchList:[],
            msg:[],
            search: '',
            today: '',
            t1: "",
            t2:"",
            dialogTableVisible: false,
            dialogFormVisible: false,
            name:"",
            card:"j20001",
            card_id: "",
            card_keeper: "等待读取",
            addCard_flag: true,
            swipe_flag: false,
            dataFromDev: {},
            time:20,
            devicename:"",
            // formLableWidth: '120px',
            params: {
                devicename: "",
            },
            currentPage: 1, //当前页
            pageSize: 10, //页面容量
            total: null, //总数
            
        }
    },
    watch:{
        today(){
            this.times();
            this.sumadd();
        }
    },
    created(){
        this.axios();
        this.sumadd();
    },
    mounted() {
        this.getTableData();
        this.sumadd();
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
            let dataFromDev = {}
            this.dataFromDev = JSON.parse(message)
            this.read();
        })
        // setInterval(() => {
        //     this.getTableData();
        //     this.sumadd();
        // }, 1000);
    },
    methods:{
        //获取后台数据
        getTableData(){
            let that = this
            axios({
                method: 'get',
                url: '/LM.php'
            }).then(res=>{
                let data =JSON.parse(JSON.stringify(res.data));
                let msg = [];
                for(let i=0;i<data.users.length;i++){
                    if(data.users[i].warning == 1 || data.users[i].warning == 2){
                        msg.push(data.users[i])
                    }
                }

                for(let i = 0;i<msg.length;i++){
                    that.ListData[i] = msg[i]
                }
                
                that.tableData = JSON.parse(JSON.stringify(that.ListData)) ;      
                that.total = that.tableData.length;
                
                // that.tableData.id = msg.users.id;
                // console.log(that.tableData);
                // console.log(msg.users.id)
                this.today = new Date();

            })
        },
        handleSizeChange(val){
            console.log("每页：$[val]条");
            this.pageSize = val;
            this.getTableData();
        },
        handleCurrentChange(val){
            console.log("当前：页$[val]条");
            this.currentPage = val;
            this.getTableData();
        },
        sumadd(){
            this.sum = 0;
            for (let i = 0; i <this.tableData.length; i++) {
                
                var err = this.tableData[i].warning;
                if (err === '1' || err === '2') {
                    this.sum += 1;
                }
            }

        },
        times(){
            return setTimeout(()=>{
                this.getTableData();
                this.sumadd();
            },2000)
        },

        password(){
            this.$prompt('请输入密码', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            inputPattern: /123456/,
            inputErrorMessage: '密码错误'
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: '密码正确',
                    center: true
                });
                this.dialogFormVisible = true
            }).catch(() => {
            this.$message({
                type: 'info',
                message: '取消输入',
                center: true
            });       
            });
        },

        addName(){    
            let that = this;
            let nameRegExp = /^[a-zA-Z0-9]{1,10}$/
            axios({
                method: 'post',
                url: "/LM.php",
                headers:{
                    'Content-type': 'application/x-www-form-urlencoded'
                },
                data:{
                    action: 'read_device',
                    devicename: that.name,
                },
            }).then((res)=>{
                let data = res.data.devices;

                if(that.name == ''){
                    this.$message({
                        message: '设备序列号不能为空',
                        type: 'error',
                        offset: 200,
                        center: true
                    });
                }else if(data.length == 1){
                    this.$message({
                        message: '设备序列号已存在',
                        type: 'error',
                        offset: 200,
                        center: true
                    })
                }else if(!nameRegExp.test(that.name)){
                    wx.showToast({
                        title: '设备序列号应由1~10字母和数字组成!',
                        icon: 'error',
                        offset: 200,
                        center: true
                    })
                }else{
                    axios({
                        method: "post",
                        url: "/LM.php",
                        headers:{
                            'Content-type': 'application/x-www-form-urlencoded'
                        },
                        data:{
                            action: 'insert',
                            devicename: that.name,
                            // GPS: 'wewew',
                            // warning: '0'
                        },
                    }).then((res)=>{
                        //发布主题
                        let message = {"devicename":that.name}
                        let msg = 'j1' + JSON.stringify(message);
                        //发布话题
                        this.client.publish(pubTopic,msg,function(err){
                            // if(!err){
                            //     console.log('成功发布pubPort')
                            // }
                        })
                        that.name = ''

                        this.$message({
                            message: '成功添加',
                            type: 'success',
                            offset: 200,
                            center: true
                        });
                    })
                }
            })
        },

        confirm(){
            let message = {"card":this.card}
            let msg = JSON.stringify(message);
            //发布话题
            this.client.publish(pubTopic,msg,function(err){
                // if(!err){
                //     console.log('成功发布pubPort')
                // }
            })
            // this.$message({
            //     message: '已确认',
            //     type: 'success',
            //     offset: 200,
            //     center: true
            // });
            if(this.swipe_flag == false){
                this.card_id = '未刷卡'
                this.card_keeper = '等待读取'
            }
        },

        read(){
            // this.dataFromDev = dataFromDev
            let card_id = this.dataFromDev.warning
            // console.log(card_id)
            if(card_id > 10){
                this.swipe_flag = true          //该标志位用于判断是否已经刷过卡
                this.card_id = card_id - 10
                // console.log(this.card_id)
                axios({
                    method: "post",
                    url: "/LM.php",
                    // url: "/LMsy.php",
                    headers:{
                        'Content-type': 'application/x-www-form-urlencoded'
                    },
                    data:{
                        action: 'read_card',
                        card_id: this.card_id
                    },
                }).then((res)=>{
                    let card = JSON.parse(JSON.stringify(res.data));
                    if(card.cards.length != 0){
                        this.addCard_flag = true;
                        this.card_keeper = card.cards[0].username;
                    }else{
                        this.addCard_flag = false;
                        this.card_keeper = "";
                    }
                })
            }else{
                // this.$message({
                //     message: '未刷卡',
                //     type: 'error',
                //     offset: 200,
                //     center: true
                // });
                if(this.swipe_flag == false){
                    this.card_id = '未刷卡'
                    this.card_keeper = '等待读取'
                }
            }
        },

        cardKeeper(){
            let cardRegExp = /^[a-zA-Z0-9]{1,10}$/
            if(this.card_keeper == ''){
                this.$message({
                    message: '持卡人不能为空',
                    type: 'error',
                    offset: 200,
                    center: true
                });
            }else if(!cardRegExp.test(this.card_keeper)){
                this.$message({
                    message: '持卡人格式错误',
                    type: 'error',
                    offset: 200,
                    center: true
                });
            }else{
               axios({
                method: "post",
                url: "/LM.php",
                headers:{
                    'Content-type': 'application/x-www-form-urlencoded'
                },
                data:{
                    action: 'insert_card',
                    card_id: this.card_id,
                    username: this.card_keeper,
                },
                }).then((res)=>{
                    this.$message({
                        type: 'success',
                        message: '成功添加',
                        offset: 200,
                        center: true
                    });
                }) 
            }
            
        },

        timeInterval(){
            let message = {"time":this.time}
            let msg = JSON.stringify(message);
            //发布话题
            this.client.publish(pubTopic,msg,function(err){
                // if(!err){
                //     console.log('成功发布pubPort')
                // }
            })
            this.$message({
                message: '成功修改',
                type: 'success',
                center: true
            });
        },

        dialogFormVisibleClose(){
            this.dialogFormVisible = false;
            this.name = ''
            this.card_id = '等待读取'
            this.card_keeper = '等待读取'
        },

        deleteData(id){
            this.$confirm(`此操作删除将删除此报警信息, 是否继续?`, `删除`, {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                axios({
                    method: "post",
                    url: "/LM.php",
                    // url: "/LMsy.php",
                    headers:{
                        'Content-type': 'application/x-www-form-urlencoded'
                    },
                    data:{
                        action: 'delete_data',
                        id: id,
                    },
                }).then(()=>{
                    this.$message({
                        type: 'success',
                        message: '删除成功',
                        offset: 200,
                        center: true
                    });
                    this.$router.go(0)
                })
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消删除',
                    offset: 200,
                    center: true
                });          
            });
        },

        gosearch(){
            this.searchList = []
            for (let index = 0; index < this.ListData.length; index++) {
                if (this.ListData[index].id == this.search || this.ListData[index].devicename == this.search) {
                    this.searchList.push(this.ListData[index])
                }               
            }
            if (this.searchList.length > 0) {
                this.tableData = []
                this.tableData = JSON.parse(JSON.stringify(this.searchList))
            }
            if (this.search == '') {
                console.log("空")
                this.tableData = JSON.parse(JSON.stringify(this.ListData))
            }
        },
        loginout(){
            this.$router.push('/login');
        },
        // 表格组件

        formatter(row, column) {
            return row.address;
        },
        filterwarning(value, row) {
            return row.warning === value;
        },

        gouserIndex(){
            this.$router.push('/userIndex')
        },

        
    },

    // 销毁定时器
    beforeDestroy(){
        // 方法一
        // clearInterval(this.timer);
        // this.timer = null;

        clearTimeout(this.times());
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
html,body{
    height: 100%;
}
.box{
    height: 100%;
    width: 100%;
}
/* 头部区域 */
.head{
    width: 100%;
    height: 9%;
    background-color: #30373b;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.headtitle{
    margin-left: 40px;
    color: #ffffff;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 24px;
    user-select: none
}
/* .headtitle h2{
    margin-top: 13%;
} */
.headuser{
    margin-right: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.myelbtn{
    margin-right: 50px;
    color: rgb(227, 227, 227);
}
.myelbtn:hover{
    color: #6a9df6;
}
.myeldialog{
    width: 100% !important;
    margin: auto;
}
.myelform{
    width: 80% !important;
    height: 480px !important;
    /* background-color: #30373b !important; */
    margin: auto;
}

.el-input{
    width: 70%;
    margin-right: 40px;
}
.el-form-item{
    margin-top: 50px;
}

.el-form-item__label{
    font-size: 20px;
}

.el-select{
    width: 65%;
    /* margin-right: 40px; */
}

.el-form-item span{
    margin-right: 40px;
    /* font-size: 24px; */
}
.myaddline{
    margin-right: 50px;
    color: #fff !important;
}
.myaddline:hover{
    color: #6a9df6 !important;
}
.headuser img{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 20px;
    margin-top: 5%;
    /* margin-top: 7%; */
}
.headuser p{
    color: #ffffff;
    /* margin-top: 13%; */
}
.myelconcel{
    background-color: #6a9df6 !important;
    color: #ffffff !important;
    
}
.myelok{
    background-color: #6a9df6 !important;
    color: #ffffff !important;
}
/* 头部区域下拉菜单 */

/* 中间内容区域 */
.contentbox{
    width: 100%;
    height: 92%;
    display: flex;
    background-color: #d9dbdb;
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
.tablebox{
    width: 88.3%;
    height: 100%;
    /* background-color: #5099c3; */
}
.table{
    width: 99.75%;
    height: 99.5%;
    margin-top: 1px;
    margin-left: 2px;
    margin-right: 5px;
    margin-bottom: 5px;
    /* background-color: #bb50c3; */
    background-color: #fff;
    display: flex;
    flex-direction: column;
}

.sumbox{
    /* background-color: rgb(249, 133, 133); */
    width: 200px;
    height: 50px;
    margin-top: 5px;
    line-height: 50px;
    text-align: center;
    font-size: 18px;
    margin-left: 30px;
    /* margin-left: 10px; */
}
.sumbox span{
    float: left;
    
}
.sumNum{
    color: #f64b4b;
}
/* 表单内容 */
.tablebox1{
    width: 99.5%;
    height: 90%;
    /* background-color: #83b5e7; */
    margin-left: 4px;
    border-color: white;
    background-color: #1a1a1b;
}
.yebox{
    width: 99.5%;
    height: 10%;
    /* background-color: #6591df; */
    /* margin-left: 4px; */
    /* margin-top: 10px; */
    display: flex;
    justify-content: center;
    align-items: center;
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

.my-datebox,.el-table th.el-table__cell>.cell{
    padding-left: 20px !important;
}

.my-searchbox,.el-input--mini .el-input__inner{
    height: 35px !important;
    width: 200px !important;
    /* margin-left: -20px !important; */
}
.el-pager{
    margin-left: 50px !important;
}
</style>