<?php
try
{
	$bdd = new PDO("mysql:host=localhost;dbname=mn1_mysql;charset=utf8","mn1_mysql","xook4hab",
		array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
	die("Erreur fatale :".$e->getMessage());
}
?>