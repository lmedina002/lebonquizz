<?php

function ScoreUser($id)
{
	#Affiche une table contenant les scores de l'utilisateur
	include("include/connect.php");
	$MaRq = $bdd-> query("SELECT * FROM score WHERE ID_UTILISATEUR = '$id'");
	$MaRqQuestionnaire = $bdd -> prepare("SELECT * FROM questionnaire WHERE ID_QUESTIONNAIRE = :id_q");
	echo "<table><tr>
	<th>Nom du questionnaire</th>
	<th>Difficulté</th>
	<th>Score</th>
	<th>Temps</th></tr>";

	while($ligne = $MaRq -> fetch())
	{
		$MaRqQuestionnaire -> bindValue('id_q', $ligne['ID_QUESTIONNAIRE'], PDO::PARAM_INT);
		$MaRqQuestionnaire -> execute();
		$questionnaire = $MaRqQuestionnaire -> fetch();
		echo "<tr>
		<td>".$questionnaire['LIBELLE_QUESTIONNAIRE']."</td>
		<td>".$ligne['DIFFICULTE']."</td>
		<td>".$ligne['POURCENTAGE']."</td>
		<td>".$ligne['CHRONO']."</td></tr>";
	}

	echo "</table>";
}

function ScoreQuestionnaire($id)
{
	#Affiche une table contenant les scores du questionnaire
	include("include/connect.php");
	$MaRqQuestionnaire = $bdd -> query("SELECT * FROM questionnaire WHERE ID_QUESTIONNAIRE = $id");
	$questionnaire = $MaRqQuestionnaire -> fetch();
	$MaRq = $bdd-> query("SELECT * FROM score WHERE ID_QUESTIONNAIRE = '$id' ORDER BY POURCENTAGE DESC, CHRONO ");
	$MaRqUser = $bdd -> prepare("SELECT * FROM utilisateur WHERE ID_UTILISATEUR = :id_u");
	echo "<table><tr><th class='nom_q' colspan='4'>".$questionnaire['LIBELLE_QUESTIONNAIRE']."</th></tr>
	<th>Nom du joueur</th>
	<th>Difficulté</th>
	<th>Score</th>
	<th>Temps</th></tr>";

	while($ligne = $MaRq -> fetch())
	{
		$MaRqUser -> bindValue('id_u', $ligne['ID_UTILISATEUR'], PDO::PARAM_INT);
		$MaRqUser -> execute();
		$user = $MaRqUser -> fetch();
		echo "<tr>
		<td>".$user['LOGIN']."</td>
		<td>".$ligne['DIFFICULTE']."</td>
		<td>".$ligne['POURCENTAGE']."</td>
		<td>".$ligne['CHRONO']."</td></tr>";
	}

	echo "</table>";
}