<?php
session_start();

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");

$db_host = "127.0.0.1";
$db_user = "root";
$db_pswd = "";
$db_name = "pg_life";
//connect database
$conn = mysqli_connect($db_host, $db_user, $db_pswd, $db_name);
if (!$conn) {
    $response = array("success" => false, "message" => "Something went wrong!");
    echo json_encode($response);
    return;
};

if (!isset($_SESSION['u_id'])) {
    $response = array("success" => false, "logged_in" => false);
    echo json_encode($response);
    return;
};

$user_id = $_SESSION['u_id'];
$property_id = $_GET['property_id'];

$sql = "select * from users_properties where user_id = $user_id and property_id = $property_id";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo json_encode(array("success" => false, "message" => "Something went wrong!"));
    return;
};

if (mysqli_num_rows($result) > 0) {
    $sql_2 = "delete from users_properties where user_id = $user_id and property_id = $property_id";
    $result_2 = mysqli_query($conn, $sql_2);
    if (!$result_2) {
        echo json_encode(array("success" => false, "message" => "Something went wrong!"));
        return;
    } else {
        echo json_encode(array("success" => true, "is_intrested" => false, "property_id" => $property_id));
        return;
    }
} else {
    $sql_3 = "insert into users_properties(user_id, property_id) values ($user_id, $property_id)";
    $result_3 = mysqli_query($conn, $sql_3);
    if (!$result_3) {
        echo json_encode(array("success" => false, "message" => "Something went wrong!"));
        return;
    } else {
        echo json_encode(array("success" => true, "is_interested" => true, "property_id" => $property_id));
        return;
    }
};

?>
