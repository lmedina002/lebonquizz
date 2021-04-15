<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quizz modifié</title>
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
			elseif(isset($_POST['suppression']))
				$media = "null";

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

	#---------- Modif data questionnaire ---------------#
	$MaRqQuestionnaire = $bdd -> prepare("UPDATE questionnaire SET NBR_QUESTIONS = :nb, ID_UTILISATEUR = :id_user, LIBELLE_QUESTIONNAIRE = :lib WHERE ID_QUESTIONNAIRE = :id_q");
	if(isset($_SESSION['id'])) { $MaRqQuestionnaire -> bindValue ('id_q',$_SESSION['id'], PDO::PARAM_INT);}
	if(isset($_SESSION['questionnaire']))
	{
		if(isset($_SESSION['questionnaire']['nombre'])) { $MaRqQuestionnaire -> bindValue ('nb',$_SESSION['questionnaire']['nombre'], PDO::PARAM_INT);}
		if(isset($_SESSION['questionnaire']['nom_questionnaire'])) { $MaRqQuestionnaire -> bindValue ('lib',$_SESSION['questionnaire']['nom_questionnaire'], PDO::PARAM_STR);}
		if(isset($_SESSION['user'])) { $MaRqQuestionnaire -> bindValue ('id_user',$_SESSION['user']['id'],PDO::PARAM_INT);}
		$MaRqQuestionnaire -> execute();
	}
	#Recuperation id_question
	$id_questionnaire = $_SESSION['id'];

	#---------- Insertion data question ---------------#		
	for ($i=1; $i <= min($_SESSION['ancienNb_Q'],$_POST['n']); $i++) 
	{	
		echo "aaaa";
		$MaRqQuestion = $bdd -> prepare("UPDATE question SET INTITULE = :intitule, LIEN_MEDIA = :lien, TYPE = :type, NBR_REP_JUSTES = :nb_juste, NBR_FACILE = :nb_f, NBR_MOYEN = :nb_m, NBR_DIFFICILE = :nb_d WHERE ID_QUESTION = :id_question");	

		$MaRqId = $bdd -> query("SELECT ID_QUESTION FROM contenir WHERE ID_QUESTIONNAIRE = $id_questionnaire ORDER BY  ID_QUESTION");

		$MonResId_Q = $MaRqId -> fetch();
		$id_q = $MonResId_Q['ID_QUESTION'];
		$MaRqQuestion -> bindValue ('id_question', $id_q, PDO::PARAM_INT);	

		if(isset($_SESSION['q'.$i]))
		{
			echo "bbbb";
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

			 		#Modif reps multiple
			 		$k = 1;
			 		$MaRqIdRep = $bdd -> query("SELECT ID_REPONSE FROM reponse WHERE ID_QUESTION = $id_q");
			 		#On compte le nombre de réponses initiales pour passer d'une requête UPDATE à INSERT
			 		$MaRqNbRep = $bdd -> query("SELECT COUNT(*) AS NB FROM reponse WHERE ID_QUESTION = $id_q");
			 		$MonResNbRep = $MaRqNbRep -> fetch();
			 		$NbRep = $MonResNbRep['NB'];
			 		while(isset($_SESSION[$i.'rep'.$k]))
			 		{
			 			if($k <= $NbRep)
			 			{	#Requete UPDATE
			 				$MonResId_R = $MaRqIdRep -> fetch();
			 				$id_r = $MonResId_R['ID_REPONSE'];
			 				$MaRqRep = $bdd -> prepare("UPDATE reponse SET INTITULE = :intitule, VERACITE = :veracite WHERE ID_QUESTION = $id_q && ID_REPONSE = $id_r");
			 			}
			 			else
			 			{	#Requete INSERT
			 				$MaRqRep = $bdd -> prepare("INSERT INTO reponse (INTITULE,VERACITE,ID_QUESTION) VALUES (:intitule, :veracite, :id_q)");
			 				$MaRqRep -> bindValue('id_q', $id_q, PDO::PARAM_INT);
			 			}

			 			$MaRqRep -> bindValue ('intitule', $_SESSION[$i.'rep'.$k]['rep'], PDO::PARAM_STR);
			 			if($_SESSION[$i.'rep'.$k]['veracite']=='faux')
			 				$MaRqRep -> bindValue ('veracite', 0 , PDO::PARAM_INT);
			 			else
			 				$MaRqRep -> bindValue ('veracite', 1 , PDO::PARAM_INT);			 				
			 			
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
			 		
			 		#Modif rep unique
			 		$MaRqIdRep = $bdd -> query("SELECT ID_REPONSE FROM reponse WHERE ID_QUESTION = $id_q");
			 		$MonResId_R = $MaRqIdRep -> fetch();
			 		$id_r = $MonResId_R['ID_REPONSE'];
			 		$MaRqRep = $bdd -> prepare("UPDATE reponse SET INTITULE = :intitule, VERACITE = :veracite WHERE ID_REPONSE = '$id_r'");
			 		$MaRqRep -> bindValue ('intitule', $_SESSION['q'.$i]['rep'], PDO::PARAM_STR);
			 		$MaRqRep -> bindValue ('veracite', 1 , PDO::PARAM_INT);
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
		} 
	}

	if($_SESSION['ancienNb_Q'] < $_POST['n'])
	{
		for ($i= $_SESSION['ancienNb_Q'] + 1; $i <= $_POST['n'] ; $i++) 
		{
			$MaRqQuestionBis = $bdd -> prepare("INSERT INTO question (INTITULE,LIEN_MEDIA,TYPE,NBR_REP_JUSTES,NBR_FACILE,NBR_MOYEN,NBR_DIFFICILE) VALUES (:intitule,:lien,:type,:nb_juste,:nb_f,:nb_m,:nb_d)");
			#Recuperation id_question précedent
			$MaRqIdBis = $bdd -> query("SELECT MAX(ID_QUESTION) AS ID_Q FROM question");
			$MonResId_QBis = $MaRqIdBis -> fetch();
			$id_qBis = $MonResId_QBis['ID_Q']+1;
			

			if(isset($_SESSION['q'.$i]))
			{
				if(isset($_SESSION['q'.$i]['lib'])) { $MaRqQuestionBis -> bindValue ('intitule',$_SESSION['q'.$i]['lib'], PDO::PARAM_STR);}
				if(isset($_SESSION['q'.$i]['lien'])) { $MaRqQuestionBis -> bindValue ('lien',$_SESSION['q'.$i]['lien'], PDO::PARAM_STR);}
				if(isset($_SESSION['q'.$i]['type']))
				{
					if($_SESSION['q'.$i]['type']=='qcm')
				 	{
				 		$MaRqQuestion -> bindValue ('type','qcm', PDO::PARAM_STR);
				 		if(isset($_SESSION['q'.$i]['nb_facile'])) { $MaRqQuestionBis -> bindValue ('nb_f',$_SESSION['q'.$i]['nb_facile'], PDO::PARAM_STR);}
				 		if(isset($_SESSION['q'.$i]['nb_moyen'])) { $MaRqQuestionBis -> bindValue ('nb_m',$_SESSION['q'.$i]['nb_moyen'], PDO::PARAM_STR);}
				 		if(isset($_SESSION['q'.$i]['nb_diff'])) { $MaRqQuestionBis -> bindValue ('nb_d',$_SESSION['q'.$i]['nb_diff'], PDO::PARAM_STR);}
				 		
				 		$k = 1;
				 		$nb_vraie = 0;
				 		while(isset($_SESSION[$i.'rep'.$k]))
				 		{
				 			if($_SESSION[$i.'rep'.$k]['veracite']=='vraie')
				 				$nb_vraie += 1;
				 			$k += 1;
				 		}
				 		$MaRqQuestionBis -> bindValue ('nb_juste', $nb_vraie, PDO::PARAM_INT);
				 		$MaRqQuestionBis -> execute();

				 		#insertion reps multiple
				 		$k = 1;			 		
				 		while(isset($_SESSION[$i.'rep'.$k]))
				 		{
				 			$MaRqRepBis = $bdd -> prepare("INSERT INTO reponse (INTITULE,VERACITE,ID_QUESTION) VALUES (:intitule, :veracite, :id_q)");
				 			$MaRqRepBis -> bindValue ('intitule', $_SESSION[$i.'rep'.$k]['rep'], PDO::PARAM_STR);
				 			if($_SESSION[$i.'rep'.$k]['veracite']=='faux')
				 				$MaRqRepBis -> bindValue ('veracite', 0 , PDO::PARAM_INT);
				 			else
				 			{
				 				$MaRqRepBis -> bindValue ('veracite', 1 , PDO::PARAM_INT);
				 				
				 			}
				 			$MaRqRepBis -> bindValue ('id_q', $id_qBis, PDO::PARAM_INT);
				 			$MaRqRepBis -> execute();

				 			$k += 1;
				 		}
				 		
				 	}
				 	elseif ($_SESSION['q'.$i]['type']=='ouvert')
				 	{
				 		$MaRqQuestionBis -> bindValue ('type','ouvert', PDO::PARAM_STR);
				 		$MaRqQuestionBis -> bindValue ('nb_f',1, PDO::PARAM_STR);
				 		$MaRqQuestionBis -> bindValue ('nb_m',1, PDO::PARAM_STR);
				 		$MaRqQuestionBis -> bindValue ('nb_d',1, PDO::PARAM_STR);
				 		$MaRqQuestionBis -> bindValue ('nb_juste', 1, PDO::PARAM_INT);
				 		$MaRqQuestionBis -> execute();
				 		
				 		#insertion rep unique
				 		$MaRqRepBis = $bdd -> prepare("INSERT INTO reponse (INTITULE,VERACITE,ID_QUESTION) VALUES (:intitule, :veracite, :id_q)");
				 		$MaRqRepBis -> bindValue ('intitule', $_SESSION['q'.$i]['rep'], PDO::PARAM_STR);
				 		$MaRqRepBis -> bindValue ('veracite', 1 , PDO::PARAM_INT);
				 		$MaRqRepBis -> bindValue ('id_q', $id_qBis, PDO::PARAM_INT);
				 		$MaRqRepBis -> execute();
				 	}
				 	else
				 	{
				 		if(isset($_SESSION['q'.$i]['rep']) && $_SESSION['q'.$i]['rep']=='oui')
				 		{
				 			$MaRqQuestionBis -> bindValue ('type','ferme_o', PDO::PARAM_STR);
				 		}
				 		else
				 		{
				 			$MaRqQuestionBis -> bindValue ('type','ferme_n', PDO::PARAM_STR);
				 		}
				 		$MaRqQuestionBis -> bindValue ('nb_f',1, PDO::PARAM_STR);
				 		$MaRqQuestionBis -> bindValue ('nb_m',1, PDO::PARAM_STR);
				 		$MaRqQuestionBis -> bindValue ('nb_d',1, PDO::PARAM_STR);
						$MaRqQuestionBis -> bindValue ('nb_juste', 1, PDO::PARAM_INT);
						$MaRqQuestionBis -> execute();			 		
				 	}
				 		 	
				}
				
				

				#Insertion dans la table contenir
				$MaRqContenir = $bdd -> prepare("INSERT INTO contenir (ID_QUESTIONNAIRE,ID_QUESTION) VALUES (:id_questionnaire,:id_question)");
				$MaRqContenir -> bindValue('id_questionnaire',$id_questionnaire, PDO::PARAM_INT);
				$MaRqContenir -> bindValue('id_question',$id_qBis,PDO::PARAM_INT);
				$MaRqContenir -> execute();
			} 

		}
	}
	elseif($_SESSION['ancienNb_Q'] > $_POST['n'])
	{
		$id_questionnaire = $_SESSION['id'];
		for ($i= $_POST['n'] + 1; $i <= $_SESSION['ancienNb_Q'] ; $i++) 
		{			
			$MonResId_Q = $MaRqId -> fetch();
			$id_q = $MonResId_Q['ID_QUESTION'];
			$id_question = $tuple['ID_QUESTION'];
			$MaRqSuppReponse = $bdd -> query("DELETE FROM reponse WHERE ID_QUESTION = $id_q");
			$MaRqSuppReponse -> execute();
			$MaRqSuppContenir = $bdd -> query("DELETE FROM contenir WHERE ID_QUESTIONNAIRE = $id_questionnaire AND ID_QUESTION = $id_q");
			$MaRqSuppContenir -> execute();
			$MaRqSuppQuestion = $bdd -> query("DELETE FROM question WHERE ID_QUESTION = $id_q");
			$MaRqSuppQuestion -> execute();	
		}
	}
?>
<h1>Modification réussie</h1><br/>
<h2>Votre questionnaire a bien été modifié</h2>
<br/><br/><div class='div'><a href='AccueilQuizz.php'>Revenir à l'accueil</a></div></div>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer>
</body>
</html>