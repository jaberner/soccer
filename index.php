<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
           <title>FIFA Tournament Rosters</title>
           <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
           <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css"
   integrity="sha512-M2wvCLH6DSRazYeZRIm1JnYyh22purTM+FDB5CsyxtQJYeKq83arPe5wgbNmcFXGqiSH2XR8dT/fJISVA1r/zQ=="
   crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"
   integrity="sha512-lInM/apFSqyy1o6s89K4iQUKg6ppXEgsVxT35HbzUupEVRh2Eu9Wdl4tHj7dZO0s1uvplcYGmt3498TtHq+log=="
   crossorigin=""></script>
<link href="style/stylesheet.css" rel="stylesheet" type="text/css"><!--[if less than IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<body>
<div class="container"><!-- container: holds  elements -->
<div data-ng-app="myapp" data-ng-controller="usercontroller" data-ng-init="loadTournament()">
  <div id="right_side" class="sidebar1"><!-- holds combo boxes --> 
   <h2>FIFA Tournament Rosters</h2>
       <div id="divTournament"><img src="images/soccer.jpg" id="imgTournament" alt="tournament logo"></div><div id="divCountry"><img src="images/soccer.jpg" id="imgCountry" alt="national flag"></div>
       <hr>
       <div id="playerInfo">
          <img data-ng-repeat="player in selected" ng-src="{{makeUrl()}}" id="imgPlayer" alt="player photo"><br /><img src="images/soccer.jpg" id="imgClub" alt="club logo"><img src="images/soccer.jpg" id="imgLeague" alt="league logo"><br />
          <label id="lNumber" data-ng-repeat="player in selected">{{player.number}}</label><label id="lName" data-ng-repeat="player in selected">{{player.player_name}}</label>
          <br /><label id="lPosition" data-ng-repeat="player in selected">{{player.position}}</label><label data-ng-repeat="player in selected" id="lAge">{{player.age}}</label><br />
          <label id="lBirthplace" data-ng-repeat="player in selected">{{player.city_name}}, {{player.country_name}}</label><br />
          <label id="lClub" data-ng-repeat="player in selected">{{player.club_name}}</label><br />
          <label id="lLeague" data-ng-repeat="player in selected">{{player.league_name}}</label>
       </div>
  <!-- end .sidebar1 --></div>

  <article class="content_wide"><!-- .content -->
                    <div data-ng-init="b_c='birthplaces'" id="divRadio">
                    <label id="lblBirthplace">
                         <input data-ng-model="b_c" type="radio" name="rdoB_C" data-ng-value="'birthplaces'" data-ng-change="chkBirthplace()" class="xRadio">
                          View Birthplaces of Players
                        </label>
                        <label id="lblClub">
                        <input data-ng-model="b_c" type="radio" name="rdoB_C" data-ng-value="'clubs'" data-ng-change="chkClubs()" class="xRadio">
                         View Club Locations
                          </label>  
                      </div> 
                  
                    <br /> 
                     <select name="tournament" data-ng-model="tournament" class="form-control" data-ng-change="loadCountry()">  
                          <option value="">Select Tournament</option>  
                          <option data-ng-repeat="tournament in tournaments" value="{{tournament.tournament_id}}">{{tournament.tournament_name}}</option>  
                     </select>  
                     <br />
                     
                     
                     <select name="country" data-ng-model="country" class="form-control" data-ng-change="loadPlayer();" id="sCountry">  
                          <option value="">Select Country</option>  
                          <option data-ng-repeat="country in countries" value="{{country.country_id}}">  
                               {{country.country_name}}  
                          </option>  
                     </select>
                     <br />
                     <select name="player" data-ng-model="player" class="form-control" data-ng-change="selPlayer()" id="sPlayer">  
                          <option value="">Select Player</option>  
                          <option data-ng-repeat="player in players" value="{{player.player_id}}">  
                               {{player.player_name}}  
                          </option>  
                     </select>

                     <div class="tab">
                        <button ng-click="page='first'">Map View</button>
                        <button ng-click="page='second'" class="tab" id="btn2">Table View</button>
                    </div>

                    <div ng-init="page='first'"></div>
  
                    <div id="mapid" ng-show="page === 'first'"></div>
                    
                    <div id="table_div" ng-show="page === 'second'">
                       <table id="tblPlayer" class="table table-bordered" stopccp>  
                            <tr id="tblHeader">  
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
                            <tr data-ng-repeat="x in players" data-ng-click="" data-ng-class-odd="'odd'" data-ng-class-even="'even'">  
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
  //basemap
    var mymap = L.map('mapid').setView([0, 0], 2);
          L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
              attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
              maxZoom: 18,
              id: 'mapbox.streets',
              accessToken: 'pk.eyJ1IjoiYmVybmVyamEwMSIsImEiOiJjaW16Zmg3cmkwNGd0d2tsdXV4eHB5NzA1In0.l2pc-oE1fUK2zGxT9IkugA'
          }).addTo(mymap);//add basemap
          var mymarker = [];//holds map points
          var lat_lon = [];//holds latitude/longitude values
          j = 0;//counter for each respective player on a roster


     var app = angular.module("myapp",[]);

     //prevent data from being copied
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


     //controller
     app.controller("usercontroller", function($scope, $http){ 


          $scope.loadTournament = function(){  
               $http.get("load_tment.php")  
               .success(function(data){  
                    $scope.tournaments = data;
                    document.getElementById('tblPlayer').style.visibility = 'hidden';  
               })  
          }  


          $scope.loadCountry = function(){  
               $http.post("load_country.php", {'tournament_id':$scope.tournament})  
               .success(function(data){  
                    mymap.closePopup();
                    document.getElementById('tblPlayer').style.visibility = 'hidden';
                    document.getElementById('playerInfo').style.visibility = 'hidden';
                    $scope.countries = data;
                    $scope.players = null;
                    $scope.clearData();
                    mymap.setView([0,0], 1);
                    document.getElementById('divCountry').style.visibility = 'hidden';
                    document.getElementById('divTournament').style.visibility = 'visible';
                    document.getElementById('tblPlayer').style.visibility = 'hidden';
                    if(($scope.countries).length == 0){
                      document.getElementById('divTournament').style.visibility = 'hidden';
                      $scope.country = "";
                      $scope.player = "";
                      $scope.loadPlayer();
                      return;
                    }
                    document.getElementById("imgTournament").src = "images/tournaments/" + $scope.tournament + ".jpg";
               });  
          }


          $scope.loadPlayer = function(){  
               $http.post("load_player.php", {'country_id':$scope.country, 'tournament_id':$scope.tournament})  
               .success(function(data){  
                    $scope.players = data;
                    document.getElementById('playerInfo').style.visibility = 'hidden';
                    if(($scope.players).length == 0){
                      $scope.player = ""; 
                      $scope.players = null;
                      $scope.clearData();
                      document.getElementById('divCountry').style.visibility = 'hidden';
                      document.getElementById('tblPlayer').style.visibility = 'hidden'; 
                      return;
                    }
                    $scope.showData();
                    document.getElementById('divCountry').style.visibility = 'visible';
                    document.getElementById('tblPlayer').style.visibility = 'visible';
               });
          }


          $scope.clearData = function(){
            mymap.closePopup();
             if(j > 0){
                   for(i = j - 23; i < j; i++){
                   mymap.removeLayer(mymarker[i]);
                }
             }
          }


          $scope.showData = function(){
            document.getElementById("imgCountry").src = "images/countries/" + $scope.players[0][3] + ".png";
             $scope.clearData();
             for(i = 0; i < 23; i++){
                if($scope.b_c === "birthplaces"){
                  mymarker[j] = L.marker([$scope.players[i][26], $scope.players[i][27]]).addTo(mymap);
                  lat_lon[i] = [$scope.players[i][26], $scope.players[i][27]];
              }
              if($scope.b_c === "clubs"){
                  mymarker[j] = L.marker([$scope.players[i][20], $scope.players[i][21]]).addTo(mymap);
                  lat_lon[i] = [$scope.players[i][20], $scope.players[i][21]];
              }
                j++;
             }
             $scope.zoomData();
          }


          $scope.zoomData = function(){
            mymap.fitBounds(lat_lon);  
          }


          $scope.selPlayer = function(){
            $http.post("sel_player.php", {'player_id':$scope.player, 'tournament_id':$scope.tournament})  
               .success(function(data){  
                    $scope.selected = data;
                    $scope.zoomPlayer();
               });
          }


          $scope.zoomPlayer = function(){
            if(($scope.selected).length == 0){
              mymap.closePopup();
              document.getElementById('playerInfo').style.visibility = 'hidden';
              return;
            }
            //document.getElementById("imgPlayer").src = "images/players/" + $scope.selected[0][20];
               $scope.makeUrl = function() {
      return "images/players/" + $scope.selected[0][20];
    }
            document.getElementById("imgClub").src = "images/clubs/" + $scope.selected[0][10];
            document.getElementById("imgLeague").src = "images/leagues/" + $scope.selected[0][15];
            document.getElementById('playerInfo').style.visibility = 'visible';
            var index = $scope.selected[0][3] - 1;//index = selected player's number - 1
            var latlng;
            if($scope.b_c === "birthplaces"){
              latlng = L.latLng($scope.selected[0][31], $scope.selected[0][32]);
            }
            if($scope.b_c === "clubs"){
              latlng = L.latLng($scope.selected[0][25], $scope.selected[0][26]);
            }
            if($scope.b_c === "birthplaces"){
              var popup = L.popup()
              .setLatLng(latlng)
              .setContent($scope.selected[0][17] + "<br />" + $scope.selected[0][28] + ", " + $scope.selected[0][34])
              .openOn(mymap);
            mymap.setView(lat_lon[index], 6);
            }
            if($scope.b_c === "clubs"){
              var popup = L.popup()
              .setLatLng(latlng)
              .setContent($scope.selected[0][17] + "<br />" + $scope.selected[0].club_name + "<br />" + $scope.selected[0][22] + ", " + $scope.selected[0][38])
              .openOn(mymap);
            mymap.setView(lat_lon[index], 5);
            }  
          }


          $scope.chkClubs = function(){
            $scope.b_c = "clubs";
            $scope.player = "";
            $scope.loadPlayer();
          }


          $scope.chkBirthplace = function(){
            $scope.b_c = "birthplaces";
            $scope.player = "";
            $scope.loadPlayer();
          }

     });
    </script>

  </body>
 </html>
