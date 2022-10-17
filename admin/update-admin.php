<?php include('partials/menu.php')?>;

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br> <br>

        <?php 
        // 1. Get the ID of Selected Admin
        $id = $_GET['id'];

        // 2. Create SQL query to Get The Details
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check whether the Query IS Executed Or Not 
        if($res==true)
        {
            //Check Wheteher the Data is available or not
            $count = mysqli_num_rows($res); //function to get all the rows in the database

            //Check whether we have admin data or not
            if($count==1)
            {
                //Get the Details
                //echo " Admin Available";
                $rows = mysqli_fetch_assoc($res);

                $full_name = $rows['full_name'];
                $username = $rows['username'];
            }
            else
            {
                //Redirect to Manage Admin Page
                header("location:".SITEURL.'admin/manage-admin.php');
            }
        }
        
        
        ?>

      <form action="" method = "POST">

            <table class = "tbl-30">
                 <tr>
                     <td>Full Name:</td>
                     <td>
                        <input type = "text" name = "full_name" value="<?php echo $full_name; ?>">
                    </td>
                 </tr>

                 <tr>
                     <td>Username: </td>
                     <td>
                        <input type = "text"  name = "username" value="<?php echo $username; ?>">
                    </td>
                 </tr>


                 <tr>
                     <td colspan="2">
                        <input type="hidden" name = "id" value = "<?php echo $id; ?>">
                       <input type = "submit" name = "submit" value = "Update Admin" class = "btn-secondary">
                    </td>
                 </tr>
            </table>
      </form>
    </div>
</div>

<?php 

//Check whether the Submit button is clicked or not
if(isset ($_POST['submit']))
{
    //echo "Button Clicked";
    //Get all the values fro FORm to update
     $id = $_POST['id'];
     $full_name = $_POST['full_name'];
     $username = $_POST['username']; 

     //Create a SQL to query to udate Admim
     $sql = "UPDATE tbl_admin SET
      full_name = '$full_name',
      username = '$username'

      WHERE id = '$id'
     
     ";

     // Execute the Query
     $res = mysqli_query($conn, $sql);

     //Check whether the Query is executed successfully or not

     if($res==true)
     {
        // Query executed and Admin Updated
        $_SESSION['update'] = "<div class='success'>Admin Updated Successfully </div>";

         //Redirect Page To Manage Admin
         header("location:".SITEURL.'admin/manage-admin.php'); 
     }

     else
     {
        //failed to Update Admin
        $_SESSION['add'] = "<div class='error'>Failed to Delete Admin </div>";

          //Redirect Page To Manage Admin Page
          header("location:".SITEURL.'admin/manage-admin.php');
     }
}


?>



<?php include('partials/footer.php')?>;