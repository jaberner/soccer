<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
           <title>FIFA Tournament Rosters</title>
           <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
     
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"
   integrity="sha512-lInM/apFSqyy1o6s89K4iQUKg6ppXEgsVxT35HbzUupEVRh2Eu9Wdl4tHj7dZO0s1uvplcYGmt3498TtHq+log=="
   crossorigin=""></script>
   <script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
   <link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />
<link href="style/stylesheet.css" rel="stylesheet" type="text/css"><!--[if less than IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" href="dist/MarkerCluster.css" />
<link rel="stylesheet" href="dist/MarkerCluster.Default.css" />
<script src="dist/leaflet.markercluster-src.js"></script>
</head>

<body>
<div class="container"><!-- container: holds  elements -->
<div data-ng-app="myapp" data-ng-controller="usercontroller" data-ng-init="loadTournament()"><!-- CONTROLLER, run code to load all tournament names from database --> 
  <div id="right_side" class="sidebar1"><!-- holds combo boxes --> 
   <h2>FIFA Tournament Rosters</h2><!-- title-->
   <!-- TOURNAMENT LOGO and NATIONAL FLAG img --> 
       <div id="divTournament"><img data-ng-model="tournament" ng-src="{{makeTournamentImageUrl('.jpg')}}" id="imgTournament" alt="tournament logo"></div><div id="divCountry"><img data-ng-model="country" ng-src="{{makeCountryImageUrl('.png')}}" id="imgCountry" alt="national flag"></div>
       <hr>
       <div id="playerInfo"><!-- container on left side of screen showing pictures of players and their information --> 
          <img ng-src="{{makePlayerImageUrl('.jpg')}}" id="imgPlayer" alt="player photo"><br />
          <img ng-src="{{makeClubImageUrl('.jpg')}}" id="imgClub" alt="club logo"><img ng-src="{{makeLeagueImageUrl('.jpg')}}" id="imgLeague" alt="league logo"><br /><!-- images of PLAYER, CLUB LOGO, LEAGUE LOGO--><label id="lNumber" data-ng-repeat="player in selected">{{player.number}}</label><label id="lName" data-ng-repeat="player in selected">{{player.player_name}}</label><!-- info for individual PLAYERS--> 
          <br /><label id="lPosition" data-ng-repeat="player in selected">{{player.position}}</label><label>age:&nbsp</label><label data-ng-repeat="player in selected" id="lAge">{{player.age}}</label><br /><!-- individual PLAYER info--> 
          <label id="lBirthplace" data-ng-repeat="player in selected">{{player.city_name}}, {{player.country_name}}</label><br /><!-- individual PLAYER info-->
          <label id="lClub" data-ng-repeat="player in selected">{{player.club_name}}</label><br /><!-- individual PLAYER info-->
          <label id="lLeague" data-ng-repeat="player in selected">{{player.league_name}}</label><!-- individual PLAYER info-->
       </div>
  <!-- end .sidebar1 --></div>

  <article class="content_wide"><!-- .content -->
                    <div data-ng-init="MapPointType='birthplaces'" id="divRadio"><!-- radio button with options to display points showing birthplaces of player or points showing club locations -->
                    <label id="lblBirthplace"><!-- click to show birthplaces of players -->
                         <input data-ng-model="MapPointType" type="radio" name="radioBtnMapPointType" data-ng-value="'birthplaces'" data-ng-change="chkBirthplace()" class="xRadio">
                          View Birthplaces of Players
                        </label>
                        <label id="lblClub"><!-- click to show club locations of players -->
                        <input data-ng-model="MapPointType" type="radio" name="radioBtnMapPointType" data-ng-value="'clubs'" data-ng-change="chkClubs()" class="xRadio">
                         View Club Locations
                          </label>  
                      </div> 
                  
                    <br /> 
                     <select name="tournament" data-ng-model="tournament" class="form-control" data-ng-change="loadCountry()"><!-- select TOURNAMENT combo box --> 
                          <option value="">Select Tournament</option>  
                          <option data-ng-repeat="tournament in tournaments" value="{{tournament.tournament_id}}">{{tournament.tournament_name}}</option><!-- load NATIONAL TEAMS for selected TOURNAMENT -->  
                     </select>  
                     <br />
                     
                     
                     <select name="country" data-ng-model="country" class="form-control" data-ng-change="loadPlayer();" id="sCountry"><!-- select NATIONAL TEAM combo box --> 
                          <option value="">Select Country</option>  
                          <option data-ng-repeat="country in countries" value="{{country.country_id}}">{{country.country_name}}</option><!-- load PLAYERS for selected NATIONAL TEAM --> 
                     </select>
                     <br />

                     <select name="player" data-ng-model="player" class="form-control" data-ng-change="selPlayer()" id="sPlayer"><!-- select PLAYER combo box --> 
                          <option value="">Select Player</option>  
                          <option data-ng-repeat="player in players" value="{{player.player_id}}">{{player.player_name}}</option><!-- load ROSTER for selected NATIONAL TEAM --> 
                     </select>

                     <div class="tab"><!-- select to either display MAP OR TABLE showing roster information --> 
                        <button ng-click="page='first'">Map View</button><!-- show MAP --> 
                        <button ng-click="page='second'" class="tab" id="btn2">Table View</button><!-- show TABLE--> 
                    </div>

                    <div ng-init="page='first'"></div>
  
                    <div id="mapid" ng-show="page === 'first'"></div>
                    
                    <div id="table_div" ng-show="page === 'second'"><!-- table showing roster informaion --> 
                       <table id="tblPlayer" class="table table-bordered" stopccp>  
                            <tr id="tblHeader">  <!-- headers --> 
                                 <th>Number</th>  
                                 <th>Player</th>
                                 <th>Position</th>
                                 <th>Age</th>
                                 <th>Birth City</th>
                                 <th>Birth Country</th>
                                 <th>Club</th>
                                 <th>League</th>
                                 <th>Division</th>
                            </tr>  
                            <tr data-ng-repeat="x in players" data-ng-click="" data-ng-class-odd="'odd'" data-ng-class-even="'even'"><!-- table data --> 
                                 <td >{{x.number}}</td>  
                                 <td >{{x.player_name}}</td>
                                 <td >{{x.position}}</td>
                                 <td >{{x.age}}</td>
                                 <td >{{x.city_name}}</td>
                                 <td >{{x.country_name}}</td>
                                 <td >{{x.club_name}}</td>
                                 <td >{{x.league_name}}</td>
                                 <td >{{x.division}}</td>
                            </tr>  
                       </table> 
                     </div>

                </div>    
    <!-- end .content --></article>
  <!-- end .container --></div>



  <script type="text/javascript">
  //LEAFLET CODE: basemap
    


          var mymap = L.map('mapid').setView([0, 0], 2);
          L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
          attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
          tileSize: 512,
          maxZoom: 18,
          zoomOffset: -1,
          id: 'mapbox/outdoors-v11',
          accessToken: 'pk.eyJ1IjoiYmVybmVyamEwMSIsImEiOiJja2ljNHFmNGswZmtpMnlxeGU2d2U4OHBiIn0._A75W9xiclQQwU3iQ9MgHg'
          }).addTo(mymap);

          //VARIABLES
         
          var mymarker = [];//holds map points
          var markers = L.markerClusterGroup({maxClusterRadius: 2});
          var marker = L.marker();
          
          var lat_lon = [];//holds latitude/longitude values
          numMapPointsDisplayed = 0;//counter for the point currently displayed on the map corresponding to each respective player on a roster
          numPlayersRoster = 23;//total number of players on each team

          imgClubs = "images/clubs/"; //path for club logo images
          imgLeagues = "images/leagues/"; //path for league logo images
          imgPlayers = "images/players/"; //path for player images
          imgCountries = "images/countries/";//path for country flag images
          imgTournaments = "images/tournaments/";//path for tournament logos




          //class for map coordinates
          class MapCoordinate{
            constructor(longitude,latitude){
              this.x = longitude;
              this.y = latitude;
            }
          }



           //class for players
          class SoccerPlayer{
            constructor(player_name, player_city, player_country, player_number){
              this.name = player_name;
              this.city = player_city;
              this.country = player_country;
              this.number = player_number;
            }

            get_location(){//return string formatted <city, country>
              return this.city + ", " + this.country;
            }

            get_index(){//for coding purposes - player's index in global array of coordinates (lat_lon) corresponds to their jersey number - 1
              return this.number - 1;
            }
          }



           //class for clubs
          class SoccerTeam{
            constructor(club_name, club_city, club_country){
              this.name = club_name;
              this.city = club_city;
              this.country = club_country;
            }

            get_location(){//return string formatted <city, country>
              return this.city + ", " + this.country;
            }
          }





    //ANGULARJS CODE
     var app = angular.module("myapp",[]);

     //DIRECTIVE - prevent data from being copied
     app.directive('stopccp', function(){
      return {
        scope: {},
        link:function(scope,element){
            element.on('cut copy', function (event) {
              event.preventDefault();
            });
        }
    };
});


     //CONTROLLER
     app.controller("usercontroller", function($scope, $http){ 


          //tournamnets loaded from database when page INITIALIZES
          $scope.loadTournament = function(){  
               $http.get("load_tment.php") 
               .success(function(data){  
                    $scope.tournaments = data;
                    document.getElementById('tblPlayer').style.visibility = 'hidden';//hide table  
               })  
          }  


          //SELECT TOURNAMENT combo box selection change
          $scope.loadCountry = function(){  
               $http.post("load_country.php", {'tournament_id':$scope.tournament})  
               .success(function(data){
                    document.getElementById('tblPlayer').style.visibility = 'hidden';//hide table
                    document.getElementById('playerInfo').style.visibility = 'hidden';//hide pictures of players and their information
                    $scope.countries = data;//countries for selected tournament returned from database, added to COUNTRIES combo box
                    $scope.country = "";//clear selected coutnries
                    $scope.players = null;//clear selected players if a national team reviously chosen
                    $scope.clearData();//clear map points, close pop-up window
                    mymap.setView([0,0], 1);//zoom out
                    document.getElementById('divCountry').style.visibility = 'hidden';//hide country flag image
                    document.getElementById('divTournament').style.visibility = 'visible';//hide tournament logo
                    if(($scope.countries).length == 0){//if query doesn't return ONE country ('<SELECT TOURNAMENT>' clicked) -> 
                      document.getElementById('divTournament').style.visibility = 'hidden';//hide tournament logo
                      $scope.country = "";//clear selected coutnries
                      $scope.player = "";//clear selected player
                      return;
                    }
               });  
          }


          //SELECT COUNTRY combo box selection change
          $scope.loadPlayer = function(){
               $http.post("load_player.php", {'country_id':$scope.country, 'tournament_id':$scope.tournament})  
               .success(function(data){  
                    $scope.players = data;//players for selected national team returned from database, added to PLAYERS combo box
                    document.getElementById('playerInfo').style.visibility = 'hidden';//hide pictures of players and their information
                    if(($scope.players).length == 0){//if query doesn't return ONE player ('<SELECT PLAYER>' clicked) -> 
                      $scope.player = "";//clear previously selected player if there is one
                      $scope.players = null;//clear selected players if a national team reviously chosen
                      $scope.clearData();//clear map points, close pop-up window
                      document.getElementById('divCountry').style.visibility = 'hidden';//hide country flag image
                      document.getElementById('tblPlayer').style.visibility = 'hidden';//hide table
                      return;
                    }
                    $scope.clearData();//clear map points, close pop-up window
                    for(i = 0; i < numPlayersRoster; i++){//for each player on roster:
                      if($scope.MapPointType === "birthplaces"){//if BIRTHPLACES chosen ->
                        player_birthplace = new MapCoordinate($scope.players[i][26], $scope.players[i][27]);//new MapCoordinate object to hold birthplace x,y
                        //mymarker[numMapPointsDisplayed] = L.marker([player_birthplace.x, player_birthplace.y]).addTo(mymap);//LEAFLET: add marker to map for birthplace
                        var name = $scope.players[i][1] + "<br />" + $scope.players[i][23] + ", " + $scope.players[i][29] + "<br /><img style='width:100px' src='" + imgPlayers + $scope.players[i][4] + "'>";
                        //for popup on click
                        var marker = L.marker([player_birthplace.x, player_birthplace.y], {name: name}).on('click', onClick);
                        marker.bindPopup(name);
                        markers.addLayer(marker);//LEAFLET: add marker to map for birthplace
                        lat_lon[i] = [player_birthplace.x, player_birthplace.y];//store coordinates for player's birthplace in global array
                      }
                      if($scope.MapPointType === "clubs"){//if CLUBS chosen ->
                          club_location = new MapCoordinate($scope.players[i][20], $scope.players[i][21]);//new MapCoordinate object to hold club location x,y
                          //mymarker[numMapPointsDisplayed] = L.marker([club_location.x, club_location.y]).addTo(mymap);//LEAFLET: add marker to map for club location
                          var name = $scope.players[i][1] + "<br />" + $scope.players[i][13]+ "<br /><img style='width:100px' src='" + imgPlayers + $scope.players[i][4] + "'>";//for popup on click
                          marker = L.marker([club_location.x, club_location.y], {name: name}).on('click', onClick);
                          marker.bindPopup(name);
                          markers.addLayer(marker);//LEAFLET: add marker to map for birthplace
                          lat_lon[i] = [club_location.x, club_location.y];//store coordinates for player's club location in global array
                      }
                        numMapPointsDisplayed++;//increment until one point mapped for each player on roster
                      }
                      mymap.addLayer(markers);
                      
                     mymap.fitBounds(lat_lon);//zooms to best show all map points that are currently displayed
                      document.getElementById('divCountry').style.visibility = 'visible';//show country flag image
                      document.getElementById('tblPlayer').style.visibility = 'visible';//show table
            });
          }


          function onClick(e){
            document.getElementById('playerInfo').style.visibility = 'hidden';//hide pictures of players and their information on the side
          }




            //SELECT PLAYER combo box selection change
            $scope.selPlayer = function(){
            $http.post("sel_player.php", {'player_id':$scope.player, 'tournament_id':$scope.tournament})  
               .success(function(data){  
                    $scope.selected = data;//selected player's info for selected tournament returned from database
                     if(($scope.selected).length != 1){//if query doesn't return ONE player ('<SELECT PLAYER>' clicked) -> close popup and hide player info/pic/logos
                      mymap.closePopup();//close popup
                      
                      return;
            }     
            document.getElementById('playerInfo').style.visibility = 'visible';//make player info/pic/logos visible
            soccer_player = new SoccerPlayer($scope.selected[0].player_name, $scope.selected[0][28], $scope.selected[0][38], $scope.selected[0][3]);//new SoccerPlayer object
            var index = soccer_player.get_index();//index = selected player's number - 1
            if($scope.MapPointType === "birthplaces"){//if BIRTHPLACES chosen ->
              var popup = L.popup()//create popup
              .setLatLng(lat_lon[index])//set location of popup
              .setContent(soccer_player.name + "<br />" + soccer_player.get_location())//show player's name and birthplace in popup
              .openOn(mymap);//open popup
            mymap.setView(lat_lon[index], 6);
            }
            if($scope.MapPointType === "clubs"){//if CLUBS chosen ->
              soccer_team = new SoccerTeam($scope.selected[0].club_name, $scope.selected[0][22], $scope.selected[0][34]);//new SoccerTeam object
              var popup = L.popup()//create popup
              .setLatLng(lat_lon[index])//set location of popup
              .setContent($scope.selected[0][17] + "<br />" + soccer_team.name + "<br />" + soccer_team.get_location())//show player's name and club_location in popup
              .openOn(mymap);//open popup
            mymap.setView(lat_lon[index], 5);//set map location and zoom-level
            }  
               });
          }



          //clear all currently displayed map points and close pop-up window
          $scope.clearData = function(){
            mymap.closePopup();
            markers.clearLayers();
          }



          //Functions to construct URLs for images when player is selected (player photo, club logo, league logo)
          //Workaround: three database tables all have same column name (image_url) - didn't find better solution (selected values are hard-coded in each image)
          $scope.makeClubImageUrl = function(fileType) {//make URL for club logos

            return imgClubs + $scope.selected[0].club_id + fileType;
          }

          $scope.makeLeagueImageUrl = function(fileType) {//make URL for league logos

            return imgLeagues + $scope.selected[0].league_id + fileType;
          }

          $scope.makePlayerImageUrl = function(fileType) {//make URL for player images

            return imgPlayers + $scope.selected[0].player_id + fileType;
          }

          $scope.makeCountryImageUrl = function(fileType) {//make URL for national flag images

            return imgCountries + $scope.players[0][3] + fileType;
          }

          $scope.makeTournamentImageUrl = function(fileType) {//make URL for tournament logo images
            
            return imgTournaments + $scope.tournament[0] + fileType;
          }


          //switch type of map points displayed on map TO CLUB LOCATIONS (where each player plays professionally)
          $scope.chkClubs = function(){
            $scope.MapPointType = "clubs";
            $scope.player = "";//if player is selected, clears selection
            $scope.loadPlayer();//show points on map for CLUB LOCATIONS
          }

          //switch type of map points displayed on map TO BIRTHPLACES OF PLAYERS
          $scope.chkBirthplace = function(){
            $scope.MapPointType = "birthplaces";
            $scope.player = "";//if player is selected, clears selection
            $scope.loadPlayer();//show points on map for BIRTHPLACES
          }

     });
    </script>

  </body>
 </html>
