<?php
include('connect.php');
include('header.php');

if(isset($_GET['deleteId'])){
    $id = $_GET['deleteId'];

    $sql = "DELETE FROM CONTACT WHERE Contact_id='$id'";
    $sql2 = "DELETE FROM PHONE WHERE Contact_id = '$id'";
    $sql3 = "DELETE FROM ADDRESS WHERE Contact_id = '$id'";
    $sql4 = "DELETE FROM DATES WHERE Contact_id = '$id'";
    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);
    $result4 = $conn->query($sql4);
    if($result || $result2 || $result3 || $result4){
        header('location:index.php');
    }else{
        // die(mysqli_error($conn));
        header('location:index.php');
    }
}
?>  
    
