<?php 

// Include constants.php file here
include('../config/constants.php');

       // 1. Get the ID of Admin to be deleted
    $id = $_GET['id'];

       // 2. Create SQL Query to Delete Admin
       $sql = "DELETE FROM tbl_admin WHERE id = $id";

       // 3. Execute the Query
       $res = mysqli_query($conn, $sql);

       // Check whether the Query executed successfully or not
       if($res==true)
        {
           //Query executed successfully And Admin Deleted
           //echo "Admin Deleted";
           //Create seesion variable to display message
           $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully </div>";

           //Redirect to Manage Admin Page
           header("location:".SITEURL.'admin/manage-admin.php');

       }  
       else
       {
        //failed to Delete Admin
        //echo "Failed To Delete Admin";

        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin, Try Again Later </div>";

        //Redirect Page To Add Admin
        header("location:".SITEURL.'admin/manage-admin.php');
       }

       // 4. Redirect to Manage Admin page with message (successs/error)


?>