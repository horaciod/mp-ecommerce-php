<?php
//require $conf['dirsistema'].'include_local/vendor/mercadopago/sdk/lib/mercadopago.php';
error_reporting(E_ALL ) ; 
ini_set('display_errors',1) ; 
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
class mp_local
{
    private $access_token = 'APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398';
    private $integrator_id  = 'dev_24c65fb163bf11ea96500242ac130004' ; 
    public $preference = false; 
    public function __construct()
    {
        MercadoPago\SDK::setAccessToken($this->access_token);
        MercadoPago\SDK::setIntegratorId($this->integrator_id);
    }

    public function getboton()
    {
            if ($this->preference){
                return $this->preference->id; 
            }
            else return false; 
    }

    public function setprefs($cuotas = 6)
    {
        $this->preference = new MercadoPago\Preference();
// ...
        $this->preference->payment_methods = array(
            "excluded_payment_methods" => array(
                array("id" => "amex"),
                array("id" => "atm"),
            ),
            "excluded_payment_types" => array(
                array("id" => "ticket"),
            ),
            "installments" => $cuotas,
        );
    }
    public function additem($precio_unit, $cantidad, $titulo, $image)
    {
        if (!$this->preference) {
            $this->setprefs();
        }

        // Crea un ítem en la preferencia
        $item = new MercadoPago\Item();
        $item->title = $titulo;
        $item->quantity = $cantidad;
        $item->unit_price = $precio_unit;
        $item->picture_url=$image ; 
        $item->description= 'Dispositivo móvil de Tienda e-commerce' ; 
        $this->preference->items = array($item);
        return $this->preference->save();
         
    }

    public function image($img){
        return   str_replace('./', 'https://horaciod-mp-ecommerce-php.herokuapp.com/',$img) ; 
    }
}
