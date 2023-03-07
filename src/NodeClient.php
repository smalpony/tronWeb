<?php
namespace TNTma\TronWeb;

use GuzzleHttp\Client;

class NodeClient{
  protected $client;
  
  static function mainNet(){
    return new self('https://api.trongrid.io');
  }
  
  static function testNet(){
    return new self('https://api.shasta.trongrid.io');
  }
  
  function __construct($uri,$token=null){
    $opts = [
      'base_uri' => $uri
    ];
	if(strlen($token) > 30){
		$headers = ['TRON-PRO-API-KEY' => $token ];   
		$opts['headers'] = $headers;
	} 
    $this->client = new Client($opts);
  }
  
  function post($api,$payload=[]){
    $opts = [
      'json' => $payload
    ];
    $rsp = $this->client->post($api,$opts);
    return $this->handle($rsp);
  }
  
  function get($api,$query=[]){
    $opts = [
      'query' => $query
    ];
    $rsp = $this->client->get($api,$opts);
    return $this->handle($rsp);
  }
  
  function handle($rsp){
    $content = $rsp->getBody();
    //echo $content . PHP_EOL;
    return json_decode($content);
  }
  
  function version(){
    return '1.0.0';
  }
}