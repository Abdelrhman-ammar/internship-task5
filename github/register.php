<?php
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['code'])){
    session_start();
    // get user code
    $_SESSION['code'] = $_GET['code'];
    //get access token 
    $data = "code=" . $_SESSION["code"] . "&client_id=" . $_SESSION["client_id"]
    . "&client_secret=" . $_SESSION["client_secret"];
    $curl_connection = curl_init("https://github.com/login/oauth/access_token");
    curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $data);
    //set connetion option
    curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
    //execute the form
    $response = curl_exec($curl_connection);
    curl_close($curl_connection);


    $Arr = explode("&",$response);
    $response = [];
    foreach($Arr as $value){
        $d = explode("=",$value);
        $response[$d[0]] = $d[1];
    }
    $_SESSION["access_token"] =  $response["access_token"];
    $_SESSION["token_type"] =  $response["token_type"];

    //access github api
    $data = "Authorization: " . $_SESSION["token_type"] ." ". $_SESSION["access_token"];
    $curl_connection = curl_init();
    curl_setopt_array($curl_connection, [
        CURLOPT_URL => "https://api.github.com/user",
        CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
        CURLOPT_HTTPHEADER => array('Content-Type: application/json',$data),
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => 1,
    ]);
    $response = curl_exec($curl_connection);
    curl_close($curl_connection);
    $Res = json_decode($response);
    $_SESSION['name'] = $Res->login;
    $_SESSION['github-id'] = $Res->id;
    $_SESSION['register'] = true;
    $_SESSION['info'] = "Enter The New password";
    header("Location: ../index.php");
}else{
    header("Location: ../index.php");
}