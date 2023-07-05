<?php
$connect = mysqli_connect('localhost', 'cms', 'secret', 'cms' );

if(mysqli_connect_errno()){
    exit('Failed to connecto to MYSQL: '. mysqli_connect_error());
}  
?>