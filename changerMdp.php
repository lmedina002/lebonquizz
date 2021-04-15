<?php
require_once("include/connect.php");
include("include/fct_verification.php");
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Changement du mot de passe</title>
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
    <h1> Changement du mot de passe </h1>
    <form method='post' action="traitementChangerMDP.php">
        <div><label for='MDP'>Mot de passe actuel </label></div>
        <input class="champ" type='password' name='MDP' size='15' required/><br/><br/>
        <div><label for='newMDP'>Nouveau mot de passe</label></div>
        <input class="champ" type='password' name='newMDP' minlength='8' size='15' required/><br/><br/>
        <div><label for='confirmNewMDP'>Nouveau mot de passe</label></div>
        <input class="champ" type='password' name='confirmNewMDP' minlength='8' size='15' required/><br/><br/>
        <input type="submit" class="validation" value="Valider">
    </form>
    <?php
    if(isset($_GET['error']))
    {
        if(verifInput($_GET['error'] == 2))
        {
            echo "<br/><br/><div class='alert alert-warning'>
            <strong>Attention!</strong> Votre ancien mot de passe n'est pas correct. Veuillez réessayer.
            </div>";
        }
        elseif(verifInput($_GET['error'] == 1))
        {
            echo "<br/><br/><div class='alert alert-warning'>
            <strong>Attention!</strong> Votre nouveau mot de passe et sa confirmation ne correspondent pas. Veuillez réessayer.
            </div>";   
        }
    }
    ?>
</div>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer>
</div></body>
</html>
