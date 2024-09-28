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
        <title>Admin | Update Employee</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="UTF-8">

        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css" />
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <?php include('includes/sidebar.php'); ?>
        <main class="mn-inner">
            <div class="row">
                <div class="col s12">
                    <div class="page-title">ข้อมูลส่วนตัว</div>
                </div>
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <div>
                                <h3>ข้อมูลส่วนตัว</h3>
                                <section>
                                    <div class="wizard-content">
                                        <div class="row">
                                            <div class="col m6">
                                                <div class="row">
                                                    <?php
                                                    $eid = $_SESSION['emplogin'];
                                                    $sql = "SELECT * from  tblemployees where EmpId=:eid";
                                                    $query = $dbh->prepare($sql);
                                                    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $result) {               ?>
                                                            <div class="input-field col m4 s12">
                                                                <label for="empcode">
                                                                    รหัสพนักงาน
                                                                </label>
                                                                <input name="empcode" id="empcode" value="<?php echo htmlentities($result->EmpId); ?>" type="text" autocomplete="off" readonly required>
                                                                <span id="empid-availability" style="font-size:12px;"></span>
                                                            </div>
                                                            <div class="input-field col m4 s12">
                                                                <select name="department" autocomplete="off" disabled>
                                                                    <?php $sql = "SELECT DepartmentName from tbldepartments";
                                                                    $query = $dbh->prepare($sql);
                                                                    $query->execute();
                                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                    $cnt = 1;
                                                                    if ($query->rowCount() > 0) {
                                                                        foreach ($results as $resultt) {  
                                                                            $selected = ($result->id == $Department) ? 'selected' : '';
                                                                    ?>
                                                                            <option value="<?php echo htmlentities($resultt->id); ?>" <?php echo $selected; ?>><?php echo htmlentities($resultt->DepartmentName); ?></option>
                                                                    <?php }
                                                                    } ?>
                                                                </select>
                                                                <label>แผนก</label>
                                                            </div>
                                                            <div class="input-field col m4 s12">
                                                                <label for="position">ตำแหน่ง</label>
                                                                <input id="position" name="position" value="<?php echo htmlentities($result->Position); ?>" type="text" readonly required>
                                                            </div>
                                                            <div class="input-field col m6 s12">
                                                                <label for="firstName">ชื่อ</label>
                                                                <input id="firstName" name="firstName" value="<?php echo htmlentities($result->FirstName); ?>" type="text" readonly required>
                                                            </div>
                                                            <div class="input-field col m6 s12">
                                                                <label for="lastName">นามสกุล</label>
                                                                <input id="lastName" name="lastName" value="<?php echo htmlentities($result->LastName); ?>" type="text" autocomplete="off" readonly required>
                                                            </div>
                                                            <div class="col m6 s12 datePkr">
                                                                <label for="birthdate">วัน เดือน ปีเกิด</label>
                                                                <input id="birthdate" name="dob" class="datepicker" value="<?php echo htmlentities($result->Dob); ?>" readonly>
                                                            </div>
                                                            <div class="input-field col m6 s12">
                                                                <label for="email">อีเมล</label>
                                                                <input name="email" type="email" id="email" value="<?php echo htmlentities($result->EmailId); ?>" readonly autocomplete="off" readonly required>
                                                                <span id="emailid-availability" style="font-size:12px;"></span>
                                                            </div>
                                                        </div>
                                            </div>

                                            <div class="col m6">
                                                <div class="row">
                                                    <div class="input-field col m6 s12">
                                                        <select name="gender" autocomplete="off" disabled>
                                                            <option value="<?php echo htmlentities($result->Gender); ?>"><?php echo htmlentities($result->Gender); ?></option>
                                                            <option value="Male">ชาย</option>
                                                            <option value="Female">หญิง</option>
                                                            <option value="Other">อื่นๆ</option>
                                                        </select>
                                                        <label>เพศ</label>
                                                    </div>
                                                    <div class="col m6 s12 datePkr">
                                                        <label for="HireDate">วันที่เริ่มงาน</label>
                                                        <input id="HireDate" name="HireDate" class="datepicker" value="<?php echo htmlentities($result->HireDate); ?>" maxlength="10" autocomplete="off" readonly required>
                                                    </div>
                                                    <div class="input-field col m6 s12">
                                                        <label for="address">ที่อยู่</label>
                                                        <input id="address" name="address" type="text" value="<?php echo htmlentities($result->Address); ?>" autocomplete="off" readonly required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="city">จังหวัด</label>
                                                        <input id="city" name="city" type="text" value="<?php echo htmlentities($result->City); ?>" autocomplete="off" readonly required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="Aumphures">เขต/อำเภอ</label>
                                                        <input id="Aumphures" name="Aumphures" type="text" value="<?php echo htmlentities($result->Aumphures); ?>" autocomplete="off" readonly required>
                                                    </div>
                                                    <div class="input-field col m6 s12">
                                                        <label for="Tambon">แขวง/ตำบล</label>
                                                        <input id="Tambon" name="Tambon" type="text" value="<?php echo htmlentities($result->Tambon); ?>" autocomplete="off" readonly required>
                                                    </div>
                                                    <div class="input-field col m6 s12">
                                                        <label for="PostCode">รหัสไปรษณีย์</label>
                                                        <input id="PostCode" name="PostCode" type="text" value="<?php echo htmlentities($result->PostCode); ?>" autocomplete="off" readonly required>
                                                    </div>
                                                    <div class="input-field col m6 s12">
                                                        <label for="phone">เบอร์โทรศัพท์</label>
                                                        <input id="phone" name="mobileno" type="tel" value="<?php echo htmlentities($result->Phonenumber); ?>" maxlength="10" autocomplete="off" readonly required>
                                                    </div>
                                                </div>
                                                <?php }
                                                    } ?>
                                            </div>
                                        </div>
                                    </div>
                                </section>
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
        <script src="assets/js/pages/form_elements.js"></script>

    </body>

    </html>
<?php } ?>