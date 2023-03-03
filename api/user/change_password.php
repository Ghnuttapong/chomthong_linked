<?php
session_start();
include '../db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        foreach ($_POST as $val) {
            if ($val == '') {
                http_response_code(400);
                echo json_encode(['msg' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
                return;
            }
        }
        $cur_pw = md5($_POST['curent_password']);
        $new_pw = md5($_POST['new_password']);
        $cf_pw = md5($_POST['confirm_password']);
        if ($cur_pw != $_SESSION['password']) {
            http_response_code(400);
            echo json_encode(['msg' => 'รหัสผ่านเดิมไม่ถูกต้อง']);
            return;
        }
        if ($new_pw != $cf_pw) {
            http_response_code(400);
            echo json_encode(['msg' => 'รหัสผ่านไม่ตรงกัน']);
            return;
        }

        $conn = new db();

        $result = $conn->update_where('users', ['password'], [$cf_pw, $_SESSION['user_id']], 'id');

        http_response_code(200);
        echo json_encode(['msg' => 'อัพเดทรหัสผ่านเรียบร้อยแล้ว']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['msg' => 'Server Error']);;
    }
} else {
    http_response_code(405);
    echo json_encode(['msg' => 'Method Not Allowed.']);;
}
