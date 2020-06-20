<?php 
 $connectdb = mysqli_connect("localhost", "root", "", "ailehekim");
    
 if ($connectdb) {
 } else {
     echo "Db Connection Error";
 }
?>