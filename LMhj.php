<?php 
    //连接数据库
    // $conn = new mysqli("120_77_174_216","120_77_174_216","liangxiaofen","120_77_174_216");
    //$conn = new mysqli("服务器地址","用户名","数据库密码","数据库名");
    $conn = new mysqli("112.124.28.149","GZLM-environment","84xHsZyfZMhWBeHz","gzlm-environment");
    if($conn->connect_error){
        die("Could not connect to database");
    }
    //新建一个变量 用来获取网络请求传过来的参数
    $action = "read";
    //新建一个变量用来返回查询的数据
   // $res = array('error' => false);

    //将网络请求传入过来的参数 赋值给$action变量
    if(isset($_REQUEST['action'])){
        $action = $_REQUEST['action'];
    }
        
        //$res = $conn->query("INSERT INTO `test`(`devicename`,`GPS`,`warning`) VALUES ('dewfergeg','sfgdg',1");
        //$res = $conn->query("INSERT INTO `test`(`devicename`) VALUES ('dewfergeg')");
        // $res=$conn->query("SELECt * FROM test");
        // if($res->num_rows>0){
            
        //   $arr=array();
        //   while($row =$res->fetch_object())
        //   {
        //       array_push($arr,$row);
        //   }
        // }
    //     //读取查询数据 如果传入参数是read
    if($action == "read"){
        //返回的数据为utf8编码 防止中文乱码现象
        $conn->query("set names utf8");
        //sql语句 查询test表中的所有数据
        $result = $conn->query("SELECT * FROM `datas`");
        //新建一个数组 接收数据
        $users = array();
        //遍历查询的结果 一行一行的遍历
        while($row = $result->fetch_assoc()){
            array_push($users,$row);
        }
        //将数据放在$res变量里面
        $res['users'] = $users;
    }
    //插入数据 如果传入参数是create
    //if($action == "insert"){
        // 接收POST请求中的数据
        
        //$age = $_POST['age'];
        
        // 插入数据
        //$sql = "INSERT INTO test (devicename) VALUES ('$name')";
        //$stmt = $conn->prepare($sql);
        //$result = mysqli_query($conn,$sql);
        //$stmt->bindParam(':name', $name);
        //$stmt->bindParam(':age', $age);
        //$stmt->execute();
        
        //echo "数据插入成功！";
   // }
    //更新数据
    if($action == "update"){
        
    }
    //删除数据
    if($action == "delete"){
        
    }
    //关闭连接
    $conn->close();
    
    header("Content-type:application/json");

    //以json的格式返回查询到的数据
    echo json_encode($res);

    die();

?>