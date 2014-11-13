<?php
//----------------------------------
// Recuperer la cle du QUESTIONNAIRE
//----------------------------------
session_start();
$cle=$_SESSION["cle"];

//------------------------------
// Recuperer les valeurs postees
//------------------------------
$methode=$_SERVER["REQUEST_METHOD"];
if ($methode=="GET")
	$param=$_GET;
else 
	$param=$_POST;

$type=$param["type"];
$name=$param["name"];
$text=$param["text"];
$defaut=$param["defaut"];

// La requete est valide si tous les champs ont ete saisis (au - 1 reponse)
// Si non, reaffichage de la page de saisie des questions
$requeteValide=($type!="" && $name!="" && $text!="" && $defaut!="" && $param["reponses"]!="");
if ($requeteValide)
	{
	//-----------------------------------------------------------
	// Recuperer la liste de REPONSES
	// Le contenu de textarea se presente sous la forme :
	// "ligne1\r\nligne2\r\nligne3"
	// Les lignes sont separees entre elles par la sequence "\r\
	// on recupere chaque sous chaene dans un tableau
	//-----------------------------------------------------------
	$reponses=explode("\r\n",$param["reponses"]);
	
	//-------------------------------------------------
	// Prise en compte des apostrophes dans les chaenes
	// pour pouvoir faire un INSERT : ' remplace par \'
	//-------------------------------------------------
	$name = str_replace("'", "\'", $name);
	$text = str_replace("'", "\'", $text);
	for ($i=0; $i<sizeof($reponses); $i++)
		$reponses[$i]=str_replace("'", "\'", $reponses[$i]);
	
	//-----------------------------------------
	// Pour le QUESTIONNAIRE en cours (cf. cle)
	// Ajout des QUESTIONS dans la BD
	//-----------------------------------------

	// 1. Formatage du RANG (heure+minute+seconde)
	$rang = time();
	$rang = date("his",$rang);
	
	// 2. Configuration serveur et BD
	$user="root";		// Login
	$pwd="";			// pwd
	$bdd="QCM";			// BD MySQL
	$hote="localhost";	// Serveur
	
	// 3. Connexion au serveur et e la BD
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
		echo "Connexion e la base de donnees impossible !";
		mysql_close($cnx);
		exit();
		}

	// 4. Ajout du QUESTIONNAIRE
	$SQL = 	"INSERT INTO questions (cle,rang,typeQ,name,text,reponse1,reponse2,reponse3,reponse4,reponse5,defaut) VALUES('".
			$cle."','".$rang."','".$type."','".$name."','".$text."'";
		
	$liste=array("vide","vide","vide","vide","vide");
	for ($i=0; $i<sizeof($reponses); $i++)
		$liste[$i]=$reponses[$i];

	for ($i=0; $i<sizeof($liste); $i++)
		$SQL = $SQL .(",'".$liste[$i]."'");
 
	$SQL = $SQL . ",".$defaut.")"; 	

	$execution= mysql_query($SQL,$cnx);
	if (! $execution)
		{
		echo "Creation des QUESTIONS impossible !";
		mysql_close($cnx);
		exit();
		}

	// 5. Fin de connexion
	mysql_close($cnx); 
	}
else
	header('Location: saisir_questions.php');
?>
<HTML>
<HEAD>
<TITLE>Enregistrement des QUESTIONS</title>
<LINK rel="stylesheet" href="questionnaires.css" type="text/css" />
</HEAD>
<BODY>
<FORM>
<h1>Question enregistree</h1>
<P>
	<input value="Nouvelle question" onclick="self.location.href='saisir_questions.php'" />
	<input value="Nouveau questionnaire" onclick="self.location.href='saisir_questionnaire.php'" />
</P>
</FORM>
</BODY>
</HEAD>
</HTML>
