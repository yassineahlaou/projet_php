<?php
include('boite_outils.php');

$personne = $_GET['personne'];

$connect = connexion();

?>
<html>
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type='text/javascript'>
   $(document).ready(function(){
     $('.dateFilter').datepicker({
        dateFormat: "yy-mm-dd"
     });
   });
   </script>
  
  
  <?php
  print "<title>Photos de $personne</title>"; 
  ?>
</head>
<body>
<h1>A faire: ajouter les dates dans le r�sum� des photos et trier les photos par dates</h1>
<form method='post' action=''>
     Start Date <input type="text" class="dateFilter" name="fromDate" value="<?php if(isset($_POST['fromDate'])) echo $_POST['fromDate']; ?>">
 
     End Date <input type="text" class="dateFilter" name="endDate" value="<?php if(isset($_POST['endDate'])) echo $_POST['endDate']; ?>">

     <input type="submit" name="but_search" value="Search">
   </form>
<!--<input type ="text" name = "from_date"  id = "from_date">
<input type ="text" name = "to_date"  id = "to_date">
<input type ="button" name = "filter"  id = "filter" value = "Filtrer">-->


<?php 
print "<h2>Photos de $personne</h2>\n"; 
?>


<!-- Employees List -->
   <div  >
 
     <table >
       <tr>
         <th>desc</th>
		 <th>photo</th>
         
         <th>date</th>
       </tr>

       <?php
       $emp_query = "SELECT * FROM photo WHERE proprietaire = '$personne'";

       // Date filter
       if(isset($_POST['but_search'])){
          $fromDate = $_POST['fromDate'];
          $endDate = $_POST['endDate'];

          if(!empty($fromDate) && !empty($endDate)){
             $emp_query .= " AND date_photo 
                          BETWEEN '".$fromDate."' and '".$endDate."' ";
          }
        }

        // Sort
        $emp_query .= " ORDER BY date_photo  DESC";
        //$employeesRecords = mysqli_query($connect,$emp_query);
		$resultat = $connect->prepare($emp_query);
		$resultat->execute();
		$row_count =$resultat->fetchColumn();

        // Check records found or not
		if($row_count > 0){
          while($empRecord = $resultat->fetch(PDO::FETCH_ASSOC)){
			$id_photo = $empRecord['id'];
            $date = $empRecord['date_photo'];
			$fichier = $empRecord['fichier'];
			$personne_param = rawurlencode($personne);
			$description_courte = substr(stripslashes($empRecord['description']),0,30);
			if (strlen ($empRecord['description']) > 30) {
				$description_courte = $description_courte.'...';
			}
			

            echo "<tr>";
            echo "<td><a href=\"photo.php?id=$id_photo\">$description_courte</a></td>";
			echo "<td><a href=\"photo.php?id=$id_photo\"><img src=\"$fichier\"></a></td>";
            echo "<td>". $date ."</td>";

           
            echo "</tr>";
          }
		}else{
		  echo "<tr>";
          echo "<td colspan='3'>No record found.</td>";
          echo "</tr>";
		}
        ?>
      </table>
 
    </div>








<!--print "<ol>\n";
$requete = "SELECT * FROM photo WHERE proprietaire = '$personne'";
$resultat = $connect->prepare($requete);
$resultat->execute();

while ($nuplet = $resultat->fetch(PDO::FETCH_ASSOC)) {
	$id_photo = $nuplet['id'];
	$date = $nuplet['date_photo'];
	
		$personne_param = rawurlencode($personne);
	$description_courte = substr(stripslashes($nuplet['description']),0,30);
	if (strlen($nuplet['description']) > 30) {
		$description_courte = $description_courte.'...';
	}
	$resume = $description_courte.$date;
	print "<div id=\"order_list\">";
	print "<li><a href='photo.php?id=$id_photo'>$resume</a></li>";
	print "</div>";
}

print "</ol>\n";
?>-->

</body>
</html>
<!--<script>
    $(document).ready(function(){
		$.datepicker.setDefaults({
   dateFormat:'yy-mm-dd'
});
        $(function(){
            $("#from_date").datepicker();
            $("#to_date").datepicker();
        });

		$('#filter').click(function(){
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    if(from_date != '' && to_date != '')
  {
	  
        $.ajax({
            url:"filter.php",
            method: "POST",
            data:{from_date:from_date, to_date:to_date},
			
            success:function(data)
            {
				console.log(data);
				$('#order_list').html = data; // erreur
				alert("hello");   
            }
			
		});
	}
		else {
			alert("Please Select date");
		}
    });
});
</script>-->

<?php
$connect = null;
?>
