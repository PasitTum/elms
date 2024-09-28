<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['emplogin']) == 0) {
    header('location:index.php');
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <!-- Title -->
        <title>Employee | Dashboard</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="UTF-8">

        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css" />
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/metrojs/MetroJs.min.css" rel="stylesheet">
        <link href="assets/plugins/weather-icons-master/css/weather-icons.min.css" rel="stylesheet">


        <!-- Theme Styles -->
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <?php include('includes/sidebar.php'); ?>

        <main class="mn-inner">
            <div class="">
                <div class="row no-m-t no-m-b">
                    <a href="leavehistory.php" target="blank">
                        <div class="col s12 m12 l4">
                            <div class="card stats-card">
                                <div class="card-content">
                                    <span class="card-title">Total Leaves</span>
                                    <?php $eid = $_SESSION['eid'];
                                    $sql = "SELECT id from  tblleaves where empid ='$eid'";
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

                    <a href="leavehistory.php" target="blank">
                        <div class="col s12 m12 l4">
                            <div class="card stats-card">
                                <div class="card-content">
                                    <span class="card-title">Approved Leaves</span>
                                    <?php
                                    $sql = "SELECT id from  tblleaves where Status=1 and empid ='$eid'";
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
                    <a href="leavehistory.php" target="blank">
                        <div class="col s12 m12 l4">
                            <div class="card stats-card">
                                <div class="card-content">
                                    <span class="card-title">New Leaves Applications</span>
                                    <?php
                                    $sql = "SELECT id from  tblleaves where Status=0 and empid ='$eid'";
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

                                <span class="card-title">สิทธิ์การลา</span>
                                <table id="example" class="display responsive-table ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="center" width="60%">ประเภทการลา</th>
                                            <th class="center" width="10%">จำนวนวัน</th>
                                            <th class="center" width="10%">ใช้สิทธิ์</th>
                                            <th class="center" width="10%">คงเหลือ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    try {
                                        $eid = $_SESSION['eid'];
                                        $sql = "SELECT * from vw_employee_leave_balance where EmployeeID='$eid' order by LeaveTypeID";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                    ?>
                                                <tr>
                                                    <td ><?php echo htmlentities($cnt); ?></td>
                                                    <td ><?php echo htmlentities($result->LeaveType); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->EntitledDays); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->UsedDays); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->RemainingDays); ?></td>
                                                </tr>
                                    <?php 
                                                $cnt++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>ไม่พบข้อมูล</td></tr>";
                                        }
                                    } catch (PDOException $e) {
                                        echo "<tr><td colspan='5'>เกิดข้อผิดพลาด: " . $e->getMessage() . "</td></tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        </div>



        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/plugins/waypoints/jquery.waypoints.min.js"></script>
        <script src="assets/plugins/counter-up-master/jquery.counterup.min.js"></script>
        <script src="assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="assets/plugins/chart.js/chart.min.js"></script>g
        <script src="assets/plugins/flot/jquery.flot.min.js"></script>
        <script src="assets/plugins/flot/jquery.flot.time.min.js"></script>
        <script src="assets/plugins/flot/jquery.flot.symbol.min.js"></script>
        <script src="assets/plugins/flot/jquery.flot.resize.min.js"></script>
        <script src="assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
        <script src="assets/plugins/curvedlines/curvedLines.js"></script>
        <script src="assets/plugins/peity/jquery.peity.min.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/dashboard.js"></script>
        <script src="assets/js/pages/notification.js"></script>


    </body>

    </html>
<?php } ?>