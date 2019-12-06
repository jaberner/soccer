 <?php  
 
 $connect = mysqli_connect("localhost", "root", "", "soccer"); 
 $output = array();  
 $data = json_decode(file_get_contents("php://input"));  
 $query = "SELECT *
					  FROM country
					  WHERE country.country_id IN
					   		(SELECT tournament_country.country_id
					   		FROM tournament_country
					   		WHERE tournament_country.tournament_id='".$data->tournament_id."') 
					   		ORDER BY country.country_name";  
 $result = mysqli_query($connect, $query);  
 while($row = mysqli_fetch_array($result))  
 {  
      $output[] = $row;  
 }  
 echo json_encode($output);  
 ?>