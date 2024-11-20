<?php
namespace App\Traits;

trait SMSTrait {
        
    public function SendMessage($mobile,$messageText){
        $url= 'https://mshastra.com/sendurlcomma.aspx?';
        $data =array(
            'user' => 'Naguib',
            'pwd'=>'41j16su4',
            'senderid'=>'NaguibSelim',
            'mobileno'=>'02'.$mobile,
            'msgtext'=>$messageText,
            'priority'=>'High',
            'CountryCode'=>'ALL',
        );
        
        $msg = http_build_query($data);
        $url .= $msg;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }
}