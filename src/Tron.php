<?php
namespace TNTma\TronWeb;

class Tron{
  const HAPY_TOKEN = 'x';

  public $api; 
  public $credential;
  
  function __construct($tronApi=0,$credential = null,$token = null){   
    if($tronApi === 0){
        $this->api = TronApi::testNet($token);  
    }else if($tronApi === 1){
        $this->api = TronApi::mainNet($token);  
    }else{
        $this->api = TronApi::myNet($tronApi,$token); 
    } 
     
    $this->credential = $credential;
    
    //new ExceptionHandler();
  }

  function setCredential($credential){
    $this->credential = $credential;
  }

  function getCredential(){
    if(is_null($this->credential)){
      throw new \Exception('Credential not set.');
    }
    return $this->credential;
  }  
  
  function sendTrx($to,$amount){
    $credential = $this->getCredential();
    $from = $credential->address()->base58();
    
    $tx = $this->api->createTransaction($to,(int)$amount,$from);
    $signedTx = $credential->signTx($tx);
    $ret = $this->api->broadcastTransaction($signedTx);
    return (object)[
      'txid' => $signedTx->txID,
      'result' => $ret->result
    ];
  }
  
  function broadcast($tx){
    return $this->api->broadcastTransaction($tx);
  }
  
  function getTrxBalance($address){
    return $this->api->getBalance($address);
  }
  
  function getTxid($txid,$confirmed=true){
    return $this->api->getTransactionById($txid,$confirmed=true);
  }
  
  function contract($abi){
    $credential = $this->getCredential();    
    return new Contract($this->api,$abi,$credential);
    return $inst;
  }
  
  function trc20($address){
    $credential = $this->getCredential();
    $inst = new Trc20($this->api,$credential);    
    return $inst->at($address);
  } 
  
  
}