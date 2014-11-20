<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20/11/14
 * Time: 15:21
 */

	$callable=$_POST['get_xml'];

    $fp = fopen("./xml/".$callable, "r");
    if (!$fp) die("Impossible d'ouvrir le fichier XML");

    while ( $ligneXML = fgets($fp, 1024))
    {
        echo htmlEntities($ligneXML)."<br />";
    }
    fclose($fp);
?>