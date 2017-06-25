<?php

if (htmlspecialchars(trim($_POST['ajax'])) == "1") {
    include '../inc/mysql.php';
    $sql = "SELECT * FROM customer WHERE customer_email = '" . mysqli_real_escape_string($conn, trim($_POST['email'])) . "' AND customer_password = '" . mysqli_real_escape_string($conn, trim(md5($_POST['password']))) . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $response["data"][$i]["customer_id"] = $row["customer_id"];
            $response["data"][$i]["customer_name"] = $row["customer_name"];
            $i++;
        }
        $response["success"] = 1;
    } else {
        $response["message"] = "Tidak ada data yang ditemukan";
        $response["success"] = 0;
    }
    echo json_encode($response);
} else {
    require '../inc/config.php';
    header("Location: " . BASE_URL);
    die();
}


