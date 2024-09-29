<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    // code for update the read notification status
    $isread = 1;
    $did = intval($_GET['leaveid']);
    date_default_timezone_set('Asia/Kolkata');
    $admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));
    $sql = "update tblleaves set IsRead=:isread where id=:did";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isread', $isread, PDO::PARAM_STR);
    $query->bindParam(':did', $did, PDO::PARAM_STR);
    $query->execute();

    // code for action taken on leave
    if (isset($_POST['update'])) {
        $did = intval($_GET['leaveid']);
        $description = $_POST['description'];
        $status = $_POST['status'];
        date_default_timezone_set('Asia/Kolkata');
        $admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));
        $sql = "update tblleaves set AdminRemark=:description,Status=:status,AdminRemarkDate=:admremarkdate where id=:did";
        $query = $dbh->prepare($sql);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':admremarkdate', $admremarkdate, PDO::PARAM_STR);
        $query->bindParam(':did', $did, PDO::PARAM_STR);
        $query->execute();
        $msg = "Leave updated Successfully";
    }



?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <!-- Title -->
        <title>Admin | รายละเอียดการลา </title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="UTF-8">

        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css" />
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="../assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

        <link href="../assets/plugins/google-code-prettify/prettify.css" rel="stylesheet" type="text/css" />
        <!-- Theme Styles -->
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php include('includes/header.php'); ?>
        <?php include('includes/sidebar.php'); ?>
        <main class="mn-inner">
            <div class="row">
                <div class="col s12">
                    <div class="page-title" style="font-size:24px;">รายละเอียดการลา</div>
                </div>

                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">รายละเอียดการลา</span>
                            <?php if ($msg) { ?><div class="succWrap"><strong>บันทึกสำเร็จ</strong> : <?php echo htmlentities($msg); ?> </div><?php } ?>
                            <table id="example" class="display responsive-table ">
                                <tbody>
                                    <?php
                                    $lid = intval($_GET['leaveid']);
                                    $sql = "SELECT tblleaves.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.EmpId,tblemployees.id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblleaves.LeaveType,tblleaves.ToDate,tblleaves.FromDate,tblleaves.Description,tblleaves.PostingDate,tblleaves.Status,tblleaves.AdminRemark,tblleaves.AdminRemarkDate from tblleaves join tblemployees on tblleaves.empid=tblemployees.id where tblleaves.id=:lid";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':lid', $lid, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {
                                    ?>

                                            <tr>
                                                <td style="font-size:16px;"> 
                                                    <b>ชื่อ-นามสกุล พนักงาน :</b>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->FirstName . " " . $result->LastName); ?>
                                                </td>
                                                <td style="font-size:16px;">
                                                    <b>รหัสพนักงาน :</b>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->EmpId); ?>
                                                </td>
                                                <td style="font-size:16px;">
                                                    <b>เพศ :</b>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->Gender); ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-size:16px;">
                                                    <b>อีเมล :</b>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->EmailId); ?>
                                                </td>
                                                <td style="font-size:16px;">
                                                    <b>เบอร์โทร :</b>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->Phonenumber); ?>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="font-size:16px;">
                                                    <b>ประเภทการลา :</b>
                                                </td>
                                                <td>
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
                                                <td style="font-size:16px;">
                                                    <b>วันที่ลา . :</b>
                                                </td>
                                                <td>
                                                    From <?php echo htmlentities($result->FromDate); ?> to <?php echo htmlentities($result->ToDate); ?>
                                                </td>
                                                <td style="font-size:16px;">
                                                    <b>วันที่กรอกข้อมูล</b>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->PostingDate); ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-size:16px;">
                                                    <b>รายละเอียดการลา : </b>
                                                </td>
                                                <td colspan="5">
                                                    <?php echo htmlentities($result->Description); ?>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td style="font-size:16px;"><b>สถานะการลา :</b></td>
                                                <td colspan="5"><?php $stats = $result->Status;
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
                                            </tr>
                                            <tr>
                                                <td style="font-size:16px;"><b>ความคิดเป็นจากผู้อนุมัติ: </b></td>
                                                <td colspan="5"><?php
                                                                if ($result->AdminRemark == "") {
                                                                    echo "";
                                                                } else {
                                                                    echo htmlentities($result->AdminRemark);
                                                                }
                                                                ?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:16px;"><b>วันที่อนุมัติ/ไม่อนุมัติ : </b></td>
                                                <td colspan="5"><?php
                                                                if ($result->AdminRemarkDate == "") {
                                                                    echo "";
                                                                } else {
                                                                    echo htmlentities($result->AdminRemarkDate);
                                                                }
                                                                ?></td>
                                            </tr>
                                            <?php
                                            if ($stats == 0) {

                                            ?>
                                                <tr>
                                                    <td colspan="5">
                                                        <a class="modal-trigger waves-effect waves-light btn" href="#modal1">ดำเนินการ</a>
                                                        <form name="adminaction" method="post">
                                                            <div id="modal1" class="modal modal-fixed-footer" style="height: 60%">
                                                                <div class="modal-content" style="width:90%">
                                                                    <h4>อนุมัติการลา</h4>
                                                                    <select class="browser-default" name="status" required="">
                                                                        <option value="">เลือกการอนุมัติ</option>
                                                                        <option value="1">อนุมัติ</option>
                                                                        <option value="2">ไม่อนุมัติ</option>
                                                                    </select></p>
                                                                    <p><textarea id="textarea1" name="description" class="materialize-textarea" name="description" placeholder="เหตุผลประกอบการอนุมัติ" length="500" maxlength="500" ></textarea></p>
                                                                </div>
                                                                <div class="modal-footer" style="width:90%">
                                                                    <input type="submit" class="waves-effect waves-light btn blue m-b-xs" name="update" value="Submit">
                                                                </div>

                                                            </div>

                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </form>
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
                                    $eid = $result->id;
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
        </main>

        </div>
        <div class="left-sidebar-hover"></div>

        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../assets/js/alpha.min.js"></script>

    </body>

    </html>
<?php } ?>