<?php
//------------------------------
// Récupérer les valeurs postées
//------------------------------
// La récupération dépend de la méthode d'envoi de ceux-ci
$méthode=$_SERVER["REQUEST_METHOD"];
if ($méthode=="GET")
	$param=$_GET;
else 
	$param=$_POST;

$name=$param["name"];
$displayName=$param["displayName"];
$description=$param["description"];

// La requête est valide si tous les champs ont été saisis
// Si non, reaffichage de la page de saisie du questionnaire
$requêteValide=($name!="" && $displayName!="");
if ($requêteValide)
	{
	//----------------------------------
	// Ajout du QUESTIONNAIRE dans la BD
	//----------------------------------
	
	// 1. Formatage de la CLE (année+mois+jour+heure+minute+seconde)
	$cle = time();
	$cle = date("ymjhis",$cle);
	
	// 2. Prise en compte des apostrophes dans les chaînes
	// pour pouvoir faire un INSERT : ' remplacé par \'
	$name = str_replace("'", "\'", $name);
	$displayName = str_replace("'", "\'", $displayName);
	$description = str_replace("'", "\'", $description);

	// 3. Configuration serveur et BD
	$user="root";		// Login
	$pwd="";			// pwd
	$bdd="QCM";			// BD MySQL
	$hote="localhost";	// Serveur
	
	// 4. Connexion au serveur et à la BD
	$cnx = mysql_connect($hote, $user, $pwd);
	if (! $cnx)
		{
		echo "Connexion au serveur impossible !";
		mysql_close($cnx);
		exit();
		}
	$labd=mysql_select_db($bdd,$cnx);
	if (! $labd)
		{
		echo "Connexion à la base de données impossible !";
		mysql_close($cnx);
		exit();
		}

	// 5. Ajout du QUESTIONNAIRE
	if ($description!="")
		$SQL = "INSERT INTO questionnaire(cle,name,displayName,description) VALUES('".$cle."','".$name."','".$displayName."','".$description."')";
	else
		$SQL = "INSERT INTO questionnaire(cle,name,displayName,description) VALUES('".$cle."','".$name."','".$displayName."','vide')";
	
	$execution= mysql_query($SQL,$cnx);
	if (! $execution)
		{
		echo "Création du QUESTIONNAIRE impossible !";
		mysql_close($cnx);
		exit();
		}

	// 6. Fin de connexion
	mysql_close($cnx);

	//---------------------------------------------
	// Démarrage de SESSION pour sauvegarder le 
	// descriptif et la clé du questionnaire, puis
	// affichage de la page de saisie des QUESTIONS
	//---------------------------------------------
	session_start();
	$_SESSION["cle"] = $cle;
 	$_SESSION["displayName"] = $displayName;

	header('Location: saisir_questions.php');
	//ou bien : include "saisir_questions.php";	
	}
else
	//-----------------------------------------------------
	// Reaffichage du formulaire de saisie du questionnaire
	//-----------------------------------------------------
	header('Location: saisir_questionnaire.php');
?>
