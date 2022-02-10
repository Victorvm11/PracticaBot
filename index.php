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
            $response = 'Hola! Soy el bot de Victor';
            sendMessage($chatId, $response);
            break;
            case '/ClasificacionATP':
                getNoticias($chatId);
             break;
        case '/ClasificacionWTA':
                sendMessage($chatId, "La clasificacion WTA es <a href='https://www.youtube.com/channel/UCGArCE3vmQkFpu_o_6axt1g'></a>");
    
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;

    }
function sendMessage($chatId, $response) {
    $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    file_get_contents($url);
}
function getNoticias($chatId){
 
    //include("simple_html_dom.php");
 
    $context = stream_context_create(array('http' =>  array('header' => 'Accept: application/xml')));
    $url = "https://www.marca.com/marcador/futbol/iphone/1/2018_19/fase0/jornada_8/marcador.xml/rss/rss.aspx";
 
    $xmlstring = file_get_contents($url, false, $context);
 
    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json, TRUE);
 
}
 
?>



?>
