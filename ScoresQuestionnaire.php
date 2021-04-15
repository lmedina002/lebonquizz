<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scores</title>
    <meta name="description" content="Quizz">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ScoresQuestionnaire.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body><div id='main'>
    <a class="retour" href="AccueilQuizz.php"> Retour</a>
    <h1>Liste des scores</h1>
    <img src="icons/podium.png" class="img-responsive" alt="Scores"/></a>
<?php 
    include('include/connect.php');
    include('include/fct_score.php');
    $MaRqQuestionnaire = $bdd -> query("SELECT ID_QUESTIONNAIRE FROM questionnaire");
    echo '<div class="container">';
    while($Questionnaire = $MaRqQuestionnaire -> fetch())
    {
        ScoreQuestionnaire($Questionnaire['ID_QUESTIONNAIRE']);
    }
?>
</div>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
    <div>Icons made by <a class="icons" href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/" class="icons" title="Flaticon">www.flaticon.com</a></div>
</footer></div>
</body>
</html>