<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscription</title>
  <meta name="description" content="Quizz">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/Inscription.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  

</head>

<body><div id='main'>
<a class="retour" href='index.php'>Retour</a>
<h1> Inscription</h1>
<div class="container">
<form method='POST' action="AccueilQuizz.php">
    <div class="texte"><label  for='login'>Nom d'utilisateur :</label></div>
    <input type='text' class="champ" name='login' size='15' required/><br/><br/>
    <div class="texte"><label for='mdp'>Mot de passe (8 caractères minimum):</label></div>
    <input type='password' class="champ" name='mdp' minlength='8' size='15' required/><br/><br/>
    <div class="texte"><label for='confirmMdp'>Confirmer le mot de passe :</label></div>
    <input type='password' class="champ" name='confirmMdp' minlength='8' size='15' required/> <br/><br/>
    <div class="texte"><label for='question_secrete' > Veuillez choisir une question secrète </label></div>
    <select name='question_secrete' class="champ" size='1'>
        <option value="nomJeuneFilleMere"> Quel était le nom de jeune fille de votre mère ?</option>
        <option value="animalDomestique"> Quel était le nom de votre premier animal domestique ?</option>
        <option value="metierGPPaternel"> Quel était le métier de votre grand-père maternel ?</option>
        <option value="nomEcolePrimaire" > Quel était le nom de votre école primaire ? </option>
        <option value="nomVille" > Quel est le nom de la ville où vous aimeriez le plus vivre ?</option>
    </select><br/><br/>
    <div class="texte"><label  for='reponse_secrete'>Votre réponse :</label></div>
    <input type='text' class="champ" name='reponse_secrete' size='15' required/><br/><br/>
    <input class="validation" type="submit" value="Valider"/>
    <input class="validation" type="reset" value="Annuler"/>
</form>
<?php
    include("include/fct_verification.php");
    if(isset($_GET['error']))
    {
        if(verifInput($_GET['error']) == 1)
            echo "<br/><br/><div class='alert alert-warning'>
                <strong>Attention!</strong> Vos mots de passe ne correspondent pas
                </div>";
        else
            echo "<br/><br/><div class='alert alert-warning'>
                <strong>Attention!</strong> Identifiant déjà utilisé
                </div>";
    }
?>
</div><br/><br/><br/>
<footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer></div>
</body>
</html>