<?php
require_once "./config.php";

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email1 = trim($_POST['email']);
    $password1 = trim($_POST['password']);
    $role = 'user';






    $sql = "SELECT * FROM  customer WHERE email = '$email1'";
    $result = mysqli_query($conn, $sql);
    $flag = 0;
    while ($row = $result->fetch_assoc()) {

        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $id = $row['id'];
        //$status = $row['status'];
        if ($email1 == $email) {
            if ($password1 == $password) {
                $flag = 1;
                break;
                
            } else {
                $response['error'] = true;
                $response['msg']   = "Password is Wrong!";
            }
        } else {
            $response['error'] = true;
            $response['msg']   = "Email does not Exit!";
        }
    }

    if($flag ==1 ){
        $response['error'] = false;
        $response['msg']   = "Log In Successfull";
        session_start();
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email1;
        $_SESSION["login"] = true;
        $_SESSION["id"] = $id;
    }
    echo json_encode($response);
}