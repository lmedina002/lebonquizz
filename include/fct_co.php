<?php
function connexion($login,$mdp)
{
	include("include/connect.php");
	$MaRqVerif = $bdd -> prepare("SELECT * FROM utilisateur WHERE LOGIN = :login AND MDP = :mdp");
	$MaRqVerif -> bindValue('login',$login,PDO::PARAM_STR);
	$MaRqVerif -> bindValue('mdp',$mdp,PDO::PARAM_STR);
	$MaRqVerif -> execute();
    if($user = $MaRqVerif -> fetch())
        $_SESSION['user'] = array(
            'id' => $user['ID_UTILISATEUR'],
            'nom' => $user['LOGIN'],
            'mdp' => $user['MDP'],
            'statut' => $user['STATUT']);
    else
    {	
		if($_SERVER["HTTP_REFERER"][-1]=='1')
		{
			header("Location: ".$_SERVER["HTTP_REFERER"]);
		}
		else
		{
			header("Location: ".$_SERVER["HTTP_REFERER"]."?error=1");
		}			
	}
}
?>