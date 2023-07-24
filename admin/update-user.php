<?php include "header.php"; 

if($_SESSION ["user_role"]== '0'){
    header("Location: http://localhost/php-practise/news-template/admin/post.php");
}

//database connection datatable and isset submit btn start

if(isset($_POST['submit'])){
   include "config.php";
    $userid = mysqli_real_escape_string($connection, $_POST['user_id']);
    $fname = mysqli_real_escape_string($connection, $_POST['f_name']);
    $lname = mysqli_real_escape_string($connection, $_POST['l_name']);
    $user =mysqli_real_escape_string($connection, $_POST['username']);
    //$password =mysqli_real_escape_string($connection,md5( $_POST['password']));
    $role =mysqli_real_escape_string($connection, $_POST['role']);

   //database connection datatable and isset submit btn end

   //update my data table start
    $sql = "UPDATE user SET first_name = '{$fname}', last_name = '{$lname}', username = '{$user}', role = '{$role}' WHERE user_id = '{$userid}'";
    $result = mysqli_query($connection, $sql) or die("Query Failed");
     //update my data table end

        if(mysqli_query($connection,$sql)){
            header("Location: http://localhost/php-practise/news-template/admin/users.php");
        }        

    }
 ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">

              <?php

                //get id and loop tabe and add user start

                include "config.php";
                $user_id = $_GET['id'];
                $sqld1= "SELECT * FROM user WHERE user_id = {$user_id}";
                $result = mysqli_query($connection, $sqld1) or die ("Query Failed");
                if(mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_assoc($result)){
              ?>

                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF'];?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $row['user_id'];?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name'];?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name'];?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username'];?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                          <?php
                          //admin and normal user check start
                          if($row['role'] == 1){
                          echo "<option value='0'>normal User</option>
                          <option value='1' selected>Admin</option>";
                          }else{
                           echo " <option value='0' selected>normal User</option>
                           <option value='1'>Admin</option>";
                          }
                          //admin and normal user check end
                          ?>
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->

                  <?php
                    }
                    //get id and loop tabe and add user end
                }
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
