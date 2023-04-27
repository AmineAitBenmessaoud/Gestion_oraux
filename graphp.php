<?php include('server.php') ?>
<?php 
	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: index.php');
	}
	if (($_SESSION['type'] != "prof")){
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
	<title>Graph</title>
    <?php include('head.php') ?>
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
        <h2 style="color: #330066; margin-top: 20px;"><strong>Graph :</strong></h2>
<canvas id="graph"></canvas>
<?php $student=$_GET['student'];
        $just=$_GET['classnote'];
        $classe=$_GET['classe'];
        $matiere=$_GET['matiere'];
  ?>
<script>
var ctx = document.getElementById('graph').getContext('2d');
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
        $i=0;
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='MA' AND student='$student'");
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
        $i=0;
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='PC' AND student='$student' ");
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
        echo "[".$C1/$i.",".$C2/$i.",".$C3/$i.",".$C4/$i.",".$C5/$i.",".$C6/$i.",".$C7/$i.",".$C8/$i.",".$C9/$i.",".$C10/$i."],";       
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
        $i=0;
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='FR' AND student='$student'");
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
        echo "[".$C1/$i.",".$C2/$i.",".$C3/$i.",".$C4/$i.",".$C5/$i.",".$C6/$i.",".$C7/$i.",".$C8/$i.",".$C9/$i.",".$C10/$i."],";     
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
        $i=0;
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='ANG' AND student='$student' ");
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
        echo "[".$C1/$i.",".$C2/$i.",".$C3/$i.",".$C4/$i.",".$C5/$i.",".$C6/$i.",".$C7/$i.",".$C8/$i.",".$C9/$i.",".$C10/$i."],";     
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
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='GE' AND student='$student'");
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
        $result=mysqli_query($db,"SELECT * FROM $just WHERE matiere='GM' AND student='$student'");
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