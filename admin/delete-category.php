<?php 
     //include Constants file
     include('../config/constants.php');



   // echo "Delete Page";
   //Check whether the id and image name value is set or not
   if(isset($_GET['id']) AND isset($_GET['image_name']))
   {
        //Get the value and Delete
        //echo "Get value and Delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file if available
        if($image_name != "") 
        {
          //Image is Available so remove it
          $path = "../images/category/".$image_name;
          //Remove/Delete the Image 
          $remove = unlink($path);
          //If fail to remove timage then add an error message and stop the proces
          if($remove==false)
          {
               //Set the session message 
               $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image</div>";
               //Redirect to Manage Category Page
               header('location:' .SITEURL.'admin/manage-category.php');
               //Stop the Process
               die();

          }
        }

        //Delete data from database
        //SQL Query to Delete Data From Database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Exwcute the query
        $res= mysqli_query($conn, $sql);

        //Check whether the data is deleted from database or not
        if($res==true)
        {
            //Set Success Message and Redirect
            $_SESSION['delete'] = "<div class = 'success'>Category Deleted Successfully</div>.";
            //Redirect to MAnage Category
            header('location:' .SITEURL. 'admin/manage-category.php');
        }
        else
        {
            //Set Fail Message and Redirect
            $_SESSION['delete'] = "<div class = 'error'>Failed To Delete Category</div>.";
            //Redirect to MAnage Category
            header('location:' .SITEURL. 'admin/manage-category.php');

        }

     
   }
   else
   {
        //Redirect to Manage Category Page
        header('location:' .SITEURL. 'admin/mange-category\.php');
   }


?>