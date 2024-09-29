<?php
session_start();
include('includes/config.php');
$msg = '';
$error = '';
if (strlen($_SESSION['emplogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['apply'])) {
        $empid = $_SESSION['eid'];
        $leavetype = $_POST['leavetype'];
        $fromdate = $_POST['fromdate'];
        $todate = $_POST['todate'];
        $description = $_POST['description'];
        $status = 0;
        $isread = 0;
        if ($fromdate > $todate) {
            $error = " วันที่ต้องไม่ต่ำกว่าวันลา ";
        }else {
            // $sql = "INSERT INTO tblleaves(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid) VALUES(:leavetype,:todate,:fromdate,:description,:status,:isread,:empid)";
            // $query = $dbh->prepare($sql);
            // $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
            // $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
            // $query->bindParam(':todate', $todate, PDO::PARAM_STR);
            // $query->bindParam(':description', $description, PDO::PARAM_STR);
            // $query->bindParam(':status', $status, PDO::PARAM_STR);
            // $query->bindParam(':isread', $isread, PDO::PARAM_STR);
            // $query->bindParam(':empid', $empid, PDO::PARAM_STR);
            // $query->execute();
            // $lastInsertId = $dbh->lastInsertId();
            // if ($lastInsertId) {
            //     $msg = "บันทึกการลาแล้ว";
            // } else {
            //     $error = "เกิดข้อผิดพลาด";
            // }
            try {
                $sql = "CALL apply_leave(:empid, :leavetype, :fromdate, :todate, :description)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':empid', $empid, PDO::PARAM_INT);
                $query->bindParam(':leavetype', $leavetype, PDO::PARAM_INT);
                $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
                $query->bindParam(':todate', $todate, PDO::PARAM_STR);
                $query->bindParam(':description', $description, PDO::PARAM_STR);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
    
                if ($result && isset($result['message'])) {
                    if ($result['message'] === 'success') {
                        $msg = ' บันทึกการลาสำเร็จ';
                    } else {
                        $error = $result['message'];
                    }
                } else {
                    $error = " ไม่สามารถรับข้อความจาก stored procedure ได้";
                }
            } catch (PDOException $e) {
                $error = "เกิดข้อผิดพลาด: " . $e->getMessage();
            }
        }
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <!-- Title -->
        <title>Employe | บันทึกการลา</title>

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
                    <div class="page-title">บันทึกการลา</div>
                </div>
                <div class="col s12 m12 l8">
                    <div class="card">
                        <div class="card-content">
                            <form id="example-form" method="post" name="addemp">
                                <div>
                                    <h3>บันทึกการลา</h3>
                                    <section>
                                        <div class="wizard-content">
                                            <div class="row">
                                                <div class="col m12">
                                                    <div class="row">
                                                    <?php if (!empty($error)) { ?>
                                                        <div class="errorWrap"><strong>เกิดข้อผิดพลาด </strong>:<?php echo htmlentities($error); ?></div>
                                                    <?php } elseif (!empty($msg)) { ?>
                                                        <div class="succWrap"><strong>บันทึกสำเร็จ </strong>:<?php echo htmlentities($msg); ?></div>
                                                    <?php } ?>
                                                        <div class="input-field col  s12">
                                                            <select name="leavetype" autocomplete="off">
                                                                <option value="">เลือกประเภทการลา</option>
                                                                <?php 
                                                                    $sql = "SELECT  * from tblleavetype";
                                                                    $query = $dbh->prepare($sql);
                                                                    $query->execute();
                                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                    $cnt = 1;
                                                                    if ($query->rowCount() > 0) {
                                                                        foreach ($results as $result) {   ?>
                                                                            <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->LeaveType); ?></option>
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <label for="fromdate">วันที่</label>
                                                            <input placeholder="" id="mask1" name="fromdate" class="datepicker" type="text" data-inputmask="'alias': 'date'" required>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <label for="todate">ถึง</label>
                                                            <input placeholder="" id="mask1" name="todate" class="datepicker" type="text" data-inputmask="'alias': 'date'" required>
                                                        </div>
                                                        <div class="input-field col m12 s12">
                                                            <label for="birthdate">รายละเอียด</label>

                                                            <textarea id="textarea1" name="description" class="materialize-textarea" length="500" required></textarea>
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="apply" id="apply" class="waves-effect waves-light btn indigo m-b-xs">บันทึก</button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </form>
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
        <script src="assets/js/pages/apply_leave.js"></script>
        <script src="assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    </body>

    </html>
<?php } ?>