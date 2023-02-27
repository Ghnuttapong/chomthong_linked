<?php
include '../db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

        foreach ($_POST as $val) {
            if ($val === '') {
                http_response_code(400);
                echo json_encode(['msg' => 'กรุณากรอกข้อมูลให้ครบถ้วน.']);
                return;
            }
        }

        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $prefix = $_POST['prefix'];
        $type = $_POST['type'];
        $fullname = $prefix . $firstname . ' ' . $lastname;


        $conn = new db();
        $count = $conn->select_fetch('users', ['COUNT(*) as count'], ['username'], [$username]);

        if ($count['count'] > 0) {
            http_response_code(400);
            echo json_encode(['msg' => 'มีรายชื่อผู้ใช้นี้แล้ว.']);
            return;
        }

        if ($type == 'student') {
            $department = $_POST['department'];
            $degree = $_POST['degree'];
            $birthday = $_POST['birthday'];

            $insert = $conn->insert(
                'users',
                ['username', 'password', 'firstname', 'lastname', 'prefix', 'fullname', 'role'],
                [$username, $password, $firstname, $lastname, $prefix, $fullname, 0]
            );

            $user_id = $conn->select_fetch('users', ['id'], ['username'], [$username]);

            $insert = $conn->insert(
                'students',
                ['department', 'degree', 'birthday', 'user_id'],
                [$department, $degree, $birthday, $user_id['id']]
            );
        }

        if ($type == 'agency') {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];


            $insert = $conn->insert(
                'users',
                ['username', 'password', 'firstname', 'lastname', 'prefix', 'fullname', 'role'],
                [$username, $password, $firstname, $lastname, $prefix, $fullname, 1]
            );

            $user_id = $conn->select_fetch('users', ['id'], ['username'], [$username]);

            $insert = $conn->insert(
                'agencies',
                ['name', 'phone', 'address', 'user_id'],
                [$name, $phone, $address, $user_id['id']]
            );
        }

        http_response_code(200);
        echo json_encode(['msg' => 'สมัครสมาชิกเรียบร้อยแล้ว']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['msg' => 'Server Error.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['msg' => 'Method Not Allowed.']);
}
