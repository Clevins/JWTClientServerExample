<?php

require 'database.php';

if (isset($_POST['login-submit'])) {
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    $query = 'SELECT * FROM `account` WHERE username = :username AND password = :password';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $password);
    $statement->execute();

    foreach ($statement as $row) {
        $account_id = $row['account_id'];
        $api_key = $row['apikey'];
        
    }
    if (isset($account_id)) {
        $_SESSION['account_id'] = $account_id;
        if(strlen($api_key)!=0){
           $_SESSION['api_key']=$api_key;
        }
        print_r($_SESSION);
        
        include '../controller/home.php';
        
    } else {
        include '../controller/login_error.php';
    }
} else {
    header("location: ../controller/login.php");
    exit();
}
