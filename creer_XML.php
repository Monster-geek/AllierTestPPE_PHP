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
?>

<HTML>
    <head>
        <title>Générer un questionnaire au format XML</title>
        <link rel="stylesheet" href="questionnaires.css" type="text/css" />
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
    </body>

</HTML>