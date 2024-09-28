<?php
require_once("includes/config.php");

$empCodeValid = true;
$emailValid = true;

if (!empty($_POST["empcode"])) {
    $empid = $_POST["empcode"];
    $sql = "SELECT EmpId FROM tblemployees WHERE EmpId=:empid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empid', $empid, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo "<span style='color:red'> รหัสพนักงานซ้ำ</span>";
        $empCodeValid = false;
    } else {
        echo "<span style='color:green'> รหัสพนักงานสามารถใช้งานได้ </span>";
    }
}

if (!empty($_POST["emailid"])) {
    $emailid = $_POST["emailid"];
    $sql = "SELECT EmailId FROM tblemployees WHERE EmailId=:emailid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':emailid', $emailid, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo "<span style='color:red'> อีเมลนี้มีอยู่ในระบบแล้ว</span>";
        $emailValid = false;
    } else {
        echo "<span style='color:green'> อีเมลสามารถใช้งานได้ </span>";
    }
}

if ($empCodeValid && $emailValid) {
    echo "<script>$('#add').prop('disabled', false);</script>";
} else {
    echo "<script>$('#add').prop('disabled', true);</script>";
}