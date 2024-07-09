<?php
session_start();

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$db_host = "127.0.0.1";
$db_user = "root";
$db_pswd = "";
$db_name = "pg_life";

//database conntion
$conn = mysqli_connect($db_host, $db_user, $db_pswd, $db_name);
if (!$conn) {
    echo "Connection Failed: " . mysqli_connect_error();
    exit;
};

$user_id = isset($_SESSION['u_id']) ? $_SESSION['u_id'] : null;
$city_name = $_GET['city'];

$sql_1 = "SELECT * FROM cities WHERE c_name = '$city_name'";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo "Something went wrong!";
    return;
}
$city = mysqli_fetch_assoc($result_1);
if (!$city) {
    echo "Sorry! We do not have any PG listed in this city.";
    return;
}
$city_id = $city['c_id'];


$sql_2 = "SELECT * FROM properties WHERE city_id = $city_id";
$result_2 = mysqli_query($conn, $sql_2);
if (!$result_2) {
    echo "Something went wrong!";
    return;
}

$properties = mysqli_fetch_all($result_2, MYSQLI_ASSOC);

$sql_3 = "SELECT * 
            FROM users_properties iup
            INNER JOIN properties p ON iup.property_id = p.p_id
            WHERE p.city_id = $city_id";
$result_3 = mysqli_query($conn, $sql_3);
if (!$result_3) {
    echo "Something went wrong!";
    return;
}
$users_properties = mysqli_fetch_all($result_3, MYSQLI_ASSOC);



$result_properties = array();
foreach($properties as $property){
    //fetch image
    $property_images = glob("../img/properties/" . $property['p_id'] . "/*");
    $property_image = $property_images[0];

    $interested_users_count = 0;
    $is_interested = false;
    foreach($users_properties as $interested_property){
        if($interested_property['property_id'] == $property['p_id']){
            $interested_users_count++;
        }

        if($interested_property['user_id'] == $user_id && $interested_property['property_id'] == $property['p_id']){
            $is_interested = true;
        }
    }

    //insert into each property entity
    $property['p_image'] = $property_image;
    $property['like_count'] = $interested_users_count;
    $property['is_interested'] = $is_interested;

    //push properties data into an array
    $result_properties[] = $property;
}

//send json response
echo json_encode($result_properties);

?>