<?php
session_start();
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
<body><div id='main'>

<!-- Traitement dernière question: stockage questions et réponses -->
	<?php
		include("include/fct_verification.php");
		
		$lien=(isset($_POST['lien_media'])) ? $_POST['lien_media']:'null';

		if(isset($_POST['type']) && isset($_POST['intitule_q']))
		{	
			#----- Traitement média ------#
			if(isset($_FILES['lien_media']['tmp_name']))
			{
				$tmpFile = $_FILES['lien_media']['tmp_name'];
				if (is_uploaded_file($tmpFile))
				{
					$media = basename($_FILES['lien_media']['name']);					
					$uploadedFile = "media/$media";
					move_uploaded_file($_FILES['lien_media']['tmp_name'], $uploadedFile);
				}
				else
					$media = "null";
			}

			if(verifInput($_POST['type'])=='ferme' && isset($_POST['intitule_r_f']))
				$_SESSION["q".($_POST['n'])] = array(
				"type" => verifInput($_POST['type']),
				"lib" => verifInput($_POST['intitule_q']),
				"lien" => $media,
				"rep" => verifInput($_POST['intitule_r_f'])
				);

			if(verifInput($_POST['type'])=='ouvert' && isset($_POST['intitule_r_o']))
				$_SESSION["q".($_POST['n'])] = array(
				"type" => verifInput($_POST['type']),
				"lib" => verifInput($_POST['intitule_q']),
				"lien" => $media,
				"rep" => verifInput($_POST['intitule_r_o'])
				);

			if(verifInput($_POST['type'])=='qcm')
			{
				$_SESSION["q".($_POST['n'])] = array(
				"type" => verifInput($_POST['type']),
				"lib" => verifInput($_POST['intitule_q']),
				"lien" => $media,
				"nb_facile" => verifInput($_POST['facile']),
				"nb_moyen" => verifInput($_POST['moyen']),
				"nb_diff" => verifInput($_POST['difficile'])
				);

				$k = 1;

				while (isset($_POST['rep'.$k])) 
				{
					$_SESSION[($_POST['n']).'rep'.$k] = array(
					"rep" => verifInput($_POST['rep'.$k]),
					"veracite" => verifInput($_POST['veracite'.$k])
					);
					$k += 1;
				}
			}
		}
	?>
<!--------------------------------------------------------------->

