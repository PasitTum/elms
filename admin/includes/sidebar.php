     <aside id="slide-out" class="side-nav white fixed">
         <div class="side-nav-wrapper">
             <div class="sidebar-profile center">
                 <div class="sidebar-profile-image">
                     <img src="../assets/images/profile-image.png" class="circle" alt="">
                 </div>
                 <div class="sidebar-profile-info">
                     <p>Admin</p>
                 </div>
             </div>
             <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
                 <li class="no-padding"><a class="waves-effect waves-grey" href="dashboard.php"><i class="material-icons">settings_input_svideo</i>แดชบอร์ด</a></li>
                 <li class="no-padding">
                     <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">apps</i>แผนก<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                     <div class="collapsible-body">
                         <ul>
                             <li><a href="adddepartment.php">เพิ่มแผนก</a></li>
                             <li><a href="managedepartments.php">จัดการแผนก</a></li>
                         </ul>
                     </div>
                 </li>
                 <li class="no-padding">
                     <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">code</i>ประเภทการลา<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                     <div class="collapsible-body">
                         <ul>
                             <li><a href="addleavetype.php">เพิ่มประเภทการลา</a></li>
                             <li><a href="manageleavetype.php">จัดการประเภทการลา</a></li>
                         </ul>
                     </div>
                 </li>
                 <li class="no-padding">
                     <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">account_box</i>พนักงาน<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                     <div class="collapsible-body">
                         <ul>
                             <li><a href="addemployee.php">เพิ่มพนักงาน</a></li>
                             <li><a href="manageemployee.php">จัดการพนักงาน</a></li>

                         </ul>
                     </div>
                 </li>
                 <li class="no-padding">
                     <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">desktop_windows</i>การลา<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                     <div class="collapsible-body">
                         <ul>
                             <li><a href="leaves.php">การลาทั้งหมด </a></li>
                             <li><a href="pending-leavehistory.php">อยู่ระหว่างพิจารณา </a></li>
                             <li><a href="approvedleave-history.php">อนุมัติ</a></li>
                             <li><a href="notapproved-leaves.php">ไม่อนุมัติ</a></li>

                         </ul>
                     </div>
                 </li>
                 <li class="no-padding"><a class="waves-effect waves-grey" href="changepassword.php"><i class="material-icons">settings_input_svideo</i>เปลี่ยนรหัสผ่าน</a></li>
                 <li class="no-padding">
                     <a class="waves-effect waves-grey" href="logout.php"><i class="material-icons">exit_to_app</i>ออกจากระบบ</a>
                 </li>
             </ul>
             <div class="footer">
                 <!-- <p class="copyright">ELMS ©</p> -->
             </div>
         </div>
     </aside>