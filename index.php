<?php
ob_start();

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');

include('includes/header.php');

if (isset($_SESSION['id'])) {
    header('Location: dashboard.php');
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($stm = $connect->prepare('SELECT * FROM users WHERE email = ? AND password = ? and active = 1')) {
        $hashed = sha1($password);
        $stm->bind_param('ss', $email, $hashed);
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc();
        if(empty($user)){
            echo '<p style="color: red;">Gegevens kloppen niet</p>';
        }

        if ($user) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];

            set_message("You have succesfully logged in " . $_SESSION['username']);
            header('Location: dashboard.php');
            die();
        }
        $stm->close();
    } 
    else {
        
        echo 'Could not prepere statement';
    }
} ?>
<div class="container mt-5">
    <?php get_message() ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class='display-1'>Log in</h1>
            <form method="post">
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Email address</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>