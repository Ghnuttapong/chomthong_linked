<?php

session_start();
include './db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $id = $_SESSION['user_id'];
        $link = $_POST['link'];

        foreach ($_POST as $val) {
            if ($val == '') {
                http_response_code(400);
                echo json_encode(['msg' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
                return;
            }
        }
        $conn = new db();

        $result = $conn->update_where('students', ['link'], [$link, $id], 'user_id');

        http_response_code(200);
        echo json_encode(['msg' => 'ส่งลิงค์เรียบร้อยแล้ว']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['msg' => 'Server Error']);;
    }
} else {
    http_response_code(405);
    echo json_encode(['msg' => 'Method Not Allowed.']);;
}
