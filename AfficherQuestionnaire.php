<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Affichage questionnaire</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="css/styleAffichageQuestionnaire.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body><div id="main">
    <a class='retour' href='AccueilQuizz.php'> Annuler et revenir à l'accueil</a>
<?php
    require_once ("include/connect.php");

    if(!empty($_GET['libelle']))
    {
        include("include/fct_verification.php");

        $libelleQuestionnaire = verifInput($_GET['libelle']);
        echo "<h1>".$libelleQuestionnaire."</h1>";
        #-------- Questionnaire --------#
        $requeteQuestionnaire=$bdd->prepare("SELECT * FROM questionnaire WHERE ID_QUESTIONNAIRE = :id");
        $requeteQuestionnaire->bindValue('id', verifInput($_GET['id']), PDO::PARAM_INT);
        $requeteQuestionnaire ->execute();
        $questionnaire=$requeteQuestionnaire->fetch();

        #-------- Questions --------#
        $requeteQuestions=$bdd->prepare("SELECT * FROM question INNER JOIN contenir ON question.ID_QUESTION = contenir.ID_QUESTION WHERE contenir.ID_QUESTIONNAIRE = :id_questionnaire");
        $requeteQuestions->bindValue('id_questionnaire', verifInput($_GET['id']), PDO::PARAM_INT);
        $requeteQuestions->execute();
        $nbrQuestions=$bdd->prepare("SELECT NBR_QUESTIONS FROM questionnaire WHERE ID_QUESTIONNAIRE = :id_questionnaire");
        $nbrQuestions->bindValue('id_questionnaire', verifInput($_GET['id']), PDO::PARAM_INT);
        $nbrQuestions->execute();


        $cptQuestions =0;
        #-------- Difficulté --------#
        $Difficulte=$_POST['difficulte'];
        $nbrFacile = $bdd -> prepare("SELECT NBR_FACILE FROM question WHERE ID_QUESTION = :id_question");
        $nbrMoyenne = $bdd -> prepare("SELECT NBR_MOYEN FROM question WHERE ID_QUESTION = :id_question");
        $nbrDifficile = $bdd -> prepare("SELECT NBR_DIFFICILE FROM question WHERE ID_QUESTION = :id_question");

        $minFacile = 5;
        $minMoyen = 4;
        $minDifficile = 3; 
    
        #-------- Réponses ----------#
        $requeteReponses = $bdd -> prepare("SELECT * FROM reponse WHERE ID_QUESTION = :id_question");
        $cptReponses=0;

        #-------- Chrono ------------#
        echo "<div id='conteneur'>";
        echo " <h3  id='chrono' >Temps restant: <span id='cptmin' >";
        if ($Difficulte == "FACILE")
        {               
            echo $minFacile;
        }
        elseif($Difficulte == "MOYEN")
        {
            echo $minMoyen;
        }
        else
        {
            echo $minDifficile;
        }
        echo "</span> minutes <span id='cptsec'>0</span> secondes</h3>";
        
        #----------------------------#
        echo "<form method='post' action ='traitementReponse.php' id='form_id'>";
        while ( $tuple=$requeteQuestions->fetch() )
        {
            $cptQuestions ++;
            #----- Affichage Question ---------#
            echo '<h2>'.$tuple['INTITULE'].'</h2><br/>';
            $_SESSION['IntiQ'.$cptQuestions] = $tuple['INTITULE'];
            $MaRqMedia = $bdd -> query("SELECT LIEN_MEDIA FROM question WHERE ID_QUESTION = ".$tuple['ID_QUESTION']);           
            $TabMedia = $MaRqMedia -> fetch();
            $Media = $TabMedia['LIEN_MEDIA'];
            if($Media != "null")
                {

                    if(substr(strtolower($Media),-3) == "jpg" || substr(strtolower($Media),-3) == "png" )
                        echo "<img src='media/".$Media."' alt='Erreur chargement' width=40%><br/>";
                    elseif(substr(strtolower($Media),-3) == "mp4" || substr(strtolower($Media),-4) == "webm" || substr(strtolower($Media),-3) =="ogg" )
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
            #----- Affichage Réponses --------#
            if ($Difficulte == "FACILE")
            {               
                $nbrFacile->bindValue('id_question', $tuple['ID_QUESTION'], PDO::PARAM_STR);
                $nbrFacile->execute();
                $Facile = $nbrFacile -> fetch();
                $nbrReponses = $Facile['NBR_FACILE'];
            }
            elseif($Difficulte == "MOYEN")
            {
                $nbrMoyenne->bindValue('id_question', $tuple['ID_QUESTION'], PDO::PARAM_STR);
                $nbrMoyenne->execute();
                $Moyen = $nbrMoyenne -> fetch();
                $nbrReponses =  $Moyen['NBR_MOYEN'];
            }
            else
            {
                $nbrDifficile -> bindValue('id_question', $tuple['ID_QUESTION'], PDO::PARAM_STR);
                $nbrDifficile->execute();
                $Difficile = $nbrDifficile -> fetch();
                $nbrReponses = $Difficile['NBR_DIFFICILE'];
            }

            $requeteReponses->bindvalue('id_question', $tuple['ID_QUESTION'], PDO::PARAM_STR);
            $requeteReponses ->execute();

            $typeRep=$tuple['TYPE'];
            $_SESSION['typeRep'.$cptQuestions] = $typeRep;
            if ($typeRep == "qcm")
            {
                $_SESSION['repJustesQcm'.$cptQuestions] = "<br/>";
                $requeteReponsesJustes = $bdd -> query("SELECT * FROM reponse WHERE VERACITE = 1 AND ID_QUESTION=".$tuple['ID_QUESTION']);
                $ReponsesJustes = $requeteReponsesJustes -> fetch();
                $requeteNbJustes = $bdd ->query("SELECT COUNT(*) AS NB FROM reponse WHERE VERACITE = 1 AND ID_QUESTION=".$tuple['ID_QUESTION']) ;
                $resultatNbJustes = $requeteNbJustes -> fetch();
                $nbrRepJustes = $resultatNbJustes['NB'];
                $_SESSION['nbrReponsesJustesQ'.$cptQuestions] = $nbrRepJustes;

                $requeteReponsesFausses = $bdd -> query("SELECT * FROM reponse WHERE VERACITE = 0 AND ID_QUESTION=".$tuple['ID_QUESTION']);
                $ReponsesFausses = $requeteReponsesFausses -> fetch();
                $requeteNbFausses = $bdd ->query("SELECT COUNT(*) AS NB FROM reponse WHERE VERACITE = 0 AND ID_QUESTION=".$tuple['ID_QUESTION']) ;

                $requeteReponses =$bdd -> query("SELECT * FROM reponse WHERE ID_QUESTION=".$tuple['ID_QUESTION']);
                $reponses= $requeteReponses -> fetch();

                $nbrRepFausses=$nbrReponses - $nbrRepJustes; #nbr de reponses fausses nécessaires pour avoir le bon nombre de réponses finales
                echo "<div class='repQCM'>";
                for($cptReponses=0; $cptReponses<$nbrReponses;$cptReponses++)
                {
                    $_SESSION['nbrReponsesQ'.$cptQuestions] = $cptReponses;
                    if($nbrRepJustes>0 and $nbrRepFausses>0)#si nous avons encore des questions justes et des fausses à disposition alors on choisit aléatoirement laquelle on fait apparaitre
                    {
                        $R = rand(0,1);#on choisit aléatoirement d'afficher une réponse juste ou une réponse fausse
                        if($R == 0)
                        {
                            echo '<input type="checkbox"  name = "R'.$cptQuestions.$cptReponses.'" value ="'.$ReponsesFausses['VERACITE'].'"/>';
                            echo '<input type="hidden"  name = "Int'.$cptQuestions.$cptReponses.'" value ="'.$ReponsesFausses['INTITULE'].'"/>';
                            echo($ReponsesFausses['INTITULE']);
                            echo '<br>';
                            $ReponsesFausses = $requeteReponsesFausses -> fetch();
                            $nbrRepFausses--;
                        }
                        else
                        {
                            echo '<input type="checkbox"  name="R'.$cptQuestions.$cptReponses.'" value ="'.$ReponsesJustes['VERACITE'].'"/>';
                            echo '<input type="hidden"  name = "Int'.$cptQuestions.$cptReponses.'" value ="'.$ReponsesJustes['INTITULE'].'"/>';
                            echo($ReponsesJustes['INTITULE']);
                            echo '<br>';
                            $_SESSION['repJustesQcm'.$cptQuestions] .= $ReponsesJustes['INTITULE']."<br/>"; 
                            $ReponsesJustes = $requeteReponsesJustes -> fetch();
                            $nbrRepJustes--;
                        }
                    }
                    elseif ($nbrRepJustes<=0)#toutes les réponses vraies sont affichées
                    {
                        echo '<input type="checkbox"  name="R'.$cptQuestions.$cptReponses.'" value ="'.$ReponsesFausses['VERACITE'].'"/>';
                        echo '<input type="hidden"  name = "Int'.$cptQuestions.$cptReponses.'" value ="'.$ReponsesFausses['INTITULE'].'"/>';
                        echo($ReponsesFausses['INTITULE']);
                        echo '<br>';
                        $ReponsesFausses = $requeteReponsesFausses -> fetch();
                        $nbrRepFausses--;
                    }
                    else #toutes les réponses fausses sont affichées
                    {
                        echo '<input type="checkbox"  name="R'.$cptQuestions.$cptReponses.'" value ="'.$ReponsesJustes['VERACITE'].'"/>';
                        echo '<input type="hidden"  name = "Int'.$cptQuestions.$cptReponses.'" value ="'.$ReponsesFausses['INTITULE'].'"/>';
                        echo($ReponsesJustes['INTITULE']);
                        echo '<br>';
                        $_SESSION['repJustesQcm'.$cptQuestions] .= $ReponsesJustes['INTITULE']."<br/>";
                        $ReponsesJustes = $requeteReponsesJustes -> fetch();
                        $nbrRepJustes--;
                    }
                }
                echo "</div>";
            }
            if($typeRep == "ferme_o" || $typeRep == "ferme_n")
            {
                echo '<input type="radio" name="R'.$cptQuestions.'" value = "oui"/>';
                echo  '    Oui    ';
                echo '<input class$"non" type="radio" name="R'.$cptQuestions.'" value = "non" />';
                echo  '    Non    <br/>';
            }
            if ($typeRep == "ouvert")
            {
                $Reponses = $requeteReponses->fetch();
                $_SESSION['RepOuverte'.$cptQuestions] = $tuple['ID_QUESTION'];
                echo '<input type="text" class="repOuverte" id="ReponseQ"'.$tuple['ID_QUESTION'].'" name="R'.$cptQuestions.'" placeholder="Votre réponse (maximum 250 mots)">';
                echo '<br/>';
            }

        }
        $_SESSION['nbrQuestions'] = $cptQuestions;   
        $_SESSION['diff'] = $Difficulte;
        $_SESSION['id_questionnaire'] = verifInput($_GET['id']);
    }
    echo '<input type="hidden" name="min" id="minleft" value="0">';
    echo '<input type="hidden" name="sec" id="secleft" value="0">';
    echo '<br/><br/><input class="validation" type="submit" name ="envoyer" value ="Valider"/><br/><br/>';
    echo '</form></div><br/><br/><br/>';
    echo "<script src='include/chrono.js'></script>";
    echo '</body></html>';
?>
<br/><br/><br/><footer>
    Lebonquizz! est un site créé par Tiphaine De Ligny et Loïc Medina dans le cadre du projet web de 1ère année à l'Ecole Nationale de Cognitique
</footer>
</div>
</body>
</html>
