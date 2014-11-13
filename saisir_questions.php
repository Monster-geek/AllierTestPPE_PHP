<?php
//------------------------------------------------
// Recuperer le libelle et la cle du questionnaire
//------------------------------------------------
session_start();
$questionnaire=$_SESSION["displayName"];
$cle=$_SESSION["cle"];


echo "
<HTML>
    <head>
        <TITLE>QUESTIONS liees e un Questionnaire</title>
        <LINK rel=\"stylesheet\" href=\"questionnaires.css\" type=\"text/css\" />
        <SCRIPT type=\"Text/JavaScript\">
            <!-- Limiter le nombre de lignes du TEXTAREA e 5 -->
            function bloquer(event, zoneSaisie)
               {
               // Si on a tape sur un caractere de retour e la ligne
               if ( event.keyCode==13 || event.which==13 )
                  {
                  // Nombre de \"\n\" presents dans la textarea >= 5
                  // split() : nb de sous-chaenes ayant \"\n\" comme separateur
                  if ( zoneSaisie.value.split(\"\n\").length >= 5 )
                        {
                        // L'evenement onkeyPress est place e faux
                        // pour interdir toute frappe de touche supplementaire...
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
    </head>
<BODY>
<FORM method=\"POST\" action=\"traiter_questions.php\" >
<h1>
";

echo $questionnaire;

?>
</h1>

<!-- Zone de saisie des QUESTIONS -->
<!-- TYPE d'objet (type), NOM (name), LIBELLE A AFFICHER (text) -->
<!-- REPONSES (reponses), PAR DEFAUT (defaut) -->
<fieldset>
<legend>Question</legend>

<label for="type">Type de composant :</label>
   <select name="type">
		<option value="combo">Liste deroulante</option>
		<option value="liste">Liste e choix multiples</option>
		<option value="radio">Boutons radio</option>
		<option value="text">Zone de texte</option>
   </select>

<label for="name">Nom :</label>
<input type="text" name="name" size="20" maxlength="20"/>
	
<label for="text">Libelle e afficher :</label>
<input type="text" name="text" size="40" maxlength="60"/>

<BR><BR>
<TABLE>
<TR>
<TD>
<label for="reponses">Reponse(s) (1 par ligne) :</label>
<textarea name="reponses" cols="30" rows="4" wrap="off" onkeyPress="return( bloquer(event, this) );"></textarea>
</TD>
<TD>
   <h2>Reponse par defaut ?</h2>
   <P>
   <label class="inline">Reponse 1</label>
   <input type="radio" name="defaut" value="1" checked="checked" /> 
   <br>
   <label class="inline">Reponse 2</label>
   <input type="radio" name="defaut" value="2" /> 
   <br>
   <label class="inline">Reponse 3</label>
   <input type="radio" name="defaut" value="3" /> 
   <br>
   <label class="inline">Reponse 4</label>
   <input type="radio" name="defaut" value="4" /> 
   <br>
   <label class="inline">Reponse 5</label>
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
