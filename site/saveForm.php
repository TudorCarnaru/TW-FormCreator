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

$name = array_key_exists('nume', $_POST) ? mysqli_real_escape_string($conn, $_POST['nume']) : "random1";
$id_formular = array_key_exists('id_formular', $_POST) ? mysqli_real_escape_string($conn, $_POST['id_formular']) : "0";
$description = array_key_exists('descriere', $_POST) ? mysqli_real_escape_string($conn, $_POST['descriere']) : "random1";
$domain = array_key_exists('domeniu', $_POST) ? mysqli_real_escape_string($conn, $_POST['domeniu']) : "random1";
$userCreatedForm = array_key_exists('userForm', $_POST) ? mysqli_real_escape_string($conn, $_POST['userForm']) : "random1";

if (!is_numeric($id_formular)) {
    die('Trebuie sa pui un numar la id. Tu ai pus ' . $id_formular);
}

/**
 * ALTE VALIDARI

  ID UNIC
 * NUME UNIC.....
 */
$query = "INSERT INTO `Formulare` (id_formular, nume,descriere, domeniu, nr_completari,html) VALUES('$id_formular', '$name', '$description', '$domain', '0', '$userCreatedForm')";

$result = mysqli_query($conn, $query) or die("Eroare inserare pentru ca " . mysqli_error($conn));

if (!$result) {
    return 'eroare';
}

return 'success';

