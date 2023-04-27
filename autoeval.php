
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
	<title>Auto-évaluation</title>
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
        <li><a  href="planeleve.php">Planning</a></li>
        <li><a  class="active" href="diagnoeleve.php">Diagnostique</a></li>

      </ul>
    </nav> 
    <div class="glory">
    	<h2 style='color: #330066; padding-top: 20px;'><strong>Auto-évaluation :</strong></h2>
				<?php 
	$classenote=$_GET['classenote'];
	$student=$_GET['student'];
	$colle=$_GET['colle'];
	$number=str_replace('C','',$colle);
	$auto='CA'.$number;
	$rauto='CAR'.$number;
	$_SESSION['classenote']=$classenote;
	$_SESSION['student']=$student;
	$_SESSION['colle']=$colle;
	$_SESSION['matiere']=$_GET['matiere'];
	$matiere=$_GET['matiere'];
	$result=mysqli_query($db,"SELECT * FROM $classenote WHERE student='$student' AND matiere='$matiere'");
	$row=$result->fetch_assoc();?>
	<form method="get" action="action.php"> 
	<table class="content-table">
		<thead>
		<tr>
			<th>Note</th>
			<th>Remarque</th>
		</tr>
		</thead>
		<tbody>
		<tr>
	<td><input class="form-control" classtype='number' name='note' value='<?php echo $row[$auto];?>'></td>
	<td><textarea class="form-control" name="remarque" cols="50" rows="10"><?php echo $row[$rauto];?></textarea></td>
		</tr>
	</tbody></table>
	<button name="saveauto"  class="btn btn-outline-primary">Enregistrer</button>
</form>
	<h2 style='color: #330066; padding-top: 20px;'><strong>évaluation :</strong></h2>
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
	$reval="CR".$number;
	echo "<td>".$row[$colle]."</td>";
	echo "<td>".$row[$reval]."</td>";
?>
	</tr>
	</tbody>
	</table>
<?php include('foot.php') ?>