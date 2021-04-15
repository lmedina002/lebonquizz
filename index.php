<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quizz</title>
  <meta name="description" content="Quizz">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  

</head>
<body><div id='main'>
<div> <a href="tuto.html" class="tuto">Voir le tutoriel du site </a></div>
<img src="icons/Lebonquizz_WEB.png" class="img-responsive" id='logo' alt="Logo">
<div class="container">
<div class="box">
    <a href="AccueilQuizz.php"><img src="icons/compose.png" class="img-responsive" alt="Jouer"/></a><br/><br/>
    <a class="nav-link" href="AccueilQuizz.php">Jouer</a>
</div>
<?php
if(isset($_SESSION['user']))
{
     echo '
<div class="box">
    <a href="Deconnexion.php"><img src="icons/exit.png" class="img-responsive" alt="Deconnexion"></a><br/><br/>
    <a class="nav-link" href="Deconnexion.php">Se déconnecter</a>
</div>
<div class="box">
    <a href="MonCompte.php"><img src="icons/user.png" class="img-responsive" alt="MonCompte"></a><br/><br/>
    <a class="nav-link" href="MonCompte.php">Mon compte</a>';
}
else
{
    echo '
<div class="box">
    <a href="Connexion.php"><img src="icons/exit.png" class="img-responsive" alt="Login"></a><br/><br/>
    <a class="nav-link" href="Connexion.php">Se connecter</a>
</div>
<div class="box">
    <a href="Inscription.php"><img src="icons/users.png" class="img-responsive" alt="Inscription"></a><br/><br/>
    <a class="nav-link" href="Inscription.php">S\'inscrire</a>';
}
?>
</div>
</div class='test'>
<br/><br/><br/><footer>
	Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
    <div>Icons made by <a href="https://www.flaticon.com/authors/smashicons" class="icons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/" class="icons" title="Flaticon">www.flaticon.com</a></div>
</footer>
</div>
</body>
</html>