<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 13/11/14
 * Time: 15:48
 */

    $chk_gen_XML = @include_once 'gen_XML.php';

    if (!$chk_gen_XML){
        die("Erreur d'inclusion du fichier système");
    }

    $gen = new gen_XML();

    if (isset($_POST['gen_xml']))
    {
        $callable = $_POST['gen_xml'];

        $doc = new DOMDocument();
        $doc->load($callable);
        echo $doc;
        die();
    }

?>

<HTML>
    <head>
        <title>Générer un questionnaire au format XML</title>
        <link rel="stylesheet" href="questionnaires.css" type="text/css" />
        <script src="./js/libs/jquery.min.js"></script>
        <script src="./js/main.js"></script>
    </head>

    <body>
        <form method="post" action="creer_XML.php">
            <fieldset>
                <legend>Générer les questionnaires XML</legend>
                <select name="type">
                    <?php
                        $list = $gen->get_list_quest();
                        echo $list;
                    ?>

                </select>
            </fieldset>

            <!-- BOUTONS -->

            <P>
                <input type="submit" value="Creer XML" />
            </P>
        </form>

        <br />

        <?php

            if (isset($_POST['type']))
            {
                $key = $_POST['type'];
                $bloc_gen = $gen->gen_to_xml($key);
                echo $bloc_gen;
            }

        ?>

    <div id="bloc_display_xml">
        <fieldset id="bloc_affichage_xml" style="display: none">

        </fieldset>
    </div>
    </body>

</HTML>