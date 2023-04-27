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
	<title>Diagnostique</title>
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
        <li><a href="planprof.php">Planning</a></li>
        <li><a class="active" href="diagnoprof.php">Diagnostic</a></li>

      </ul>
    </nav> 
    <div class="glory">
	<h2 style="color: #330066; padding-top:20px;"><strong>Diagnostic :</strong></h2>
<?php
//the new lines
            $username=$_SESSION['username'];
			$class=[];
			$classe=[];
            $pro2="";
            $pro=mysqli_query($db,"SELECT * FROM users WHERE username='$username'");
            while($pro1 = mysqli_fetch_array($pro)){
                $pro2=$pro1['classe'];
         }
 			$results=mysqli_query($db,"SELECT * FROM groupe");
 		   	while($row = mysqli_fetch_array($results)){
 				 array_push($classe,$row['classe']);
 			}
             for ($i=0; $i < count($classe); $i++){
$just="seance_".$classe[$i];
$result = mysqli_query($db,"SELECT * FROM $just WHERE prof='$username'");
while($row = mysqli_fetch_array($result))
{
	array_push($class,$classe[$i]);
    $subject=$row['subject'];
}
}
//finish of new lines
//$class = $_SESSION['classes'];
//$classes=array_unique($class);
$try=array_unique($class);
$nuke=[];
/*for($u=0;$u < count($try);$u++){
    if($try[$u]!=NULL){
		array_push($nuke,$try[$u]);
	}
}*/
foreach ($try as &$value) {
    array_push($nuke,$value);
}
$try1=$nuke;
$matiere=$_SESSION['subject'];
for ($i=0; $i < count($try1) ; $i++) {
    if(($matiere=="FR" || $matiere=="ANG" || $matiere=="GE" || $matiere=="GM")||(($matiere=="MA" || $matiere=="PC") & $try1[$i]==$pro2)){
//try to choose the num of seance
$numclass=[];
$just="seance_".$try1[$i];
$resulti = mysqli_query($db,"SELECT * FROM $just WHERE prof='$username'");
while($rowi = mysqli_fetch_array($resulti))
{
	array_push($numclass,$rowi['seance']);
}
//stop try
$tb=$try1[$i];
echo "
<h3 style='color:#9933ff;'>".$try1[$i]."</h3>
<div style='overflow-x:auto;'><table class='content-table' id='".$tb."'>
<thead>
<tr>
<th>élève</th>
<th>Groupe</th>";
if($matiere=="MA" || $matiere=="PC"){
for ($j=1; $j < 13 ; $j++) { 
	echo"<th>C".$j."</th>";
	$num=13;
}
}
if($matiere=="FR" || $matiere=="ANG"){
for ($j=1; $j < 13 ; $j++) { 
	echo"<th>C".$j."</th>";
	$num=13;
}
}
if($matiere=="GE" || $matiere=="GM"){
for ($j=1; $j < 13 ; $j++) { 
	echo"<th>C".$j."</th>";
	$num=13;
}
}
echo "</tr><thead>";
echo "<tr><tbody>";
$cli = $try1[$i];//classe ?
$just="note_".$cli;
$_SESSION['classenote']=$just;
$resultsi = mysqli_query($db,"SELECT * FROM $just WHERE matiere='$matiere' ORDER BY groupe");
//here i play
$resu=mysqli_query($db,"SELECT * FROM groupe WHERE classe='$cli'");
$key=0;
while($round = mysqli_fetch_array($resu)){
  $key=$round['n'];
}
//with fire
while($row = mysqli_fetch_array($resultsi))
{
echo "<td><a href='graphp.php?student=".$row['student']."&classnote=".$just."&classe=".$classe."&matiere=".$matiere."'>" .$row['student']. "</td>";
echo "<td>" . $row['groupe'] . "</td>";
$groupe=$row['groupe'];
//here condition
if($key==10){
$res= mysqli_query($db,"SELECT * FROM inter10 WHERE groupe='$groupe' ");
}
if($key==8){
	$res= mysqli_query($db,"SELECT * FROM inter8 WHERE groupe='$groupe' ");
	}
$here=$res->fetch_assoc();
for ($a=1; $a < $num ; $a++) { 
	$colle='C'.$a;
	/*if($matiere == "MA" || $matiere == "PC"){
	$inter=$matiere.$colle;
	if (in_array($here[$inter],$numclass)){
              //here i changed $_SESSION[$classe] , $classes
	echo "<td><a href='eval.php?student=".$row['student']."&classenote=".$just."&matiere=".$matiere."&colle=".$colle."'>".$row[$colle] ."</td></a>";
}else{
	echo "<td>" . $row[$colle] . "</td>";
}
}else { // ANG & FR & GE & GM 
	echo "<td><a href='eval.php?student=".$row['student']."&classenote=".$just."&matiere=".$matiere."&colle=".$colle."'>".$row[$colle] ."</td></a>";
}*/
echo "<td><a href='eval.php?student=".$row['student']."&classenote=".$just."&matiere=".$matiere."&colle=".$colle."'>".$row[$colle] ."</td></a>";
}
echo "</tr>";
}
echo "</tbody></table></div>";
echo "<button onclick=\"exportTableToExcel('".$tb."')\" class='btn btn-outline-primary'>Exporter en format Excel</button>";
?>
<h4 style="color: #66c2ff;">Graphe</h4>
<h10 style="text-align: center; color:grey;">Ox : Les colles</h10>
<h10 style="text-align: center; color:grey;">Oy : La moyenne des notes de la classe</h10>
<canvas id="graph<?php echo $try1[$i];?>"></canvas>
<?php $id="graph".$try1[$i];
echo "<canvas id='".$id."'></canvas>"
?>
<script>
var ctx = document.getElementById('<?php echo $id;?>').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['C1', 'C2', 'C3', 'C4', 'C5', 'C6','C7','C8','C9','C10','C11','C12'],
        datasets: [
        <?php if($matiere=="MA") :?>{
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
        $y=0;
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='MA'");
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
                'rgba(255, 99, 132, 1)',
            borderWidth: 1
        },<?php endif; ?>
         <?php if($matiere=="PC") :?>{
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
        $y=0;
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
            $y++;
 }
        echo "[".$C1/$y.",".$C2/$y.",".$C3/$y.",".$C4/$y.",".$C5/$y.",".$C6/$y.",".$C7/$y.",".$C8/$y.",".$C9/$y.",".$C10/$y.",".$C11/$y.",".$C11/$y.",".$C12/$y."],";       
  ?>
    
            fill:false,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 
                'rgba(102, 255, 153, 1)',
            borderWidth: 1
        },<?php endif; ?><?php if($matiere=="FR") :?>
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
        $y=0;
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='FR'");
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
                'rgba(153, 0, 255, 1)',
            borderWidth: 1
        },<?php endif; ?><?php if($matiere=="ANG") :?>
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
        $y=0;
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
        <?php endif; ?><?php if($matiere=="GE"){
        
        echo "{
            label: 'GE',"; 
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
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='GE'");
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
    
            echo "
            fill:false,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 
                'rgba(102, 51, 0, 1)',
            borderWidth: 1
        },";}
        if($matiere=="GM"){
        echo"
         {
            label: 'GM',";
                    $C1=0;
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
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='GM'");
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
            echo "fill:false,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 
                'rgba(0, 0, 204, 1)',
            borderWidth: 1
        }";}
    ?>
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
</script><script>
var ctx = document.getElementById('<?php echo $id;?>').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['C1', 'C2', 'C3', 'C4', 'C5', 'C6','C7','C8','C9','C10','C11','C12'],
        datasets: [
        <?php if($matiere=="MA") :?>{
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
        $y=0;
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='MA'");
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
                'rgba(255, 99, 132, 1)',
            borderWidth: 1
        },<?php endif; ?>
         <?php if($matiere=="PC") :?>{
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
        $y=0;
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
            $y++;
 }
        echo "[".$C1/$y.",".$C2/$y.",".$C3/$y.",".$C4/$y.",".$C5/$y.",".$C6/$y.",".$C7/$y.",".$C8/$y.",".$C9/$y.",".$C10/$y.",".$C11/$y.",".$C11/$y.",".$C12/$y."],";       
  ?>
    
            fill:false,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 
                'rgba(102, 255, 153, 1)',
            borderWidth: 1
        },<?php endif; ?><?php if($matiere=="FR") :?>
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
        $y=0;
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='FR'");
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
                'rgba(153, 0, 255, 1)',
            borderWidth: 1
        },<?php endif; ?><?php if($matiere=="ANG") :?>
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
        $y=0;
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
        <?php endif; ?><?php if($matiere=="GE") :?>
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
        <?php endif; ?><?php if($matiere=="GM") :?>
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
<?php }}?>
<?php include('foot.php') ?>