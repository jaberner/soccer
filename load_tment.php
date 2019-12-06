<?php  

 $connect = mysqli_connect("localhost", "root", "", "soccer");  
 $output = array();  
 $query = "SELECT * FROM tournament";  
 $result = mysqli_query($connect, $query);  
 while($row = mysqli_fetch_array($result))  
 {  
      $output[] = $row;  
 }  
 echo json_encode($output);  
 ?>  