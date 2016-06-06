<?php

/*
 * This code belongs to NIMA Software SRL | nimasoftware.com
 * For details contact contact@nimasoftware.com
 */
error_reporting(-1);
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] != "POST") {

    die('We accept only ajax over POST');
}


$name = array_key_exists('nume',$_POST)? $_POST['nume']:"random1";
$id_formular = array_key_exists('id_formular',$_POST)? $_POST['id_formular']:"0";
$description = array_key_exists('description',$_POST)? $_POST['description']:"random1";
$domain = array_key_exists('domain',$_POST)? $_POST['domain']:"random1";
$TextArray =  array_key_exists('TextFields',$_POST)? $_POST['TextFields']:"None";
$SingleArray = array_key_exists('SingleFields',$_POST)? $_POST['SingleFields']:"None";
$MultipleArrays = array_key_exists('MultipleFields',$_POST)? $_POST['MultipleFields']:"None";

$arrayText= explode(",",$TextArray);
$arraySingle = explode(",",$SingleArray);
$arrayMultiple = explode(",",$MultipleArrays);
/**
 * ALTE VALIDARI

  ID UNIC
 * NUME UNIC.....
 */

 //Inserarea in formular;
$query = "select count(nume) from Formulare where nume='$name'";
$q = oci_parse($conn, $query);
$r=oci_execute($q);
$re=oci_fetch_array($q);
$valoare=$re[0];
if($valoare>0) echo " Introduceti alt nume";
else
{
	$query = "INSERT INTO Formulare VALUES('$id_formular', '$name', '$description', '$domain', To_date('10/10/1999','dd/mm/yyyy'),0)";		
	$q = oci_parse($conn, $query);
	$r=oci_execute($q);
	oci_commit($conn);
}


//setare id-field;
$query= "Select * from (select id_field from Asociere order by id_field desc) where rownum<2";
$q = oci_parse($conn, $query);
$r=oci_execute($q);
$re=oci_fetch_array($q);
$id_field=$re[0]+1;
$tip_field=0;


$textlength = sizeof($arrayText);
//Insert Text Fields
for($i=0;$i<$textlength;$i+=1)
{
	$query2="INSERT INTO Campuri VALUES('$id_field','$arrayText[$i]','$tip_field')";
	$q = oci_parse($conn, $query2);
	$r=oci_execute($q);
	oci_commit($conn);
	$query3="INSERT INTO Asociere VALUES('$id_formular','$id_field')";
	$q = oci_parse($conn, $query3);
	$r=oci_execute($q);
	oci_commit($conn);
	$query1="INSERT INTO Optiuni (id_field, optiune) VALUES ('$id_field','')";
	$q1 = oci_parse($conn, $query1);
	$r1=oci_execute($q1);
	echo $query1;
	oci_commit($conn);
	$id_field+=1;
}


$arrayLength = sizeof($arraySingle);
// Insert Single Options
$tip_field=1;
for($i=0;$i<$arrayLength;$i+=2)
{
	$nume_optiune=$arraySingle[$i+1];
	$nume_field=$arraySingle[$i];
	$query2="INSERT INTO Campuri VALUES('$id_field','$nume_field','$tip_field')";
	$q = oci_parse($conn, $query2);
	$r=oci_execute($q);
	oci_commit($conn);
	$query3="INSERT INTO Asociere VALUES('$id_formular','$id_field')";
	$q = oci_parse($conn, $query3);
	$r=oci_execute($q);
	oci_commit($conn);
	$query="INSERT INTO Optiuni (id_field, optiune) VALUES ('$id_field','$nume_optiune')";
	$q = oci_parse($conn, $query);
	$r=oci_execute($q);
	oci_commit($conn);
	$id_field+=1;
}



$arrayLength = sizeof($arrayMultiple);
//Insert Multiple Options
$tip_field=2;
for($i=0;$i<$arrayLength;$i+=2)
{
	$nume_optiune=$arrayMultiple[$i+1];
	$nume_field=$arrayMultiple[$i];
	$query2="INSERT INTO Campuri VALUES('$id_field','$nume_field','$tip_field')";
	$q = oci_parse($conn, $query2);
	$r=oci_execute($q);
	oci_commit($conn);
	$query3="INSERT INTO Asociere VALUES('$id_formular','$id_field')";
	$q = oci_parse($conn, $query3);
	$r=oci_execute($q);
	oci_commit($conn);
	$query="INSERT INTO Optiuni (id_field, optiune) VALUES ('$id_field','$nume_optiune')";
	$q = oci_parse($conn, $query);
	$r=oci_execute($q);
	oci_commit($conn);
	$id_field+=1;
}



