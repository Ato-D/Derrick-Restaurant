<?php include('partials-front/menu.php'); ?>

    <?php
       //Check whether food id is set ot not
       if(isset($_GET['food_id'])) 
       {
            //Get the Food id and detailsof the selected food
            $food_id = $_GET['food_id'];

            //Get the Deatils of the selected Food
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
            //Execute the Query
            $res = mysqli_query($conn, $sql);
            //Count the rows
            $count = mysqli_num_rows($res);
            //Check whether the data is available or not
            //We are comparing with 1 because there would only be one row or value with one food ID
            if($count==1)
            {
                //We have Data
                //Get the row from database
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else
            {
                //Food Not available
                //Redirect to Home Page
                header('location:'.SITEURL);
            }

       }
       else
       {
            //Redirect to Homepage
            header('location:'.SITEURL);
       }
    
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
                             //Check whether the image is available or not
                             if($image_name=="")
                             {
                                //image Not Available
                                echo "<div class='error'>Image Not Available</div>";
                             }
                             else
                             {
                                //Image Is Available
                                ?> 
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                                <?php
                             }
                        
                        ?>
                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Derrick Donkoh" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 0598xxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. donkorderrick31@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                 //Check whether the CONFIRM button is clicked or Not
                 if(isset($_POST['submit']))
                 {
                    //Get all the details from the form
                    $food = mysqli_real_escape_string($conn, $_POST['food']);
                    $price = mysqli_real_escape_string($conn, $_POST['price']);
                    $qty = mysqli_real_escape_string($conn, $_POST['qty']);

                    $total = $price * $qty; // total = price x qty

                    $order_date = date("Y/m/d h:i:sa"); //Order Date

                    $status = "Ordered"; //Ordered, On Delivery, Delivered, Cancelled

                    $customer_name = mysqli_real_escape_string($conn, $_POST['full-name']);
                    $customer_contact = mysqli_real_escape_string($conn, $_POST['contact']);
                    $customer_email = mysqli_real_escape_string($conn, $_POST['email']);
                    $customer_address = mysqli_real_escape_string($conn, $_POST['address']);

                    //Save the orer In Database
                    //Create SQL to save database
                    $sql2 = "INSERT INTO tbl_order SET
                    food = '$food',
                    price = $price,
                    qty = $qty,
                    total = $total,
                    order_date = '$order_date',
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    ";

                   //echo $sql2; die();

                    //Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    //Check whether query is executed or not
                    if($res2==true)
                    {
                        //Query Executed and Order Saved
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //Failed To Save Order
                        $_SESSION['order'] = "<div class='error text-center'>Failed To Order Food</div>";
                        header('location:'.SITEURL);
                    }

                 } 
            
            
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>