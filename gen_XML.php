<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 13/11/14
 * Time: 15:51
 */

class gen_XML {

    /**
     * @var $user = Identifiant mysqli
     * @var $pwd = Mot de passe mysqli
     * @var $bdd = Nom de la base a interroger
     * @var $hote = Adresse du serveur mysqli
     */
    private $user = "root";
    private $pwd = "";
    private $bdd="QCM";
    private $hote="localhost";

    /**
     * @param $key_quest = Clé du questionnaire
     * @return array|bool = retourne un tableau avec les questions lié au questionnaire demandé | FALSE en cas de vide
     */
    protected function GetData( $key_quest ){

        $mysqli = $this->connexion_DB();

        $req = 'SELECT rang , typeQ , questions.name , text , reponse1 , reponse2 ,reponse3 ,reponse4 ,reponse5 ,defaut
                FROM questions
                WHERE '.$key_quest.' = cle
                ';

        $exec = $mysqli->query($req);

        $tab_row = NULL;
        while ($tab_req = $exec->fetch_array()){
            $tab_row[] = $tab_req;
        }

        if($tab_row == NULL){
            $tab_row = FALSE;
        }

        $mysqli->close();
        return $tab_row;

    }


    /**
     * @param $key_file = clé du fichier XML
     *
     * return = callable du fichier XML
     */
    public function gen_to_xml( $key_file){

        //Get data from BDD
        $data = $this->GetData($key_file);

        if($data == FALSE){

        }

        //Building XML file
        $callable = $this->build_xml_file($data , $key_file);

        //Building message on the succes of the build
        //$this->gen_display_bloc($res_build , $build_responce , $callable);
    }

    /**
     * @return string = Liste des questionnnaire prete a etre afficher.
     */
    public function get_list_quest () {

        $resultat = "" ;

        $mysqli = $this->connexion_DB();

        if ($mysqli->connect_errno){

            $mysqli->close();
            return "Erreur critique lors de la connection a la base de données.";
        }

        $req = "SELECT displayName , cle FROM Questionnaire";

        $exec = $mysqli->query($req);

        if (($exec == FALSE) || ($exec == NULL)){

            $mysqli->close();
            return "Erreur critique lors de l'intérrogation de la base de données.";
        }

        while( $tab_quest = $exec->fetch_array())
        {
            $tab_row[] = $tab_quest;
        }

        foreach ($tab_row as $row){
            $resultat = $resultat.'<option value="'.$row[1].'">'.$row[0].'</option>';
        }


        $mysqli->close();
        return $resultat;
    }

    /**
     * @return bool|resource = retourne FALSE en cas d'erreur sinon retoune le jeton de connection
     */
    private function connexion_DB(){
        $mysqli = new mysqli($this->hote, $this->user, $this->pwd, $this->bdd);

        if ( $mysqli->connect_errno )
        {
            $mysqli->close();
            return false;
        }

        return $mysqli;
    }

    /**
     * @param $data
     */
    private function build_xml_file($data , $key){

        /**
        * Recup d'info basique
        */
        $mysqli = $this->connexion_DB();
        $req = 'SELECT displayName , questionnaire.name ,description  FROM questionnaire WHERE '.$key.' = cle';
        $exec = $mysqli->query($req);
        $tab_info = $exec->fetch_array();
        $display_name = $tab_info[0];
        $name = $tab_info[1];
        $descrip = $tab_info[2];



        // HEAD
        $xml = domxml_new_doc("1.0");
        $root = $xml->create_element("questionnaire");
        $root->set_attribute("cle",$key);
        $root->set_attribute("name",$name);
        $root->set_attribute("displayName",$display_name);
        $root = $xml->append_child($root);

        //Descrip
        $desc = $xml->create_element("description");
        $desc = $root->append_child($desc);
        $text_desc = $xml->create_text_node($descrip);
        $text_desc = $desc->append_child($text_desc);


        foreach($data as $row){
            $tab_quest[] = $row;
        }
        foreach($tab_quest as $row){

        }


    }

    private function gen_display_bloc($res_build , $msg , $callable)
    {

        if ($res_build)     // Build = OK
        {
            $html = "<fieldset>";
            $html = $html."<legend> Generation réussie !</legend>";
            $html = $html."</fieldset>";
        }
        else                //Build = FAIL
        {
            $html = "<fieldset>";
            $html = $html."<legend> Echec de la génération du fichier !</legend>";
            $html = $html."</fieldset>";
        }
    }
} 