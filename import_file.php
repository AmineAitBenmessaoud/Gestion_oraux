<?php include('server.php') ?>
<?php
if(isset($_POST["submit_file"]))
{   
    $file = $_FILES["file"]["tmp_name"];
    $file_open = fopen($file,"r");
    while(($csv = fgetcsv($file_open, 32, ";")) !== false)
    {
     $user = $csv[0];
     $gro = $csv[1];
     $clas = $csv[2];
    
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
}
    header('location: secret.php');
}
?>