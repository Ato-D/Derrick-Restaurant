<?php
    //Include Constants Page 
    include('../config/constants.php'); 

//echo "Delete food page";

     if(isset($_GET['id']) && isset($_GET['image_name']))
     {
        //Process To Delete
        //echo "Process to Delete";

        //1. Get ID and Image Name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Remove image if Available
        //Check whether the image is Avdailable or not and Delete only if Available
        if($image_name != "")
        {
            //It has image and need to remove from folder
            //Get the Image Path
            $path = "../images/food/".$image_name;

            //Remove Image file from folder
            $remove = unlink($path);

            //Check whether the image is removed or not
            if($remove==false)
            {
                //Failed to Remove Image
                $_SESSION['upload'] = "<div class='error'>Failed To Remove Image File</div>";
                //Redirect to Manage Food
                header('location:' .SITEURL. 'admin/manage-food.php');
                //Stop the process of Deleting Food
                die();
            }
        }

        //3. Delete Food from Database
        $sql = "DELETE FROM  tbl_food WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        
        //Check whether the Query Is Executed or Not And Set the Session Message Respectively
         //4. Redirect to Manage Food With Session Message
        if($res==true)
        {
            //Food Deleted
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
            header('location:' .SITEURL. 'admin/manage-food.php');
        }
        else
        {
            //Failed To Delete Food
            $_SESSION['delete'] = "<div class='error'>Failed To Delete Food</div>";
            header('location:' .SITEURL. 'admin/manage-food.php');
        }

       
     }
     else
     {
        //Redirect to Manage Food Page
        //echo "Redirect";
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
        header('location:' .SITEURL. 'admin/manage-food.php');
     }


?>