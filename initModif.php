<?php
	session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modification questionnaire</title>
  <meta name="description" content="Quizz">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/init.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body><div id='main'>
	<a class="retour" href='AccueilQuizz.php'> Retour</a><br/><br/>
	<h1>Choix des paramètres du questionnaire</h1>

	<?php
	include("include/fct_verification.php");

	if(isset($_GET['id']))
		$_SESSION['id'] = verifInput($_GET['id']);

	include('include/connect.php');
	#------ Table Questionnaire -------#
	$MaRqQuestionnaire = $bdd -> prepare("SELECT * FROM questionnaire WHERE ID_QUESTIONNAIRE = :id");
	$MaRqQuestionnaire -> bindValue('id',$_SESSION['id'],PDO::PARAM_INT);
	$MaRqQuestionnaire -> execute();
	$Questionnaire = $MaRqQuestionnaire -> fetch();
	$_SESSION['questionnaire'] = array( 
		"nombre" => $Questionnaire['NBR_QUESTIONS'],
		"nom_questionnaire" => $Questionnaire['LIBELLE_QUESTIONNAIRE']
		);

	$_SESSION['ancienNb_Q'] = $_SESSION['questionnaire']['nombre']; #Permettra de faire la transition entre des requêtes update et insert

	#------- Completion champs de saisies --------#
	$tmp_nom = (isset($_SESSION['questionnaire']['nom_questionnaire'])) ? $_SESSION['questionnaire']['nom_questionnaire']:'';
	$tmp_nb = (isset($_SESSION['questionnaire']['nombre'])) ? $_SESSION['questionnaire']['nombre']:'';

	echo'
	<div class="container">
	<form  method="POST" action="modification.php?n=1">
	<label for="nom" class="nom"> Nom du questionnaire :</label>
	<input type="text" name="nom" size="20" value="'.$tmp_nom.'" required/><br/><br/>	
	<label for="nbre">Nombre de questions :</label>
	<input type="number" name="nbre" size="5" min="5" value="'.$tmp_nb.'" required/><br/><br/>
	<input type="submit" class="validation" value="Suivant"/>
	<input type="reset" class="validation" value="Annuler"/>
	</form><br/>
	<a class="supp" href="suppression.php">Supprimer le questionnaire, attention cela est irréversible !</a>
	</div>';

	?>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer></div>
</body>
</html>