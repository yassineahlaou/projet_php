<?php
include("boite_outils.php");

$connect = connexion();
?>
<html>
<head>
  <title>Accueil</title>
  <script src="fonctions.js"> </script>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
</head>
<body>
<?php
print "<h2>Bienvenue $login !</h2>";	
?>  
<h3>Voir les photos de:</h3>
<ul>
<?php
	$requete = "SELECT login FROM utilisateur";
	$resultat = $connect->prepare($requete);
	$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$resultat->execute();
	while ($nuplet = $resultat->fetch(PDO::FETCH_ASSOC)) {
		$personne = $nuplet['login'];
		$personne_param = rawurlencode($personne);
		print '<li><a href="photos_personne.php?personne='
			.$personne_param.'">'.$personne.'</a></li>'."\n";

			
	}
?>
</ul>
<hr>
<h3>Ajouter une photo a ma collection</h3>
<form action="ajoute_photo.php" method="POST" enctype="multipart/form-data" name="add_photo">
	<p>Fichier de la photo: <input type="file" name="photo" size=30></p>
	<p>Description de la photo:</p>
	<p><textarea name="description" rows="10" cols="60">Entrez la description de la photo ici.
	</textarea></p>
	<p>Date de la photo: <? input_date('date_photo','add_photo'); ?></p>
	<div id="map"></div>
	<p>
	  <input type="submit" value="Ajouter la photo">
	  <input type="reset" value="Annuler">
	</p>
</form>
<hr>
<p><a href="deconnexion.php">Se deconnecter</a>.</p>
</body>
</html>
<script>
var map;
  function getData() {
    $.ajax({
    url: "map_api_wrapper.php",
    async: true,
    dataType: 'json',
    success: function (data) {
      console.log(data);
      //load map
      init_map(data);
    }
  });  
  }
  
  function init_map(data) {
        var map_options = {
            zoom: 14,
            center: new google.maps.LatLng(data['latitude'], data['longitude'])
          }
        map = new google.maps.Map(document.getElementById("map"), map_options);
       marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(data['latitude'], data['longitude'])
        });
        infowindow = new google.maps.InfoWindow({
            content: data['formatted_address']
        });
        google.maps.event.addListener(marker, "click", function () {
            infowindow.open(map, marker);
        });
        infowindow.open(map, marker);
    }
    
 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1Ewba3cSlzLJ1079fjEf0i_6PwBS7QrU&callback=getData" async defer></script>
</script>
<?php
    $connect = null;
?>
