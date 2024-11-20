<?php
session_start();
include 'functions.php';
$pdo = pdo_connect_mysql();
$val="n";
$id = $_GET['idHoraire'];


$sql = "UPDATE Horaires SET valide=?   WHERE idHoraire=?";
$stmt= $pdo->prepare($sql);
$stmt->execute([$val,$id]);
echo $_GET['idHoraire'] ;
header("location:HoraireV.php");
?>