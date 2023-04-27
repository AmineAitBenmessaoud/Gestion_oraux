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
	<title>Diagnostic</title>
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
        <li><a  href="secret.php">Créer</a></li>
        <li><a  href="planadmin.php">Planning</a></li>
        <li><a class="active" href="diagnoadmin.php">Diagnostic</a></li>

      </ul>
    </nav> 
    <div class="glory">
				<?php 
	$just=$_GET['lkra'];
	$just1=$_GET['eleve'];
	$just2=$_GET['colle'];
	$number=str_replace('C','',$just2);
	$result=mysqli_query($db,"SELECT * FROM $just WHERE student='$just1'");
	$row=$result->fetch_assoc();?>
	<h2 style="color: #330066; padding-top: 20px;"><strong>évaluation</strong></h2>
	<table class='content-table'>
	<thead>
	<tr>
	<th>Note</th>
	<th>Remarque</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<?php 
	$just3="C".$number;
	$just4="CR".$number;
	echo "<td>".$row[$just3]."</td>";
	echo "<td>".$row[$just4]."</td>";
?>
	</tr></tbody>
	</table>
	<h2 style="color: #330066;"><strong>auto-évaluation</strong> </h2>
	<table class='content-table'>
	<thead>
	<tr>
	<th>Note</th>
	<th>Remarque</th>
	</tr></thead>
	<tbody>
	<tr>
	<?php 
	$just3="CA".$number;
	$just4="CAR".$number;
	echo "<td>".$row[$just3]."</td>";
	echo "<td>".$row[$just4]."</td>";
?>

	</tr></tbody>
	</table>
	<?php include('foot.php') ?>
</html>