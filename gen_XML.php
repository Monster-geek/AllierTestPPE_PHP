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
     * @param $key_file = Clé du questionnaire
     *
     * @return string = Code HTML a afficher
     */
    public function gen_to_xml( $key_file){

        //Get data from BDD
        $data = $this->GetData($key_file);

        if($data == FALSE){

        }

        //Building XML file
        $callable = $this->build_xml_file($data , $key_file);

        if ($callable == FALSE)
        {
            $res_build = FALSE;
        }
        else
        {
            $res_build = TRUE;
        }

        //Building message on the succes of the build
        $display_result = $this->gen_display_bloc($res_build  , $callable);

       //return
        echo $display_result;
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
     * @param $data = Tableau de donnée extrait de la BDD
     * @param $key = ID du questionnaire
     *
     * @return string|bool = en cas de succes retourne le callable, sinon renvoie FALSE.
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

        /**
         * Head of XML
         */
        $xml = new DOMDocument('1.0','iso-8859-1');
        $root = $xml->createElement("questionnaire");
        $root->setAttribute("cle",$key);
        $root->setAttribute("name",$name);
        $root->setAttribute("displayName",$display_name);
        $root = $xml->appendChild($root);

        //Descrip
        $desc = $xml->createElement("description");
        $desc = $root->appendChild($desc);
        $text_desc = $xml->createTextNode($descrip);
        $text_desc = $desc->appendChild($text_desc);


        // Split if multiple responses
        foreach($data as $row){
            $tab_quest[] = $row;
        }
        // Reponces
        foreach($tab_quest as $row){

            $question = $xml->createElement("question");
            $question->setAttribute("type",$row[1]);
            $question->setAttribute("name",$row[2]);
            $question = $root->appendChild($question);

            $quest = $xml->createElement("text");
            $question->appendChild($quest);
            $quest_text = $xml->createTextNode($row[3]);
            $quest->appendChild($quest_text);

            $block_responce = $xml->createElement("reponses");
            $block_responce = $question->appendChild($block_responce);

            if($row[4] != "vide")
            {
                $rep = "";
                $rep = $xml->createElement("reponse");
                if ($row[9] == 1)
                {
                    $rep->setAttribute("default", "true");
                }
                else
                {
                    $rep->setAttribute("default", "false");
                }

                $rep_text = $xml->createTextNode($row[4]);
                $rep->appendChild($rep_text);
                $block_responce->appendChild($rep);
            }
            if($row[5] != "vide")
            {
                $rep = "";
                $rep = $xml->createElement("reponse");
                if ($row[9] == 2)
                {
                    $rep->setAttribute("default", "true");
                }
                else
                {
                    $rep->setAttribute("default", "false");
                }

                $rep_text = $xml->createTextNode($row[5]);
                $rep->appendChild($rep_text);
                $block_responce->appendChild($rep);
            }
            if($row[6] != "vide")
            {
                $rep = "";
                $rep = $xml->createElement("reponse");
                if ($row[9] == 3)
                {
                    $rep->setAttribute("default", "true");
                }
                else
                {
                    $rep->setAttribute("default", "false");
                }

                $rep_text = $xml->createTextNode($row[6]);
                $rep->appendChild($rep_text);
                $block_responce->appendChild($rep);
            }
            if($row[7] != "vide")
            {
                $rep = "";
                $rep = $xml->createElement("reponse");
                if ($row[9] == 4)
                {
                    $rep->setAttribute("default", "true");
                }
                else
                {
                    $rep->setAttribute("default", "false");
                }

                $rep_text = $xml->createTextNode($row[7]);
                $rep->appendChild($rep_text);
                $block_responce->appendChild($rep);
            }
            if($row[8] != "vide")
            {
                $rep = "";
                $rep = $xml->createElement("reponse");
                if ($row[9] == 5)
                {
                    $rep->setAttribute("default", "true");
                }
                else
                {
                    $rep->setAttribute("default", "false");
                }

                $rep_text = $xml->createTextNode($row[8]);
                $rep->appendChild($rep_text);
                $block_responce->appendChild($rep);
            }
        }

        //write it on server and return the callable
        $xml->save("test.xml");
        $callable = "test.xml";
        return $callable;
    }

    /**
     * @param $res_build bool = resultat du build du fichier
     * @param $callable = path callable du fichier
     *
     * @return string = code HTML pret a afficher
     */
    private function gen_display_bloc($res_build , $callable)
    {

        if ($res_build)     // Build = OK
        {
            $html = "<fieldset>";
            $html = $html."<legend> Generation réussie !</legend>";
            $html = $html."Path callable = ".$callable;
            $html = $html."</fieldset>";
        }
        else                //Build = FAIL
        {
            $html = "<fieldset>";
            $html = $html."<legend> Echec de la génération du fichier !</legend>";
            $html = $html."</fieldset>";
        }

        return $html;
    }
} 