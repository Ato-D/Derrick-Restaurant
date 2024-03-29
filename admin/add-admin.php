<?php include ('partials/menu.php'); ?>
 

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br> <br>

        <?php  
            if (isset($_SESSION['add'])) //Checking WHether Session Is Set Or Not
            {
                echo $_SESSION['add']; //Displaying Session Message If Set  
                unset($_SESSION['add']); //Removing Session Message
            }
        ?>    

        <form action="" method = "POST">

            <table class = "tbl-30" >
                <tr>
                    <td>Full Name:</td>
                    <td><input type = "text" name = "full_name" placeholder = "Enter Your name"></td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type = "text"  name = "username" placeholder = "Your username"></td>
                </tr>

                <tr>
                <td>Password: </td>
                    <td> <input type = "password" name = "password" placeholder = "Your Password"></td>
                </tr>
            

                <tr>
                    <td colspan="2">
                       <input type = "submit" text name = "submit" value = "Add Admin" class = "btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include ('partials/footer.php'); ?>

<?php 
//process the value from the form and save it in the database

// check whether the button is clicked or not

if(isset($_POST['submit']))
{
    //button clicked 
      //echo "Button Clicked";

    //1. Get the Data from FORM
    //$full_name = $_POST['full_name'];
    //$username = $_POST['username'];
    //$password = md5($_POST['password']); //Password Encrypted with MD5

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    $raw_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $raw_password);

    //2. SQL query to save the Data into database
    $sql = "INSERT INTO tbl_admin SET
      full_name = '$full_name',
      username = '$username',
      password = '$password'

    ";
  

  //3. Executing Query and Saving Data Into Database
    $res = mysqli_query($conn, $sql) or die(mysql_error());

    //4. Check whether the (Query is Executed) data is inserted or not and dispaly appropriate message

    if($res==TRUE)
    {
        //Data Inserted
        //echo "Data Inserted";

        //Cretae a  Session Variable to Display Message

        $_SESSION['add'] = "<div class='success'>Admin Added Successfully </div>";

        //Redirect Page To Manage Admin
        header("location:".SITEURL.'admin/manage-admin.php');

    }
    else{
        //Failed to Insert Data
        //echo "Failed to Insert Data";

          //Cretae a  Session Variable to Display Message

          $_SESSION['add'] = "<div class='error'>Failed to Add Admin </div>";

          //Redirect Page To Add Admin
          header("location:".SITEURL.'admin/add-admin.php');
    }

}



?>