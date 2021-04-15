<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modification Quizz</title>
  <meta name="description" content="Quizz">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/creation.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  

</head>
<body><div id='main'>

<!-- Script permettant l'insertion des champs de réponses -->	
	<script type="text/javascript" src="include/bouton_ajout.js"></script>

<!-- Chargement des différentes table dans $_SESSION -->
<?php

	include('include/connect.php');
	include("include/fct_verification.php");

	$id = $_SESSION['id'];

	#------ Table Questions -------#
	if($_GET['n'] == 1)
	{
	$MaRqQuestion = $bdd -> query("SELECT * FROM question INNER JOIN contenir ON question.ID_QUESTION = contenir.ID_QUESTION WHERE contenir.ID_QUESTIONNAIRE = $id");
	$n = 1;
	while($Question = $MaRqQuestion -> fetch())
	{
		#------ Table Réponses ------#
		$id_question = $Question['ID_QUESTION'];
		$MaRqReponse = $bdd -> query("SELECT * FROM reponse WHERE ID_QUESTION = $id_question");

		if($Question['TYPE']=='ferme_o')
			$_SESSION["q".$n] = array(
			"type" => 'ferme',
			"lib" => $Question['INTITULE'],
			"lien" => $Question['LIEN_MEDIA'],
			"rep" => 'oui'
			);

		if($Question['TYPE']=='ferme_n')
			$_SESSION["q".$n] = array(
			"type" => 'ferme',
			"lib" => $Question['INTITULE'],
			"lien" => $Question['LIEN_MEDIA'],
			"rep" => "non"
			);

		if($Question['TYPE']=='ouvert')
		{
			$Reponse = $MaRqReponse -> fetch();
			$_SESSION["q".$n] = array(
			"type" => $Question['TYPE'],
			"lib" => $Question['INTITULE'],
			"lien" => $Question['LIEN_MEDIA'],
			"rep" => $Reponse['INTITULE']
			);
		}
		if($Question['TYPE']=='qcm')
		{		
			$_SESSION["q".$n] = array(
			"type" => $Question['TYPE'],
			"lib" => $Question['INTITULE'],
			"lien" => $Question['LIEN_MEDIA'],
			"nb_facile" => $Question['NBR_FACILE'],
			"nb_moyen" => $Question['NBR_MOYEN'],
			"nb_diff" => $Question['NBR_DIFFICILE']
			);

			$k = 1;
			while($Reponse = $MaRqReponse -> fetch())
			{
				$_SESSION[$n.'rep'.$k] = array(
				"rep" => $Reponse['INTITULE'],
				"veracite" => ($Reponse['VERACITE']==1) ? 'vraie':'faux'
				);
				$k += 1;
			}


		}

		$n += 1;
	}
}

?>

<!-- Traitement cas n=1: stockage nom et nouveau nbre questions -->
	<?php
	
	if($_GET['n']==1 && (isset($_POST['nom']) && isset($_POST['nbre'])))
	{		
		$_SESSION['questionnaire'] = array( 
		"nombre" => verifInput($_POST['nbre']),
		"nom_questionnaire" => verifInput($_POST['nom'])
		);
	}
	?>
