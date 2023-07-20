<?php
ob_start();
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
include('includes/header.php');

include('includes/footer.php');
?>
<script type="text/javascript">
    function ConfirmDelete() {
        if (confirm("Delete Account?")) {
            location.href = 'users.php';
        }
    }
</script>

<?php
if (isset($_GET['delete'])) {

    if ($stm = $connect->prepare('DELETE FROM users WHERE id = ?')) {
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();
        set_message(" User " . $_GET['delete'] . " has been deleted");
        $connect->query('ALTER TABLE users AUTO_INCREMENT = 1');
        echo header("Location: a_users.php");
        $stm->close();
        die();
    } else {
        echo 'Could not prepere statement';
    }
}

if ($stm = $connect->prepare('SELECT * FROM users')) {
    $stm->execute();

    $result = $stm->get_result();


    if ($result->num_rows > 0) {



?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h1 class='display-1'>Users Management</h1>
                    <a href="users.php">Users management</a>
                    |
                    <a href="posts.php">Posts management</a>
                    <p id="demo"></p>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Edit</th>

                        </tr>
                        <?php while ($record = mysqli_fetch_assoc($result)) : ?>
                            <!-- <?php var_dump($record) ?> -->
                            <tr>
                                <td><?php echo $record['id'] ?></td>
                                <td><?php echo $record['username'] ?></td>
                                <td><?php echo $record['email'] ?></td>
                                <td><?php echo $record['active'] ?></td>
                                <?php if ($record['id'] == $_SESSION['id']) {
                                    echo '<td><a href="users_edit.php?id=' . $record['id'] .'">Edit</a></td>';
                                    continue;
                                }
                                echo "<td></td>";
                                ?>
                            </tr>
                        <?php endwhile; ?>


                    </table>

                </div>
            </div>

        </div>
<?php
    } else {
        echo "No users found";
    }


    $stm->close();
} else {
    echo 'Could not prepere statement';
}






?>