<?php 
 
// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
require_once "vendor/autoload.php";  
 
use Twilio\Rest\Client; 
 
$sid    = "AC0811f92949b6bd8026502035b63d31a6"; 
$token  = "[AuthToken]"; 
$twilio = new Client($sid, $token); 
 
$message = $twilio->messages 
                  ->create("+5518991353887", // to 
                           array(  
                               "messagingServiceSid" => "MGb1ef6909b2be30029d3a0509570847e7",      
                               "body" => "teste" 
                           ) 
                  ); 
 
print($message->sid);



    