<?php
include('boite_outils.php');


include('mesfonctions.php');

$connect = connexion();

if(isset($_GET['delid'])){
    $idp=$_GET['delid'];
    $requete = "SELECT id, proprietaire FROM photo WHERE id= '$idp'";
        $re = $connect->prepare($requete);
      $re->execute();
      if($nuplet = $re->fetch(PDO::FETCH_ASSOC)){
        $perso = $nuplet['proprietaire'];
        $perso_param = rawurlencode($perso);
        
       
    $sql_="DELETE FROM photo where id=$idp";
    //$sql="UPDATE photo SET description = 'hi89' where id=$idphoto";
    $resu = $connect->prepare($sql_);
      $resu->execute();
      
      if($resu){
        echo "nice";
        
        
      //header ("location:photos_personne.php?personne=$perso_param");
     }
    }
    
    else{
         die(mysqli_error($connect));
    }
 }
?>