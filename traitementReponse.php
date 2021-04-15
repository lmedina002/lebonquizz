<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fin questionnaire</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="css/styleTraitementRep.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body><div id="main">
<?php
require_once ("include/connect.php");
include("include/fct_verification.php");

#----------Calcul du score-----------#
$nbrQuestions = $_SESSION['nbrQuestions'];
$nbrReponsesCorrectes =0;
$nbrReponsesFausses =0;
$texte = "";

for($i=1; $i<=$nbrQuestions; $i++)
{
    $texte .= "<br/><h3>".$_SESSION['IntiQ'.$i]."</h3><p>";
    $typeRep = $_SESSION['typeRep'.$i];
    if($typeRep == 'qcm')
    {
        $nbrReponses = $_SESSION['nbrReponsesQ'.$i];
        $nbrRepCorrectesQCM =0;
        $nbrRepFaussesQCM = 0;
        $texte .= "Vos réponses:<br/>";
        for($j=0; $j<=$nbrReponses;$j++)
        {
            if(isset($_POST['R'.$i.$j]))
            {   
                $texte .= $_POST['Int'.$i.$j]."<br/>";
                if($_POST['R'.$i.$j]== 1)
                    $nbrRepCorrectesQCM++;
                else
                    $nbrRepFaussesQCM++;
            }
        }
        if($nbrRepCorrectesQCM == $_SESSION['nbrReponsesJustesQ'.$i] && $nbrRepFaussesQCM == 0)
            $nbrReponsesCorrectes++;
        else
            $nbrReponsesFausses++;

        $texte .= "Réponse(s) attendue(s):<br/>";
        $texte .= $_SESSION['repJustesQcm'.$i];
    }
    elseif($typeRep == "ferme_o")
    {
        if (isset($_POST['R'.$i]) && $_POST['R'.$i]  == "oui")
        {
            $texte .= "Votre réponse: oui<br/>";
            $nbrReponsesCorrectes++;
        }
        else
        {
            $texte .= "Votre réponse: non<br/>"; 
            $nbrReponsesFausses++;
        }
        $texte .= "Réponse attendue: oui<br/>";
    }
    elseif($typeRep == "ferme_n")
    {
        if (isset($_POST['R'.$i]) && $_POST['R'.$i] == "non")
        {
            $texte .= "Votre réponse: non<br/>";
            $nbrReponsesCorrectes++;
        }
        else
        {
            $texte .= "Votre réponse: oui<br/>"; 
            $nbrReponsesFausses++;
        }
        $texte .= "Réponse attendue: non<br/>";
    }
    elseif($typeRep == "ouvert")
    {
        if(isset($_POST['R'.$i]))
        {
            $requeteRepOuverte = $bdd -> query("SELECT INTITULE FROM reponse WHERE VERACITE = 1 AND ID_QUESTION = ".$_SESSION['RepOuverte'.$i]);
            $RepOuverte = $requeteRepOuverte -> fetch();
            if(strtolower(verifInput($_POST['R'.$i])) == strtolower($RepOuverte['INTITULE']))
                $nbrReponsesCorrectes++;
            else 
                $nbrReponsesFausses++;
            $texte .= "Votre réponse: ".strtolower(verifInput($_POST['R'.$i]))."<br/>";
            $texte .= "Réponse attendue: ".strtolower($RepOuverte['INTITULE'])."<br/>";
        }
        else 
            $nbrReponsesFausses++;

    }
    $texte .= "</p><br/>";
}
$note = round($nbrReponsesCorrectes / $nbrQuestions * 100);

#--------------------------------------#

#----------Stockage du score-----------#
echo "<a class='accueil' href='AccueilQuizz.php' >Accueil</a><div class='container'>
<h1 class='score'> Vous avez réussi ce quiz à : ".$note." % </h1>";
if(isset($_SESSION['user']))
{
    $chrono = '00:0'.$_POST['min'].':'.$_POST['sec'];
    $MaRqScore = $bdd -> prepare("INSERT INTO score (POURCENTAGE, CHRONO, DIFFICULTE, ID_QUESTIONNAIRE, ID_UTILISATEUR) VALUES (:note,:chrono,:diff,:id_q,:id_u)");
    $MaRqScore -> bindValue ('note',$note, PDO::PARAM_INT);
    $MaRqScore -> bindValue ('diff',$_SESSION['diff'], PDO::PARAM_STR);
    $MaRqScore -> bindValue ('id_q',$_SESSION['id_questionnaire'], PDO::PARAM_INT);
    $MaRqScore -> bindValue ('id_u',$_SESSION['user']['id'], PDO::PARAM_INT);
    if($_SESSION['diff']=='FACILE')
        $chrono = '00:0'.(5 - $_POST['min'] - 1).':'.(60 - $_POST['sec']);
    elseif($_SESSION['diff']=='MOYEN')
        $chrono = '00:0'.(4 - $_POST['min'] - 1).':'.(60 - $_POST['sec']);
    elseif($_SESSION['diff']=='DIFFICILE')
        $chrono = '00:0'.(3 - $_POST['min'] - 1).':'.(60 - $_POST['sec']);

    $MaRqScore -> bindValue ('chrono',$chrono, PDO::PARAM_STR);
    $MaRqScore -> execute();
    echo "<h4><br/><br/>Votre score a été enregistré.<br/><br/>Vous pouvez retrouver vos scores <a href='MesScores.php'>ici</a>.</h4>";
}
else 
{
    echo "<h4>Vous n'êtes pas connecté, votre score n'a pas été sauvegardé<br/>
    Vous pouvez vous inscrire <a href='Inscription.php'>ici</a></h4>";
}
#--------------------------------------#
echo "<br/>".$texte;
?>
</div><br/><br/><br/>
<footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer></div>
</body>
</html>