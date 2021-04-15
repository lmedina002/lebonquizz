<?php
    session_start();

    #-- Gestion connexion --#

    include("include/connect.php");
    include("include/fct_verification.php");
    include("include/fct_co.php");
    if(substr($_SERVER["HTTP_REFERER"],-13)=="Connexion.php" || substr($_SERVER["HTTP_REFERER"],-21)=="Connexion.php?error=1")
    {
        $login = (isset($_POST["login"])) ? verifInput($_POST['login']):"";
        $mdp = (isset($_POST["mdp"])) ? verifInput($_POST['mdp']):"";
        connexion($login,$mdp);
    }

    #-- Gestion inscription --#
    if(substr($_SERVER["HTTP_REFERER"],-15)=="Inscription.php" || substr($_SERVER["HTTP_REFERER"],-23)=="Inscription.php?error=1")
    {

        if (verifInput($_POST['confirmMdp']) != verifInput($_POST['mdp']))
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
        else
        {   
            #Verification doublon login
            $login = verifInput($_POST['login']);
            $MaRqLogin = $bdd -> query("SELECT LOGIN FROM utilisateur");
            $doublon = 0;
            while ($listelogin = $MaRqLogin -> fetch())
            {
                if($listelogin['LOGIN']==$login)
                {
                    $doublon = 1;
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
            if($doublon == 0)
            {
                $mdp = verifInput($_POST['mdp']);
                $statut = 'joueur';
                $questionSecrete = verifInput($_POST['question_secrete']);
                $reponseSecrete = mb_strtolower(verifInput($_POST['reponse_secrete']));
                enleveaccents($reponseSecrete);
                $ajoutUtilisateur = $bdd -> exec("INSERT INTO utilisateur ( LOGIN, MDP, STATUT, QUESTION_SECRETE, REPONSE_SECRETE) VALUES('$login','$mdp','$statut','$questionSecrete','$reponseSecrete')");
                connexion($login,$mdp);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="css/styleAccueilQuizz.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styleAccueilQuizz.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>


<body>
    <div id='main'>
    <!---------------------->
    <a class='retour' href='index.php'> Retour</a><br/><br/>
    <!-- Mode connecté -->
    <div class='options'>
    <?php
    if(isset($_SESSION['user']))
    {
        echo '<h1><a class="titre" href="MonCompte.php">Gérer mon compte</a></h1><br/>';
        $MaRqStatut = $bdd -> query("SELECT STATUT FROM utilisateur WHERE ID_UTILISATEUR = ".$_SESSION['user']['id']);
        $Statut = $MaRqStatut -> fetch();
        if($Statut['STATUT'] == "admin")
        {
            echo '<h1><a class="titre" href="init.php">Créer un nouveau quizz</a></h1><br/>';
            echo '<h1><a class="titre" href="AccueilQuizzModif.php">Modifier vos quizz</a></h1>';
        }
    }
    ?>
    <!---------------------->
    <br/><h1><a class="titre" href="ScoresQuestionnaire.php">Voir les scores</a></h1><br/>
    </div>
	<form action="AfficherQuestionnaire.php" method="post">
		<fieldset>
			<h1>Choix du Quizz</h1>
            <div class="texte">
				<p><span class='choix'>Choisissez la difficulté:</span>
                    <input TYPE="radio" name="difficulte" value="FACILE" required/> Facile
                    <input TYPE="radio" name="difficulte" value="MOYEN" checked/> Moyen
                    <input TYPE="radio" name="difficulte" value="DIFFICILE"/> Difficile <br/><br/>
                    <span class='choix'>Choisissez votre quiz:</span><br/>
            </div>
                    <?php 
                    	include('include/connect.php');
                    	$MaRqQuestionnaire = $bdd -> query("SELECT LIBELLE_QUESTIONNAIRE, ID_QUESTIONNAIRE FROM questionnaire");
                    	echo"<div id='conteneur'>";
                        while($Questionnaire = $MaRqQuestionnaire -> fetch())
                        {                               
                            echo
                            '                          
                            <button type="submit" class="quest" formaction="AfficherQuestionnaire.php?id='.$Questionnaire['ID_QUESTIONNAIRE'].'&libelle='.$Questionnaire["LIBELLE_QUESTIONNAIRE"].'"><p>'.$Questionnaire["LIBELLE_QUESTIONNAIRE"].'</p></button><br/><br/>                               
                            ';
                        }
                        echo "</div>"
                    ?>					
				</p>
		</fieldset>
	</form>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer>
</div>
</body>
</html>