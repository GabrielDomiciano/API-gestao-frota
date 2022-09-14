<?php

namespace App\Communication;

class Whatsapp {

    public function sendWhatsapp($telefone, $message){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.positus.global/v2/sandbox/whatsapp/numbers/6334ea09-d3fe-4689-8acb-684eb0d0ec78/messages",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n  \"to\": \"55$telefone\",\r\n  
                \"type\": \"text\",\r\n  \"text\": {\r\n      
                \"body\": \"$message\"\r\n  }\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMDJmZGFjMjBkOWMwNWZjMzQ2OWZiM2RlZjU2NGMxOWVkYmJiODUwMWMzMDU4NDc0NjE0MGU1Yjk4MWQ5MzJiODJhOWU2ODNiOWM1YTI0NmEiLCJpYXQiOjE2NjI1NjgzMTEuMjU5NDM5LCJuYmYiOjE2NjI1NjgzMTEuMjU5NDQyLCJleHAiOjE2OTQxMDQzMTEuMjU2NTgxLCJzdWIiOiIzMDE5NiIsInNjb3BlcyI6W119.FM6vphYjceypjPLMLGl1x5COOCrsNzldsGkRtTsqcCFzB1fctmY0MFzVyxQ26S9byPnItA51jtnENbiG0EO4ZR7WHDSfxceub00xYh_uE_4bSp080oEpaoI3v5335m3h2xWIStmqQHZLKkFhuhsssqzGMMvUS0yZu9qfFQjzWOnatCwPXIQ1bjh1TfqIlNIrxdPYw4YzzYMKyq5WR66_uZZr3Dqc4EYx-mjtAYLjXmojG2M7urNiSJ3-9-vEND7KF9YrrSVP-AISYB8YqLacRdFR1ONv3JAJ3YEgluE2nItH0bV-_K17ylGyMqNOpCT5h6ABjK9nCMddVhHCSq5v9K3VDU5XnDnWBCa5z_69AXXowgqetAWMr2p0GsBPBPhYQR8xlRH5oruT-12sCOt-ADkzcOkYBt_wsisNt-MctYh2iU6mUOSa1rWD4WQmAtii_oAURGpS3p0dC4q14dsBS4lAhkM_5MMSBD1OI0IME8UGtC_-AmDXRk_zI2aI2UjOirrEDJUbdXVIyRuzqS6McM_X-1Vxh9kUAPveewEtReESSsQFPsaXPUOXXwpbkDeTeHnooDqLgY1hujuo6NN3hi4DREVjbU5F8EVJOgfT1csJ_ifeyTPyv7LaL2TfOhvbOL9R4YvOpXtij7RI0-3WKStSK6uSWU8KH3MPiUhIwj4",
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

}