<!---------------------------------------------------------->

	<a href="AccueilQuizz.php" class="retour"> Annuler et revenir à l'accueil</a>
	<h1>Création de la question numéro <?php echo $_GET['n'];?></h1>
	<div class="container">

	<?php

	if(isset($_GET['type_q']))
	{
		#Changement de la redirection après le remplissage du form si le nbre de questions est atteint
		if($_GET['n'] == $_SESSION['questionnaire']['nombre']) {
			echo '<form  id="formu" method="POST" action="finModif.php" enctype="multipart/form-data">
			<input type="hidden" name="n" value="'.$_GET['n'].'"/>';
		}
		else
			echo '<form  id="formu" method="POST" action="?n='.($_GET['n']+1).'" enctype="multipart/form-data">';

		#------- Completion champs de saisies --------#
		$tmp_lib = (isset($_SESSION['q'.$_GET['n']]['lib'])) ? $_SESSION['q'.$_GET['n']]['lib']:'';
		$tmp_facile = (isset($_SESSION['q'.$_GET['n']]['nb_facile'])) ? $_SESSION['q'.$_GET['n']]['nb_facile']:'';
		$tmp_moyen = (isset($_SESSION['q'.$_GET['n']]['nb_moyen'])) ? $_SESSION['q'.$_GET['n']]['nb_moyen']:'';
		$tmp_diff = (isset($_SESSION['q'.$_GET['n']]['nb_diff'])) ? $_SESSION['q'.$_GET['n']]['nb_diff']:'';
		$tmp_rep_ouverte = (isset($_SESSION['q'.$_GET['n']]['rep']) && isset($_SESSION['q'.$_GET['n']]['type']) && $_SESSION['q'.$_GET['n']]['type'] == 'ouvert') ? $_SESSION['q'.$_GET['n']]['rep']:'';
		if(isset($_SESSION['q'.$_GET['n']]['rep']) && isset($_SESSION['q'.$_GET['n']]['type']) && $_SESSION['q'.$_GET['n']]['type'] == 'ferme')
		{	if($_SESSION['q'.$_GET['n']]['rep'] == 'oui')
			{
				$tmp_check_oui ='checked';
				$tmp_check_non ='';
			}
			else
			{
				$tmp_check_oui ='';
				$tmp_check_non ='checked';
			}
		}
		else
		{
			$tmp_check_oui ='';
			$tmp_check_non ='';	
		}

		#------- Affichage des champs de saisies ------#
		echo '
		<input type="hidden" name="type" value="'.$_GET['type_q'].'">
		<label for="intitule_q"> Question :</label><br/>
		<textarea name="intitule_q" rows="3" required>'.$tmp_lib.'</textarea><br/><br/>';
		
		#Affichage média chargé
		if(isset($_SESSION['q'.$_GET['n']]['lien']) && $_SESSION['q'.$_GET['n']]['lien']  != "null")
		{
			$Media = $_SESSION['q'.$_GET['n']]['lien'];
			if(substr($Media,-3) == "jpg" || substr($Media,-3) == "png" )
	   			echo "<img src='media/".$Media."' alt='Erreur chargement' width=40%><br/>";
	   		elseif(substr($Media,-3) == "mp4" || substr($Media,-4) == "webm" || substr($Media,-3) =="ogg" )
	   		{	
	   			echo 
	   			"<video controls>
	   			<source src='media/".$Media."' type='video/mp4'>
	   			<source src='media/".$Media."' type='video/ogg'>
	   			<source src='media/".$Media."' type='video/webm'>
	   			Vidéo non supportée par le navigateur
	   			</video><br/>";
	   		}
	    }
	    #Checkbox pour supprimer l'image
	    echo '<input type="checkbox" id="supp_media" name="suppression" value="null"/>
	    <label for="supp_media">Supprimer l\'image ou vidéo actuelle</label><br/>';


		echo '<label for="lien_media"> Image ou vidéo (si nécessaire). Cela remplacera l\'image ou vidéo existante</label>
		<input type="file" class="bouton" name="lien_media" accept=".jpg,.png,.mp4,.webm,.ogg"/><br/><br/>';

		if($_GET['type_q']=='qcm') {
			#------- Complétion réponses ---------#
			$h = 1;
			while(isset($_SESSION[$_GET['n'].'rep'.$h]))
			{
				echo '<script>
				var rep = "'.$_SESSION[$_GET['n'].'rep'.$h]['rep'].'";
				var veracite = "'.$_SESSION[$_GET['n'].'rep'.$h]['veracite'].'";
				AjoutRepRemplie(rep,veracite)</script>';
				$h += 1;
			}
			#-------------------------------------#
			echo '
			<button type="button" class="bouton" id="ajout" onclick="AjoutRep()">Ajouter réponse</button>
			<button type="button" class="bouton" id="suppression" onclick="SupprimeRep()">Supprimer réponse</button><br/><br/>
			Nombre de propositions à afficher en difficulté:<br/>
			<label for="facile">Facile  </label>
			<input type="text" name="facile" size="3" value="'.$tmp_facile.'" required></input><br/>
			<label for="moyen">Moyenne  </label>
			<input type="text" name="moyen" size="3"  value="'.$tmp_moyen.'" required></input><br/>
			<label for="difficile">Difficile  </label>
			<input type="text" name="difficile" size="3"  value="'.$tmp_diff.'" required></input><br/><br/>';						
		}
		elseif ($_GET['type_q']=='ouvert') {
			echo '
			<label for="intitule_r_o"> Réponse :</label><br/>
			<textarea name="intitule_r_o" rows="3" required>'.$tmp_rep_ouverte.'</textarea><br/><br/>';
		}
		else {
			echo '
			<label for="intitule_r_f"> Réponse :</label><br/>
			<label for="oui">Oui</label>
			<input type="radio" id="oui" name="intitule_r_f" value="oui" required '.$tmp_check_oui.'/><br/><br/>
			<label for="non">Non</label>	
			<input type="radio" id="non" name="intitule_r_f" value="non" '.$tmp_check_non.'/><br/><br/>';
		}

		echo '
		<input class="bouton" type="submit" value="Valider"/>
		<input class="bouton" type="reset" value="Annuler"/>
		</form><br/>';	

	}
	else
	{
		#------- Completion champs de saisies --------#
		$tmp_qcm = "";
		$tmp_ouvert = "";
		$tmp_ferme = "";

		if(isset($_SESSION['q'.$_GET['n']]['type']))
		{
			if($_SESSION['q'.$_GET['n']]['type'] == 'qcm')
				$tmp_qcm = "checked";
			elseif($_SESSION['q'.$_GET['n']]['type'] == 'ouvert')
				$tmp_ouvert = "checked";
			else
				$tmp_ferme = "checked";
		}

		echo '
		<form  method="GET" action="">
		<input type="hidden" name="n" value="'.$_GET['n'].'">	
		Type de question :<br/>
		<label for="qcm">QCM</label>
		<input type="radio" id="qcm" name="type_q" value="qcm" required '.$tmp_qcm.'/><br/><br/>
		<label for="ouvert">Ouverte (champ de saisie)</label>	
		<input type="radio" id="ouvert" name="type_q" value="ouvert" '.$tmp_ouvert.'/><br/><br/>
		<label for="ferme">Oui/Non</label>
		<input type="radio" id="ferme" name="type_q" value="ferme" '.$tmp_ferme.'/><br/><br/>
		<input class="bouton" type="submit" value="Valider"/>
		<input class="bouton" type="reset" value="Annuler"/>
		</form><br/>';

	}

	#------- Affichage des boutons pour parcourir les différentes questions -------#
	echo "</div>
		<div class='parcours'>";

	for ($i=1; $i <= $_SESSION['questionnaire']['nombre']; $i++)
	{ 
		echo "
		<form method='GET' action='' style='display: inline'>
		<input type='hidden' name='n' value='".$i."'/>
		<button class='bouton' type='submit'/>".$i."</button>
		</form>"; 
	}		

	?>


