<?php 

namespace App\Classe;

use \Mailjet\Client;
use \Mailjet\Resources;


class Mail {
    private $api_key = 'bde1f0cea117b2da5ba6646a6df06f56';
    private $api_key_secret = '0c42518787be584dda6c11ca0191cb8f';
    
    public function send($to_email, $to_name , $subject, $content) {
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);
        
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "youssouf774@hotmail.fr",
                        'Name' => "YK.DESIGN"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 5005162,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];
        
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && dd($response->getData());
        
        if ($response->success()) {
            var_dump($response->getData());
        }
    }
}
