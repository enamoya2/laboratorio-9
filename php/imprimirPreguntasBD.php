<?php
session_start();
include_once ("funcionalidades.php");

sleep(1);

$email = $_SESSION["email"];
imprimirPreguntasBD($email);
?>
