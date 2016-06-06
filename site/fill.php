<!DOCTYPE HTML>
<html>
<head>
    <title>Fill form</title>
    <meta charset="utf-8"/>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,100,700,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="fill.css">
	<link rel="stylesheet" type="text/css" href="base.css">
</head>
<body>
<?php include 'header.php';
	$id_formular = $_GET['id_formular'];
	$conn = oci_connect("student", "student", "//localhost/XE");
	//nume si descriere
	$query = "select nume,descriere from Formulare where id_formular='$id_formular'";   //numele si descrierea formularului
	$q = oci_parse($conn, $query);
	$r=oci_execute($q);
	$head=oci_fetch_array($q);
	$nume=$head[0];
	$descriere=$head[1];
	echo '<h1 class="page-title"><b>Sondaj "'.$nume.'"</b></h1><br> <p class="page-description">'.$descriere.'</p><br><br>';

	//Intrebari
	$query = "select id_field,nume_field,tip_field from Campuri natural join asociere where id_formular='$id_formular'";
	$q = oci_parse($conn, $query);
	$r=oci_execute($q);
	$count=0;
	$count0=0;
	$count2=0;
	$count3=0;
	$a=0;
	$a0=0;
	$a2=0;
	$a3=0;
	echo '<form name="all_forms" method="POST">';
	while($questions=oci_fetch_array($q)){
		$a=$a+1;
		$idfield[$a]=$questions[0];		
		$field=$questions[1];
		$tip=$questions[2];
		echo '<div><b>'.$field.'</b><br>';
		//Optiuni
		$query = "select optiune,text from ((Formulare natural join Asociere)natural join Optiuni) where id_field='$idfield[$a]'";
		$q2 = oci_parse($conn, $query);
		$r = oci_execute($q2);
		if($tip==2){			//radio button
			$count2=$count2+1;
			$a2=$a2+1;
			$idfield2[$a2]=$questions[0];
			while($optiuni=oci_fetch_array($q2)){
				$optiune=$optiuni[0];
				$tip2[$count]=$tip;
				echo '<input type="radio" name="fieldtip2'.$count2.'" value="'.$optiune.'">'.$optiune.'<br/>';
			}
		}
		else if($tip==0){		//textarea
			$count0=$count0+1;
			$a0=$a0+1;
			$idfield0[$a0]=$questions[0];
			$text=oci_fetch_array($q2);
			$text0[$a0]=$text[1];
			$tip2[$count]=$tip;
			echo '<input type="text" value="" name="fieldtip0'.$count0.'"><br/>';
		}
		else if ($tip==3){		//checkbox
			$count3=$count3+1;
			$a3=$a3+1;
			$idfield3[$a3]=$questions[0];
			while($optiuni=oci_fetch_array($q2)){
				$optiune=$optiuni[0];
				$tip2[$count]=$tip;
				echo '<input type="checkbox" name="fieldtip3'.$count3.'[]" value="'.$optiune.'" />'.$optiune.'<br/>';
			}
		}
		echo '</div>';
	}
	echo '<button type="submit" id="submit" name="confirm" value="Submit">Submit</button>';
	echo '</form>';
	$k=1; //nr de raspunsuri date-radio button
	$nodata=0;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {	//PRELUARE INFORMATII
		while(isset($_POST['fieldtip2'.$k.''])){
			$k++;
		}
		if($k-1==$count2){					 
			for($i=1; $i<=$count2;$i++){			//informatii radio button
				$var[$i] = $_POST['fieldtip2'.$i.''];
				$select="select nr_voturi from ((Formulare natural join Asociere)natural join Optiuni) where id_field='$idfield2[$i]' and optiune='$var[$i]'";
				$q3=oci_parse($conn, $select);
				$r=oci_execute($q3);
				$v=oci_fetch_array($q3);
				$votes=$v[0];
				$votes1=$votes+1;
				$update="update Optiuni set nr_voturi='".$votes1."'where id_field='".$idfield2[$i]."' and optiune='".$var[$i]."'";
				$q4=oci_parse($conn, $update);
				$r4=oci_execute($q4);
				oci_commit($conn);				
			}
		}
		else $nodata=1;

		$k0=1;
		while(isset($_POST['fieldtip0'.$k0.''])){
			$k0++;
		}
		if($k0-1==$count0){
			for($i=1; $i<=$count0;$i++){	
			$newtext=$_POST['fieldtip0'.$i.''];
			$newtext=$text0[$i].' '.$newtext;
			$update="update Optiuni set text='".$newtext."'where id_field='".$idfield0[$i]."'";
			$q4=oci_parse($conn, $update);
			$r4=oci_execute($q4);
			oci_commit($conn);	
			}
		}

		$k3=1;										//nr de raspunsuri date checkbox
		while(isset($_POST['fieldtip3'.$k3])){
			$k3++;
		}
		if($k3-1==$count3){
			for($i = 1; $i <= $count3; $i++) {								//informatii checkbox
				$var3=$_POST['fieldtip3'.$i]; 
	    		$N = count($var3);
	    		for($j=0; $j < $N; $j++){
					$id_field=$questions[0];
					$select="select nr_voturi from ((Formulare natural join Asociere)natural join Optiuni) where id_field='$idfield3[$i]' and optiune='$var3[$j]'";
					$q3=oci_parse($conn, $select);
					$r=oci_execute($q3);
					$v=oci_fetch_array($q3);
					$votes=$v[0];
					$votes1=$votes+1;
					$update="update Optiuni set nr_voturi='".$votes1."'where id_field='".$idfield3[$i]."' and optiune='".$var3[$j]."'";
					$q4=oci_parse($conn, $update);
					$r4=oci_execute($q4);
					oci_commit($conn);
	    		}	 			
			}	
		}
		else $nodata=1;
		if($nodata==1){
			echo '<p class="page-description">Nu ati raspuns la toate intrebarile.</p>';
		}
	}
	
	echo '<br/><br><br>';
	include 'footer.php';
?>
</body>
<iframe name="frame"></iframe>
</html>