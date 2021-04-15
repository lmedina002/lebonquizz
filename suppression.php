<?php
	session_start();
	include("include/connect.php");
	$id_questionnaire = $_SESSION['id'];
	$MaRqSuppScores = $bdd -> query("DELETE FROM score WHERE ID_QUESTIONNAIRE = $id_questionnaire");
	$MaRqSuppScores -> execute();
	$MaRqIdQuestion = $bdd -> query("SELECT ID_QUESTION FROM contenir WHERE ID_QUESTIONNAIRE = $id_questionnaire");
	while($tuple = $MaRqIdQuestion -> fetch())
	{
		$id_question = $tuple['ID_QUESTION'];
		$MaRqSuppReponse = $bdd -> query("DELETE FROM reponse WHERE ID_QUESTION = $id_question"); #recup liste id question
		$MaRqSuppReponse -> execute();
		$MaRqSuppContenir = $bdd -> query("DELETE FROM contenir WHERE ID_QUESTIONNAIRE = $id_questionnaire AND ID_QUESTION = $id_question");
		$MaRqSuppContenir -> execute();
		$MaRqSuppQuestion = $bdd -> query("DELETE FROM question WHERE ID_QUESTION = $id_question");
		$MaRqSuppQuestion -> execute();	
	}
	$MaRqSuppQuestionnaire = $bdd -> query("DELETE FROM questionnaire WHERE ID_QUESTIONNAIRE = $id_questionnaire");
	$MaRqSuppQuestionnaire -> execute();
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Suppression</title>
  <meta name="description" content="Quizz">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/traitementChangerMDP.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  

</head>
<body><div id='main'>
	<h1>Suppression réussie</h1><br/>
	<h2>Votre questionnaire a bien été supprimé</h2>
	<br/><br/><div class='div'><a href='AccueilQuizz.php'>Revenir à l'accueil</a></div>
	<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer></div>
</body>
</html>