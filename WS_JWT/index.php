<?php

require_once 'JWT_class.php';
require_once 'database.php';
$secret = "password";

$api_key = filter_input(INPUT_GET, 'api_key');
$Service = filter_input(INPUT_GET, 'Service');
if ($api_key == Null) {
    if ($Service != "Request_Key") {
        $response = "Error 2";
        echo json_encode($response);
        exit;
    }
}
switch ($Service) {
    case 'Request_Key';
        $token = array();
        $token['userName'] = filter_input(INPUT_GET, 'userName');
        $token['passWord'] = filter_input(INPUT_GET, 'password');
        $token['memType'] = filter_input(INPUT_GET, 'memType');

        $jwt = JWT::encode($token, $secret);

        $query = 'INSERT INTO `account`(`apikey`) VALUES (:apikey)';
        $statement = $db->prepare($query);
        $statement->bindValue(':apikey', $jwt);
        $statement->execute();

        echo $jwt;
        break;
    case 'Service1';
        echo 'service 1 selected';
        $api_key = filter_input(INPUT_GET, 'api_key');

        $query = 'SELECT * FROM `account` WHERE apikey = :apikey';
        $statement = $db->prepare($query);
        $statement->bindValue(':apikey', $api_key);
        $statement->execute();

        foreach ($statement as $row) {
            $account_id = $row['account_id'];
        }

        if (isset($account_id)) {
            try {
                $token = JWT::decode($api_key, $secret);
                echo getAllBooks();
            } catch (Exception $ex) {
                return 'Error';
            }
        } else {
            $response = "Not A Memeber";
            echo json_encode($response);
        }
        break;

    case 'Service2';
        $api_key = filter_input(INPUT_GET, 'api_key');

        $query = 'SELECT * FROM `account` WHERE apikey = :apikey';
        $statement = $db->prepare($query);
        $statement->bindValue(':apikey', $api_key);
        $statement->execute();

        foreach ($statement as $row) {
            $account_id = $row['account_id'];
        }

        if (isset($account_id)) {
            try {

                $value = get_object_vars(JWT::decode($api_key, $secret));
                if ($value['memType'] == "premium") {
                    $bookCategory = filter_input(INPUT_GET, 'category');
                    echo getBookCategory($bookCategory);
                } else {
                    $response = "Upgrade Membership To Use Serivce";
                    echo json_encode($response);
                }
            } catch (Exception $ex) {
                return 'Error';
            }
        } else {
            $response = "Not A Memeber";
            echo json_encode($response);
        }

        break;
    case 'Service3';
        $api_key = filter_input(INPUT_GET, 'api_key');

        $query = 'SELECT * FROM `account` WHERE apikey = :apikey';
        $statement = $db->prepare($query);
        $statement->bindValue(':apikey', $api_key);
        $statement->execute();

        foreach ($statement as $row) {
            $account_id = $row['account_id'];
        }

        if (isset($account_id)) {
            try {

                $value = get_object_vars(JWT::decode($api_key, $secret));
                if ($value['memType'] == "premium") {
                    $date1 = filter_input(INPUT_GET, 'date1');
                    $date2 = filter_input(INPUT_GET, 'date2');
                    echo getBookByDate($date1,$date2);
                } else {
                    $response = "Upgrade Membership To Use Serivce";
                    echo json_encode($response);
                }
            } catch (Exception $ex) {
                return 'Error';
            }
        } else {
            $response = "Not A Memeber";
            echo json_encode($response);
        }

        break;
}

function getAllBooks() {
    global $db;
    $query = "SELECT * FROM book;";
    $statement = $db->prepare($query);
    $statement->execute();

    $json = "[";
    if ($statement->rowCount() > 0) {
        /* Get field information for all fields */
        $isFirstRecord = true;
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $row) {
            if (!$isFirstRecord) {
                $json .= ",";
            }
            $json .= '{"title":"' . $row->title . '","image":"' . $row->image . '","description":"' . $row->description . '","category":"' . $row->category . '","ISBN":"' . $row->ISBN . '","author":"' . $row->author . '","year":"' . $row->year . '"}';

            $isFirstRecord = false;
        }
    }
    $json .= "]";
    return $json;
}

function getBookCategory($bookCategory) {
    global $db;
    $query = "SELECT * FROM book Where category = :book_category;";
    $statement = $db->prepare($query);
    $statement->bindValue(":book_category", $bookCategory);
    $statement->execute();


    $json = "[";
    if ($statement->rowCount() > 0) {
        /* Get field information for all fields */
        $isFirstRecord = true;
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $row) {
            if (!$isFirstRecord) {
                $json .= ",";
            }
            $json .= '{"title":"' . $row->title . '","image":"' . $row->image . '","description":"' . $row->description . '","category":"' . $row->category . '","ISBN":"' . $row->ISBN . '","author":"' . $row->author . '","year":"' . $row->year . '"}';

            $isFirstRecord = false;
        }
    }
    $json .= "]";
    return $json;
}
function getBookByDate($date1 , $date2) {
    global $db;
    $query = "SELECT * FROM `book` WHERE (SELECT YEAR(year)) BETWEEN :year_1 AND :year_2;";
    $statement = $db->prepare($query);
    $statement->bindValue(":year_1",$date1);
    $statement->bindValue(":year_2",$date2);
    $statement->execute();

    
    $json = "[";
    if ($statement->rowCount() > 0) {
        /* Get field information for all fields */
        $isFirstRecord = true;
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $row) {
            if (!$isFirstRecord) {
                $json .= ",";
            }
            $json .= '{"title":"' . $row->title . '","image":"' . $row->image . '","description":"' . $row->description . '","category":"' . $row->category . '","ISBN":"' . $row->ISBN . '","author":"' . $row->author . '","year":"' . $row->year . '"}';

            $isFirstRecord = false;
        }
    }
    $json .= "]";
    return $json;
}