<?php 

include '../db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $id = $_POST['id'];
        $conn = new db();

        $result = $conn->delete_where('users', "id = $id");
        $result = $conn->delete_where('students', "user_id = $id");

        http_response_code(200);
        echo json_encode(['msg' => 'ข้อมูลถูกลบแล้ว.']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['msg' => 'Server Error']);;
    }
} else {
    http_response_code(405);
    echo json_encode(['msg' => 'Method Not Allowed.']);;
}
