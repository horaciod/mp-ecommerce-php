<?php

require __DIR__  . '../vendor/autoload.php';

    require './mercadopagoconf.php' ;
    $mp   = new mp_local();
   if (isset($_POST['type']) and isset($_POST['id'])) {
        $jsonSent = $mp->process_notification($_POST['type'], $_POST['id']); 
        file_put_contents("php://stderr", "Notificacion! $jsonSent \n");
   }

