<?php include('server.php') ?>
<?php 
	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: index.php');
	}
	if ($_SESSION['type'] != "prof"){
		session_destroy();
		header('location: index.php');
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: index.php");
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Planning</title>
	<?php include('head.php') ?>
</head>
<?php include('bar.php') ?>
	<nav>
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo"><img src="images/logo.png" height="85px" style="padding-bottom:10px;"></label>
      <ul>
        <li><a class="active" href="planprof.php">Planning</a></li>
        <li><a href="diagnoprof.php">Diagnostic</a></li>

      </ul>
    </nav> 
    <div class="glory">
		<h2 style="color: #330066; padding-top: 20px;"><strong>Planning</strong></h2>
<?php
$currentDateTime = date('Y-m-d');
$classes=array();
echo "
<div style='overflow-x:auto;'><table  class='content-table' >
<thead><tr>
<th>Classe</th>
<th>Jour</th>
<th>Heure de début</th>
<th>Heure de fin</th>
<th>Salle</th>
<th>G1</th>
<th>G2</th>
<th>G3</th>
<th>G4</th>
<th>G5</th>
<th>G6</th>
<th>G7</th>
<th>G8</th>
<th>G9</th>
<th>G10</th>
</tr></thead><tbody>";
 			$classe=[];
 			$groupe=[];
 			$results=mysqli_query($db,"SELECT * FROM groupe");
 		   	while($row = mysqli_fetch_array($results)){
 				array_push($classe,$row['classe']);
 				array_push($groupe,$row['n']);
 			}
for ($i=0; $i < count($classe); $i++) {
 $_SESSION[$classe[$i]]=array();
$just="seance_".$classe[$i];
$username=$_SESSION['username'];
$result = mysqli_query($db,"SELECT * FROM $just WHERE prof='$username'");
while($row = mysqli_fetch_array($result))
{
echo "<tr>
<td>".$classe[$i]."</td>";
array_push($classes,$classe[$i]);
array_push($_SESSION[$classe[$i]],$row['seance']);
echo "<td>".$row['debut']."</td>
<td>".$row['debut_time']."</td>
<td>".$row['fin_time']."</td>
<td>".$row['salle']."</td>";
$seance=$row['seance'];
$_SESSION['subject']=$row['subject'];
 $tsi=preg_replace('/[0-9]+/','',$classe[$i]);
 for($z=1; $z <= $groupe[$i]; $z++)
 {
 $G="G".$z;
 $G2="G2_".$z;
 $G3="G3_".$z;
 if($tsi=="tsi"){
$resulta = mysqli_query($db,"SELECT * FROM $classe[$i] WHERE $G='$seance' OR $G2='$seance' OR $G3='$seance'");
}
else{
	$resulta = mysqli_query($db,"SELECT * FROM $classe[$i] WHERE $G='$seance' OR $G2='$seance'");
}
$semaine="";
$weeek=mysqli_query($db,"SELECT * FROM semaine");
$debut=[];
$fin=[];
while($glad = mysqli_fetch_array($weeek)){
 				array_push($debut,$glad['debut']);
 				array_push($fin,$glad['fin']);
 			}
while($row1 = mysqli_fetch_array($resulta)){
		$finalweek=$row1['week'];
		if($currentDateTime>=$debut[$finalweek-1] && $currentDateTime<=$fin[$finalweek-1]){
	$semaine="<strong style='color:green;'>S".$row1['week']."</strong>+".$semaine;
}
else{
	$semaine="S".$row1['week']."+".$semaine;
}

}
echo "<td>".$semaine."</td>";
}
echo "</tr>";
}
}
echo "</tbody></table></div>";
?>
<p style="color: green; font-size:small;">*vert : semaine actuelle</p>
<?php include('foot.php') ?>