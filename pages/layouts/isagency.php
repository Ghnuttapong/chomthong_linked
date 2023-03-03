<?php
session_start();
if (isset($_SESSION['user_id']) == '') {
    header('location: login.html');
}
if (!$_SESSION['role']) header('location: login.html');
