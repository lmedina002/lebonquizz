<!DOCTYPE html>
<html>
<head>
	<title>Connexion</title>
	<meta charset="utf-8" />
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="css/connexion.css">
  
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body><div id='main'>
<a class='retour' href='index.php'> Retour</a>
<div class="container">
<h1> Connexion </h1>
<form method="post" action="AccueilQuizz.php">
        <div class="texte"><label for='login'> Identifiant</label></div>
        <input type='textarea' class="champ" name='login' maxlength='50' size='12' placeholder="Saisir votre identifiant" required><br/><br/>
            
        <div class="texte"><label for='mdp'>Mot de Passe (8 caractères minimum):</label></div>
        <input type='password'id='mdp' class="champ" name='mdp' minlength='8' size='12' placeholder="Saisir votre mot de passe" required><br/><br/>
            
        <a name='oublie' href='mdpOubli.php'>Mot de passe oublié ? </a><br/><br/>
        <input class="validation" type='submit' name ='envoyer' value ='Envoyer' ><br/>
</form>
<?php
	if(isset($_GET['error']))
	{
		echo "<br/><br/><div class='alert alert-warning'>
			<strong>Attention!</strong> Mauvais identifiants
			</div>";
	}
?>
</div>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer></div>
</body>
</html>
