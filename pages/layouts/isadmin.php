<?php
    // unused
    session_start();
    if(isset($_SESSION['user_id']) == '') {
        header('location: login.html');
    }
    if($_SESSION['role'] != 2) header('location: login.html');
