<?php

if (htmlspecialchars(trim($_POST['ajax'])) == "1") {
    include '../inc/mysql.php';
    $sql = 'INSERT INTO customer (
        customer_name, 
        customer_hp, 
        customer_email, 
        customer_password, 
        customer_type) VALUES (
        "' . mysqli_real_escape_string($conn, trim($_POST['name'])) . '",
        "' . mysqli_real_escape_string($conn, trim($_POST['hp'])) . '", 
        "' . mysqli_real_escape_string($conn, trim($_POST['email'])) . '", 
        "' . mysqli_real_escape_string($conn, trim(md5($_POST['password']))) . '", 
        "expert")';
    if (mysqli_query($conn, $sql)) {
        $response["success"] = 1;
    } else {
        $response["message"] = mysqli_error($conn);
        $response["success"] = 0;
    }
    $register = "Expert : Please immediately be followed up | Prospective buyer : " . mysqli_real_escape_string($conn, trim($_POST['name'])) .
            " (" . mysqli_real_escape_string($conn, trim($_POST['hp'])) . " / " . mysqli_real_escape_string($conn, trim($_POST['email'])) . ")";
    file_get_contents("https://api.telegram.org/bot123:key/sendMessage?chat_id=-123&text=" . $register);
    file_get_contents("https://api.telegram.org/bot123:key/sendMessage?chat_id=-123&text=" . $register);
    echo json_encode($response);
} else {
    require '../inc/config.php';
    header("Location: " . BASE_URL);
    die();
}