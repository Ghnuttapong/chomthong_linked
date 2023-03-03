<?php 

include './db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $id = $_POST['id'];

        $conn = new db();
        $result = $conn->update_where('users', ['enabled'], [1, $id], 'id');

        http_response_code(200);
        echo json_encode(['msg' => 'อนุมัติเรียบร้อยแล้ว']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['msg' => 'Server Error']);;
    }
} else {
    http_response_code(405);
    echo json_encode(['msg' => 'Method Not Allowed.']);;
}



?>