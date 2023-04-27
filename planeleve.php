<?php include('server.php') ?>
<?php 
	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: index.php');
	}
	if ($_SESSION['type'] != "eleve"){
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
        <li><a class="active" href="planeleve.php">Planning</a></li>
        <li><a href="diagnoeleve.php">Diagnostic</a></li>

      </ul>
    </nav> 
    <div class="glory">
	<?php
$currentDateTime = date('Y-m-d');
$weeek=mysqli_query($db,"SELECT * FROM semaine");
$debut=[];
$fin=[];
while($glad = mysqli_fetch_array($weeek)){
 				array_push($debut,$glad['debut']);
 				array_push($fin,$glad['fin']);
 			}
$student = $_SESSION['username'];
$result = mysqli_query($db,"SELECT * FROM users WHERE username='$student'");
$row = $result->fetch_assoc();
$groupe ="G".$row['groupe'];
$groupel="G2_".$row['groupe'];
$groupe2="G3_".$row['groupe'];
$classe =$row['classe'];
$_SESSION['classe']=$classe;
echo "<h2 style='color: #330066; padding-top: 20px;'><strong>Planning : G".$row['groupe']."</strong></h2>";
echo "
<p style='color:#EE82EE; font-size:medium;'>*Violet : semaine actuelle</p>
<div style='overflow-x:auto;'><table class='content-table'>
<thead>
<tr>
<th>Semaine</th>
<th>Date de début</th>
<th>Date de fin</th>
<th style='width:250px;'>Séances MA/PC</th>
<th style='width:250px;'>Séances ANG/FR</th>";
if($classe=="tsi1"){
	echo "<th style='width:250px;'>Séances GE/GM</th>";
}
echo "</tr></thead><tbody>";
$result = mysqli_query($db,"SELECT * FROM $classe");
while($row = mysqli_fetch_array($result))
{
$finalweek=$row['week'];
if($currentDateTime>=$debut[$finalweek-1] && $currentDateTime<=$fin[$finalweek-1]){
 echo "<tr style='background-color:#d699ff;'>";
}else{
 echo "<tr>";
}
echo "<td>S" . $row['week'] . "</td>";
echo "<td>" .$debut[$finalweek-1]. "</td>";
echo "<td>" . $fin[$finalweek-1] . "</td>";  
$just="seance_".$classe;
$just1=$row[$groupe];
$just2=$row[$groupel];
$results = mysqli_query($db,"SELECT * FROM $just WHERE seance='$just1'");
$i=0;
while($row1 = mysqli_fetch_array($results)){
echo "<td> Matière :".$row1['subject'] ."~~ Le :". $row1['debut'] . "~~ entre :".$row1['debut_time']."~~ Et :".$row1['fin_time']."~~ avec : Prof.".$row1['prof']."~~ Classe:".$row1['salle']."</td>";
	$i++;
}
if($i==0){
echo "<td>--</td>";
$i=0;
}
$i=0;
$results1 = mysqli_query($db,"SELECT * FROM $just WHERE seance='$just2'");
while($row2 = mysqli_fetch_array($results1)){
echo "<td> Matière :".$row2['subject'] ."~~ Le :". $row2['debut'] . "~~ entre :".$row2['debut_time']."~~ Et :".$row2['fin_time']."~~ avec : Prof.".$row2['prof']."~~ Classe:".$row2['salle']."</td>";
	$i++;
	
}
if($i==0){
$i=0;
echo "<td>--</td>";}
$i=0;
if($classe=="tsi1"){
$just3=$row[$groupe2];
$results1 = mysqli_query($db,"SELECT * FROM $just WHERE seance='$just3'");
while($row2 = mysqli_fetch_array($results1)){
echo "<td> Matière :".$row2['subject'] ."~~ Le :". $row2['debut'] . "~~ entre :".$row2['debut_time']."~~ Et :".$row2['fin_time']."~~ avec : Prof.".$row2['prof']."~~ Classe:".$row2['salle']."</td>";
	$i++;
	
}
if($i==0){
$i=0;
echo "<td>--</td>";}}
echo "</tr>";}
echo "</tbody></table></div>";
?>
<?php include('foot.php') ?>