<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modifier vos quizz</title>
  <meta name="description" content="Quizz">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/AccueilQuizzModif.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  

</head>


<body><div id="main">
    <a class="retour"href='AccueilQuizz.php'> Retour</a><br/><br/>
    <h1>Bienvenue sur la page de gestion de vos quizz</h1><br/><br/>
    <h1><a class="titre" href="init.php">Créer un nouveau quizz</a></h1><br/><br/>
    <!-- Afficher uniquement quiz créés par la personne -->
	<form action="initModif.php" method="post">
		<fieldset>
			<h1>Modifier vos quizz</h1><br/><br/>
				<p><div class='container'>
                    <?php
                    	include('include/connect.php');
                    	$MaRqQuestionnaire = $bdd -> query("SELECT LIBELLE_QUESTIONNAIRE, ID_QUESTIONNAIRE FROM questionnaire WHERE ID_UTILISATEUR = ".$_SESSION['user']['id']);
                    	while($Questionnaire = $MaRqQuestionnaire -> fetch())
                    	{                               
                            echo
                            '<a href=initModif.php?id='.$Questionnaire['ID_QUESTIONNAIRE'].'>
                            <div class="quest"><a class="nav-link" href=initModif.php?id='.$Questionnaire['ID_QUESTIONNAIRE'].'>'.$Questionnaire["LIBELLE_QUESTIONNAIRE"].'</a></div></a><br/><br/>';        
                        }
                    ?>					
				</div></p>
		</fieldset>
</form></div>
<br/><br/><br/><footer>
    Lebonquizz! est un site crée par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer>
</body>
</html>