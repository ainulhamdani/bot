<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Callback extends CI_Controller {
    
    private $token = "EAAUErx8qkU4BAPHkRC4WZCBScmLaRviIyBUrWZAGHpQNZCGTSWk0TxO5s8Ki9jXEJUdZCqxrkL6SJTa7juLLwwnMh2x5u0ZA1EkIxUQwj88cqvFD03DboeS0hBUC67BmKK17ws4uzFZAkZAUZBCnZCzoZCP9yDUP2QAfHrRy02EjDrMAZDZD";

    public function index(){
        if(isset($_GET['hub_mode'])){
            if($_GET['hub_mode']=='subscribe'){
                if($_GET['hub_verify_token']=='ainulhamdani'){
                    print_r($_GET['hub_challenge']);
                }
            }
        }else{
            $input = json_decode(file_get_contents("php://input"));
            if(isset($input->object)){
                if($input->object=="page"){
                    if(isset($input->entry[0]->messaging[0]->message)){
                        $rid = $input->entry[0]->messaging[0]->sender->id;
                        $msg = $input->entry[0]->messaging[0]->message->text;
                        $replies = array(
                            'Hi, nice to meet you',
                            'Selamat datang',
                            'Salam kenal',
                            'Glad to see you',
                            'Ada yang bisa dibantu?'
                        );
                        $data1 = array(
                            'recipient' => array('id' => $rid),
                            'message' => array(
                                'text' => $replies[rand(0, 4)],
                                'quick_replies' => array([
                                    'content_type' => 'text',
                                    'title' => 'Pilihan 1',
                                    'payload' => '1'
                                ],[
                                    'content_type' => 'text',
                                    'title' => 'Pilihan 2',
                                    'payload' => '2'
                                ])
                            )
                        );
                        $data = array(
                            'recipient' => array('id' => $rid),
                            'message' => array(
                                'attachment' => array(
                                    'type' => 'template',
                                    'payload' => array(
                                        'template_type' => 'button',
                                        'text' => 'What do you want?',
                                        'buttons' => [array(
                                            'type' => 'web_url',
                                            'title' => 'Show',
                                            'url' => 'https://bot.ainulhamdani.com'
                                        ),
                                            array(
                                            'type' => 'web_url',
                                            'title' => 'See',
                                            'url' => 'https://bot.ainulhamdani.com'    
                                            )]
                                    )
                                )
                            )
                        );
                        $opt = array(
                            'http' => array(
                                'method' => 'POST',
                                'content' => json_encode($data),
                                'header' => "Content-Type: application/json\n"
                            )
                        );

                        $context = stream_context_create($opt);
                        file_get_contents("https://graph.facebook.com/v2.6/me/messages?access_token=$this->token",false,$context);
                    }elseif(isset($input->entry[0]->messaging[0]->read)){
                        
                    }
                }
            }else{
                
            }
        }
    }
    
    public function see(){
        $fb = file_get_contents("fb.txt");
        print_r($fb);
    }
}
