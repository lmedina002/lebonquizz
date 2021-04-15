<?php
	session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Création questionnaire</title>
  <meta name="description" content="Quizz">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/init.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body><div id='main'>
  <a class="retour" href='AccueilQuizz.php'> Retour</a><br/><br/>
	<h1>Choix des paramètres du questionnaire</h1>
	<div class='container'>
	<form  method="POST" action="creation.php?n=1">
	<label for="nom" class="nom">Nom du questionnaire :</label>
	<input type="text" name="nom" size="20" required/><br/><br/>	
	<label for="nbre">Nombre de questions :</label>
	<input type="number" name="nbre" size="5" min="5" value="10" required/><br/><br/>
	<input type="submit" class="validation" value="Suivant"/>
	<input type="reset" class="validation" value="Annuler"/>
	</form>
</div>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer></div>
</body>
</html>