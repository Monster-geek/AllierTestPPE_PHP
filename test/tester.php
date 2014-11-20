<?php

    include_once '../gen_XML.php';

    $gen = new gen_XML();


    /**
     * Test GetData ()
     */

    $data = $gen->GetData( 12064011927 );

    var_dump($data);



?>