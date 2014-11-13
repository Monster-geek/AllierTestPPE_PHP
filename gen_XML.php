<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 13/11/14
 * Time: 15:51
 */

class gen_XML {

    /**
     * @var $user = Identifiant MySQL
     * @var $pwd = Mot de passe MySQL
     * @var $bdd = Nom de la base a interroger
     * @var $hote = Adresse du serveur MySQL
     */
    private $user = "root";
    private $pwd = "";
    private $bdd="QCM";
    private $hote="localhost";

    /**
     * @param $name_quest = Nom du questionnaire a générer
     *
     * return = Tableau de données pour la génération du XML
     */
    public function GetData( $name_quest ){

    }

    /**
     * @param $data = Tableau de donnée pour la génération du XML
     * @param $name_file = nom du fichier XML
     *
     * return = callable du fichier XML
     */
    public function gen_to_xml( $data , $name_file ){

    }

    /**
     * @return string = Liste des questionnnaire prete a etre afficher.
     */
    public function get_list_quest(){

        $resultat = "" ;

        $cnx = $this->connexion_DB();

        if (($cnx == FALSE) || ($cnx == NULL)){
            return "Erreur critique lors de la connection a la base de données.";
        }

        $req = "SELECT displayName FROM Questionnaire";

        $exec = mysql_query($req , $cnx);

        if (($exec == FALSE) || ($exec == NULL)){
            return "Erreur critique lors de l'intérrogation de la base de données.";
        }

        $tab_quest = mysql_fetch_array($exec);

        foreach ($tab_quest as $r){

            $resultat = "<option value=\".$r.\">".$r."</option>";

        }

        return $resultat;
    }

    /**
     * @return bool|resource = retourne FALSE en cas d'erreur sinon retoune le jeton de connection
     */
    private function connexion_DB(){
        $cnx = mysql_connect($this->$hote, $this->$user,$this->$pwd);

        if ( !$cnx )
        {
            mysql_close($cnx);
            return false;
        }

        $labd=mysql_select_db($this->$bdd,$cnx);

        if ( !$labd )
        {
            mysql_close($cnx);
            return false;
        }

        return $cnx;
    }
} 