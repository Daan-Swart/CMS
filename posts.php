<?php


include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();
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

    if ($stm = $connect->prepare('DELETE FROM posts WHERE id = ?')) {
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();
        
        set_message("Post " . $_GET['delete'] . " has been deleted");

        $sql = "SET @num := 0;";
        $sql .= "UPDATE posts SET id = @num := (@num+1);";
        $sql .= "ALTER TABLE posts AUTO_INCREMENT=1;";
        $connect->multi_query($sql);
        header("Location: posts.php");
        $stm->close();
        die();
    } else {
        echo 'Could not prepere statement';
    }
}

if ($stm = $connect->prepare('SELECT * FROM posts')) {
    $stm->execute();

    $result = $stm->get_result();


    if ($result->num_rows > 0) {



?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h1 class='display-1'>Posts management</h1>
                    <a href="users.php">Users management</a>
                    |
                    <a href="posts.php">Posts management</a>
                    <p id="demo"></p>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Author's ID</th>
                            <th>Content</th>
                            <th>Edit | Delete</th>

                        </tr>
                        <?php while ($record = mysqli_fetch_assoc($result)) : ?>
                            <!-- <?php var_dump($record) ?> -->
                            <tr>
                                <td><?php echo $record['id'] ?></td>
                                <td><?php echo $record['title'] ?></td>
                                <td><?php echo $record['author'] ?></td>
                                <td><?php echo $record['content'] ?></td>
                                <td><a href="posts_edit.php?id=<?php echo $record['id'] ?>&email=<?php echo $record['author'] ?>">Edit</a> |
                                    <a href="posts.php?delete=<?php echo $record['id'] ?>" onClick="return confirm('Wil je dit account verwijderen?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>


                    </table>
                    <a href="posts_add.php">Add new post</a>

                </div>
            </div>

        </div>
<?php
    } else {
        echo "No posts found";
    }


    $stm->close();
} else {
    echo 'Could not prepere statement';
}






?>