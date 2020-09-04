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
            $pass = sha1($_POST['password']);
            $check = $DBobj->makeQuery("SELECT userName FROM users WHERE userName = '{$_POST['userName']}' and password = '{$pass}'");
            if(empty($check)){
                $_SESSION["alert"] = "Email And Password Doesm't Match";
                header("Location: ../index.php");
            }else{
                $_SESSION["name"] = $check[0]['userName'];
                $_SESSION['login'] = true;
                header("Location: ./home.php");
            }
        }
    }else{
        header("Location: ./home.php");
    }