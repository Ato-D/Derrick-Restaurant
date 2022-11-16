<?php include('partials-front/menu.php'); ?>


<?php
        //Check whether ID is passed or not
        //If category id is available, then we have to process and display everything based on category else redirect to Home Page
        if(isset($_GET['category_id']))
        {
            //Category id is set and get the id
            $category_id = $_GET['category_id'];

            //Get The Category Title BAsed on CAtegory ID
            $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //Get The VAlue From Database
            $row = mysqli_fetch_assoc($res);
            //Get The Title
            $category_title = $row['title'];

        }
        else
        {
            //Category Not Passed
            //Redirect to Home Page
            header('location:'.SITEURL);
        }
        

?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                //Create SQL Query to Get Foods based on selected Category
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

                //Execute The Query
                $res2 = mysqli_query($conn, $sql2);

                //Count The Rows
                $count2 = mysqli_num_rows($res2); 

                //Check whether food is available or not
                if($count2>0)
                {
                    //Food Is Available
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>

                        <div class="food-menu-box">
                                <div class="food-menu-img">

                                <?php 
                                    if($image_name=="")
                                    {
                                        //Image Not Available
                                        echo "div class='error'>Image Not Available</div>";
                                    }
                                    else
                                    {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                                        <?php
                                    }
                                
                                
                                ?>
                                    
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price">$<?php echo $price; ?></p>
                                    <p class="food-detail">
                                    <?php echo $description; ?>
                                    </p>
                                    <br>

                                    <a href="<?php echo SITEURL ; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                </div>
                        </div>


                        <?php

                    }
                }
                else
                {
                    //Food is Available
                    echo "<div class='error'>Food Not Available</div>";
                }
            
            ?>

    
            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>