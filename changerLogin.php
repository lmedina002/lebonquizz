<?php
require_once("include/connect.php");
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Changement du login</title>
  <meta name="description" content="Quizz">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/connexion.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  

</head>
<body><div id='main'>
<a class="retour" href='MonCompte.php'> Retour</a>
<div class="container">
<h1> Changement de l'identifiant </h1>
<form method='post' action="traitementChangerLogin.php">
    <div><label for='login'>Identifiant actuel </label></div>
    <input class="champ" type='text' name='login' required /><br/><br/>
    <div><label for='newLogin'>Nouvel Identifiant</label></div>
    <input class="champ" type='text' name='newLogin' size='15' required/><br/><br/>
    <input class="validation" type="submit" value="Valider">
</form>
<?php
	if(isset($_GET['error']))
	{
		echo "<br/><br/><div class='alert alert-warning'>
			<strong>Attention!</strong> L'identifiant que vous avez rentré ne correspond pas à celui sous lequel vous êtes enregisté. Veuillez réessayer.
			</div>";
	}
?>
</div>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer></div>
</body>
</html>
