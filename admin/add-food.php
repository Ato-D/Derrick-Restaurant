<?php include('partials/menu.php') ?>

<div class="main-content">
            <div class="wrapper">
            <h1>Add Food</h1>

             <br><br>
             

             <?php 
                 if(isset($_SESSION['upload']))
                 {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
             
                  }  


             ?>

             <form action="" method="post" enctype="multipart/form-data">

             <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category"width='100%'>

                        <?php 
                             //Create PHP Code to display categories from Database
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
                                //We have categories
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    //get the details of categories
                                    $id = $row['id'];
                                    $title = $row['title'];

                                    ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                    <?php

                                }
                             }
                             else
                             {
                                //We do not have categories
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                             }
                             //2. Display on Dropdown                        
                        
                        ?>
                           
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name=  "featured"  value="Yes">Yes
                        <input type="radio" name=  "featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">

                    </td>
                </tr>

            </table>
             </form>

             <?php

                    //Check whether button is clicked ot not
                    if(isset($_POST['submit'])) 
                    {
                        //Add the Food In Database
                        //echo "Clicked";

                        //1. Get the Data from form
                        $title =$_POST['title'];
                        $description =$_POST['description'];
                        $price =$_POST['price'];
                        $category =$_POST['category'];

                        //Check whether radio button for featured and active are checked or not
                        if(isset($_POST['featured']))
                        {
                            $featured = $_POST['featured'];
                        }
                        else
                        {
                            $featured = "No"; //string the Default value
                        }

                        if(isset($_POST['active']))
                        {
                            $active = $_POST['active'];
                        }
                        else
                        {
                            $active = "No"; //Selling Default value

                        }
                        

                        

                        //2. Upload image if selected
                        //Check whether the select image is clicked or not and upload the image is selected
                        if(isset($_FILES['image']['name']))
                        {
                            //Get the details of the selected image
                            $image_name = $_FILES['image']['name'];

                            //Check whether the image is selected or not and upload image only if selected 
                            if($image_name !="")
                            {
                                // Image is Selected
                                //A. Rename the image
                                //Get the extension of selected image (jpg, png,gif, etc)
                                $ext = end(explode('.', $image_name)); 

                                // Create New name for image
                                $image_name = "Food_Name-".rand(0000,9999).".".$ext; //New Image May Be "Food-name-593.jpg"

                                //B. Upload the Image
                                //Get the source path na Destination path

                                //Source path is the current location of the image 

                                 $src = $_FILES['image']['tmp_name'];

                                 //Destination Path for the image to be uploaded
                                 $dst = "../images/food/".$image_name;

                                 //Finally upload the food image
                                 $upload = move_uploaded_file($src, $dst);

                                 //Check whether image uploaded or not
                                 if($upload==false)
                                 {
                                    //Failed to upload the image
                                    //Redirect to Add Food page With Error Message
                                    $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                                    header('location:' .SITEURL. 'admin/add-food.php');

                                    //Stop the Process
                                    die();
                                 }



                            }
                        }
                        else
                        {
                            $image_name = ""; //Setting Default value as blank
                        }


                        //3. Insert Into Database

                        //Create Sql query to save or Add Food
                        //For numerical value we do not need to pass value iside quotes '' but for string value it is compulsory to add quotes ''
                        $sql2 = "INSERT INTO tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = '$price',
                        image_name = '$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'
                        ";

                        //Execute the Query
                        $res2 = mysqli_query($conn, $sql2);
                        //Check whether data is inserted or not
                        //4. Redirect with Message to Manage Food page

                        if($res2 == true)
                        {
                            //Data inserted Successfully
                            $_SESSION['add'] = "<div class = 'success'>Food Added Successfully</div>";
                            header('location:' .SITEURL. 'admin/manage-food.php');
                        }

                        else
                        {
                            //Failed to Insert Data
                            $_SESSION['add'] = "<div class = 'error'>Failed To Add Food</div>";
                            header('location:' .SITEURL. 'admin/manage-food.php');
                        }



                        


                    }       
             
             
             ?>

               


<?php include('partials/footer.php')?>