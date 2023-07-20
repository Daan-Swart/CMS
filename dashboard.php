<?php
ob_start();
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
include('includes/header.php');
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class='display-1'>Dashboard</h1>

            <?php 
            if($_SESSION['id']=="1"){
              echo  '<a href="a_users.php">Users management</a>';
            }
            else{
             echo  '<a href="users.php">Users management</a>';       
            }
            ?>
            
            
            <a href="posts.php">Post management</a>
        </div>
    </div>

</div>
<?php
include('includes/footer.php');
?>