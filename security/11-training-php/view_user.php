<?php
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

$user = NULL; // Add new user
$id = NULL;

// Tạo hàm mã hóa ID (ví dụ)
function encrypt_id($id) {
    $mapping = [
        '2' => '*&BUYG',
        '3' => ')(*YH',
        '1' => '@#',
        '4' => '$$',
    ];
    return $mapping[$id] ?? $id; // Trả về ID đã mã hóa hoặc ID gốc nếu không có ánh xạ
}

// Tạo hàm giải mã ID
function decrypt_id($encrypted_id) {
    $mapping = [
        '*&BUYG' => '2',
        ')(*YH' => '3',
        '@#' => '1',
        '$$' => '4',
    ];
    return $mapping[$encrypted_id] ?? null; // Trả về ID đã giải mã hoặc null nếu không có ánh xạ
}

if (!empty($_GET['id'])) {
    $id = decrypt_id($_GET['id']); // Giải mã ID từ URL
    if ($id !== null) {
        $user = $userModel->findUserById($id); // Tìm người dùng bằng ID đã giải mã
    }
}

if (!empty($_POST['submit'])) {
    if (!empty($id)) {
        $userModel->updateUser($_POST);
    } else {
        $userModel->insertUser($_POST);
    }
    header('location: list_users.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Form</title>
    <?php include 'views/meta.php'; ?>
</head>
<body>
<?php include 'views/header.php'; ?>
<div class="container">
    <?php if ($user) { ?>
        <div class="alert alert-warning" role="alert">
            User profile
        </div>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo encrypt_id($id); ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <span><?php echo htmlspecialchars($user[0]['name']); ?></span>
            </div>
            <div class="form-group">
                <label for="fullname">Fullname</label>
                <span><?php echo htmlspecialchars($user[0]['fullname']); ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <span><?php echo htmlspecialchars($user[0]['email']); ?></span>
            </div>
        </form>
    <?php } else { ?>
        <div class="alert alert-danger" role="alert">
            User not found!
        </div>
    <?php } ?>
</div>
</body>
</html>
