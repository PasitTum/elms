<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <!-- Title -->
        <title>Admin | Dashboard</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="UTF-8">

        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css" />
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/metrojs/MetroJs.min.css" rel="stylesheet">
        <link href="../assets/plugins/weather-icons-master/css/weather-icons.min.css" rel="stylesheet">
        <link href="../assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

        <!-- Theme Styles -->
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <?php include('includes/sidebar.php'); ?>

        <main class="mn-inner">
            <div class="">
                <div class="row no-m-t no-m-b">
                    <a href="manageemployee.php" target="blank">
                        <div class="col s12 m12 l4">
                            <div class="card stats-card">
                                <div class="card-content">

                                    <span class="card-title">จำนวนพนักงาน</span>
                                    <span class="stats-counter">
                                        <?php
                                        $sql = "SELECT id from tblemployees";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $empcount = $query->rowCount();
                                        ?>

                                        <span class="counter"><?php echo htmlentities($empcount); ?></span></span>
                                </div>
                                <div class="progress stats-card-progress">
                                    <div class="determinate" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="managedepartments.php" target="blank">
                        <div class="col s12 m12 l4">
                            <div class="card stats-card">
                                <div class="card-content">

                                    <span class="card-title">จำนวนแผนก </span>
                                    <?php
                                    $sql = "SELECT id from tbldepartments";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $dptcount = $query->rowCount();
                                    ?>
                                    <span class="stats-counter"><span class="counter"><?php echo htmlentities($dptcount); ?></span></span>
                                </div>
                                <div class="progress stats-card-progress">
                                    <div class="determinate" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="manageleavetype.php" target="blank">
                        <div class="col s12 m12 l4">
                            <div class="card stats-card">
                                <div class="card-content">
                                    <span class="card-title">จำนวนประเภทการลา</span>
                                    <?php
                                    $sql = "SELECT id from  tblleavetype";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $leavtypcount = $query->rowCount();
                                    ?>
                                    <span class="stats-counter"><span class="counter"><?php echo htmlentities($leavtypcount); ?></span></span>

                                </div>
                                <div class="progress stats-card-progress">
                                    <div class="determinate" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="leaves.php" target="blank">
                        <div class="col s12 m12 l4">
                            <div class="card stats-card">
                                <div class="card-content">
                                    <span class="card-title">จำนวนการลา</span>
                                    <?php
                                    $sql = "SELECT id from  tblleaves";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $totalleaves = $query->rowCount();
                                    ?>
                                    <span class="stats-counter"><span class="counter"><?php echo htmlentities($totalleaves); ?></span></span>

                                </div>
                                <div class="progress stats-card-progress">
                                    <div class="success" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="approvedleave-history.php" target="blank">
                        <div class="col s12 m12 l4">
                            <div class="card stats-card">
                                <div class="card-content">
                                    <span class="card-title">จำนวนการอนุมัติ</span>
                                    <?php
                                    $sql = "SELECT id from  tblleaves where Status=1";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $approvedleaves = $query->rowCount();
                                    ?>
                                    <span class="stats-counter"><span class="counter"><?php echo htmlentities($approvedleaves); ?></span></span>

                                </div>
                                <div class="progress stats-card-progress">
                                    <div class="success" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="pending-leavehistory.php" target="blank">
                        <div class="col s12 m12 l4">
                            <div class="card stats-card">
                                <div class="card-content">
                                    <span class="card-title">จำนวนการลาใหม่</span>
                                    <?php
                                    $sql = "SELECT id from  tblleaves where Status=0";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $approvedleaves = $query->rowCount();
                                    ?>
                                    <span class="stats-counter"><span class="counter"><?php echo htmlentities($approvedleaves); ?></span></span>

                                </div>
                                <div class="progress stats-card-progress">
                                    <div class="success" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="row no-m-t no-m-b">
                    <div class="col s15 m12 l12">
                        <div class="card invoices-card">
                            <div class="card-content">
                                <span class="card-title">Latest Leave Applications</span>
                                <table id="example" class="display responsive-table ">
                                    <thead>
                                        <tr>
                                            <th class="center" width="5%">#</th>
                                            <th class="center" width="40%">ชื่อพนักงาน</th>
                                            <th class="center" width="20%">ประเภทการลา</th>
                                            <th class="center" width="10%">วันที่กรอกข้อมูล</th>
                                            <th class="center" width="10%">สถานะ</th>
                                            <th class="center" align="center">จัดการ</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $sql = "SELECT tblleaves.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.EmpId,tblemployees.id,tblleaves.LeaveType,tblleaves.PostingDate,tblleaves.Status from tblleaves join tblemployees on tblleaves.empid=tblemployees.id order by lid desc ";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                        ?>

                                                <tr>
                                                    <td class="center"> <b><?php echo htmlentities($cnt); ?></b></td>
                                                    <td><?php echo htmlentities($result->FirstName . " " . $result->LastName); ?></td>
                                                    <td class="center">
                                                        <?php 
                                                        $leaveTypeId = $result->LeaveType;
                                                        $sql = "SELECT LeaveType FROM tblleavetype WHERE id = :id";
                                                        $query = $dbh->prepare($sql);
                                                        $query->bindParam(':id', $leaveTypeId, PDO::PARAM_INT);
                                                        $query->execute();
                                                        $leaveTypeResult = $query->fetch(PDO::FETCH_OBJ);
                                                        echo htmlentities($leaveTypeResult->LeaveType);
                                                        ?>
                                                    </td>
                                                    <td class="center"><?php echo htmlentities($result->PostingDate); ?></td>
                                                    <td class="center"><?php $stats = $result->Status;
                                                        if ($stats == 1) {
                                                        ?>
                                                            <span style="color: green">อนุมัติ</span>
                                                        <?php }
                                                        if ($stats == 2) { ?>
                                                            <span style="color: red">ไม่อนุมัติ</span>
                                                        <?php }
                                                        if ($stats == 0) { ?>
                                                            <span style="color: blue">อยู่ระหว่างพิจารณา</span>
                                                        <?php } ?>


                                                    </td>
                                                    <td class="center"><a href="leave-details.php?leaveid=<?php echo htmlentities($result->lid); ?>" class="waves-effect waves-light btn blue m-b-xs"> ดูรายละเอียด</a></td>
                                                </tr>
                                        <?php $cnt++;
                                            }
                                        } ?>
                                    </tbody>
                                </table>
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
        <script src="../assets/plugins/waypoints/jquery.waypoints.min.js"></script>
        <script src="../assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="../assets/plugins/peity/jquery.peity.min.js"></script>
        <script src="../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/js/pages/table-data.js"></script>

    </body>

    </html>
<?php } ?>