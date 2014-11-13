<?php
//------------------------------------------------
// R�cup�rer le libell� et la cl� du questionnaire
//------------------------------------------------
session_start();
$questionnaire=$_SESSION["displayName"];
$cle=$_SESSION["cle"];
?>
<HTML>
<HEAD>
<TITLE>QUESTIONS li�es � un Questionnaire</title>
<LINK rel="stylesheet" href="questionnaires.css" type="text/css" />
<SCRIPT type="Text/JavaScript">
<!-- Limiter le nombre de lignes du TEXTAREA � 5 -->
function bloquer(event, zoneSaisie)
   {  
   // Si on a tap� sur un caract�re de retour � la ligne
   if ( event.keyCode==13 || event.which==13 )
      {  
	  // Nombre de "\n" pr�sents dans la textarea >= 5
	  // split() : nb de sous-cha�nes ayant "\n" comme s�parateur
      if ( zoneSaisie.value.split("\n").length >= 5 )
			{ 
			// L'�v�nement onkeyPress est plac� � faux
			// pour interdir toute frappe de touche suppl�mentaire...
			event.returnValue=false;
			// Sortie de la fonction
			return false;
			}
      }
	  // Sortie de la fonction
      return true;
   }
</SCRIPT>
</STYLE>
</HEAD>
<BODY>
<FORM method="POST" action="traiter_questions.php" >
<h1><?php echo $questionnaire;?></h1>

<!-- Zone de saisie des QUESTIONS -->
<!-- TYPE d'objet (type), NOM (name), LIBELLE A AFFICHER (text) -->
<!-- REPONSES (reponses), PAR DEFAUT (defaut) -->
<fieldset>
<legend>Question</legend>

<label for="type">Type de composant :</label>
   <select name="type">
		<option value="combo">Liste d�roulante</option>
		<option value="liste">Liste � choix multiples</option>
		<option value="radio">Boutons radio</option>
		<option value="text">Zone de texte</option>
   </select>

<label for="name">Nom :</label>
<input type="text" name="name" size="20" maxlength="20"/>
	
<label for="text">Libell� � afficher :</label>
<input type="text" name="text" size="40" maxlength="60"/>

<BR><BR>
<TABLE>
<TR>
<TD>
<label for="reponses">R�ponse(s) (1 par ligne) :</label>
<textarea name="reponses" cols="30" rows="4" wrap="off" onkeyPress="return( bloquer(event, this) );"></textarea>
</TD>
<TD>
   <h2>R�ponse par d�faut ?</h2>
   <P>
   <label class="inline">R�ponse 1</label>
   <input type="radio" name="defaut" value="1" checked="checked" /> 
   <br>
   <label class="inline">R�ponse 2</label>
   <input type="radio" name="defaut" value="2" /> 
   <br>
   <label class="inline">R�ponse 3</label>
   <input type="radio" name="defaut" value="3" /> 
   <br>
   <label class="inline">R�ponse 4</label>
   <input type="radio" name="defaut" value="4" /> 
   <br>
   <label class="inline">R�ponse 5</label>
   <input type="radio" name="defaut" value="5" /> 
   </P>
</TD>
</TR>
</TABLE>
</fieldset>
<!-- BOUTONS -->
<P>
	<input type="submit" value="Envoyer" />
	<input type="reset" value="Annuler" />
	<input value="Nouveau questionnaire" onclick="self.location.href='saisir_questionnaire.php'" />
</P>
</FORM>
</BODY>
</HTML>
