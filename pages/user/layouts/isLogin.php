<?php 
    include '../../api/db.php';
    $conn = new db();
    session_start();
    if(isset($_SESSION['user_id']) == '') {
        header('location: ../login.html');
    }

?>