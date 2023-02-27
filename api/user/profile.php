<?php


session_start();
include '../db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $date = date("YmdHis");
        $numrand = (mt_rand());
        if ($_FILES['file']) {   
            $path = "../../assets/profile/";

            $type = strrchr($_FILES['file']['name'], ".");

            $newname = $date . $numrand . $type;
            $path_copy = $path . $newname;

            move_uploaded_file($_FILES['file']['tmp_name'], $path_copy);
        } else {
            http_response_code(400);
            echo json_encode(['msg' => 'ไม่สามารถเพิ่มรูปภาพได้']);
            return;
        }

        $conn = new db();
        $result = $conn->update_where('users', ['path'], [$newname, $_SESSION['user_id']], 'id');

        http_response_code(200);
        echo json_encode(['msg' => 'อัพเดทรูปภาพเรียบร้อยแล้ว']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['msg' => 'Server Error']);;
    }
} else {
    http_response_code(405);
    echo json_encode(['msg' => 'Method Not Allowed.']);;
}
