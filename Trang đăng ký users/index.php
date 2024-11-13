<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký người dùng</title>
</head>
<body>

<h2>Trang đăng ký người dùng</h2>
<form method="POST" action="">
    <label>Tên người dùng:</label><br>
    <input type="text" name="name"><br><br>

    <label for="email">Email:</label><br>
    <input type="text" name="email"><br><br>

    <label for="phone">Điện thoại:</label><br>
    <input type="text" name="phone"><br><br>

    <input type="submit" value="Đăng ký">
</form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    $errors = [];
    if (empty($name)) {
        $errors[] = "Tên không được để trống.";
    }
    if (empty($email)) {
        $errors[] = "Email không được để trống.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không đúng định dạng.";
    }
    if (empty($phone)) {
        $errors[] = "Điện thoại không được để trống.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    } else {

        if (saveDataJSON('users.json', $name, $email, $phone)) {
            echo "<p>Đăng ký thành công!</p>";
        } else {
            echo "<p>Đã xảy ra lỗi.</p>";
        }
    }
}

function saveDataJSON($filename, $name, $email, $phone) {
    $contact = [
        "name" => $name,
        "email" => $email,
        "phone" => $phone
    ];

    $data = [];
    if (file_exists($filename)) {
        $jsonData = file_get_contents($filename);
        $data = json_decode($jsonData, true);
    }
    $data[] = $contact;
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    return file_put_contents($filename, $jsonData) !== false;
}
?>

</body>
</html>
