<?php include('server.php') ?>
<?php
//update semaine
	if(isset($_GET['add_semaine'])){
		$debut=mysqli_real_escape_string($db, $_GET['debut']);
		$fin=mysqli_real_escape_string($db, $_GET['fin']);
		$semaine=mysqli_real_escape_string($db, $_GET['semaine']);
		mysqli_query($db,"UPDATE semaine SET debut='$debut',fin='$fin' WHERE week='$semaine'");
		header('location: planadmin.php');
	} 
	//add séance 
	if(isset($_GET['add_seance'])){
		$seance=mysqli_real_escape_string($db, $_GET['seance']);
		$subject=mysqli_real_escape_string($db, $_GET['subject']);
		$jour=mysqli_real_escape_string($db, $_GET['jour']);
		$debut1=mysqli_real_escape_string($db, $_GET['debut1']);
		$fin1=mysqli_real_escape_string($db, $_GET['fin1']);
		$prof=mysqli_real_escape_string($db, $_GET['prof']);
		$salle=mysqli_real_escape_string($db, $_GET['salle']);
		$just="seance_".$classe;
		mysqli_query($db,"INSERT INTO $just (seance,subject,debut,debut_time,fin_time,prof,salle) VALUES('$seance','$subject','$jour','$debut1','$fin1','$prof','$salle')");
		header('location: planadmin.php');
	} 
	//delete seance
		if(isset($_GET['delete_seance'])){
		$seance=mysqli_real_escape_string($db, $_GET['seance']);	
		$just="seance_".$classe;
		mysqli_query($db,"DELETE FROM $just WHERE seance='$seance'");
		header('location: planadmin.php');
	}
		//add secret 
	if(isset($_GET['add_him'])){
		$user=mysqli_real_escape_string($db, $_GET['user']);
		$clas=mysqli_real_escape_string($db, $_GET['clas']);
		$gro=mysqli_real_escape_string($db, $_GET['gro']);
		$password=password_hash('Am1234Am1234', PASSWORD_BCRYPT);
		$just="note_".$clas;
		$type="eleve";
		mysqli_query($db,"INSERT INTO users (type,groupe,username,password,classe) VALUES('$type','$gro','$user','$password','$clas')");
		mysqli_query($db,"INSERT INTO $just (student,groupe,matiere,C1,C2,C3,C4,C5,C6,C7,C8,C9,C10,C11,C12) VALUES('$user','$gro','MA','N','N','N','N','N','N','N','N','N','N','N','N')");
		mysqli_query($db,"INSERT INTO $just (student,groupe,matiere,C1,C2,C3,C4,C5,C6,C7,C8,C9,C10,C11,C12) VALUES('$user','$gro','PC','N','N','N','N','N','N','N','N','N','N','N','N')");
		mysqli_query($db,"INSERT INTO $just (student,groupe,matiere,C1,C2,C3,C4,C5,C6,C7,C8,C9,C10,C11,C12) VALUES('$user','$gro','ANG','N','N','N','N','N','N','N','N','N','N','N','N')");
		mysqli_query($db,"INSERT INTO $just (student,groupe,matiere,C1,C2,C3,C4,C5,C6,C7,C8,C9,C10,C11,C12) VALUES('$user','$gro','FR','N','N','N','N','N','N','N','N','N','N','N','N')");

		 $tsi=preg_replace('/[0-9]+/','',$clas);
 		if($tsi=="tsi"){
				mysqli_query($db,"INSERT INTO $just (student,groupe,matiere,C1,C2,C3,C4,C5,C6,C7,C8,C9,C10,C11,C12) VALUES('$user','$gro','GE','N','N','N','N','N','N','N','N','N','N','N','N')");
			mysqli_query($db,"INSERT INTO $just (student,groupe,matiere,C1,C2,C3,C4,C5,C6,C7,C8,C9,C10,C11,C12) VALUES('$user','$gro','GM','N','N','N','N','N','N','N','N','N','N','N','N')");
	}
		header('location: secret.php');
	} 
	//delete secret
		if(isset($_GET['delete_him'])){
		$user=mysqli_real_escape_string($db, $_GET['user']);
		$result = mysqli_query($db,"SELECT * FROM users WHERE username='$user'");
		while($row = mysqli_fetch_array($result))
{
	$just="note_".$row['classe'];
}
		mysqli_query($db,"DELETE FROM $just WHERE student='$user'");
		mysqli_query($db,"DELETE FROM users WHERE username='$user'");
		header('location: secret.php');
	}
	//add classe
	if(isset($_GET['add_classe'])){
		$newc=mysqli_real_escape_string($db, $_GET['newc']);
		$ng=mysqli_real_escape_string($db, $_GET['ng']);
		$seance="seance_".$newc;
		mysqli_query($db,"CREATE TABLE $seance(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    seance INT(30) NOT NULL,
    subject VARCHAR(30) NOT NULL,
    debut VARCHAR(30) NOT NULL,
    debut_time TIME(4) NOT NULL,
    fin_time TIME(4) NOT NULL,
    prof VARCHAR(30) NOT NULL,
    salle VARCHAR(30) NOT NULL
	)");
	$note="note_".$newc;
	mysqli_query($db,"CREATE TABLE $note(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    student VARCHAR(40) NOT NULL,
    groupe VARCHAR(30) NOT NULL,
    matiere VARCHAR(30) NOT NULL,
    C1 VARCHAR(30) NOT NULL,
    C2 VARCHAR(30) NOT NULL,
    C3 VARCHAR(30) NOT NULL,
    C4 VARCHAR(30) NOT NULL,
    C5 VARCHAR(30) NOT NULL,
    C6 VARCHAR(30) NOT NULL,
    C7 VARCHAR(30) NOT NULL,
    C8 VARCHAR(30) NOT NULL,
    C9 VARCHAR(30) NOT NULL,
    C10 VARCHAR(30) NOT NULL,
    C11 VARCHAR(30) NOT NULL,
    C12 VARCHAR(30) NOT NULL,
    CR1 VARCHAR(30) NOT NULL,
    CR2 VARCHAR(30) NOT NULL,
    CR3 VARCHAR(30) NOT NULL,
    CR4 VARCHAR(30) NOT NULL,
    CR5 VARCHAR(30) NOT NULL,
    CR6 VARCHAR(30) NOT NULL,
    CR7 VARCHAR(30) NOT NULL,
    CR8 VARCHAR(30) NOT NULL,
    CR9 VARCHAR(30) NOT NULL,
    CR10 VARCHAR(30) NOT NULL,
    CR11 VARCHAR(30) NOT NULL,
    CR12 VARCHAR(30) NOT NULL,
    CA1 VARCHAR(30) NOT NULL,
    CA2 VARCHAR(30) NOT NULL,
    CA3 VARCHAR(30) NOT NULL,
    CA4 VARCHAR(30) NOT NULL,
    CA5 VARCHAR(30) NOT NULL,
    CA6 VARCHAR(30) NOT NULL,
    CA7 VARCHAR(30) NOT NULL,
    CA8 VARCHAR(30) NOT NULL,
    CA9 VARCHAR(30) NOT NULL,
    CA10 VARCHAR(30) NOT NULL,
    CA11 VARCHAR(30) NOT NULL,
    CA12 VARCHAR(30) NOT NULL,
    CAR1 VARCHAR(30) NOT NULL,
    CAR2 VARCHAR(30) NOT NULL,
    CAR3 VARCHAR(30) NOT NULL,
    CAR4 VARCHAR(30) NOT NULL,
    CAR5 VARCHAR(30) NOT NULL,
    CAR6 VARCHAR(30) NOT NULL,
    CAR7 VARCHAR(30) NOT NULL,
    CAR8 VARCHAR(30) NOT NULL,
    CAR9 VARCHAR(30) NOT NULL,
    CAR10 VARCHAR(30) NOT NULL,
    CAR11 VARCHAR(30) NOT NULL,
    CAR12 VARCHAR(30) NOT NULL
	)");
	mysqli_query($db,"INSERT INTO groupe (n,classe) VALUES('$ng','$newc')");
	/*mysqli_query($db,"CREATE TABLE $newc(
    week INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    debut DATE NOT NULL,
    fin DATE NOT NULL
	)");*/
	if ($ng==8){
	mysqli_query($db,"CREATE TABLE $newc LIKE plan8");
	mysqli_query($db,"INSERT $newc SELECT * FROM plan8");
}
if($ng==10){
	mysqli_query($db,"CREATE TABLE $newc LIKE plan");
	mysqli_query($db,"INSERT $newc SELECT * FROM plan");
}
	/*
	for ($i=1; $i <= $ng ; $i++) { 
		$y="G".$i;
		mysqli_query($db,"ALTER TABLE  $newc ADD  $y INT(11) NOT NULL");
	}
	for ($i=1; $i <= $ng ; $i++) {
		$y="G2_".$i;
		mysqli_query($db,"ALTER TABLE  $newc ADD  $y INT(11) NOT NULL");
		}
		$tsi=preg_replace('/[0-9]+/','',$newc);
 		if($tsi=="tsi"){
 		 for ($i=1; $i <= $ng ; $i++) { 
 			$y="G3_".$i;
 		mysqli_query($db,"ALTER TABLE  $newc ADD  $y INT(11) NOT NULL");
}
	}
	$x=0;
	$z=0;
	$t=0;
	for ($i=1; $i <=20 ; $i++) { 
		mysqli_query($db,"INSERT INTO $newc (week) VALUES ('$i')");
		for ($j=1; $j <=$ng; $j++) { 	
			$grp="G".$j;
			$grp2="G2_".$j;
			$se=$j-$x;
			if($se<=0){
				$se=$ng+$se;
			}
			$sel=$z+$ng+1-$x;
			if($sel<=$ng){
				$sel=$ng+$sel;
			}
			if($sel==($ng+5)){
				$sel=0;
				$t=1;
			}
			mysqli_query($db,"UPDATE $newc SET $grp='$se' WHERE week='$i'");
			mysqli_query($db,"UPDATE $newc SET $grp2='$sel' WHERE week='$i'");
			$z++;
			if($t==1){
				$z=0;
				$t=0;
			}
	}
	$x++;
	if($x==$ng+1){
		$x=1;
	}
	}*/
		header('location: secret.php');
	}
	//delete classe 
			if(isset($_GET['delete_classe'])){
		$newc=mysqli_real_escape_string($db, $_GET['newc']);
		$classnote="note_".$newc;
		$seance="seance_".$newc;
		mysqli_query($db,"DROP TABLE $newc");
		mysqli_query($db,"DROP TABLE $classnote");
		mysqli_query($db,"DROP TABLE $seance");
		mysqli_query($db,"DELETE FROM groupe WHERE classe='$newc'");
		mysqli_query($db,"DELETE FROM users WHERE classe='$newc'");
		header('location: secret.php');
	}
	//evaluation 
	if(isset($_GET['save'])){		
		$classnote=$_SESSION['classenote'];
		$student=$_SESSION['student'];
		$colle=$_SESSION['colle'];
		$matiere=$_SESSION['matiere'];
		$number=str_replace('C','',$colle);
		$reval='CR'.$number;
		$note=$_GET['note'];
		$remarque=$_GET['remarque'];
		$result=mysqli_query($db,"UPDATE $classnote SET $colle='$note' WHERE student='$student' AND matiere='$matiere'");
		$result=mysqli_query($db,"UPDATE $classnote SET $reval='$remarque' WHERE student='$student'  AND matiere='$matiere'");
		$small="location: eval.php?colle=".$colle."&classenote=".$classnote.'&student='.$student.'&matiere='.$matiere;
		header($small);
	}
	//auto-evaluation 
		if(isset($_GET['saveauto'])){		
		$classnote=$_SESSION['classenote'];
		$student=$_SESSION['student'];
		$colle=$_SESSION['colle'];
		$matiere=$_SESSION['matiere'];
		$number=str_replace('C','',$colle);
		$auto='CA'.$number;
		$rauto='CAR'.$number;
		$note=$_GET['note'];
		$remarque=$_GET['remarque'];
		$result=mysqli_query($db,"UPDATE $classnote SET $auto='$note' WHERE student='$student' AND matiere='$matiere'");
		$result=mysqli_query($db,"UPDATE $classnote SET $rauto='$remarque' WHERE student='$student' AND matiere='$matiere'");
		$small="location: autoeval.php?colle=".$colle."&classenote=".$classnote.'&student='.$student.'&matiere='.$matiere;
		header($small);
	}
?>