<?php

if (htmlspecialchars(trim($_POST['ajax'])) == "1") {
    include './inc/mysql.php';
    $sql = 'INSERT INTO customer_has_expert (
        customer_customer_id, 
        expert_expert_id, 
        customer_has_expert_duration, 
        customer_has_expert_start, 
        customer_has_expert_onsite, 
        customer_has_expert_province, 
        customer_has_expert_total) VALUES (
        "' . mysqli_real_escape_string($conn, trim($_POST['customer_id'])) . '",
        "' . mysqli_real_escape_string($conn, trim($_POST['expert_id'])) . '", 
        "' . mysqli_real_escape_string($conn, trim($_POST['duration'])) . '", 
        "' . mysqli_real_escape_string($conn, trim($_POST['start'])) . '", 
        "' . mysqli_real_escape_string($conn, trim($_POST['onsite'])) . '", 
        "' . mysqli_real_escape_string($conn, trim($_POST['province'])) . '", 
        "' . mysqli_real_escape_string($conn, trim($_POST['price'])) . '")';
    if (mysqli_query($conn, $sql)) {
        $response["success"] = 1;
    } else {
        $response["message"] = mysqli_error($conn);
        $response["success"] = 0;
    }
    $customer_result = mysqli_query($conn, "SELECT * FROM customer WHERE customer_id = " . mysqli_real_escape_string($conn, trim($_POST['customer_id'])));
    $expert_result = mysqli_query($conn, "SELECT * FROM expert WHERE expert_id = " . mysqli_real_escape_string($conn, trim($_POST['expert_id'])));
    $customer = mysqli_fetch_assoc($customer_result);
    $expert = mysqli_fetch_assoc($expert_result);
    $name = $customer['customer_name'];
    $to = $customer['customer_email'];
    $subject = "Invoice";
    $from = 'Sender <no-reply@server.distroit.com>';
    $body = 'Hi ' . $name . ', <br/><br>This is your invoice : Rp ' . number_format(mysqli_real_escape_string($conn, trim($_POST['price'])), 2, ",", ".");
    $headers = "From: " . ($from) . "\r\n";
    $headers .= "Reply-To: " . ($from) . "\r\n";
    $headers .= "Return-Path: " . ($from) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
    mail($to, $subject, $body, $headers, "-f " . $from);
    $order = "Expert : " . $_POST['product'] . " | Buyer : " . $customer['customer_name'] .
            " (" . $customer['customer_hp'] . " / " . $customer['customer_email'] . ") | Expert : " . $expert['expert_name'] .
            " (" . $expert['expert_hp'] . ") | Start date : " .
            mysqli_real_escape_string($conn, trim($_POST['start'])) . " | Duration : " .
            mysqli_real_escape_string($conn, trim($_POST['duration'])) .
            " " . ((mysqli_real_escape_string($conn, trim($_POST['duration'])) == 1) ? "day | " : "days | ") .
            "Onsite : " . mysqli_real_escape_string($conn, trim($_POST['onsite'])) .
            " | " . ((mysqli_real_escape_string($conn, trim($_POST['onsite'] == "yes"))) ? "Province : " . mysqli_real_escape_string($conn, trim($_POST['province'])) . " | " : "") .
            "Total : Rp " . mysqli_real_escape_string($conn, number_format(trim($_POST['price']), 2, ",", ".")) . "";
    file_get_contents("https://api.telegram.org/bot123:key/sendMessage?chat_id=-123&text=" . $order);
    file_get_contents("https://api.telegram.org/bot123:key/sendMessage?chat_id=-123&text=" . $order);
    echo json_encode($response);
} else {
    require './inc/config.php';
    header("Location: " . BASE_URL);
    die();
}