<?php
    session_start();
    if(!isset($_SESSION['login'])){
        require_once "../database/connection.php";
        require_once "../database/queryBuilder.php";
        $config = require_once "../config.php";
        $pdo = connection::connectConfig($config['database']);
        $DBobj = new queryBuilder($pdo);
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $check = $DBobj->makeQuery("SELECT id FROM users WHERE userName = '" . $_POST['userName'] . "'");
            if(empty($check)){
                if($_POST['password'] != $_POST['confirm-password']){
                    $_SESSION["alert"] = "Two passwords are not same";
                    header("Location: ../index.php");
                }else{
                    $data = [];
                    $data["userName"] = $_POST["userName"];
                    $data["password"] = sha1($_POST['password']);
                    $data["githubId"] = $_SESSION['github-id'];
                    $DBobj->insert('users',$data);
                    $_SESSION["login"] = true;
                    header("Location: ./home.php");
                }
            }else{
                $_SESSION["alert"] = "This Email Already Exist";
                unset($_SESSION['register']);
                header("Location: ../index.php");
            }
        }
    }else{
        header("Location: ./home.php");
    }