<?php
	require("include/connect.php");

	#---------- Insertion data questionnaire ---------------#
	$MaRqQuestionnaire = $bdd -> prepare("INSERT INTO questionnaire (NBR_QUESTIONS,ID_UTILISATEUR,LIBELLE_QUESTIONNAIRE) VALUES (:nb,:id_user,:lib)");
	if(isset($_SESSION['questionnaire']))
	{
		if(isset($_SESSION['questionnaire']['nombre'])) { $MaRqQuestionnaire -> bindValue ('nb',$_SESSION['questionnaire']['nombre'], PDO::PARAM_INT);}
		if(isset($_SESSION['questionnaire']['nom_questionnaire'])) { $MaRqQuestionnaire -> bindValue ('lib',$_SESSION['questionnaire']['nom_questionnaire'], PDO::PARAM_STR);}
		if(isset($_SESSION['user'])) { $MaRqQuestionnaire -> bindValue ('id_user',$_SESSION['user']['id'],PDO::PARAM_INT);}
		$MaRqQuestionnaire -> execute();
	}
	#Recuperation id_question
	$MaRqId_Questionnaire = $bdd -> query("SELECT MAX(ID_QUESTIONNAIRE) AS ID FROM questionnaire");
	$MonResId_Questionnaire = $MaRqId_Questionnaire -> fetch();
	$id_questionnaire = $MonResId_Questionnaire['ID'];

	#---------- Insertion data question ---------------#
	$MaRqQuestion = $bdd -> prepare("INSERT INTO question (INTITULE,LIEN_MEDIA,TYPE,NBR_REP_JUSTES,NBR_FACILE,NBR_MOYEN,NBR_DIFFICILE) VALUES (:intitule,:lien,:type,:nb_juste,:nb_f,:nb_m,:nb_d)");
	for ($i=1; $i <= $_POST['n']; $i++) {		
		#Recuperation id_question précedent
		$MaRqId = $bdd -> query("SELECT MAX(ID_QUESTION) AS ID_Q FROM question");
		$MonResId_Q = $MaRqId -> fetch();
		$id_q = $MonResId_Q['ID_Q']+1;
		

		if(isset($_SESSION['q'.$i]))
		{
			if(isset($_SESSION['q'.$i]['lib'])) { $MaRqQuestion -> bindValue ('intitule',$_SESSION['q'.$i]['lib'], PDO::PARAM_STR);}
			if(isset($_SESSION['q'.$i]['lien'])) { $MaRqQuestion -> bindValue ('lien',$_SESSION['q'.$i]['lien'], PDO::PARAM_STR);}
			if(isset($_SESSION['q'.$i]['type']))
			{
				if($_SESSION['q'.$i]['type']=='qcm')
			 	{
			 		$MaRqQuestion -> bindValue ('type','qcm', PDO::PARAM_STR);
			 		if(isset($_SESSION['q'.$i]['nb_facile'])) { $MaRqQuestion -> bindValue ('nb_f',$_SESSION['q'.$i]['nb_facile'], PDO::PARAM_STR);}
			 		if(isset($_SESSION['q'.$i]['nb_moyen'])) { $MaRqQuestion -> bindValue ('nb_m',$_SESSION['q'.$i]['nb_moyen'], PDO::PARAM_STR);}
			 		if(isset($_SESSION['q'.$i]['nb_diff'])) { $MaRqQuestion -> bindValue ('nb_d',$_SESSION['q'.$i]['nb_diff'], PDO::PARAM_STR);}
			 		
			 		$k = 1;
			 		$nb_vraie = 0;
			 		while(isset($_SESSION[$i.'rep'.$k]))
			 		{
			 			if($_SESSION[$i.'rep'.$k]['veracite']=='vraie')
			 				$nb_vraie += 1;
			 			$k += 1;
			 		}
			 		$MaRqQuestion -> bindValue ('nb_juste', $nb_vraie, PDO::PARAM_INT);
			 		$MaRqQuestion -> execute();

			 		#insertion reps multiple
			 		$k = 1;			 		
			 		while(isset($_SESSION[$i.'rep'.$k]))
			 		{
			 			$MaRqRep = $bdd -> prepare("INSERT INTO reponse (INTITULE,VERACITE,ID_QUESTION) VALUES (:intitule, :veracite, :id_q)");
			 			$MaRqRep -> bindValue ('intitule', $_SESSION[$i.'rep'.$k]['rep'], PDO::PARAM_STR);
			 			if($_SESSION[$i.'rep'.$k]['veracite']=='faux')
			 				$MaRqRep -> bindValue ('veracite', 0 , PDO::PARAM_INT);
			 			else
			 			{
			 				$MaRqRep -> bindValue ('veracite', 1 , PDO::PARAM_INT);
			 				
			 			}
			 			$MaRqRep -> bindValue ('id_q', $id_q, PDO::PARAM_INT);
			 			$MaRqRep -> execute();

			 			$k += 1;
			 		}
			 		
			 	}
			 	elseif ($_SESSION['q'.$i]['type']=='ouvert')
			 	{
			 		$MaRqQuestion -> bindValue ('type','ouvert', PDO::PARAM_STR);
			 		$MaRqQuestion -> bindValue ('nb_f',1, PDO::PARAM_STR);
			 		$MaRqQuestion -> bindValue ('nb_m',1, PDO::PARAM_STR);
			 		$MaRqQuestion -> bindValue ('nb_d',1, PDO::PARAM_STR);
			 		$MaRqQuestion -> bindValue ('nb_juste', 1, PDO::PARAM_INT);
			 		$MaRqQuestion -> execute();
			 		
			 		#insertion rep unique
			 		$MaRqRep = $bdd -> prepare("INSERT INTO reponse (INTITULE,VERACITE,ID_QUESTION) VALUES (:intitule, :veracite, :id_q)");
			 		$MaRqRep -> bindValue ('intitule', $_SESSION['q'.$i]['rep'], PDO::PARAM_STR);
			 		$MaRqRep -> bindValue ('veracite', 1 , PDO::PARAM_INT);
			 		$MaRqRep -> bindValue ('id_q', $id_q, PDO::PARAM_INT);
			 		$MaRqRep -> execute();
			 	}
			 	else
			 	{
			 		if(isset($_SESSION['q'.$i]['rep']) && $_SESSION['q'.$i]['rep']=='oui')
			 		{
			 			$MaRqQuestion -> bindValue ('type','ferme_o', PDO::PARAM_STR);
			 		}
			 		else
			 		{
			 			$MaRqQuestion -> bindValue ('type','ferme_n', PDO::PARAM_STR);
			 		}
			 		$MaRqQuestion -> bindValue ('nb_f',1, PDO::PARAM_STR);
			 		$MaRqQuestion -> bindValue ('nb_m',1, PDO::PARAM_STR);
			 		$MaRqQuestion -> bindValue ('nb_d',1, PDO::PARAM_STR);
					$MaRqQuestion -> bindValue ('nb_juste', 1, PDO::PARAM_INT);
					$MaRqQuestion -> execute();			 		
			 	}
			 		 	
			}
			
			

			#Insertion dans la table CONTENIR
			$MaRqContenir = $bdd -> prepare("INSERT INTO contenir (ID_QUESTIONNAIRE,ID_QUESTION) VALUES (:id_questionnaire,:id_question)");
			$MaRqContenir -> bindValue('id_questionnaire',$id_questionnaire, PDO::PARAM_INT);
			$MaRqContenir -> bindValue('id_question',$id_q,PDO::PARAM_INT);
			$MaRqContenir -> execute();
		} 
	}
?>
<h1>Création réussie</h1><br/>
<h2>Votre questionnaire a bien été créé</h2>
<br/><br/><div class='div'><a href='AccueilQuizz.php'>Revenir à l'accueil</a></div>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer></div>
</body>
</html>