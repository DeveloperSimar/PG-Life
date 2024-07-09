<?php 
    session_start();

    header('Content-Type:application/json');

    $db_host = "127.0.0.1";
    $db_user = "root";
    $db_pswd = "";
    $db_name = "pg_life";

    //user data
    $full_name = $_POST['full_name'];
    $ph_no = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $college_name = $_POST['college_name'];
    $gender = $_POST['gender'];

    //connect database
    $conn = mysqli_connect($db_host, $db_user, $db_pswd, $db_name);
    if(!$conn){
        $response = array("success" => false, "message" => "Something went wrong!");
        echo json_encode($response);
        return;
    };

    $sql = "SELECT * FROM users WHERE gmail='$email'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $response = array("success" => false, "message" => "Something went wrong!");
        echo json_encode($response);
	return;
    }

    $row_count = mysqli_num_rows($result);
    if ($row_count != 0) {
        $response = array("success" => false, "message" => "This email is already exist...");
        echo json_encode($response);
	return;
    }


    //sql query
    $sql = "insert into users(`u_name`, `phno`, `gmail`, `pswd`, `gender`, `college_name`) values('$full_name', $ph_no, '$email', '$password', '$gender', '$college_name')";

    //database update
    $result = mysqli_query($conn, $sql);
    if(!$result){
        $response = array("success" => false, "message" => "Something went wrong!");
        echo json_encode($response);
        return;
    }

    $sql = "SELECT * FROM users WHERE gmail='$email'";
    $result_2 = mysqli_query($conn, $sql);
    if(!$result_2){
        $response = array("success" => false, "message" => "Something went wrong!");
        echo json_encode($response);
        return;
    }

    $row = mysqli_fetch_assoc($result_2);

    $_SESSION = array(
        "u_name" => $full_name,
        "phno" => $ph_no,
        "gmail" => $email,
        "pswd" => $password,
        "gender" => $gender,
        "college_name" => $college_name
    );
    $_SESSION['u_id'] = $row['u_id'];
  

    $response = array("success" => true, "message" => "Registration Successful!");
    echo json_encode($response);

    //close database connection
    mysqli_close($conn);

?>