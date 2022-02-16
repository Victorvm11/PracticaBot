<?php
$token = '5208043466:AAFrmtgzTU5bdMkq3Br5zRyjcKp9z_VYo10';
$website = 'https://api.telegram.org/bot'.$token;
 
$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);

/*

$message = $update['message'];

$id = $message["from"]["id"];
$name = $message["from"]["first_name"];
$text = $message["text"];
*/
 
$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];
$repl=$update['message']['reply_to_message']['text'];

switch($message) {
    case '/start':
        $response = 'Me has iniciado';
        sendMessage($chatId, $response, TRUE);
        break;
    case '/info':
        $response = 'Hola! Soy @Victorvm_bot';
        sendMessage($chatId, $response);
        break;
        case 'Hola':
            $response = 'Hola! Soy el bot de Victor😉';
            sendMessage($chatId, $response);
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
            case '/help':
                $response  = 'Los comandos disponibles son:
                /start Inicia el bot 🤖
                /fecha Muestra la fecha actual 📆
                /hora Muestra la hora actual ⌚
                /info Informacion del bot 🤖
                /noticias Muestra la informacion del tenis del dia 🎾
                /help Muestra esta ayuda';
                sendMessage($chatId, $response);

                break;
                    
        

    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;
 
    }
    
    /*
    $keyboard= [
         ['100''200','300'], 
         ['400''500','600'],
         ['CANCELAR'],
    ];
    $key = array('one_time_keyboard' => true, 'resize_keyboard' => true, 'keyboard' => $keyboard);
    $k=json_encode($key)
    $response='Hola'

    sendMessage($id,$respuesta,$token,$k);


    function sendMessage($chatID, $messaggio, $token,&$k = ''){
        $url = "https://api.telegram.org/" . $token . "/sendMessage?disable_web_page_preview=false&parse_mode=HTML&chat_id=" . $chatID;
    
        if(isset($k)) {
            $url = $url."&reply_markup=".$k; 
            }
    
        $url = $url."&text=" . urlencode($messaggio);
        $ch = curl_init();
        $optArray = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
    }
    

*/

function sendMessage($chatId, $response, $repl) {
    if($repl==TRUE){
        $reply_mark=array('force_reply'=>True);
        $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&reply_markup='.json_encode($reply_mark).'&text='.urlencode($response);
    }
    else $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
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
 
