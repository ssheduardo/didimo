<?php

namespace Didimo\Sms;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


/**
*  Didimo sms
*
*  Class to send SMS with provider Didimo [http://www.didimo.es]
*
*  @author Eduardo D.
*/

class Sms{

    /**
     * @var string
     */
    protected $user;
    /**
     * @var string
     */
    protected $password;

    protected $client;

    protected $_setEnvironment;

    /**
     *
     * @param string $user User
     * @param string $password Password
     */
    public function __construct($user='', $password='')
    {
        $this->user = $user;
        $this->password = $password;
        $this->client = new Client();
        $this->_setEnvironment='https://preprosms.didimo.es/';
    }

    /**
     * Set environment
     * @param string $environment test or live
     * @throws Exception
     */

    public function setEnvironment($environment='test')
    {
        if(trim($environment) == 'live'){
            //Live
            $this->_setEnvironment='https://sms.didimo.es/';
        }
        else {
            //Test
            $this->_setEnvironment ='https://preprosms.didimo.es/';
        }

    }
    /**
     * This operation allows you to send 1 or more messages in a single call.
     * @param string $sender Message sender. If informed, it must be a maximum of 11 characters. If not reported, the API will use the user-defined sender.
     * @param array $messages With the messages to send.
     * @param string $scheduledate Optional. Date and time when you want the message to be delivered at destination.
     * @return object
     */
    public function createSend($sender='', $messages=array(), $scheduledate='')
    {
        $message_sender = array();
        $index = 0;

        $url = $this->_setEnvironment.'wcf/Service.svc/rest/CreateSend';

        if(is_array($messages)) {
            foreach($messages as $mobile => $message){
                $message_sender[$index]['Mobile'] = $mobile;
                $message_sender[$index]['Text'] = $message;
                $index++;
            }
        }

        $json = array(
            'UserName'      => $this->user,
            'Password'      => $this->password,
            'Sender'        => $sender,
            'Messages'      => $message_sender,
            'ScheduleDate'  => $scheduledate,
        );

        try {
            $response = $this->client->post($url,[
                    'headers' => [ 'Content-Type' => 'application/json','Accept' => 'application/json' ],
                    'body' => json_encode($json)
                ]
            );

            $result = json_decode($response->getBody()->getContents(), true);
            $result['Status'] = $response->getStatusCode();
            $result =json_decode(json_encode($result));
        } catch (RequestException $e) {
            $result = $this->StatusCodeHandling($e);
        }

        return $result;
    }

    /**
     * This operation allows you to send 1 message on a single call.
     *
     * @param string $sender Message sender. If informed, it must be a maximum of 11 characters. If not reported, the API will use the user-defined sender.
     * @param string $mobile Recipient of the message. Information is available in international (+34699999999,003469999999999,34699999999) or national (699999999) formats. It is recommended to use the international format 0034699999999.
     * @param string $message Message text. If the text length is greater than the character limit per SMS (160 for GSM-7 coded text messages, and 70 for Unicode coded messages)
     * @param string $scheduledate Optional. Date and time when you want the message to be delivered at destination.
     * @return object
     */
    public function createMessage($sender='',$mobile='', $message='', $scheduledate='')
    {
        $url = $this->_setEnvironment.'wcf/Service.svc/rest/CreateMessage';

        $json = array(
            'UserName'      => $this->user,
            'Password'      => $this->password,
            'Sender'        => $sender,
            'Mobile'        => $mobile,
            'Text'          => $message,
            'ScheduleDate'  => $scheduledate,
        );

        try {
            $response = $this->client->post($url,[
                    'headers' => [ 'Content-Type' => 'application/json','Accept' => 'application/json' ],
                    'body' => json_encode($json)
                ]
            );

            $result = json_decode($response->getBody()->getContents(), true);
            $result['Status'] = $response->getStatusCode();
            $result =json_decode(json_encode($result));

        } catch (RequestException $e) {
            $result = $this->StatusCodeHandling($e);
        }

        return $result;
    }


    /**
     *
     * @return object
     */
    public function ping()
    {
        $url = $this->_setEnvironment.'wcf/Service.svc/rest/Ping';

        $json = array(
            'UserName'      => $this->user,
            'Password'      => $this->password,
        );

        try {
            $response = $this->client->post($url,[
                    'headers' => [ 'Content-Type' => 'application/json','Accept' => 'application/json' ],
                    'body' => json_encode($json)
                ]
            );

            $result = json_decode($response->getBody()->getContents(), true);
            $result['Status'] = $response->getStatusCode();
            $result =json_decode(json_encode($result));

        } catch (RequestException $e) {
            $result = $this->StatusCodeHandling($e);
        }

        return $result;
    }

    /**
     * This operation allows you to check the status of a message.
     * @param string $id Id message
     * @return mixed
     */
    public function getMessageStatus($id='')
    {
        $url = $this->_setEnvironment.'wcf/Service.svc/rest/GetMessageStatus';

        $json = array(
            'UserName'      => $this->user,
            'Password'      => $this->password,
            'Id'            => $id,
        );

        try {
            $response = $this->client->post($url,[
                    'headers' => [ 'Content-Type' => 'application/json','Accept' => 'application/json' ],
                    'body' => json_encode($json)
                ]
            );

            $result = json_decode($response->getBody()->getContents(), true);
            $result['Status'] = $response->getStatusCode();
            $result =json_decode(json_encode($result));

        } catch (RequestException $e) {
            $result = $this->StatusCodeHandling($e);
        }

        return $result;
    }

    /**
     * This operation allows you to check the available balance to send SMS.
     */
    public function getCredits()
    {
        try {
            $url = $this->_setEnvironment.'wcf/Service.svc/rest/GetCredits';

            $json = array(
                'UserName'      => $this->user,
                'Password'      => $this->password,
            );

            try {
                $response = $this->client->post($url,[
                        'headers' => [ 'Content-Type' => 'application/json','Accept' => 'application/json' ],
                        'body' => json_encode($json)
                    ]
                );

                $result = json_decode($response->getBody()->getContents(), true);
                $result['Status'] = $response->getStatusCode();
                $result =json_decode(json_encode($result));

            } catch (RequestException $e) {
                $result = $this->StatusCodeHandling($e);
            }

            return $result;

        } catch (RequestException $e) {

            $response = $this->StatusCodeHandling($e);
            return $response;
        }
    }

    /**
     * Return message error
     * @param $e
     * @return array
     */
    protected function statusCodeHandling($e)
    {
        $response =(object)array(
            "Status" => $e->getResponse()->getStatusCode(),
            "Error" => json_decode($e->getResponse()->getBody(true)->getContents())
        );
        return $response;
    }
}