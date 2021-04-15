<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mon Compte</title>
  <meta name="description" content="Quizz">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/MonCompte.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  
</head>
<body><div id='main'>
    <a class="retour" href='AccueilQuizz.php'> Retour</a><br/><br/>
    <h1>Bonjour <?php echo $_SESSION['user']['nom'];?></h1>
    <div class="container">
    <div class="box">
    <a href="changerLogin.php"><img src="icons/id-card.png" class="img-responsive" alt="changerLogin"/></a><br/>
    <a class="nav-link" href="changerLogin.php">Changer votre login</a><br/>
    </div>
    <div class="box">
    <a href="changerMdp.php"><img src="icons/locked.png" class="img-responsive" alt="changerMdp"></a><br/>
    <a class="nav-link" href="changerMdp.php">Changer votre mot de passe</a><br/>
    </div>
    <div class="box">
    <a href="MesScores.php"><img src="icons/cup.png" class="img-responsive" alt="messcores"></a><br/>
    <a class="nav-link" href="MesScores.php">Voir mes scores</a>
    </div>
</div>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
    <div>Icons made by <a class="icons" href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/" class="icons" title="Flaticon">www.flaticon.com</a></div>
</footer></div>
</body>
</html>