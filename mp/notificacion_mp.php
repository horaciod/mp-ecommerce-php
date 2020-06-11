<?php
// require './mercadopagoconf.php' ;
//     $mp   = new mp_local();
//    if (isset($_POST['type']) and isset($_POST['id'])) {
//         $jsonSent = $mp->process_notification($_POST['type'], $_POST['id']); 
//         file_put_contents("php://stderr", "Notificacion! $jsonSent \n");
//    }



error_log("===========  POST  ============== ".print_r($_POST, true));
error_log("===========  REQUEST  ============== ".print_r($_REQUEST, true));
$entityBody = file_get_contents('php://input');
error_log("===========  TODO  ============== ".print_r($entityBody, true));
