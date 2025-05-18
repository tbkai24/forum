<?php 
require "../layouts/header.php"; 
require "../../config/config.php"; 

if(!isset($_SESSION['adminname'])) {
    header("location: ".ADMINURL."/admins/login-admins.php");
    exit;
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Use prepared statement for security
    $delete = $conn->prepare("DELETE FROM replies WHERE id = :id");
    $delete->execute([':id' => $id]);

    // Redirect back to replies page
    header("location: ".ADMINURL."/replies-admins/show-replies.php");
    exit;
} else {
    header("location: ".ADMINURL."/replies-admins/show-replies.php");
    exit;
}
?>