<?php
// Hàm lưu dữ liệu vào file JSON
function saveDataJSON($filename, $data) {
    $currentData = [];
    if (file_exists($filename)) {
        $jsonContent = file_get_contents($filename);
        $currentData = json_decode($jsonContent, true) ?: [];
    }
    $currentData[] = $data;
    $jsonContent = json_encode($currentData, JSON_PRETTY_PRINT);
    return file_put_contents($filename, $jsonContent) !== false;
}

// Khởi tạo các biến để lưu thông báo lỗi và thành công
$errors = [];
$successMessage = "";

// Xử lý biểu mẫu khi người dùng gửi dữ liệu
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Kiểm tra dữ liệu nhập
    if (empty($username)) {
        $errors[] = "Username là bắt buộc.";
    }

    if (empty($email)) {
        $errors[] = "Email là bắt buộc.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Imail không đúng định dạng.";
    }

    if (empty($password)) {
        $errors[] = "Password là bắt buộc.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password phải có 8 ký tự trở lên.";
    }

    // Nếu không có lỗi, lưu thông tin vào file JSON
    if (empty($errors)) {
        $userData = [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT), // Mã hóa mật khẩu
        ];

        if (saveDataJSON('users.json', $userData)) {
            $successMessage = "Đăng ký thành công!";
        } else {
            $errors[] = "Kết nối thất bại";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>User Registration Form</h1>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($successMessage): ?>
        <div class="success">
            <p><?php echo htmlspecialchars($successMessage); ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"><br><br>

        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
