<?php

namespace Darkish\CategoryBundle\Sms;

class SmsClient extends \SoapClient
{

    private $username = "09123446038";
    private $password = "satrup10127";
    private $lineNumber = "10000108";
    public function __construct()
    {
        parent::__construct('http://n.sms.ir/ws/SendReceive.asmx?wsdl');
    }

    public function sendSms($to, $text)
    {
        $parameters['userName'] = $this->username;
        $parameters['password'] = $this->password;
        $parameters['mobileNos'] = array(doubleval($to));
        $parameters['messages'] = array($text);
        $parameters['lineNumber'] = $this->lineNumber;
        $parameters['sendDateTime'] = date("Y-m-d")."T".date("H:i:s");

        return $this->SendMessageWithLineNumber($parameters);
    }
}