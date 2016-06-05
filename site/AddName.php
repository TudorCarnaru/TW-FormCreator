<html>
<body>

<?php
	$conn = oci_connect("system","wowmaster252","localhost/orcl");
    $name=array_key_exists('q',$_POST)? $_POST['q']:"random1";
	$query = "select count(nume) from Formulare where nume='$name'";
			$q = oci_parse($conn, $query);
			$r=oci_execute($q);
			$re=oci_fetch_array($q);
			$valoare=$re[0];
			if($valoare>0) echo " Introduceti alt nume";
?>
</body>
</html>