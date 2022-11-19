<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
            <h1>Change Password</h1>

            <br> <br>

            <?php
                if(isset($_GET['id'])) 
                {
                    $id = mysqli_real_escape_string($conn, $_GET['id']);
                }
            
            
            ?>

            <form action="" method = "POST">

            <table class = "tbl-30">
                 <tr>
                     <td>Current Password:</td>
                     <td>
                        <input type = "password" name = "current_password" placeholder = "Current Password">
                    </td>
                 </tr>

                 <tr>
                     <td>New Password: </td>
                     <td>
                        <input type = "password"  name = "new_password"  placeholder = "New Password">
                    </td>
                 </tr>


                 <tr>
                     <td>Confirm Password: </td>
                     <td>
                        <input type="password" name ="confirm_password" placeholder = "Confirm Password">
                     </td>
                 </tr>

                 <tr>
                    <td colspan="2">
                        <input type="hidden" name = "id" value = "<?php echo $id; ?> ">
                        <input type="submit" name ="submit" value ="Change Password" class = "btn-secondary">

                    </td>
                 </tr>
            </table>
      </form>
    </div>        

</div>

<?php 
   //Check whether Submit button is clicked or not

   if(isset($_POST['submit']))
   {
    //echo "Clicked";

    //1. Get the Data from FORM
    //$id = $_POST['id'];
    //$current_password =md5 ($_POST['current_password']);
    //$new_password =md5 ($_POST['new_password']);
    //$confirm_password =md5 ($_POST['confirm_password']);

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $current_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $current_password);

    $new_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $new_password);

    $confirm_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $confirm_password);

    //2. Check whether the user with current ID and current Password Exits or Not
    $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'"; 

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    if($res==true)
    {
        //Check whether data is available or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User Exit and Password Can Be Changed
           //echo "User Found";
           //Check whether the new password and the confirm password match o not

           if($new_password == $confirm_password)
           {
            //Update the password
            $sql2 = "UPDATE tbl_admin SET
            password = '$new_password'
            WHERE id = $id
            ";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql);

            //Chck whether the query executed or Not
            if($res==true)
            {
                //Display Success MESSAGE
                    $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully.</div>";
                    //Redirect the user to Manage Admin Page
                    header("location:".SITEURL.'admin/manage-admin.php');
            }
            else
            {
                //Display Error Message
                $_SESSION['pwd-not-match'] = "<div class = 'error'>Failed To Change Password.</div>";
                //Redirect the user to Manage Admin Page
                header("location:".SITEURL.'admin/manage-admin.php');
            }
           }
           else{
            //Redirect to Manage Admin PAge With Error MEsaage
            $_SESSION['pwd-not-match'] = "<div class = 'error'>Password Did Not Match.</div>";
            //Redirect the user to Manage Admin Page
            header("location:".SITEURL.'admin/manage-admin.php');
           }
        }
        else{
            //User does not exit, Set Message and Redirect
            $_SESSION['user-not-found'] = "<div class = 'error'>User Not Found.</div>";
            //Redirect the user to Manage Admin Page
            header("location:".SITEURL.'admin/manage-admin.php');
        }
    }

    //3. Check whether the New Password and Confirm Password Match or Not

    //4. Change Password If all Above Is True

   }



?>




<?php include('partials/footer.php');?>