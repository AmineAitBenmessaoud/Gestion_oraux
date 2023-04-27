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
<html>
<head>
	<title>Créer</title>
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
        <li><a class="active" href="secret.php">Créer</a></li>
        <li><a href="planadmin.php">Planning</a></li>
        <li><a href="diagnoadmin.php">Diagnostique</a></li>

      </ul>
    </nav> 
    <div class="glory">
			<h2 style="color: #330066; margin-top: 20px;"><strong>Ajouter une classe :</strong></h2>
		<form method="get" action="action.php"> 
	<div style='overflow-x:auto;'>
	<table class="content-table">
	<thead>
		<tr>
		<th>Classe</th>
		<th>Nombre de groupe</th>
	</tr>
	</thead>	
	<tbody>
		<tr>
	<td><input type="text" name="newc" style="width: 100px;" class="form-control"></td>
	<td><input type="number" min="1" value="1" max="10" name="ng" style="width: 100px;" class="form-control"></td>
		</tr>
</tbody>
</table></div>
<button  class="btn btn-outline-primary" name="add_classe">Add</button>
<button  class="btn btn-outline-primary" name="delete_classe">Delete</button>
</form>
<br>
<h2 style="color: #330066; margin-top: 20px;"><strong>Ajouter une liste d'élèves :</strong></h2><p style="color:cadetblue;font-size:small;">(cvs ; élève|groupe|classe)</p>
<form method="post" action="import_file.php" enctype="multipart/form-data">
  <input type="file" name="file"/>
  <input type="submit" class="btn btn-outline-primary" name="submit_file" value="Submit"/>
</form>
<h2 style="color: #330066; margin-top: 20px;"><strong>Ajouter un élève :</strong></h2>
		<form method="get" action="action.php"> 
	<div style='overflow-x:auto;'>
	<table class="content-table">
	<thead>
		<tr>
		<th>Classe</th>
		<th>username</th>
		<th>groupe</th>
	</tr>
	</thead>	
	<tbody>
		<tr>
		<td><select name="clas" class="form-control" id="sel1" style="width: 100px;">
 			<?php
 			$results=mysqli_query($db,"SELECT * FROM groupe ");
 		   	while($row = mysqli_fetch_array($results)){
 				echo"<option value='".$row['classe']."'>".$row['classe']."</option>";
 			}
 			?>
		</select></td>
	<td><input type="text" name="user" style="width: 100px;" class="form-control"></td>
	<td><input type="number" name="gro" min="1" value="1" max="10" style="width: 100px;" class="form-control"></td>
		</tr>
</tbody>
</table></div>
<button  class="btn btn-outline-primary" name="add_him">Add</button>
<button  class="btn btn-outline-primary" name="delete_him">Delete</button>
</form>
<?php $results=mysqli_query($db,"SELECT * FROM groupe");
 		   	while($rowi = mysqli_fetch_array($results)){ ?>
		<h2 style="color: #330066; margin-top: 20px;"><strong>Classe : <?php echo $rowi['classe'];?></strong></h2>
<h3 style='color:#9933ff;'>Liste des élèves:</h3>
<?php
$classe=$rowi['classe'];
$result = mysqli_query($db,"SELECT * FROM users WHERE type='eleve' AND classe='$classe' ORDER BY groupe");
echo "<div style='overflow-x:auto;'><table class='content-table'>
<thead>
<tr>
<th>username</th>
<th>classe</th>
<th>groupe</th>
</tr></thead>";
while($row = mysqli_fetch_array($result))
{
echo "<tbody><tr>";
echo "<td>" . $row['username'] . "</td>";
echo "<td>" . $row['classe'] . "</td>";
echo "<td>" . $row['groupe'] . "</td>";
}
echo "</tbody></table></div>";
?>
<?php }?>
<?php include('foot.php') ?>