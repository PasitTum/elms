<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $eid = intval($_GET['empid']);
if (isset($_POST['update'])) {
    try {
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $department = $_POST['department'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $mobileno = $_POST['mobileno'];
        $position = $_POST['position'];
        $email = $_POST['email'];
        $hiredate = $_POST['HireDate'];
        $aumphures = $_POST['Aumphures'];
        $tambon = $_POST['Tambon'];
        $postcode = $_POST['PostCode'];

        $sql = "UPDATE tblemployees SET 
                FirstName = :fname,
                LastName = :lname,
                Gender = :gender,
                Dob = :dob,
                Department = :department,
                Address = :address,
                City = :city,
                Phonenumber = :mobileno,
                Position = :position,
                EmailId = :email,
                HireDate = :hiredate,
                Aumphures = :aumphures,
                Tambon = :tambon,
                PostCode = :postcode
            WHERE id = :eid";

        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':department', $department, PDO::PARAM_INT);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':position', $position, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':hiredate', $hiredate, PDO::PARAM_STR);
        $query->bindParam(':aumphures', $aumphures, PDO::PARAM_STR);
        $query->bindParam(':tambon', $tambon, PDO::PARAM_STR);
        $query->bindParam(':postcode', $postcode, PDO::PARAM_INT);
        $query->bindParam(':eid', $eid, PDO::PARAM_INT);

        $query->execute();

        if($query->rowCount() > 0) {
            $msg = "Employee record updated successfully";
        } else {
            $msg = "No changes were made or employee not found";
        }
    } catch(PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $error = "An error occurred while updating the employee record. Please try again.";
        
        // Additional debugging information
        error_log("Error details: " . print_r($e->errorInfo, true));
        error_log("SQL: " . $sql);
        error_log("Parameters: " . print_r($_POST, true));
    }
}

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <!-- Title -->
        <title>Admin | Update Employee</title>

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
                    <div class="page-title">แก้ไขข้อมูลพนักงาน</div>
                </div>
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <form id="example-form" method="post" name="updatemp">
                                <div>
                                    <h3>แก้ไขข้อมูลพนักงาน</h3>
                                    <?php if ($error) { ?><div class="errorWrap"><strong>เกิดข้อผิดพลาด</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>บันทึกสำเร็จ</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                                    <section>
                                        <div class="wizard-content">
                                            <div class="row">
                                                <div class="col m6">
                                                    <div class="row">
                                                        <?php
                                                        $eid = intval($_GET['empid']);
                                                        $sql = "SELECT * from  tblemployees where id=:eid";
                                                        $query = $dbh->prepare($sql);
                                                        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {               ?>
                                                                <div class="input-field col m4 s12">
                                                                    <label for="empcode">Employee Code(Must be unique)</label>
                                                                    <input name="empcode" id="empcode" value="<?php echo htmlentities($result->EmpId); ?>" type="text" autocomplete="off" readonly required>
                                                                    <span id="empid-availability" style="font-size:12px;"></span>
                                                                </div>
                                                                <div class="input-field col m4 s12">
                                                                    <select name="department" autocomplete="off">
                                                                        <?php $sql = "SELECT * from tbldepartments";
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
                                                                    <input id="position" name="position" value="<?php echo htmlentities($result->Position); ?>" type="text" required>
                                                                </div>
                                                                <div class="input-field col m6 s12">
                                                                    <label for="firstName">ชื่อ</label>
                                                                    <input id="firstName" name="firstName" value="<?php echo htmlentities($result->FirstName); ?>" type="text" required>
                                                                </div>
                                                                <div class="input-field col m6 s12">
                                                                    <label for="lastName">นามสกุล</label>
                                                                    <input id="lastName" name="lastName" value="<?php echo htmlentities($result->LastName); ?>" type="text" autocomplete="off" required>
                                                                </div>
                                                                <div class="col m6 s12 datePkr">
                                                                    <label for="birthdate">วัน เดือน ปีเกิด</label>
                                                                    <input id="birthdate" name="dob" class="datepicker" value="<?php echo htmlentities($result->Dob); ?>">
                                                                </div>
                                                                <div class="input-field col m6 s12">
                                                                    <label for="email">อีเมล</label>
                                                                    <input name="email" type="email" id="email" value="<?php echo htmlentities($result->EmailId); ?>" readonly autocomplete="off" required>
                                                                    <span class="avilable" id="emailid-availability" style="font-size:12px;"></span>
                                                                </div>

                                                    </div>
                                                </div>

                                                <div class="col m6">
                                                    <div class="row">
                                                        <div class="input-field col m6 s12">
                                                            <select name="gender" autocomplete="off">
                                                                <option value="<?php echo htmlentities($result->Gender); ?>"><?php echo htmlentities($result->Gender); ?></option>
                                                                <option value="Male">ชาย</option>
                                                                <option value="Female">หญิง</option>
                                                                <option value="Other">อื่นๆ</option>
                                                            </select>
                                                        </div>
                                                        <div class="col m6 s12 datePkr">
                                                            <label for="HireDate">วันที่เริ่มงาน</label>
                                                            <input id="HireDate" name="HireDate" class="datepicker" value="<?php echo htmlentities($result->HireDate); ?>" maxlength="10" autocomplete="off" readonly required>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <label for="address">ที่อยู่</label>
                                                            <input id="address" name="address" type="text" value="<?php echo htmlentities($result->Address); ?>" autocomplete="off" required>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <select id="city" name="city" required>
                                                                <option value="" disabled>เลือกจังหวัด</option>
                                                                <?php
                                                                $sql = "SELECT id, name_th FROM thai_provinces ORDER BY name_th";
                                                                $query = $dbh->prepare($sql);
                                                                $query->execute();
                                                                $provinces = $query->fetchAll(PDO::FETCH_OBJ);
                                                                foreach ($provinces as $province) {
                                                                    $selected = ($province->name_th == $result->City) ? 'selected' : '';
                                                                    echo "<option value='" . $province->name_th . "' data-id='" . $province->id . "' " . $selected . ">" . $province->name_th . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <label for="city">จังหวัด</label>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <select id="Aumphures" name="Aumphures" required>
                                                                <option value="" disabled>เลือกอำเภอ</option>
                                                                <?php
                                                                if ($result->City) {
                                                                    $sql = "SELECT * FROM thai_amphures WHERE province_id = (SELECT id FROM thai_provinces WHERE name_th = :city) ORDER BY name_th";
                                                                    $query = $dbh->prepare($sql);
                                                                    $query->bindParam(':city', $result->City, PDO::PARAM_STR); 
                                                                    $query->execute();
                                                                    $amphures = $query->fetchAll(PDO::FETCH_OBJ);
                                                                    foreach ($amphures as $amphur) {
                                                                        $selected = ($amphur->name_th == $result->Aumphures) ? 'selected' : '';
                                                                        echo "<option value='" . $amphur->name_th . "' data-id='" . $amphur->id . "' " . $selected . ">" . $amphur->name_th . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <label for="Aumphures">เขต/อำเภอ</label>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <select id="Tambon" name="Tambon" required>
                                                                <option value="" disabled>เลือกตำบล</option>
                                                                <?php
                                                                if ($result->Aumphures) {
                                                                    $sql = "SELECT id, name_th FROM thai_tambons WHERE amphure_id like (SELECT id FROM thai_amphures WHERE name_th = :amphure) ORDER BY name_th";
                                                                    error_log("SQL Query: " . $sql);
                                                                    error_log("Amphure value: " . $result->Aumphures);
                                                                    $query = $dbh->prepare($sql);
                                                                    $query->bindParam(':amphure', $result->Aumphures, PDO::PARAM_STR);
                                                                    $query->execute();
                                                                    error_log("Number of rows returned: " . $query->rowCount());
                                                                    $tambons = $query->fetchAll(PDO::FETCH_OBJ);
                                                                    
                                                                    foreach ($tambons as $tambon) {
                                                                        $selected = ($tambon->name_th == $result->Tambon) ? 'selected' : '';
                                                                        echo "<option value='" . $tambon->name_th . "' data-id='" . $tambon->id . "' " . $selected . ">" . $tambon->name_th . "</option>";
                                                                        
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <label for="Tambon">แขวง/ตำบล</label>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <label for="PostCode">รหัสไปรษณีย์</label>
                                                            <input id="PostCode" name="PostCode" type="text" value="<?php echo htmlentities($result->PostCode); ?>" autocomplete="off" readonly required>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <label for="phone">Mobile number</label>
                                                            <input id="phone" name="mobileno" type="tel" value="<?php echo htmlentities($result->Phonenumber); ?>" maxlength="10" autocomplete="off" required>
                                                        </div>
                                                <?php }
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12 center">
                                                    <button type="submit" name="update" id="update" class="waves-effect waves-light btn indigo m-b-xs">แก้ไขข้อมูลพนักงาน</button>
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