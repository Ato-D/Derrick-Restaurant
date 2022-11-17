<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php 
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                //Create Sql query to Display Categories FRom Database
                $sql = "SELECT * FROM tbl_category WHERE featured='Yes' AND active='Yes' LIMIT 3";
                //Execute the Query
                $res = mysqli_query($conn, $sql);

                //Count the nmber of rows to check whether category is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //categories Available
                    //We use a while loop to Get And Display all the actegories from database 
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the values like id, title, image name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                        <!-- This code below will display the ID of the selected CATEGORY -->
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                //Check whether image is available or not
                                if($image_name=="")
                                {
                                    //Display message
                                    echo "<div class='error'>Image Not Available</div>";
                                } 
                                else
                                {
                                    //Image Available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                    <?php

                                }
                                
                                ?>
                                 
                                    <!-- Display the title as well -->
                                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else
                {
                    //catwgories not availble
                    echo "<div class='error'>Category Not Added</div>";
                }
            
            
            ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                //Getting Foods from Database that are Active and Featured
                //Sql Query
                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                
                //Count rows
                $count2 = mysqli_num_rows($res2);

                //check whether food available or not
                if($count2>0)
                {
                    //Food Available
                    while($row=mysqli_fetch_assoc($res2))
                    {
                        //Get all the values 
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

                        
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                     //Check whether image is available or not
                                     if($image_name=="")
                                     {
                                        //Image Not Available
                                        echo "<div class='error'>Image Not Available</div>";
                                     } 
                                     else
                                     {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                     }
                                
                                ?>
                                    
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">$<?php echo $price; ?>;</p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <!-- We have to specify the id of the food ordered below -->
                                <a href="<?php echo SITEURL ; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    //Food not Avialble
                    echo "<div class=error'>Food Not Available</div>";
                }
            
            ?>







            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>

 