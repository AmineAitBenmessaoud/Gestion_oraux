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
	<script type="text/javascript">
	function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
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
		 	<div class="row">
      <form method="get" action="diagnoadmin.php">
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
	<h2 style="color: #330066;"><strong>Diagnostic :<?php echo $classe;?></strong></h2>
<?php
echo "
<h3 style='color:#9933ff;'>Maths</h3>
<div style='overflow-x:auto;'><table  class='content-table' id='tb' >
<thead>
<tr>
<th>élève</th>
<th>Groupe</th>";
for ($i=1; $i < 13; $i++) { 
	echo "<th>C".$i."</th>";
}
echo "</tr></thead>";
echo "<tbody><tr>";
$just="note_".$classe;
$result = mysqli_query($db,"SELECT * FROM $just WHERE matiere='MA' ORDER BY groupe");
while($row = mysqli_fetch_array($result))
{
echo "<td><a href='graph.php?student=".$row['student']."&classnote=".$just."&classe=".$classe."'>" .$row['student']. "</td>";
echo "<td>" . $row['groupe'] . "</td>";
$student=$row['student'];
$result1 = mysqli_query($db,"SELECT * FROM $classe WHERE student='$student'");
for ($i=1; $i < 13; $i++)
{
$just1="C".$i;
echo "<td><a href='evalt.php?colle=".$just1."&eleve=".$row['student']."&lkra=".$just."'>" . $row[$just1] . "</a></td>";
}
echo "</tr>";
}
echo "<tbody></table></div>
<button onclick=\"exportTableToExcel('tb')\" class='btn btn-outline-primary' style='margin-bottom:20px;'>Exporter en Excel</button>;
<h3 style='color:#9933ff;'>PC</h3>
<div style='overflow-x:auto;'><table class='content-table' id='tb1'>
<thead>
<tr>
<th>élève</th>
<th>Groupe</th>";
for ($i=1; $i < 13; $i++) { 
	echo "<th>C".$i."</th>";
}
echo "</tr></thead>";
echo "<tbody><tr>";
$just="note_".$classe;
$result = mysqli_query($db,"SELECT * FROM $just WHERE matiere='PC' ORDER BY groupe");
while($row = mysqli_fetch_array($result))
{
echo "<td>".$row['student']. "</td>";
echo "<td>" . $row['groupe'] . "</td>";
$student=$row['student'];
$result1 = mysqli_query($db,"SELECT * FROM $classe WHERE student='$student'");
for ($i=1; $i < 13; $i++)
{
$just1="C".$i;
echo "<td><a href='evalt.php?colle=".$just1."&eleve=".$row['student']."&lkra=".$just."'>" . $row[$just1] . "</a></td>";
}
echo "</tr>";
}
echo "<tbody></table></div>";
echo "<button onclick=\"exportTableToExcel('tb1')\" class='btn btn-outline-primary' style='margin-bottom:20px;'>Exporter en Excel</button>";
echo "
<h3 style='color:#9933ff;'>FR</h3>
<div style='overflow-x:auto;' >
<table  class='content-table' id='tb2'>
<thead>
<tr>
<th>élève</th>
<th>Groupe</th>";
for ($i=1; $i < 13; $i++) { 
	echo "<th>C".$i."</th>";
}
echo "</tr></thead>";
echo "<tbody><tr>";
$just="note_".$classe;
$result = mysqli_query($db,"SELECT * FROM $just WHERE matiere='FR' ORDER BY groupe");
while($row = mysqli_fetch_array($result))
{
echo "<td>".$row['student']. "</td>";
echo "<td>" . $row['groupe'] . "</td>";
$student=$row['student'];
$result1 = mysqli_query($db,"SELECT * FROM $classe WHERE student='$student'");
for ($i=1; $i < 13; $i++)
{
$just1="C".$i;
echo "<td><a href='evalt.php?colle=".$just1."&eleve=".$row['student']."&lkra=".$just."'>" . $row[$just1] . "</a></td>";
}
echo "</tr>";
}
echo "<tbody></table></div>";
echo "<button onclick=\"exportTableToExcel('tb2')\" class='btn btn-outline-primary' style='margin-bottom:20px;'>Exporter en Excel</button>";
echo "
<h3 style='color:#9933ff;'>ANG</h3>
<div style='overflow-x:auto;' >
<table  class='content-table' id='tb3'>
<thead>
<tr>
<th>élève</th>
<th>Groupe</th>";
for ($i=1; $i < 13; $i++) { 
	echo "<th>C".$i."</th>";
}
echo "</tr></thead>";
echo "<tbody><tr>";
$just="note_".$classe;
$result = mysqli_query($db,"SELECT * FROM $just WHERE matiere='ANG' ORDER BY groupe");
while($row = mysqli_fetch_array($result))
{
echo "<td>".$row['student']. "</td>";
echo "<td>" . $row['groupe'] . "</td>";
$student=$row['student'];
$result1 = mysqli_query($db,"SELECT * FROM $classe WHERE student='$student'");
for ($i=1; $i < 13; $i++)
{
$just1="C".$i;
echo "<td><a href='evalt.php?colle=".$just1."&eleve=".$row['student']."&lkra=".$just."'>" . $row[$just1] . "</a></td>";
}
echo "</tr>";
}
echo "<tbody></table></div><br>";
echo "<button onclick=\"exportTableToExcel('tb3')\" class='btn btn-outline-primary' style='margin-bottom:20px;'>Exporter en Excel</button>";
 $tsi=preg_replace('/[0-9]+/','',$classe);
 if($tsi=="tsi"){
echo "
<div style='overflow-x:auto;'><div style='display:inline-block;'><h3 style='color:#9933ff;'>GE</h3>
<table  class='content-table' id='tb4'>
<thead>
<tr>
<th>élève</th>
<th>Groupe</th>";
for ($i=1; $i < 13; $i++) { 
	echo "<th>C".$i."</th>";
}
echo "</tr></thead>";
echo "<tbody><tr>";
$just="note_".$classe;
$result = mysqli_query($db,"SELECT * FROM $just WHERE matiere='GE' ORDER BY groupe");
while($row = mysqli_fetch_array($result))
{
echo "<td>".$row['student']. "</td>";
echo "<td>" . $row['groupe'] . "</td>";
$student=$row['student'];
$result1 = mysqli_query($db,"SELECT * FROM $classe WHERE student='$student'");
for ($i=1; $i < 13; $i++)
{
$just1="C".$i;
echo "<td><a href='evalt.php?colle=".$just1."&eleve=".$row['student']."&lkra=".$just."'>" . $row[$just1] . "</a></td>";
}
echo "</tr>";
}
echo "<tbody></table>";	
echo "<button onclick=\"exportTableToExcel('tb4')\" class='btn btn-outline-primary'>Exporter en Excel</button></div>";
echo "
<div style='display:inline-block;'><h3 style='color:#9933ff;'>GM</h3>
<table  class='content-table' id='tb5'>
<thead>
<tr>
<th>élève</th>
<th>Groupe</th>";
for ($i=1; $i < 13; $i++) { 
	echo "<th>C".$i."</th>";
}
echo "</tr></thead>";
echo "<tbody><tr>";
$just="note_".$classe;
$result = mysqli_query($db,"SELECT * FROM $just WHERE matiere='GM' ORDER BY groupe");
while($row = mysqli_fetch_array($result))
{
echo "<td>".$row['student']. "</td>";
echo "<td>" . $row['groupe'] . "</td>";
$student=$row['student'];
$result1 = mysqli_query($db,"SELECT * FROM $classe WHERE student='$student'");
for ($i=1; $i < 13; $i++)
{
$just1="C".$i;
echo "<td><a href='evalt.php?colle=".$just1."&eleve=".$row['student']."&lkra=".$just."'>" . $row[$just1] . "</a></td>";
}
echo "</tr>";
}
echo "<tbody></table>";	
echo "<button onclick=\"exportTableToExcel('tb5')\" class='btn btn-outline-primary' style='margin-bottom:20px;'>Exporter en Excel</button></div></div>";
}
?>
<h2 style="color: #330066;"><strong>Graphe :</strong></h2>
<canvas id="graph"></canvas>
<?php  ?>
<script>
var ctx = document.getElementById('graph').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['C1', 'C2', 'C3', 'C4', 'C5', 'C6','C7','C8','C9','C10','C11','C12'],
        datasets: [
        {
            label: 'MA',
 		data :<?php 
 		$C1=0;
 		$C2=0;
 		$C3=0;
 		$C4=0;
 		$C5=0;
 		$C6=0;
 		$C7=0;
 		$C8=0;
 		$C9=0;
 		$C10=0;
    $C11=0;
    $C12=0;
 		$i=0;
 		$result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='MA' ");
 		while ($row = mysqli_fetch_array($result)) {
 			$C1=(int)$row['C1']+$C1;
 			$C2=(int)$row['C2']+$C2;
 			$C3=(int)$row['C3']+$C3;
 			$C4=(int)$row['C4']+$C4;
 			$C5=(int)$row['C5']+$C5;
 			$C6=(int)$row['C6']+$C6;
 			$C7=(int)$row['C7']+$C7;
 			$C8=(int)$row['C8']+$C8;
 			$C9=(int)$row['C9']+$C9;
 			$C10=(int)$row['C10']+$C10;
      $C11=(int)$row['C11']+$C11;
      $C12=(int)$row['C12']+$C12;
 			$i++;
 }
  		echo "[".$C1/$i.",".$C2/$i.",".$C3/$i.",".$C4/$i.",".$C5/$i.",".$C6/$i.",".$C7/$i.",".$C8/$i.",".$C9/$i.",".$C10/$i.",".$C11/$i.",".$C12/$i."],"; 		
  ?>
            fill:false,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 
                'rgba(255, 99, 132, 1)',
            borderWidth: 1
        },
         {
            label: 'PC',
            data :<?php 
 		$C1=0;
 		$C2=0;
 		$C3=0;
 		$C4=0;
 		$C5=0;
 		$C6=0;
 		$C7=0;
 		$C8=0;
 		$C9=0;
 		$C10=0;
    $C11=0;
    $C12=0;
 		$i=0;
 		$result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='PC' ");
 		while ($row = mysqli_fetch_array($result)) {
 			$C1=(int)$row['C1']+$C1;
 			$C2=(int)$row['C2']+$C2;
 			$C3=(int)$row['C3']+$C3;
 			$C4=(int)$row['C4']+$C4;
 			$C5=(int)$row['C5']+$C5;
 			$C6=(int)$row['C6']+$C6;
 			$C7=(int)$row['C7']+$C7;
 			$C8=(int)$row['C8']+$C8;
 			$C9=(int)$row['C9']+$C9;
 			$C10=(int)$row['C10']+$C10;
      $C11=(int)$row['C11']+$C11;
      $C12=(int)$row['C12']+$C12;
 			$i++;
 }
      echo "[".$C1/$i.",".$C2/$i.",".$C3/$i.",".$C4/$i.",".$C5/$i.",".$C6/$i.",".$C7/$i.",".$C8/$i.",".$C9/$i.",".$C10/$i.",".$C11/$i.",".$C12/$i."],"; 	
  ?>
    
            fill:false,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 
                'rgba(102, 255, 153, 1)',
            borderWidth: 1
        },
           {
            label: 'FR',
            data :<?php 
    $C1=0;
    $C2=0;
    $C3=0;
    $C4=0;
    $C5=0;
    $C6=0;
    $C7=0;
    $C8=0;
    $C9=0;
    $C10=0;
    $C11=0;
    $C12=0;
 		$i=0;
 		$result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='FR' ");
 			while ($row = mysqli_fetch_array($result)) {
 			$C1=(int)$row['C1']+$C1;
 			$C2=(int)$row['C2']+$C2;
 			$C3=(int)$row['C3']+$C3;
 			$C4=(int)$row['C4']+$C4;
 			$C5=(int)$row['C5']+$C5;
 			$C6=(int)$row['C6']+$C6;
 			$C7=(int)$row['C7']+$C7;
 			$C8=(int)$row['C8']+$C8;
      $C11=(int)$row['C11']+$C11;
      $C12=(int)$row['C12']+$C12;
 			$i++;
 }
      echo "[".$C1/$i.",".$C2/$i.",".$C3/$i.",".$C4/$i.",".$C5/$i.",".$C6/$i.",".$C7/$i.",".$C8/$i.",".$C9/$i.",".$C10/$i.",".$C11/$i.",".$C12/$i."],"; 		
  ?>
    
            fill:false,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 
                'rgba(153, 0, 255, 1)',
            borderWidth: 1
        },
         {
            label: 'ANG',
          data :<?php 
    $C1=0;
    $C2=0;
    $C3=0;
    $C4=0;
    $C5=0;
    $C6=0;
    $C7=0;
    $C8=0;
    $C9=0;
    $C10=0;
    $C11=0;
    $C12=0;
 		$i=0;
 		$result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='ANG' ");
 		while ($row = mysqli_fetch_array($result)) {
 			$C1=(int)$row['C1']+$C1;
 			$C2=(int)$row['C2']+$C2;
 			$C3=(int)$row['C3']+$C3;
 			$C4=(int)$row['C4']+$C4;
 			$C5=(int)$row['C5']+$C5;
 			$C6=(int)$row['C6']+$C6;
 			$C7=(int)$row['C7']+$C7;
 			$C8=(int)$row['C8']+$C8;
      $C9=(int)$row['C9']+$C7;
      $C10=(int)$row['C10']+$C8;
      $C11=(int)$row['C11']+$C11;
      $C12=(int)$row['C12']+$C12;
 			$i++;
 }
      echo "[".$C1/$i.",".$C2/$i.",".$C3/$i.",".$C4/$i.",".$C5/$i.",".$C6/$i.",".$C7/$i.",".$C8/$i.",".$C9/$i.",".$C10/$i.",".$C11/$i.",".$C12/$i."],"; 	
  ?>
    
            fill:false,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 
                'rgba(255, 51, 204,1)',
            borderWidth: 1
        },
        <?php  $tsi=preg_replace('/[0-9]+/','',$classe);?>
                    <?php if($tsi=="tsi") :?>
         {
            label: 'GE',
          data :<?php 
        $C1=0;
        $C2=0;
        $C3=0;
        $C4=0;
        $C5=0;
        $C6=0;
        $C7=0;
        $C8=0;
        $C9=0;
        $C10=0;
        $C11=0;
        $C12=0;
        $y=0;
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='GE' ");
        while ($row = mysqli_fetch_array($result)) {
            $C1=(int)$row['C1']+$C1;
            $C2=(int)$row['C2']+$C2;
            $C3=(int)$row['C3']+$C3;
            $C4=(int)$row['C4']+$C4;
            $C5=(int)$row['C5']+$C5;
            $C6=(int)$row['C6']+$C6;
            $C7=(int)$row['C7']+$C7;
            $C8=(int)$row['C8']+$C8;
            $C9=(int)$row['C9']+$C9;
            $C10=(int)$row['C10']+$C10;
            $C11=(int)$row['C11']+$C11;
            $C12=(int)$row['C12']+$C12;
            $y++;
 }
        echo "[".$C1/$y.",".$C2/$y.",".$C3/$y.",".$C4/$y.",".$C5/$y.",".$C6/$y.",".$C7/$y.",".$C8/$y.",".$C9/$y.",".$C10/$y.",".$C11/$y.",".$C11/$y.",".$C12/$y."],";     
  ?>
    
            fill:false,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 
                'rgba(255, 51, 204,1)',
            borderWidth: 1
        },
         {
            label: 'GM',
          data :<?php 
        $C1=0;
        $C2=0;
        $C3=0;
        $C4=0;
        $C5=0;
        $C6=0;
        $C7=0;
        $C8=0;
        $C9=0;
        $C10=0;
        $C11=0;
        $C12=0;
        $y=0;
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='GM' ");
        while ($row = mysqli_fetch_array($result)) {
            $C1=(int)$row['C1']+$C1;
            $C2=(int)$row['C2']+$C2;
            $C3=(int)$row['C3']+$C3;
            $C4=(int)$row['C4']+$C4;
            $C5=(int)$row['C5']+$C5;
            $C6=(int)$row['C6']+$C6;
            $C7=(int)$row['C7']+$C7;
            $C8=(int)$row['C8']+$C8;
            $C9=(int)$row['C9']+$C9;
            $C10=(int)$row['C10']+$C10;
            $C11=(int)$row['C11']+$C11;
            $C12=(int)$row['C12']+$C12;
            $y++;
 }
        echo "[".$C1/$y.",".$C2/$y.",".$C3/$y.",".$C4/$y.",".$C5/$y.",".$C6/$y.",".$C7/$y.",".$C8/$y.",".$C9/$y.",".$C10/$y.",".$C11/$y.",".$C11/$y.",".$C12/$y."],";     
  ?>
    
            fill:false,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 
                'rgba(255, 51, 204,1)',
            borderWidth: 1
        },<?php endif; ?>
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
<?php include('foot.php') ?>