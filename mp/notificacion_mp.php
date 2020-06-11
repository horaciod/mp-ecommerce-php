<?php
require './mercadopagoconf.php' ;
    $mp   = new mp_local();
   if (isset($_POST['type']) and isset($_POST['id'])) {
        $jsonSent = $mp->process_notification($_POST['type'], $_POST['id']); 
        file_put_contents("php://stderr", "Notificacion! $jsonSent \n");
   }
//"/mp/notificacion_mp.php?data.id=7054169396&type=payment
var_dump($_GET) ;
if (isset($_GET['type']) and isset($_GET['data_id'])) {
    echo "si" ;    
     $jsonSent = $mp->process_notification($_GET['type'], $_GET['data_id']); 
    var_dump($jsonSent); 
}