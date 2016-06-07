	<?php
	include 'db.php';
	$name = array_key_exists('numeForm',$_GET)? $_GET['numeForm']:"random1";
	$query = "select count(nume) from Formulare where nume='$name'";
	$q = oci_parse($conn, $query);
	$r=oci_execute($q);
	$re=oci_fetch_array($q);
	$valoare=$re[0];
	if($valoare>0)
	{
		echo "<table>
		<tr>
		<th>Nume Formular</th>
		<th>Descriere</th>
		<th>Domeniu</th>
		</tr>";
		$query="select id_formular,nume,descriere,domeniu from Formulare where nume='$name'";
		$q = oci_parse($conn, $query);
		$r=oci_execute($q);
		while($row = oci_fetch_array($q)) {
			$id_formular=$row[0];
			$link='fill.php?id_formular='.$id_formular;
			echo "<tr>";
			echo "<td>" . $row[1] . "</td>";
			echo "<td>" . $row[2] . "</td>";
			echo "<td>" . $row[3] . "</td>";
			echo "<button onclick='window.location.href=".'"'.$link. '"'."'>Fill</button>";
			echo "<a class='btn' value=$id_formular href=statistics.php?=$id_formular> Statistics </a>";
			echo "</tr>";
		}
		echo "</table>";
	}
	else
	{
		echo 'Nu avem Formularul Dvs';
	}

	?>
