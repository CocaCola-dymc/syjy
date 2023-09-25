<?php 
    //连接数据库
    // $conn = new mysqli("120_77_174_216","120_77_174_216","liangxiaofen","120_77_174_216");
    //$conn = new mysqli("服务器地址","用户名","数据库密码","数据库名");
    $conn = new mysqli("112.124.28.149","GZLM","GZLM61006366","gzlm");
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
    $datetime=date("Y-m-d h:i:s");
    $name = $_POST['devicename'];
    // $GPS = $_POST['GPS'];
    // $warning = $_POST['warning']
    
    if($action == "read_device"){
        $devicename = $_POST['devicename'];
        //返回的数据为utf8编码 防止中文乱码现象
        $conn->query("set names utf8");
        //sql语句 查询datas表中的所有数据
        $result = $conn->query("SELECT * FROM `device` WHERE devicename='$devicename'");
        //新建一个数组 接收数据
        $devices = array();
        //遍历查询的结果 一行一行的遍历
        while($row = $result->fetch_assoc()){
            array_push($devices,$row);
        }
        //将数据放在$res变量里面
        $res['devices'] = $devices;
    }
    
    if($action=='insert'){
        $devicename = $_POST['devicename'];
    // 插入数据
    // $res = $conn->query("INSERT INTO `datas` (`devicename`,`GPS`,`warning`) VALUES ('$name','sfgdg',1)");
        // $sql = "INSERT INTO datas (devicename,GPS,warning,time) VALUES ('$name','$GPS','$warning','$datetime')";
        $sql1 = "INSERT INTO device VALUES (null,'$devicename',now())";
        $result1 = mysqli_query($conn,$sql1);
        
        //根据传入的设备名新建一个表
        $sql2 = "CREATE TABLE `d${devicename}`(
            id INT(11) NOT NULL PRIMARY KEY auto_increment,
            GPS VARCHAR(50) NOT NULL,
            warning INT(11) NOT NULL,
            createdTime VARCHAR(50) NOT NULL
        )";

        $result2 = mysqli_query($conn,$sql2);
        
        if (!$result2) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
          }else{
            //   echo "数据插入成功！";
            echo "数据表新建成功";
          }
    }
        
        //$res = $conn->query("INSERT INTO `datas`(`devicename`,`GPS`,`warning`) VALUES ('dewfergeg','sfgdg',1");
        //$res = $conn->query("INSERT INTO `datas`(`devicename`) VALUES ('dewfergeg')");
        // $res=$conn->query("SELECt * FROM datas");
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
        //sql语句 查询datas表中的所有数据
        $result = $conn->query("SELECT * FROM `datas` WHERE warning<=10");
        //新建一个数组 接收数据
        $users = array();
        //遍历查询的结果 一行一行的遍历
        while($row = $result->fetch_assoc()){
            array_push($users,$row);
        }
        //将数据放在$res变量里面
        $res['users'] = $users;
    }
    
    if($action == "read_card"){
        $card_id = $_POST['card_id'];
        //返回的数据为utf8编码 防止中文乱码现象
        $conn->query("set names utf8");
        //sql语句 查询datas表中的所有数据
        $result = $conn->query("SELECT * FROM `card` WHERE card_id='$card_id'");
        //新建一个数组 接收数据
        $cards = array();
        //遍历查询的结果 一行一行的遍历
        while($row = $result->fetch_assoc()){
            array_push($cards,$row);
        }
        //将数据放在$res变量里面
        $res['cards'] = $cards;
    }
    
    if($action == "read_cards"){
        //返回的数据为utf8编码 防止中文乱码现象
        $conn->query("set names utf8");
        //sql语句 查询datas表中的所有数据
        $result = $conn->query("SELECT * FROM `card`");
        //新建一个数组 接收数据
        $cards = array();
        //遍历查询的结果 一行一行的遍历
        while($row = $result->fetch_assoc()){
            array_push($cards,$row);
        }
        //将数据放在$res变量里面
        $res['cards'] = $cards;
    }
    
    if($action == "insert_card"){
        $username = $_POST['username'];
        $card_id = $_POST['card_id'];
        //返回的数据为utf8编码 防止中文乱码现象
        $conn->query("set names utf8");
        //sql语句 查询datas表中的所有数据
        $sql = $conn->query("INSERT INTO card VALUES (null,'$username','$card_id',now())");
        $result = mysqli_query($conn,$sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }else{
        //   echo "数据插入成功！";
            echo "新卡添加成功";
        }
    }
    //插入数据 如果传入参数是create
    //if($action == "insert"){
        // 接收POST请求中的数据
        
        //$age = $_POST['age'];
        
        // 插入数据
        //$sql = "INSERT INTO datas (devicename) VALUES ('$name')";
        //$stmt = $conn->prepare($sql);
        //$result = mysqli_query($conn,$sql);
        //$stmt->bindParam(':name', $name);
        //$stmt->bindParam(':age', $age);
        //$stmt->execute();
        
        //echo "数据插入成功！";
   // }
    //更新数据
    if($action == "update"){
        $username = $_POST['username'];
        $card_id = $_POST['card_id'];
        //返回的数据为utf8编码 防止中文乱码现象
        $conn->query("set names utf8");
        //sql语句 查询datas表中的所有数据
        $sql = $conn->query("UPDATE card SET username='$username',time=now() WHERE card_id='$card_id'");
        $result = mysqli_query($conn,$sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }else{
        //   echo "数据插入成功！";
            echo "修改成功";
        }
    }
    //删除卡
    if($action == "delete"){
        $card_id = $_POST['card_id'];
        //返回的数据为utf8编码 防止中文乱码现象
        $conn->query("set names utf8");
        //sql语句 查询datas表中的所有数据
        $sql = $conn->query("DELETE FROM card WHERE card_id='$card_id'");
        $result = mysqli_query($conn,$sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }else{
        //   echo "数据插入成功！";
            echo "删除成功";
        }
    }
    //删除数据
    if($action == "delete_data"){
        $id = $_POST['id'];
        $sql = "DELETE FROM datas WHERE id='$id'";
        $result = mysqli_query($conn,$sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }else{
            echo "数据删除成功！";
        }
    }
    //关闭连接
    $conn->close();
    
    header("Content-type:application/json");

    //以json的格式返回查询到的数据
    echo json_encode($res);

    die();

?>