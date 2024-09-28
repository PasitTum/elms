<?php
session_start();
error_reporting(error_level: 0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['add'])) {
        try {
            $empid = $_POST['empcode'];
            $fname = $_POST['firstName'];
            $lname = $_POST['lastName'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $gender = $_POST['gender'];
            $dob = $_POST['dob'];
            $department = $_POST['department'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $aumphur = $_POST['Aumphures'];
            $tambon = $_POST['Tambon'];
            $postcode = $_POST['PostCode'];
            $position = $_POST['position'];
            $mobileno = $_POST['mobileno'];
            $hiredate = $_POST['HireDate'];
            $status = 1;

            // Check if employee ID already exists
            $stmt = $dbh->prepare("SELECT COUNT(*) FROM tblemployees WHERE EmpId = :empid");
            $stmt->bindParam(':empid', $empid, PDO::PARAM_STR);
            $stmt->execute();
            $empIdCount = $stmt->fetchColumn();

            // Check if email already exists
            $stmt = $dbh->prepare("SELECT COUNT(*) FROM tblemployees WHERE EmailId = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $emailCount = $stmt->fetchColumn();


            if ($empIdCount > 0) {
                $error = "รหัสพนักงานนี้มีอยู่ในระบบแล้ว กรุณาใช้รหัสอื่น";
            } elseif ($emailCount > 0) {
                $error = "อีเมลนี้มีอยู่ในระบบแล้ว กรุณาใช้อีเมลอื่น";
            } else {
                $sql = "INSERT INTO tblemployees(EmpId,FirstName,LastName,EmailId,Password,Gender,Dob,Department,Address,City,Phonenumber,Status,Position,Tambon,Aumphures,HireDate,PostCode) VALUES(:empid,:fname,:lname,:email,:password,:gender,:dob,:department,:address,:city,:mobileno,:status,:position,:tambon,:aumphures,:hiredate,:postcode)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':empid', $empid, PDO::PARAM_STR);
                $query->bindParam(':fname', $fname, PDO::PARAM_STR);
                $query->bindParam(':lname', $lname, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->bindParam(':password', $password, PDO::PARAM_STR);
                $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                $query->bindParam(':dob', $dob, PDO::PARAM_STR);
                $query->bindParam(':department', $department, PDO::PARAM_STR);
                $query->bindParam(':address', $address, PDO::PARAM_STR);
                $query->bindParam(':city', $city, PDO::PARAM_STR);
                $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
                $query->bindParam(':status', $status, PDO::PARAM_STR);
                $query->bindParam(':position', $position, PDO::PARAM_STR);
                $query->bindParam(':tambon', $tambon, PDO::PARAM_STR);
                $query->bindParam(':aumphures', $aumphur, PDO::PARAM_STR);
                $query->bindParam(':hiredate', $hiredate, PDO::PARAM_STR);
                $query->bindParam(':postcode', $postcode, PDO::PARAM_INT);
                $query->execute();
                $lastInsertId = $dbh->lastInsertId();
                if ($lastInsertId) {
                    $msg = "Employee record added Successfully";
                } else {
                    $error = "Something went wrong. Please try again";
                }
            }
        } catch (PDOException $e) {
            $error = "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $e->getMessage();
        }
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <!-- Title -->
        <title>Admin | เพิ่มพนักงาน</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="UTF-8">

        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css" />
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            function valid() {
                if (document.addemp.password.value != document.addemp.confirmpassword.value) {
                    alert("New Password and Confirm Password Field do not match  !!");
                    document.addemp.confirmpassword.focus();
                    return false;
                }
                return true;
            }
        </script>

        <script>
            function checkAvailabilityEmpid() {
                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "check_availability.php",
                    data: 'empcode=' + $("#empcode").val(),
                    type: "POST",
                    success: function(data) {
                        $("#empid-availability").html(data);
                        $("#loaderIcon").hide();
                    },
                    error: function() {}
                });
            }
        </script>

        <script>
            function checkAvailabilityEmailid() {
                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "check_availability.php",
                    data: 'emailid=' + $("#email").val(),
                    type: "POST",
                    success: function(data) {
                        $("#emailid-availability").html(data);
                        $("#loaderIcon").hide();
                    },
                    error: function() {}
                });
            }
        </script>
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <?php include('includes/sidebar.php'); ?>
        <main class="mn-inner">
            <div class="row">
                <div class="col s12">
                    <div class="page-title">เพิ่มข้อมูลพนักงาน</div>
                </div>
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <form id="example-form" method="post" name="addemp">
                                <div>
                                    <h3>ข้อมูลพนักงาน</h3>
                                    <section>
                                        <div class="wizard-content">
                                            <div class="row">
                                                <div class="col m6">
                                                    <div class="row">
                                                        <?php if ($error) { ?><div class="errorWrap"><strong>เกิดข้อผิดพลาด</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>บันทึกสำเร็จ</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                                                        <div class="input-field col m4 s12">
                                                            <label for="empcode">รหัสพนักงาน(ควรจะไม่ซ้ำ)</label>
                                                            <input name="empcode" id="empcode" onBlur="checkAvailabilityEmpid()" type="text" autocomplete="off" required>
                                                            <span class="avilable" id="empid-availability" style="font-size:12px;"></span>
                                                        </div>
                                                        <div class="input-field col m4 s12">
                                                            <select name="department" autocomplete="off">
                                                                <option value="">กรุณาเลือกแผนก...</option>
                                                                <?php
                                                                $sql = "SELECT * from tbldepartments";
                                                                $query = $dbh->prepare($sql);
                                                                $query->execute();
                                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                $cnt = 1;
                                                                if ($query->rowCount() > 0) {
                                                                    foreach ($results as $resultt) {
                                                                ?>
                                                                        <option value="<?php echo htmlentities($resultt->id); ?>"><?php echo htmlentities($resultt->DepartmentName); ?></option>
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="input-field col m4 s12">
                                                            <label for="position">ตำแหน่ง</label>
                                                            <input id="position" name="position" type="text" required>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <label for="firstName">ชื่อ</label>
                                                            <input id="firstName" name="firstName" type="text" required>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <label for="lastName">นามสกุล</label>
                                                            <input id="lastName" name="lastName" type="text" autocomplete="off" required>
                                                        </div>
                                                        <div class="input-field col m6 s12 datePkr">
                                                            <label for="birthdate">วัน เดือน ปีเกิด</label>
                                                            <input id="birthdate" name="dob" class="datepicker" autocomplete="off">
                                                        </div>
                                                        <div class="input-field m6 col s12">
                                                            <label for="email">อีเมล</label>
                                                            <input name="email" type="email" id="email" onBlur="checkAvailabilityEmailid()" autocomplete="off" required>
                                                            <span id="emailid-availability" style="font-size:12px;"></span>
                                                        </div>
                                                        <div class="input-field col s12">
                                                            <label for="password">รหัสผ่าน</label>
                                                            <input id="password" name="password" type="password" autocomplete="off" required>
                                                        </div>
                                                        <div class="input-field col s12">
                                                            <label for="confirm">ยืนยันรหัสผ่าน</label>
                                                            <input id="confirm" name="confirmpassword" type="password" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col m6">
                                                    <div class="row">
                                                        <div class="input-field col m6 s12">
                                                            <select name="gender" autocomplete="off">
                                                                <option value="">กรุณาเลือกเพศ</option>
                                                                <option value="Male">ชาย</option>
                                                                <option value="Female">หญิง</option>
                                                                <option value="Other">อื่นๆ</option>
                                                            </select>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <label for="HireDate">วันที่เริ่มงาน</label>
                                                            <input id="HireDate" name="HireDate" class="datepicker" required>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <label for="address">ที่อยู่</label>
                                                            <input id="address" name="address" type="text" autocomplete="off" required>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <select id="city" name="city" required>
                                                                <option value="" disabled selected>เลือกจังหวัด</option>
                                                                <?php
                                                                $sql = "SELECT id, name_th FROM thai_provinces ORDER BY name_th";
                                                                $query = $dbh->prepare($sql);
                                                                $query->execute();
                                                                $provinces = $query->fetchAll(PDO::FETCH_OBJ);
                                                                foreach ($provinces as $province) {
                                                                    echo "<option value='" . $province->name_th . "' data-id='" . $province->id . "'>" . $province->name_th . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <label for="city">จังหวัด</label>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <select id="Aumphures" name="Aumphures" required>
                                                                <option value="" disabled selected>เลือกอำเภอ</option>
                                                            </select>
                                                            <label for="Aumphures">อำเภอ</label>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <select id="Tambon" name="Tambon" required>
                                                                <option value="" disabled selected>เลือกตำบล</option>
                                                            </select>
                                                            <label for="Tambon">ตำบล</label>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <label for="PostCode">รหัสไปรษณีย์</label>
                                                            <input id="PostCode" name="PostCode" type="text" maxlength="5" autocomplete="off" required>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <label for="phone">เบอร์โทรศัพท์</label>
                                                            <input id="phone" name="mobileno" type="tel" maxlength="10" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12 center">
                                                    <button type="submit" name="add" onclick="return valid();" id="add" class="waves-effect waves-light btn indigo m-b-xs">เพิ่มข้อมูลพนักงาน</button>
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
        </div>
        <div class="left-sidebar-hover"></div>

        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/js/pages/form_elements.js"></script>


        <script>
            $(document).ready(function() {
                $('#city').change(function() {
                    var provinceId = $(this).find(':selected').data('id');
                    if (provinceId) {
                        $.ajax({
                            url: 'get_locations.php',
                            type: 'GET',
                            data: {
                                province_id: provinceId
                            },
                            dataType: 'json',
                            success: function(data) {
                                var $amphur = $('#Aumphures');
                                $amphur.empty().append('<option value="" disabled selected>เลือกอำเภอ</option>');
                                $.each(data, function(key, value) {
                                    $amphur.append($('<option>', {
                                        value: value.name_th,
                                        'data-id': value.id,
                                        text: value.name_th
                                    }));
                                });
                                $amphur.prop('disabled', false);

                                // ใช้ setTimeout เพื่อให้แน่ใจว่า DOM ได้อัปเดตแล้ว
                                setTimeout(function() {
                                    $amphur.material_select('destroy');
                                    $amphur.material_select();
                                }, 0);

                                $('#Tambon').empty().append('<option value="" disabled selected>เลือกตำบล</option>');
                                $('#Tambon').prop('disabled', true).material_select();
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Error:", status, error);
                            }
                        });
                    } else {
                        $('#Aumphures').empty().append('<option value="" disabled selected>เลือกอำเภอ</option>');
                        $('#Aumphures').prop('disabled', true).material_select();
                        $('#Tambon').empty().append('<option value="" disabled selected>เลือกตำบล</option>');
                        $('#Tambon').prop('disabled', true).material_select();
                    }
                });

                // ทำแบบเดียวกันสำหรับ #amphur change event
                $('#Aumphures').change(function() {
                    var amphurId = $(this).find(':selected').data('id');
                    if (amphurId) {
                        $.ajax({
                            url: 'get_locations.php',
                            type: 'GET',
                            data: {
                                amphur_id: amphurId
                            },
                            dataType: 'json',
                            success: function(data) {
                                var $tambon = $('#Tambon');
                                $tambon.empty().append('<option value="" disabled selected>เลือกตำบล</option>');
                                $.each(data, function(key, value) {
                                    $tambon.append($('<option>', {
                                        value: value.name_th,
                                        'data-id': value.id,
                                        text: value.name_th
                                    }));
                                });
                                $tambon.prop('disabled', false);

                                setTimeout(function() {
                                    $tambon.material_select('destroy');
                                    $tambon.material_select();
                                }, 0);
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Error:", status, error);
                            }
                        });
                    } else {
                        $('#Tambon').empty().append('<option value="" disabled selected>เลือกตำบล</option>');
                        $('#Tambon').prop('disabled', true).material_select();
                    }
                });
            });
        </script>

    </body>

    </html>
<?php } ?>