<!-- Traitement cas quelconque: stockage questions et réponses -->
	<?php
		
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
			

			#------ Traitement selon type question -------#
			if($_POST['type']=='ferme' && isset($_POST['intitule_r_f']))
				$_SESSION["q".($_GET['n']-1)] = array(
				"type" => verifInput($_POST['type']),
				"lib" => verifInput($_POST['intitule_q']),
				"lien" => $media,
				"rep" => verifInput($_POST['intitule_r_f'])
				);

			if($_POST['type']=='ouvert' && isset($_POST['intitule_r_o']))
			{	echo 'TRAITEMENT';
				$_SESSION["q".($_GET['n']-1)] = array(
				"type" => verifInput($_POST['type']),
				"lib" => verifInput($_POST['intitule_q']),
				"lien" => $media,
				"rep" => verifInput($_POST['intitule_r_o'])
				);
			}

			if($_POST['type']=='qcm')
			{
				$_SESSION["q".($_GET['n']-1)] = array(
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
					$_SESSION[($_GET['n']-1).'rep'.$k] = array(
					"rep" => verifInput($_POST['rep'.$k]),
					"veracite" => verifInput($_POST['veracite'.$k])
					);
					$k += 1;
				}
			}


		}
	?>
<!--------------------------------------------------------------->
</div>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer></div>
</body>
</html>