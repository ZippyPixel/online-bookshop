<?php

require_once "./config.php";
$response = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $number = trim($_POST['number']);
    $address = trim($_POST['address']);
    $password = trim($_POST['password']);
    //$role = 'user';
    //$status = 1;

    // // File upload path
    // $targetDir = "img/";
    // $fileName = basename($_FILES["file"]["name"]);
    // $targetFilePath = $targetDir . $fileName;
    // $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // // Allow certain file formats
    // $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
    // if (in_array($fileType, $allowTypes)) {
    //     // Upload file to server
    //     if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
    //         $insert = $conn->query("INSERT into pic  VALUES (Null,'" . $fileName . "', NOW())");
    //     }
    // }


    $sql = "SELECT * FROM  customer WHERE email LIKE '$email'";
    $result = mysqli_query($conn, $sql);
    $flag = 0;
    while ($row = $result->fetch_assoc()) {

        $email1 = $row['email'];
        if ($email1 == $email) {
            $response['error'] = true;
            $response['msg']   = "This  email has already been used!";
            $flag = 1;
            break;
        }
    }
    if ($flag != 1) {
        $sql1 = "INSERT INTO customer ( name, address, phone_no, email, password)  VALUES ('$name','$address','$number', '$email','$password')";

        if (!mysqli_query($conn, $sql1)) {
            $response['error'] = true;
            $response['msg']   = "Connection Failed! Try Again!";;
        } else {
            $response['error'] = false;
            $response['msg']   = "";
            $sql2 = "INSERT INTO cart (customer_id) SELECT id FROM customer WHERE email='$email';";
            if(!mysqli_query($conn, $sql2)){
                $response['error'] = true;
                $response['msg']   = "Connection Failed! Try Again!";;
            }
            else{
                $response['error'] = false;
                $response['msg']   = "";
            }
        }
    }
    echo json_encode($response);
}