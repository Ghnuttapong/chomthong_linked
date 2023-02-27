<?php
include '../db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        foreach ($_POST as $val) {
            if ($val == '') {
                http_response_code(400);
                echo json_encode(['msg' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
                return;
            }
        }

        $conn = new db();
        $value = $conn->select_fetch('users', ['*'], ['username', 'password'], [$username, $password]);
        if (!$value) {
            http_response_code(400);
            echo json_encode(['msg' => 'ไม่พบรายชื่อผู้ใช้งาน']);
            return;
        }

        if(!$value['enabled']) {
            http_response_code(400);
            echo json_encode(['msg' => 'ไม่พบรายชื่อผู้ใช้งาน']);
            return;
        }

        $_SESSION['user_id'] = $value['id'];
        $_SESSION['fullname'] = $value['fullname'];
        $_SESSION['username'] = $value['username'];
        $_SESSION['password'] = $value['password'];
        $_SESSION['role'] = $value['role'];
        $url = './user/index.php';
        if($value['role']) {
            $value['role'] == 2 ? $url = './index.php' : $url = './site.php';
        }
        http_response_code(200);
        echo json_encode(['msg' => 'ยินดีต้อนรับเข้าสู่ระบบ', 'url' => $url]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo 'Server Error';
    }
} else {
    http_response_code(405);
    echo 'Method Not Allowed.';
}
