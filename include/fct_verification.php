<?php

function verifInput($valeur)
{
	#Fonction permettant d'éviter les injections
	$valeur = stripslashes($valeur); # enleve les \
	$valeur = htmlspecialchars($valeur); # enleve les balises
	return $valeur;
}

function enleveaccents(&$chaine)
{
	#Remplace tous les accents par leur équivalent sans accent.
    $chaine = strtr($chaine,
        "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
        "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
}

function chaine_aleatoire($nb_car, $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789')
{
	#Génere une chaine de caractères aléatoire
    $nb_lettres = strlen($chaine) - 1;
    $generation = '';
    for($i=0; $i < $nb_car; $i++)
    {
        $pos = mt_rand(0, $nb_lettres);
        $car = $chaine[$pos];
        $generation .= $car;
    }
    return $generation;
}
?>