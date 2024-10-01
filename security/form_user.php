<?php
// Bắt đầu phiên làm việc
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

$user = NULL; // Để thêm người dùng mới
$_id = NULL;

// Khởi tạo biến để lưu thông tin lỗi
$errors = [];

// Kiểm tra xem có id không, nếu có thì cập nhật thông tin người dùng
if (!empty($_GET['id'])) {
    $_id = $_GET['id'];
    $user = $userModel->findUserById($_id); // Cập nhật thông tin người dùng
}

// Xử lý form khi người dùng gửi dữ liệu
if (!empty($_POST['submit'])) {
    $data = [
        'name' => trim($_POST['name']),
        'password' => trim($_POST['password']),
    ];

    // Kiểm tra thông tin tên người dùng
    if (empty($data['name'])) {
        $errors[] = 'Tên người dùng là bắt buộc.';
    } elseif (!preg_match('/^[A-Za-z0-9]{5,15}$/', $data['name'])) {
        $errors[] = 'Tên người dùng phải là ký tự hợp lệ (A-Z, a-z, 0-9) và chiều dài từ 5 đến 15 ký tự.';
    }

    // Kiểm tra thông tin mật khẩu
    if (empty($data['password'])) {
        $errors[] = 'Mật khẩu là bắt buộc.';
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*()]).{5,10}$/', $data['password'])) {
        $errors[] = 'Mật khẩu phải bao gồm chữ thường, chữ HOA, số và ký tự đặc biệt (~!@#$%^&*()), và chiều dài từ 5 đến 10 ký tự.';
    }

    // Nếu không có lỗi, thêm hoặc cập nhật người dùng
    if (empty($errors)) {
        if (!empty($_id)) {
            $userModel->updateUser($data); // Cập nhật thông tin người dùng
        } else {
            $userModel->insertUser($data); // Thêm người dùng mới
        }
        header('Location: list_users.php');
        exit; // Dừng lại để không thực hiện các lệnh tiếp theo
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User form</title>
    <?php include 'views/meta.php'; ?>
</head>
<body>
    <?php include 'views/header.php' ?>
    <div class="container">
        <?php if ($user || !isset($_id)) { ?>
            <div class="alert alert-warning" role="alert">
                User form
            </div>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($_id); ?>">
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" name="name" placeholder="Name" value='<?php echo htmlspecialchars($user[0]['name'] ?? ''); ?>' required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
            </form>
        <?php } else { ?>
            <div class="alert alert-danger" role="alert">
                User not found!
            </div>
        <?php } ?>
    </div>
</body>
</html>
