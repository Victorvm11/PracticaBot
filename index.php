<?php
$token = '5208043466:AAFrmtgzTU5bdMkq3Br5zRyjcKp9z_VYo10';
$website = 'https://api.telegram.org/bot'.$token;
 
$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);
 
$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];
$repl=$update['message']['reply_to_message']['text'];

switch($message) {
    case '/start':
        $response = 'Me has iniciado';
        sendMessage($chatId, $response, TRUE);
        break;
    case '/info':
        $response = 'Hola soy @Victorvm_bot';
        sendMessage($chatId, $response, TRUE);
        break;
        case 'Hola':
            $response = 'Hola! soy el bot de Victor😉';
            sendMessage($chatId, $response, TRUE);
            break;
            case '/noticias':
            getNoticias($chatId);
            break;
            case '/fecha':
                $response  = 'La fecha actual es  ' . date('d/m/Y');
                sendMessage($chatId, $response,FALSE);
                break;
       
            case '/hora':
                $response  = 'La hora actual es ' . date('H:i:s');
                sendMessage($chatId, $response,FALSE);
            break;
            case '/help':
                $response  = 'Los comandos disponibles son:
                /start Inicia el bot 🤖
                /fecha Muestra la fecha actual 📆
                /hora Muestra la hora actual ⌚
                /info Informacion del bot 🤖
                /noticias Muestra la informacion del tenis del dia 🎾
                /help Muestra esta ayuda';
                sendMessage($chatId, $response,TRUE);

                break;
                case '/teclado':
                    $keyboard = array('keyboard' => 
            array(array( 
                array('text'=>'/hora','callback_data'=>"6"), 
            ), 
            array( 
                array('text'=>'/noticias','callback_data'=>"4"),
            ), 
                array( 
                    array('text'=>'/fecha','callback_data'=>"5") 
                )), 'one_time_keyboard' => false, 'resize_keyboard' => true 
        ); 
        file_get_contents('https://api.telegram.org/bot5208043466:AAFrmtgzTU5bdMkq3Br5zRyjcKp9z_VYo10/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&reply_markup='.json_encode($keyboard).'&text=Elija que desea hacer');
                    break;
            
                    
        

    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response,TRUE);
        break;
 
    }
    

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
    
 
    sendMessage($chatId, $titulos, FALSE);
 
 
 
}

?>
 
