<?php include('server.php') ?>
<?php 
	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: index.php');
	}
	if ($_SESSION['type'] != "admin"){
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
      	<li><a href="secret.php">Créer</a></li>
        <li><a class="active" href="planadmin.php">Planning</a></li>
        <li><a href="diagnoadmin.php">Diagnostic</a></li>
      </ul>
    </nav>  
  <div class="glory">
	 	<div class="row">
 	<form method="get" action="planadmin.php">
 		<!--<label style="color:#e066ff; font-size:25px; font-family:arial;"><i>Classe :</i></label>-->
		<div class="form-group" style="display: inline-block;">
		<label class="font-weight-bold" style="color:#e066ff;"><i>Classe :</i></label>
		<select name="classe" class="form-control" id="sel1">
 			<?php
 			$results=mysqli_query($db,"SELECT * FROM groupe");
 		   	while($row = mysqli_fetch_array($results)){
 				echo"<option value='".$row['classe']."'>".$row['classe']."</option>";
 			}
 			?>
		</select>
	</div>
      <button type="submit" name="ok" class="btn btn-outline-primary">Soumettre</button>
     </form>
	</div>
	<h2 style="color: #330066;"><strong>Planning :<?php echo $classe;?></strong></h2>

<?php
$currentDateTime = date('Y-m-d');
$results=mysqli_query($db,"SELECT * FROM $classe");
echo"
<h3 style='color:#9933ff;'>Maths et PC</h3>
<div style='overflow-x:auto;''><table  class='content-table' >
<thead>
<tr>
";
$results=mysqli_query($db,"SELECT n FROM groupe WHERE classe='$classe'");
while($row = mysqli_fetch_array($results)){
	$n=$row['n'];
}
for ($i=1; $i <= $n ; $i++) { 
echo"<th>G".$i."</th>";}
echo"
  </thead>";
echo "<tbody>";

$results=mysqli_query($db,"SELECT * FROM $classe");
$i=1;
while($row = mysqli_fetch_array($results)){
if($row['week']==$n+1){break;}
	if($currentDateTime>=$row['debut'] && $currentDateTime<=$row['fin']){
	 echo "<tr style='background-color:#d699ff;'>";
}else{
	echo "<tr>";
}
for ($y=1; $y <=$n ; $y++) { 
	$groupe='G'.$y;
	echo "<td>".$row[$groupe]."</td>";
}
echo "</tr>";
$i++;
}
echo "</tbody>";
echo"</table></div>";
echo"<small style='color:#9999ff;'>PS : Les nombres paires pour séances de PC/MA et impaires pour séances de MA/PC</small>"; 
 echo "
<h3 style='color:#9933ff; padding-top:20px;'>FR et ANG</h3>
<div style='overflow-x:auto;';>
<table class='content-table'>
<thead>
<tr>
";
for ($i=1; $i <= $n ; $i++) { 
echo"<th>G".$i."</th>";}
echo"
  </thead>";
echo "<tbody>";
$results=mysqli_query($db,"SELECT * FROM $classe");
$i=1;
while($row = mysqli_fetch_array($results))
{
	if($row['week']==$n+1){break;}
	if($currentDateTime>=$row['debut'] && $currentDateTime<=$row['fin']){
	 echo "<tr style='background-color:#d699ff;'>";
}else{
	echo "<tr>";
}
for ($y=1; $y <=$n ; $y++) { 
	$groupe='G2_'.$y;
	echo "<td>".$row[$groupe]."</td>";
}
echo "</tr>";
$i++;
}
echo "</tbody></table></div>";
echo"<small style='color:#9999ff;'>PS : Les nombres paires pour séances de FR/ANG et impaires pour séances de ANG/FR</small>"; 
 $tsi=preg_replace('/[0-9]+/','',$classe);
 if($tsi=="tsi"){
 echo "
<h3 style='color:#9933ff;padding-top:20px;'>GE et GM</h3>
<div style='overflow-x:auto;';>
<table class='content-table'>
<thead>
<tr>
";
for ($i=1; $i <= $n ; $i++) { 
echo"<th>G".$i."</th>";}
echo"
  </thead>";
echo "<tbody>";
$results=mysqli_query($db,"SELECT * FROM $classe");
$i=1;
while($row = mysqli_fetch_array($results))
{
	if($row['week']==$n+1){break;}
	if($currentDateTime>=$row['debut'] && $currentDateTime<=$row['fin']){
	 echo "<tr style='background-color:#d699ff;'>";
}else{
	echo "<tr>";
}
for ($y=1; $y <=$n ; $y++) { 
	$groupe='G3_'.$y;
	echo "<td>".$row[$groupe]."</td>";
}
echo "</tr>";
$i++;
}
echo "</tbody></table></div>";
echo"<small style='color:#9999ff;'>PS : Les nombres paires pour séances de GM/GE et impaires pour séances de GE/GM</small>"; 
}
?>
<h3 style='color:#9933ff;padding-top:20px;'>Semaines</h3>
<?php
echo "<div style='overflow-x:auto;'>
<table class='content-table'style='display:inline-block;'>
<thead>
<tr>
<th>Semaine</th>
<th>Date de début</th>
<th>Date de fin</th>
</tr>
<thead>";
$results=mysqli_query($db,"SELECT * FROM semaine");
echo "<tbody>";
while($row = mysqli_fetch_array($results))
{
echo "<tr><td>S" . $row['week'] . "</td>";
echo "<td>" . $row['debut'] . "</td>";
echo "<td>" . $row['fin'] . "</td></tr>";
if($row['week']==12){break;}
}
echo "</tbody></table>";
echo "<table class='content-table' style='display:inline-block; padding-left:10px;'>
<thead>
<tr>
<th>Semaine</th>
<th>Date de début</th>
<th>Date de fin</th>
</tr>
<thead>";
echo "<tbody>";
while($row = mysqli_fetch_array($results))
{
echo "<tr><td>S" . $row['week'] . "</td>";
echo "<td>" . $row['debut'] . "</td>";
echo "<td>" . $row['fin'] . "</td></tr>";
}
echo "</tbody></table></div>";
?>
<h3 style='color:#9933ff;'>Modifier les dates (semaines):</h3>
<form method="get" action="action.php">	
	<div style='overflow-x:auto;'>
	<table class="content-table">
	<thead>
		<tr>
	<th>Numéro</th>
	<th>Date début:</th>
	<th>Date fin:</th>
</tr>
	</thead>
	<tbody>
		<tr>

	<td><input class="form-control" type="number" min="1" value="1" style="width:60px;" name="semaine" ></td>
	
	<td><input class="form-control" type="date" name="debut"></td>
	
	<td><input class="form-control" type="date" name="fin"></td>
</tr>
	</tbody>
</table>
</div>
<button name="add_semaine" type="submit" class="btn btn-outline-primary">Modifier</button><br>
</form>

<h3 style='color:#9933ff; padding-top: 10px;'>Séances:</h3>
<?php
$seance="seance_".$classe;
$result = mysqli_query($db,"SELECT * FROM $seance ORDER BY seance ");
echo "<div style='overflow-x:auto;'><table class='content-table'>
<thead>
<tr>
<th>Seance</th>
<th>Matière</th>
<th>Jour</th>
<th>Heure de début</th>
<th>Heure de fin</th>
<th>Professeur</th>
<th>salle</th>
</tr></thead>";
while($row = mysqli_fetch_array($result))
{
echo "<tbody><tr>";
echo "<td>" . $row['seance'] . "</td>";
echo "<td>" . $row['subject'] . "</td>";
echo "<td>" . $row['debut'] . "</td>";
echo "<td>" . $row['debut_time'] . "</td>";
echo "<td>" . $row['fin_time'] . "</td>";
echo "<td>" . $row['prof'] . "</td>";
echo "<td>" . $row['salle'] . "</td>";
}
echo "</tbody></table></div>";
?>
<h3 style='color:#9933ff;'>Ajouter une séance:</h3>
<form method="get" action="action.php"> 
	<div style='overflow-x:auto;'>
	<table class="content-table">
	<thead>
		<tr>
		<th>Séance</th>
		<th>Matière</th>
		<th>Jour</th>
		<th>Heure de début</th>
		<th>Heure de fin</th>
		<th>Prof</th>
		<th>Salle</th>
	</tr>
	</thead>	
	<tbody>
		<tr>
	<td><input class="form-control" type="number" min="1" value="1" name="seance" style="width:60px;" ></td>
	<td><select name="subject" class="form-control" id="sel1" style="width: 80px;" value="PC">
 			<option value="MA">MA</option>
 			<option value="PC">PC</option>
 			<option value="GM">GM</option>
 			<option value="GE">GE</option>
 			<option value="ANG">ANG</option>
 			<option value="FR">FR</option>
		</select></td>
		<td>
		<select name="jour" class="form-control" id="sel1" style="width: 70px;">
 			<option value="Lu">Lu</option>
 			<option value="Ma">Ma</option>
 			<option value="Mer">Mer</option>
 			<option value="Je">Je</option>
 			<option value="Ve">Ve</option>
		</select>
	</td>
	<td><input type="time" name="debut1" class="form-control"></td>
	<td><input type="time" name="fin1" class="form-control"></td>
	<!--<td><input type="text" name="prof" style="width: 100px;" class="form-control"></td>-->
	<td><select name="prof" class="form-control" id="sel1" style="width: 100px;">
 			<?php
 			$results=mysqli_query($db,"SELECT * FROM users WHERE type='prof'");
 		   	while($row = mysqli_fetch_array($results)){
 				echo"<option value='".$row['username']."'>".$row['username']."</option>";
 			}
 			?>
		</select></td>
	<td><input type="text" name="salle" style="width: 100px;" class="form-control"></td>

		</tr>
</tbody>
</table></div>
<button  class="btn btn-outline-primary" name="add_seance" >Ajouter séance</button>
	<button  class="btn btn-outline-primary" name="delete_seance">supprimer séance</button>
</form>
<?php include('foot.php') ?>