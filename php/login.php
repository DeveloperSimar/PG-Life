<?php
    session_start();

    ob_start();

    $db_host = "127.0.0.1";
    $db_user = "root";
    $db_pswd = "";
    $db_name = "pg_life";

    //user data
    $email = $_POST['email'];
    $password = $_POST['password'];

    //database conntion
    $conn = mysqli_connect($db_host, $db_user, $db_pswd, $db_name);
    if(!$conn){
        $response = array("success" => false, "message" => "Something went wrong!");
        echo json_encode($response);
        ob_end_flush();
        exit;
    };

    //fetch user data
    $sql = "SELECT * FROM users WHERE gmail='$email' and pswd='$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        $response = array("success" => false, "message" => "Login failed! Invalid email or password.");
        echo json_encode($response);
        ob_end_flush();
	exit;
    }
    // user session info
    $_SESSION['u_name'] = $row['u_name'];
    $_SESSION['u_id'] = $row['u_id'];

    $response = array("success" => true, "message" => "Login successful!");
    echo json_encode($response);
    ob_end_flush();
    
    //close database connection
    mysqli_close($conn);

?>