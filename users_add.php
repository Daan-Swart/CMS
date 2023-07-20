<?php

ob_start();
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
include('includes/header.php');



if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $active = $_POST['active'];


    if ($stm = $connect->prepare('INSERT INTO users (username, email, password, active) VALUES (?,?,?,?)')) {
        $hashed = sha1($password);
        $stm->bind_param('ssss', $username, $email, $hashed, $active);
        $stm->execute();

        set_message("A new user " . $username . " has been added");
        header('Location: a_users.php');
        $stm->close();
        die();
    } else {
        echo 'Could not prepere statement';
    }
}

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class='display-1'>Add user</h1>
            <form method="post">
                <!-- Username input -->
                <div class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control" />
                    <label class="form-label" for="username">Username</label>
                </div>

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

                <!-- Active select -->
                <div class="form-outline mb-4">
                    <select id="active" name="active" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add</button>
            </form>

        </div>
    </div>

</div>
<?php
include('includes/footer.php');
?>