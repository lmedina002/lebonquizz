<?php
session_start();
require_once("include/connect.php");
include("include/fct_verification.php");
$login = $_SESSION['user']['nom'];
$requeteMDP = $bdd -> query("SELECT * FROM utilisateur WHERE LOGIN = '$login'");
$requeteMDP -> execute();
$tableauMDP= $requeteMDP-> fetch();
$MDP = $tableauMDP['MDP'];
$MDPsaisi = verifInput($_POST['MDP']);
$validation = 0;
if (verifInput($_POST['newMDP'])== verifInput($_POST['confirmNewMDP']))
{
    $newMDP = verifInput($_POST['newMDP']);

    if(strcmp($MDPsaisi,$MDP)==0)
    {
        $changementMDP = $bdd -> prepare("UPDATE utilisateur SET MDP = '$newMDP' WHERE LOGIN= '$login'");
        $changementMDP -> execute();
        $validation = 1;
    }
    else
    {
        if($_SERVER["HTTP_REFERER"][-1]=='2')
            header("Location: ".$_SERVER["HTTP_REFERER"]);
        elseif($_SERVER["HTTP_REFERER"][-1]=='1')
        {
            $_SERVER["HTTP_REFERER"][-1]='2';
            header("Location: ".$_SERVER["HTTP_REFERER"]);
        }
        else
            header("Location: ".$_SERVER["HTTP_REFERER"]."?error=2");
    }
}
else
{
    if($_SERVER["HTTP_REFERER"][-1]=='1')
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    elseif($_SERVER["HTTP_REFERER"][-1]=='2')
    {
        $_SERVER["HTTP_REFERER"][-1]='1';
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    else
        header("Location: ".$_SERVER["HTTP_REFERER"]."?error=1");
}
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
  <link rel="stylesheet" type="text/css" href="css/traitementChangerMDP.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  

</head>
<body><div id="main">
<?php
if ($validation == 1)
{
    echo "<h1>Votre mot de passe a été mis à jour.</h1>";
}
echo "<br/><br/><div><a href='index.php'>Revenir à l'accueil</a></div>";
?>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer></div>
</body>
</html>