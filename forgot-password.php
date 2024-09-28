<?php
session_start();
error_reporting(0);
include('includes/config.php');
// Code for change password 
if (isset($_POST['change'])) {
    $newpassword = md5($_POST['newpassword']);
    $empid = $_SESSION['empid'];

    $con = "update tblemployees set Password=:newpassword where id=:empid";
    $chngpwd1 = $dbh->prepare($con);
    $chngpwd1->bindParam(':empid', $empid, PDO::PARAM_STR);
    $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
    $chngpwd1->execute();
    $msg = "Your Password succesfully changed";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->
    <title>ELMS | Password Recovery</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">

    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="loader-bg"></div>
    <div class="loader">
        <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-spinner-teal lighten-1">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="mn-content fixed-sidebar">
        <header class="mn-header navbar-fixed">
            <nav class="cyan darken-1">
                <div class="nav-wrapper row">
                    <section class="material-design-hamburger navigation-toggle">
                        <a href="#" data-activates="slide-out" class="button-collapse show-on-large material-design-hamburger__icon">
                            <span class="material-design-hamburger__layer"></span>
                        </a>
                    </section>
                    <div class="header-title col s4">
                        <span class="chapter-title">โปรแกรมบันทึกการลางาน | Employee Leave Management System</span>
                    </div>
                </div>
            </nav>
        </header>
        <aside id="slide-out" class="side-nav white fixed">
            <div class="side-nav-wrapper">
                <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion" style="">
                    <li>&nbsp;</li>
                    <li class="no-padding"><a class="waves-effect waves-grey" href="index.php"><i class="material-icons">account_box</i>พนักงานเข้าสู่ระบบ</a></li>
                    <li class="no-padding"><a class="waves-effect waves-grey" href="forgot-password.php"><i class="material-icons">account_box</i>ลืมรหัสผ่าน</a></li>
                    <li class="no-padding"><a class="waves-effect waves-grey" href="admin/"><i class="material-icons">account_box</i>Admin Login</a></li>
                </ul>
                <div class="footer">
                </div>
            </div>
        </aside>
        <main class="mn-inner">
            <div class="row">
                <div class="col s12">

                    <div class="col s12 m6 l8 offset-l2 offset-m3">
                        <div class="card white darken-1">

                            <div class="card-content ">
                                <span class="card-title" style="font-size:20px;">กู้คืนรหัสผ่าน</span>
                                <?php if ($msg) { ?><div class="succWrap"><strong>Success </strong> : <?php echo htmlentities($msg); ?> </div><?php } ?>
                                <div class="row">
                                    <form class="col s12" name="signin" method="post">
                                        <div class="input-field col s12">
                                            <input id="empid" type="text" name="empid" class="validate" autocomplete="off" required>
                                            <label for="email">รหัสพนักงาน</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="password" type="text" class="validate" name="emailid" autocomplete="off" required>
                                            <label for="password">อีเมล</label>
                                        </div>
                                        <div class="col s12 right-align m-t-sm">

                                            <input type="submit" name="submit" value="Reset" class="waves-effect waves-light btn teal">
                                        </div>
                                    </form>
                                </div>
                            <?php if (isset($_POST['submit'])) {
                                $empid = $_POST['empid'];
                                $email = $_POST['emailid'];
                                $sql = "SELECT id FROM tblemployees WHERE EmailId=:email and EmpId=:empid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':email', $email, PDO::PARAM_STR);
                                $query->bindParam(':empid', $empid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {
                                        $_SESSION['empid'] = $result->id;
                                    }
                            ?>

                                    <div class="row">
                                        <form class="col s12" name="udatepwd" method="post">
                                            <div class="input-field col s12">
                                                <input id="password" type="password" name="newpassword" class="validate" autocomplete="off" required>
                                                <label for="password">รหัสใหม่</label>
                                            </div>

                                            <div class="input-field col s12">
                                                <input id="password" type="password" name="confirmpassword" class="validate" autocomplete="off" required>
                                                <label for="password">ยินยันรหัสใหม่</label>
                                            </div>


                                            <div class="input-field col s12">
                                                <button type="submit" name="change" class="waves-effect waves-light btn indigo m-b-xs" onclick="return valid();">เปลี่ยนรหัสผ่าน</button>

                                            </div>
                                    </div>
                                    </form>
                                <?php } else { ?>
                                    <div class="errorWrap" style="margin-left: 2%; font-size:22px;">
                                        <strong>ไม่พบรายการ</strong> : <?php echo htmlentities("Invalid details");
                                                                } ?>
                                    </div>
                                <?php } ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
    <div class="left-sidebar-hover"></div>

    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
    <script src="assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="assets/js/alpha.min.js"></script>

</body>

</html>