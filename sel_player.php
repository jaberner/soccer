<?php  

 $connect = mysqli_connect("localhost", "root", "", "soccer"); 
 $output = array(); 
 $data = json_decode(file_get_contents("php://input"));   
 $query = "SELECT * FROM player_tournament
			INNER JOIN club ON player_tournament.club_id = club.club_id
			INNER JOIN league ON player_tournament.league_id = league.league_id
			INNER JOIN player ON player.player_id = player_tournament.player_id
			INNER JOIN city C2 ON club.city_id = C2.city_id
			INNER JOIN city ON player.city_id = city.city_id
			INNER JOIN country ON city.country_id = country.country_id
			INNER JOIN country CN2 ON C2.country_id = CN2.country_id
			WHERE player.player_id =".$data->player_id."
			AND player_tournament.tournament_id =".$data->tournament_id;  
 $result = mysqli_query($connect, $query);  
 while($row = mysqli_fetch_array($result))  
 {  
      $output[] = $row;  
 }

 echo json_encode($output);  
 ?>