<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['emplogin']) == 0) {
    header('location:index.php');
} else {
    // Code for change password 
    if (isset($_POST['change'])) {
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $username = $_SESSION['emplogin'];
        $sql = "SELECT Password FROM tblemployees WHERE EmpId=:username and Password=:password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            $con = "update tblemployees set Password=:newpassword where EmpId=:username";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $msg = "แก้ไขรหัสผ่านสำเร็จ";
        } else {
            $error = "รหัสผ่านผิดพลาด";
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <!-- Title -->
        <title>Employee | เปลี่ยนรหัสผ่าน</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="UTF-8">
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css" />
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <?php include('includes/sidebar.php'); ?>
        <main class="mn-inner">
            <div class="row">
                <div class="col s12">
                    <div class="page-title">เปลี่ยนรหัสผ่าน</div>
                </div>
                <div class="col s12 m12 l6">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <form class="col s12" name="chngpwd" method="post">
                                    <?php if ($error) { ?><div class="errorWrap"><strong>เกิดข้อผิดพลาด</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>บันทึกสำเร็จ</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="password" type="password" class="validate" autocomplete="off" name="password" required>
                                            <label for="password">รหัสเก่า</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="password" type="password" name="newpassword" class="validate" autocomplete="off" required>
                                            <label for="password">รหัสใหม่</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="password" type="password" name="confirmpassword" class="validate" autocomplete="off" required>
                                            <label for="password">ยืนยันรหัสใหม่</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <button type="submit" name="change" class="waves-effect waves-light btn indigo m-b-xs" onclick="return valid();">เปลี่ยนรหัสผ่าน</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="left-sidebar-hover"></div>

        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/form_elements.js"></script>

    </body>

    </html>
<?php } ?>