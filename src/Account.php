<?php
namespace TNTma\TronWeb;

use Elliptic\EC;
use kornrunner\Keccak;

class Account{
  protected $keyPair;
  
  function __construct($privateKey){
    $ec = new EC('secp256k1');
    $this->keyPair = $ec->keyFromPrivate($privateKey);
  }
  
  static function SetPrivateKey($privateKey){
    return new self($privateKey);
  }
  
  static function create(){
    $bin = random_bytes(32);
    $privateKey = bin2hex($bin);
    return new self($privateKey);
  }
  
  function privateKey(){
    return  $this->keyPair->getPrivate()->toString(16,2);
  }
  
  function publicKey(){
    return $this->keyPair->getPublic()->encode('hex');
  }
  
  function address(){ 
    return Address::fromPublicKey($this->publicKey());
  }
  
  function sign($hex){
    $signature = $this->keyPair->sign($hex);
    $r = $signature->r->toString('hex');
    $s = $signature->s->toString('hex');
    //$v = bin2hex(pack('C',$signature->recoveryParam));
    $v = bin2hex(chr($signature->recoveryParam));
    return $r.$s.$v;
  }
  
  function signTx($tx){
      if(empty($tx->txID)){
          var_dump($tx);
          throw new \Exception("交易失败,请查看原因");
      }
    $signature = $this->sign($tx->txID);
    //var_dump($signature);
    $tx->signature = [$signature];
    return $tx;
  }
}