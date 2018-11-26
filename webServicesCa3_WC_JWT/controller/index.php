        
<?php
include_once '../model/session_start.php';
require_once'../model/database.php';
require_once'../view/nav.php';


//session_unset();
//session_destroy();

if (isset($_SESSION['api_key'])) {
    $api_key = $_SESSION['api_key'];
} else {
    $api_key = null;
}

$action = filter_input(INPUT_POST, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
    if ($action == Null) {
        $action = 'show_login';
    }
}

$basicUrl = "http://localhost/webserca3/WS_JWT/index.php";

switch ($action) {
    case 'show_login';
        include_once '../view/show_login.php';
        break;

    case 'login';

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
            if (strlen($api_key) != 0) {
                $_SESSION['api_key'] = $api_key;
                include '../view/show_token.php';
            } else {
                include '../view/show_request_token.php';
            }
        } else {
            include '../view/login_error.php';
        }
        break;
    case 'show_request_token';
        include '../view/show_request_token.php';
        break;
    case 'request_token';

        $userName = filter_input(INPUT_POST, 'userName');
        $password = filter_input(INPUT_POST, 'password');
        $memType = filter_input(INPUT_POST, 'memType');
        $keyReq = "?userName=" . $userName
                . "&password=" . $password
                . "&memType=" . $memType
                . "&Service=Request_Key";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $basicUrl . $keyReq);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
        curl_setopt($ch, CURLOPT_HEADER, False);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
        $api_key = curl_exec($ch);
        curl_close($ch);



        $_SESSION['api_key'] = $api_key;
        $account_Id = $_SESSION['account_id'];



        $query = 'UPDATE `account` SET `apikey` = :apikey WHERE account_id = :account_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':apikey', $api_key);
        $statement->bindValue(':account_id', $account_Id);
        $statement->execute();

        include '../view/show_token.php';
        break;
    case 'request_service1';
        $keyReq = "?api_key=" . $api_key . "&Service=Service1";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $basicUrl . $keyReq);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
        curl_setopt($ch, CURLOPT_HEADER, False);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
        $response = curl_exec($ch);
        curl_close($ch);

        include '../view/show_response1.php';
        break;
    case 'request_service2';
        $keyReq = "?api_key=" . $api_key . "&Service=Service2" . "&category=" . "Music";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $basicUrl . $keyReq);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
        curl_setopt($ch, CURLOPT_HEADER, False);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
        $response = curl_exec($ch);
        curl_close($ch);

        include '../view/show_response2.php';
        break;
    case 'request_service3';
        $keyReq = "?api_key=" . $api_key . "&Service=Service3" . "&date1=" . "2010-02-12". "&date2=" . "2018-12-28";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $basicUrl . $keyReq);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
        curl_setopt($ch, CURLOPT_HEADER, False);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
        $response = curl_exec($ch);
        curl_close($ch);

        include '../view/show_response3.php';
        break;
}
?>

<!--Page Content-->

<div class="container">
    <div class="row">
        <?php
        echo '<form id="login_form" action="../controller/index.php" method="post">'
        . '<input type="hidden" name="action" value="request_service1">'
        . '<div class="form-check">'
        . '<button type="submit" class="btn btn-primary" id="reg_button" name="login-submit">Request Service 1</button>'
        . '</div>'
        . '</form';
        ?>
    </div>
    <div class="row">
        <?php
        echo '<form action="../controller/index.php" method="post">'
        . '<input type="hidden" name="action" value="request_service2">'
        . '<div class="form-check">'
        . '<button type="submit" class="btn btn-primary"  name="login-submit">Request Service 2</button>'
        . '</div>'
        . '</form';
        ?>
    </div>
    <div class="row">
        <?php
        echo '<form action="../controller/index.php" method="post">'
        . '<input type="hidden" name="action" value="request_service3">'
        . '<div class="form-check">'
        . '<button type="submit" class="btn btn-primary"  name="login-submit">Request Service 3</button>'
        . '</div>'
        . '</form';
        ?>
    </div>



</div>

