<?php
session_start();
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
<body><div id="main">
<?php
require_once("include/connect.php");
include("include/fct_verification.php");
if(empty($_SESSION['log']))
{
    $login = verifInput($_POST['login']);
    $_SESSION['log'] = $login;
}
else
{
    $login = $_SESSION['log'];
}
$requeteQuestionSecrete = $bdd ->  query("SELECT * FROM utilisateur WHERE LOGIN = '$login'");
$tableauQuestion = $requeteQuestionSecrete -> fetch();
$question = $tableauQuestion['QUESTION_SECRETE'];
$_SESSION['RepSec'] = $tableauQuestion['REPONSE_SECRETE'];

echo "<a class='retour' href='javascript:history.go(-1)'> Retour </a>";
echo "<div class='container'><h1>Mot de passe oublié</h1>";
echo "<form method='post' action='verifReponseSecrete.php'><span class='q'>";
if(strcmp($question,"nomJeuneFilleMere")==0)
    echo "Quel était le nom de jeune fille de votre mère ?";
elseif (strcmp($question,"animalDomestique")==0)
    echo "Quel était le nom de votre premier animal domestique ?";
elseif (strcmp($question,"metierGPPaternel")==0)
    echo "Quel était le métier de votre grand-père maternel ?";
elseif(strcmp($question,"nomEcolePrimaire")==0)
    echo "Quel était le nom de votre école primaire ?";
else
    echo " Quel est le nom de la ville où vous aimeriez le plus vivre ?";
echo "</span><br/><br/><div><label  for='reponse_secrete'>Votre réponse : </label></div>";
echo "<input class='champ' type='text' name='reponse_secrete' size='15' required/><br/><br/>";
echo "<input class='validation' type='submit'  value='Valider'>";
echo "</form>";

if(isset($_GET['error']))
{
    echo "<br/><br/><div class='alert alert-warning'>
        <strong>Attention!</strong> Votre réponse est incorrecte
        </div></div>";
}
?>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer></div>
</body>
</html>

