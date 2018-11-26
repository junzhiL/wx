<?php
    header("Content-type: text/html; charset=utf-8");
        $user_name = $_POST['user_name'];
        $user_pwd = $_POST['user_pwd'];
        $user_pwd2 = $_POST['user_pwd2'];
        if ($user_name == ''){
            echo '<script>alert("请输入用户名！");history.go(-1);</script>';
            exit(0);
        }
        if ($user_pwd == ''){
            echo '<script>alert("请输入密码");history.go(-1);</script>';
            exit(0);
        }
        if ($user_pwd != $user_pwd2){
            echo '<script>alert("密码与确认密码应该一致");history.go(-1);</script>';
            exit(0);
        }
        if($user_pwd == $user_pwd2){
            $conn = new mysqli('localhost','sql154_8_139_13','root','sql154_8_139_13');
            if ($conn->connect_error){
                echo '数据库连接失败！';
                exit(0);
            }else {
                $sql = "select user_name from users where user_name = '$_POST[user_name]'";
                $result = $conn->query($sql);
                $number = mysqli_num_rows($result);
                if ($number) {
                    echo '<script>alert("用户名已经存在");history.go(-1);</script>';
                } else {
                    $sql_insert = "insert into users (user_name,user_pwd) values('$_POST[user_name]','$_POST[user_pwd]')";
                    $res_insert = $conn->query($sql_insert);
                    if ($res_insert) {
                         $this->redirect(url('index/index'));
                    } else {
                        echo "<script>alert('系统繁忙，请稍候！');</script>";
                    }
                }
            }
        }else{
            echo "<script>alert('提交未成功！'); history.go(-1);</script>";
        }
?>
