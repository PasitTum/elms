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
        $yearsofservice = $_POST['yearsofservice'];
        $entitleddays = $_POST['entitleddays'];
        
        $sql = "update tblleaveentitlement set LeaveTypeID=:leavetype, YearsOfService=:yearsofservice, EntitledDays=:entitleddays where id=:lid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype', $leavetype, PDO::PARAM_INT);
        $query->bindParam(':yearsofservice', $yearsofservice, PDO::PARAM_INT);
        $query->bindParam(':entitleddays', $entitleddays, PDO::PARAM_INT); 
        $query->bindParam(':lid', $lid, PDO::PARAM_INT);
        $query->execute();

        $msg = "Leave Entitlement updated successfully";
    }

?>

<!DOCTYPE html>
<html lang="en">
...
                                    
<?php 
  $lid = intval($_GET['lid']);
  $sql = "SELECT le.id, lt.LeaveType, le.YearsOfService, le.EntitledDays 
          from tblleaveentitlement le
          INNER JOIN tblleavetype lt ON lt.id = le.LeaveTypeID 
          where le.id=:lid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':lid', $lid, PDO::PARAM_INT);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);

  if ($query->rowCount() > 0) {
      foreach ($results as $result) {               
?>
                                            
 <div class="row">
   <div class="input-field col s12">
     <select name="leavetype" autocomplete="off">
        <option value="">--Select Leave Type--</option>
        <?php 
          $sql = "SELECT * from tblleavetype";
          $leavetypequery = $dbh -> prepare($sql);
          $leavetypequery->execute();
          $leavetypes = $leavetypequery->fetchAll(PDO::FETCH_OBJ);
          foreach($leavetypes as $lt) {
        ?>                                        
        <option value="<?php echo htmlentities($lt->id);?>" <?php if($lt->id == $result->LeaveTypeID) {echo "selected";} ?>>
          <?php echo htmlentities($lt->LeaveType);?>
        </option>

       <?php } ?>
     </select>
     <label for="leavetype">Leave Type</label>
   </div>

   <div class="input-field col s12">
     <input id="yearsofservice" type="number" class="validate" autocomplete="off" name="yearsofservice" value="<?php echo htmlentities($result->YearsOfService);?>" required />
     <label for="yearsofservice">Years of Service</label>
   </div>

   <div class="input-field col s12">
     <input id="entitleddays" type="number" class="validate" autocomplete="off" name="entitleddays" value="<?php echo htmlentities($result->EntitledDays);?>" required />  
     <label for="entitleddays">Entitled Days</label>
   </div>
     
 </div>

<?php }} ?> 
                                            
<div class="input-field col s12">
  <button type="submit" name="update" class="waves-effect waves-light btn indigo m-b-xs">UPDATE</button>
</div>
                                        
</form>
...
</html>
<?php } ?>