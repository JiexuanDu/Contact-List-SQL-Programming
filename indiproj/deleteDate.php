<?php
include('connect.php');
include('header.php');

if(isset($_GET['deleteDateId'])){
    $dateId = $_GET['deleteDateId'];

    $sql = "DELETE FROM DATES WHERE Date_id='$dateId'";
    $result = $conn->query($sql);
    if($result){
        header('location:index.php');
    }else{
        // die(mysqli_error($conn));
        header('location:index.php');
    }
}
?>  