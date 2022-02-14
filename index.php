<?php
$token = '5208043466:AAFrmtgzTU5bdMkq3Br5zRyjcKp9z_VYo10';
$website = 'https://api.telegram.org/bot'.$token;
 
$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);
 
$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];
switch($message) {
    case '/start':
        $response = 'Me has iniciado';
        sendMessage($chatId, $response);
        break;
    case '/info':
        $response = 'Hola! Soy @Victorvm_bot';
        sendMessage($chatId, $response);
        break;
        case 'Hola':
            $response = 'Hola! Soy el bot de Victor😉';
            sendMessage($chatId, $response);
            break;

        case '/ayuda2':
            if(isset($text) &&  $text =='❌ CANCELAR')
{

$keyboard= [
	['Opción 1','Opción 2'],
	['❌ CANCELAR']
];

	$key = array('one_time_keyboard' => true,'resize_keyboard' => true,'keyboard' => $keyboard);
	$k=json_encode($key);


	$respuesta = "USTED HA CANCELADO";
	sendMessage($chatId,$response,$token);


	die();
}
            break;
        case '/noticias':
            getNoticias($chatId);
            break;
            case '/fecha':
                $response  = 'La fecha actual es ' . date('d/m/Y');
                sendMessage($chatId, $response);
                break;
       
            case '/hora':
                $response  = 'La hora actual es ' . date('H:i:s');
                sendMessage($chatId, $response);
            break;

    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;
 
    }
function sendMessage($chatId, $response, $keyboard = NULL) {
    $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    file_get_contents($url);

}
 
function getNoticias($chatId){
 
    //include("simple_html_dom.php");
 
    $context = stream_context_create(array('https' =>  array('header' => 'Accept: application/xml')));
    $url = "https://www.sport.es/es/rss/tenis/rss.xml";
    $xmlstring = file_get_contents($url, false, $context);
 
    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json, TRUE);
    
    $titulos = $titulos."\n\n".$array['channel']['title']."<a href='".$array['channel']['item']['1']['link']."'> +info</a>";
    
 
    sendMessage($chatId, $titulos);
 
 
 
}
 
 
?>
