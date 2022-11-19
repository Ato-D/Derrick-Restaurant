<?php include('partials/menu.php'); ?>

<?php
     //Check whther id is set or not
     if(isset($_GET['id']))
     {
        //Get All the deatils
        $id = $_GET['id'];

        //SQL Query to Get Selected Food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id"; 

        //Execute the Query
        $res2 = mysqli_query($conn, $sql2);

        //Count the rows to check whether the id is valid or not
        $count = mysqli_num_rows($res2);

            //Get the value based on query executed
            $row2= mysqli_fetch_assoc($res2);

            //Get the individual values of selected food
            $title = $row2['title'];
            $description = $row2['description'];
            $price = $row2['price'];
            $current_image = $row2['image_name'];
            $current_category = $row2['category_id'];
            $featured = $row2['featured'];
            $active = $row2['active'];
        }
      
    else
        {
            //Redirect to Manage Food Page
            header('location:' .SITEURL. 'admin/manage-food.php');
        }

?>        

<div class="main-content">
    <div class="wrapper">
         <h1>Update Food</h1>
         <br><br>

         <form action="" method="post" enctype="multipart/form-data">

         <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>" >
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                             if($current_image == "")
                             {
                                //Image Not Available
                                echo "<div class='error'>Image Not Available</div>";
                             } 
                             else
                             {
                                //Image Available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>"width="150px">
                                <?php
                                

                             }
                        
                        ?>    
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                        <?php
                              //1. Create SQL to get all active categories from database
                              $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                              //Execute the Query
                              $res = mysqli_query($conn, $sql);
 
                              //Count rows to check whether we have categories or not
                              $count = mysqli_num_rows($res);
 
                              //Check whether category available or not
                              //If count is greater than zero, we have categories else we do not have categories
                              if($count>0)
                              {
                                 //Category Available
                                 while($row=mysqli_fetch_assoc($res))
                                 {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];


                                    //echo "<option value='$category_id'>$category_title</option>";                                    
                                    ?>
                                    <option value="<?php if($current_category==$current_id){echo "selected";} ?>" value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                                    <?php
                                 }
                             }   

                                 else
                                 {
                                    //Category Not Available
                                    echo "<option value='0'>Category Not Available</option>";

                                 }                   
                        
                        
                        ?>
                            
                        </select>   

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name=  "featured"  value="Yes">Yes
                        <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name=  "featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="No">No
                </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">    
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">

                    </td>
                </tr>
        </table>

        </form>

        <?php
             if(isset($_POST['submit']))
             {
                //echo "Button Clicked";

                //1. Get all the details from the form
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];
                

                //2. Upload the image if selected

                //Check whether upload button is clicked or not
                if(isset($_FILES['image']['name']))
            {
                //Get the Image Details
                $image_name = $_FILES['image']['name'];

                //Check whether the image file is available or not
                if($image_name!="")
                {
                        //Image Available
                        //A. Upload the new image 

                          //Rename our image
                    //Get the Extension of our image (jpg, png, gif, etc) e.g. "specialfood1.jpg"
                    $ext = end(explode('.', $image_name));

                    //Rename the Image
                    $image_name = "Food_Name_".rand(0000, 9999).'.'.$ext; //e.g Food_Category_894.jpg

                        //Get the Source Path and Destination Path
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;

                        //Upload the Image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        //Check whether the image is uploaded or not
                        //And if the image is not uploaded then we will stop the process and redirect with error message
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                            //Redirect to Manage Food PAge
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Stop the Process
                            die();

                             //3. Remove the image if new image is uploaded and current image exists
                            //B. Remove current image if available
                            if($current_image!="")
                        {
                            $remove_path ="../images/food/".$current_image;

                                $remove = unlink($remove_path);
    
                                 //Check whether image is removed or not
                                //if failed to remove then display the message and stop processes
                                if($remove==false)
                                {

                                //failed to remove image
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image</div>";
                                //Redirect to Manage Fod Page 
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die(); // stop the process
        
                                }
                            }
                                
                        }
                    else
                    {
                        $image_name = $current_image; //Default Image when Image is noy selected
                    }    
                    }
                else
                    {
                        $image_name = $current_image; //Default Image when Button is not clicked

                    }
                  
            }
               

                //4. Update the food in database
                $sql3 = "UPDATE tbl_food SET
                title='$title',
                description='$description',
                price='$price',
                image_name='$image_name',
                category_id='$category',
                featured='$featured',
                active='$active'
                WHERE id=$id
                ";

                //Excuet the Query
            $res3 = mysqli_query($conn, $sql3);

            //Check whether executed or Not
            if($res3==true)
            {
                //Query Executed and Food Updated
                $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                //failed to update food
                $_SESSION['update'] = "<div class='error'>Failed To Update Food</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }

            
            }              
             
        
        
        ?>


    </div> 
</div>   

<?php include('partials/footer.php'); ?>