<!DOCTYPE HTML>
<html>
<head>
    <title>Fill form</title>
    <meta charset="utf-8"/>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,100,700,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="mainh.css">
	<link rel="stylesheet" type="text/css" href="base.css">
</head>
<body>
<?php include 'header.php';
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);	 
		$data = htmlspecialchars($data);
		return $data;
	}
	$id_formular = $_GET['id_formular'];
	$conn = oci_connect("system","wowmaster252","localhost/orcl");
	//nume si descriere
	$query = "select nume,descriere from Formulare where id_formular='$id_formular'";
	$q = oci_parse($conn, $query);
	$r=oci_execute($q);
	$head=oci_fetch_array($q);
	$nume=$head[0];
	$descriere=$head[1];
	echo '<h1 class="page-title"><b>Sondaj "'.$nume.'"</b></h1><br> <div class="fill-desc">'.$descriere.'</div><br><br>';

	//Intrebari
	$query = "select id_field,nume_field,tip_field from Campuri natural join asociere where id_formular='$id_formular'";
	$q = oci_parse($conn, $query);
	$r=oci_execute($q);
	$count=0;
	echo '<form name="all_forms" method="POST">';
	while($questions=oci_fetch_array($q)){
		$count=$count+1;
		$id_field=$questions[0];
		$field=$questions[1];
		$tip=$questions[2];
		echo '<div class="fill-elem"><b>'.$field.'</b><br>';
		//Optiuni
		$query = "select optiune from ((Formulare natural join Asociere)natural join Optiuni) where id_field='$id_field'";
		$q2 = oci_parse($conn, $query);
		$r = oci_execute($q2);
		if($tip==2){
			//echo '<form name="'.$id_field.'" method="POST">';
			while($optiuni=oci_fetch_array($q2)){
				$optiune=$optiuni[0];
				echo '<input type="radio" name="field'.$count.'" value="'.$optiune.'">'.$optiune.'<br/>';
			}
			//echo '</form>';
		}
		else if($tip==0){
			echo '<input type="text" value="" name="field'.$count.'"><br/><br/>';
		}
		else if ($tip==3){
			//echo '<form name="'.$id_field.'" method="POST">';
			while($optiuni=oci_fetch_array($q2)){
				$optiune=$optiuni[0];
				echo '<input type="checkbox" name="field'.$count.'" value="'.$optiune.'" />'.$optiune.'<br/>';
			}
			//echo '<button type="submit" name="confirm" value="Submit">Submit</button>';
			//echo '</form>';
		}
		echo '</div>';
	}
	echo '<button type="submit" name="confirm" value="Submit">Submit</button>';
	echo '</form>';

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		$name = test_input($_GET['field1']);
		echo $name;
	}
	
	echo '<br/><br><br>';
	include 'footer.php';
?>
</body>
<iframe name="frame"></iframe>
</html>