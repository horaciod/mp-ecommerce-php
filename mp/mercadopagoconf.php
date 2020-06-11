<?php
//require $conf['dirsistema'].'include_local/vendor/mercadopago/sdk/lib/mercadopago.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__  . '/../vendor/autoload.php';
class mp_local
{
    private $access_token = 'APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398';
    private $integrator_id = 'dev_24c65fb163bf11ea96500242ac130004';
    public $preference = false;
    public function __construct()
    {
        MercadoPago\SDK::setAccessToken($this->access_token);
        MercadoPago\SDK::setIntegratorId($this->integrator_id);
    }

    public function getboton()
    {
        if ($this->preference) {
            return $this->preference->id;
        } else {
            return false;
        }

    }

    public function setprefs($cuotas = 6)
    {
        $this->preference = new MercadoPago\Preference();
// ...
        $this->preference->payment_methods = array(
            "excluded_payment_methods" => array(
                array("id" => "amex")
                
            ),
            "excluded_payment_types" => array(
                array("id" => "atm"),
            ),
            "installments" => $cuotas,
        );
        $this->preference->external_reference = 'horaciod@gmail.com';
        $this->preference->notification_url = 'https://horaciod-mp-ecommerce-php.herokuapp.com/mp/notificacion_mp.php';
        $this->preference->back_urls =(object) array(
            "success" => "https://horaciod-mp-ecommerce-php.herokuapp.com/mp/graciasporelpago.php",
            "failure" => "https://horaciod-mp-ecommerce-php.herokuapp.com/mp/errorenelpago.php",
            "pending" => "https://horaciod-mp-ecommerce-php.herokuapp.com/mp/pagopendiente.php"
        );
        $payer = new MercadoPago\Payer();
        $payer->name = "Lalo";
        $payer->surname = "Landa";
        $payer->email = "test_user_63274575@testuser.com";
        $payer->phone = array(
            "area_code" => "11",
            "number" => "22223333",
        );
        $payer->address =(object) array(
            "street_name" => 'False',
            "street_number" => '123',
            "zip_code" => "1111",
        );
        $this->preference->payer = $payer;
    }
    public function additem($precio_unit, $cantidad, $titulo, $image)
    {
        if (!$this->preference) {
            $this->setprefs();
        }
        $image = trim($image);
        // Crea un ítem en la preferencia
        $item = new MercadoPago\Item();
        $item->id = '1234';
        $item->title = $titulo;
        $item->quantity = $cantidad;
        $item->unit_price = $precio_unit;
        if ($image != '') {
            $item->picture_url = "http://" . $_SERVER['HTTP_HOST'] . substr($image, 1, strlen($image));
        }

        $item->description = 'Dispositivo móvil de Tienda e-commerce';
        $this->preference->items = array($item);
        $this->preference->auto_return = 'approved';    
        $ret = $this->preference->save();

        return $ret; 

    }

   
    public function process_notification($type,$id){
        

        switch($type) {
            case "payment":
                //solo implementamos esta
                $payment = MercadoPago\Payment::find_by_id($id);
                return $payment; 
                break;
            case "plan":
                $plan = MercadoPago\Plan::find_by_id($id);
                break;
            case "subscription":
                $plan = MercadoPago\Subscription::find_by_id($id);
                break;
            case "invoice":
                $plan = MercadoPago\Invoice::find_by_id($id);
                break;
        }
        return $plan; 
    }
}


