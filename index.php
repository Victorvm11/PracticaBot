<?php
include('TelegramBot/Api/BotApi.php');
include('TelegramBot/Api/Exception.php');
include('TelegramBot/Api/InvalidArgumentException.php');
include('TelegramBot/Api/BaseType.php');
include('TelegramBot/Api/TypeInterface.php');
include('TelegramBot/Api/Types/ArrayOfArrayOfPhotoSize.php');
include('TelegramBot/Api/Types/ArrayOfPhotoSize.php');
include('TelegramBot/Api/Types/Audio.php');
include('TelegramBot/Api/Types/Chat.php');
include('TelegramBot/Api/Types/Contact.php');
include('TelegramBot/Api/Types/Document.php');
include('TelegramBot/Api/Types/ForceReply.php');
include('TelegramBot/Api/Types/GroupChat.php');
include('TelegramBot/Api/Types/Location.php');
include('TelegramBot/Api/Types/Message.php');
include('TelegramBot/Api/Types/PhotoSize.php');
include('TelegramBot/Api/Types/ReplyKeyboardHide.php');
include('TelegramBot/Api/Types/ReplyKeyboardMarkup.php');
include('TelegramBot/Api/Types/Sticker.php');
include('TelegramBot/Api/Types/User.php');
include('TelegramBot/Api/Types/UserProfilePhotos.php');
include('TelegramBot/Api/Types/Video.php');

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
    case '/hora':
               $response = 'La hora actual es ' . date('H:i:s');
            break;
            case '/noticias':
                getNoticias($chatId);
                break;
            case '/participar': case '/participar@VazCell_bot':
                getSorteos($chatId, $message, $userId, $firstname, $agg);
                break;
            case '/youtube':
                sendMessage($chatId, "Mi canal de YouTube es <a href='https://www.youtube.com/channel/UCGArCE3vmQkFpu_o_6axt1g'>SrVazquez</a>");
            break;
        
        }
         default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;

    }
function sendMessage($chatId, $response) {
    $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    file_get_contents($url);
    function sendMessage($chatId, $response, $keyboard = NULL){
        if (isset($keyboard)) {
            $teclado = '&reply_markup={"keyboard":['.$keyboard.'], "resize_keyboard":true, "one_time_keyboard":true}';
        }
        $url = $GLOBALS[website].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response).$teclado;
        file_get_contents($url);
    }
    
    function getNoticias($chatId){
    
        //include("simple_html_dom.php");
    
        $context = stream_context_create(array('http' =>  array('header' => 'Accept: application/xml')));
        $url = "https://www.sport.es/es/rss/tenis/rss.xml";
    
        $xmlstring = file_get_contents($url, false, $context);
    
        $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
    
        for ($i=0; $i < 9; $i++) { 
            $titulos = $titulos."\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'> +info</a>";
        }
    
        sendMessage($chatId, $titulos);
    
    
    
    }

}
 
?>




