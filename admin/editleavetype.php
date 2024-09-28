<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['update'])) {
        $lid = intval($_GET['lid']);
        $leavetype = $_POST['leavetype'];
        $description = $_POST['description'];
        $maxdays = $_POST['maxdays'];
        $sql = "update tblleavetype set LeaveType=:leavetype,Description=:description,MaxDays=:maxdays where id=:lid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':maxdays', $maxdays, PDO::PARAM_INT);
        $query->bindParam(':lid', $lid, PDO::PARAM_STR);
        $query->execute();

        $msg = "Leave type updated Successfully";
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <!-- Title -->
        <title>Admin | จัดการประเภทการลา</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="UTF-8">

        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css" />
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <?php include('includes/sidebar.php'); ?>
        <main class="mn-inner">
            <div class="row">
                <div class="col s12">
                    <div class="page-title">จัดการประเภทการลา</div>
                </div>
                <div class="col s12 m12 l6">
                    <div class="card">
                        <div class="card-content">

                            <div class="row">
                                <form class="col s12" name="chngpwd" method="post">
                                    <?php if ($error) { ?><div class="errorWrap"><strong>เกิดข้อผิดพลาด</strong> : <?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>บันทึกสำเร็จ</strong> : <?php echo htmlentities($msg); ?> </div><?php } ?>
                                    <?php
                                        $lid = intval($_GET['lid']);
                                        $sql = "SELECT * from tblleavetype where id=:lid";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':lid', $lid, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {               ?>

                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <input id="leavetype" type="text" class="validate" autocomplete="off" name="leavetype" value="<?php echo htmlentities($result->LeaveType); ?>" required>
                                                        <label for="leavetype">ประเภทการลา</label>
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <textarea id="textarea1" name="description" class="materialize-textarea" name="description" length="500"><?php echo htmlentities($result->Description); ?></textarea>
                                                        <label for="deptshortname">รายละเอียด</label>
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <input id="maxdays" type="number" class="validate" autocomplete="off" value="<?php echo htmlentities($result->MaxDays); ?>"
                                                            name="maxdays" required>
                                                        <label for="maxdays">
                                                            จำนวนวันลา
                                                        </label>
                                                    </div>
                                                </div>

                                            <?php }
                                        } 
                                    ?>
                                    <div class="input-field col s12">
                                        <button type="submit" name="update" class="waves-effect waves-light btn indigo m-b-xs">แก้ไข</button>
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
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/js/pages/form_elements.js"></script>

    </body>

    </html>
<?php } ?>