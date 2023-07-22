# 关于TronWeb
基于web3.js 开发,支持波场链 所有API,支持sunswap闪兑，跨链兑换，usdt兑换trx等等！

# 开发初衷
是为了开发Telegram 机器人（24小时自动兑换trx）而编写的轮子 分享给大家！
 
# PS4引入
	use TNTma\TronWeb\Address;
	use TNTma\TronWeb\Account;
	use TNTma\TronWeb\Tron;



# #■■■■■■■■■■■■地址操作■■■■■■■■■■■■ 

# #创建地址 - 支持离线
	//$credential = Account::create();  
	// echo PHP_EOL.'private (私钥)key ：' . $credential->privateKey() ; 
	// echo PHP_EOL.'public  (公钥)key ：' . $credential->publicKey() ; 
	// echo PHP_EOL.'Base58  (地址)res ：' . $credential->address();

# #私钥转地址
	// $credential = Account::fromPrivateKey('9d939c3f7540ce396d21a12f36f50c579c6738bd66edce2718c378216e8044d3');
	// echo PHP_EOL.'转换 -> public  (公钥)key ：' . $credential->publicKey() ; 
	// echo PHP_EOL.'转换 -> Base58  (地址)res ：' . $credential->address();


# #地址hex&base58转换
	// $hex = Address::decode('TRBGg5jVfj5SUMRE8758ecMDWnNNNNNNNN');
	// $Base58 = Address::encode('413516435fb1e706c51efff614c7e14ce2625f28e5'); 












# ■■■■■■■■■■■■波场基础■■■■■■■■■■■■ 

# #TRX查询余额 -  
	// $tron = new Tron(1);//0测试网 , 1主网
	// $balance = $tron->getTrxBalance('TRBGg5jVfj5SUMRE8758ecMDWnNNNNNNNN');  
	// $balance /= 1000000; // 精度6   $balance ÷ 1000000 =   人性化数值



# #TRX转账
	// $PrivateKey = Account::SetPrivateKey('你的地址秘钥');//设定私钥 
	// $tron = new Tron(1,$PrivateKey);//0测试网 , 1主网 
	// $to = 'TQn9Y2khEsLJW1ChVWFMSMeRDow5KcbLSE'; //目标地址
	// $money = 1*1000000;//代表1USDT  注：合约精度6  
	// $ret = $tron->sendTrx($to,$money);  
	// echo "\ntxid  ：" . $ret->txid . PHP_EOL;
	// echo "\nresult：" . $ret->result . PHP_EOL; //result=true 代表广播成功-不代表交易成功,需调用查哈希地址进行查询交易结果


# #根据Txid 哈希查询交易状态
	// $tron = new Tron(1);
	// $ret = $tron->getTxid('4c8e2656d73d518bc2063d5536cb63f729d4ef8314d62d3cb4692933f3534ab3'); 
	// if(empty($ret->ret[0])){
	//     echo '对不起，无法找到该交易。';  
	// }else if($ret->ret[0]->contractRet == 'SUCCESS'){
	//   echo '交易成功'; 
	// }else{
	//   echo '交易失败：'.$ret->ret[0]->contractRet;  
	// }









# ■■■■■■■■■■■■波场合约(USDT)■■■■■■■■■■■■ 

# #设置网络/秘钥/合约
	$PrivateKey = Account::SetPrivateKey('9d939c3f7540ce396d21a12f36f50c579c6738bd66edce2718c378216e8044d3');//设定私钥 
	$tron = new Tron(1,$PrivateKey);//0测试网 , 1主网
	$TRC20 = $tron->Trc20('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t');//合约地址 - USDT合约


# #查询合约信息
	 echo "\n合约名称：".$TRC20->name();
	 echo "\n合约标志：".$TRC20->symbol();
	 echo "\n合约精度：".$TRC20->decimals();
	 echo "\n发行总量：".$TRC20->totalSupply();



# #查询余额
	//$balance = $TRC20->balanceOf('TRBGg5jVfj5SUMRE8758ecMDWnNNNNNNNN')->toString(); //÷1000000=人性化可是数值



# #合约转账(转usdt)
	// $to = 'TQn9Y2khEsLJW1ChVWFMSMeRDow5KcbLSE'; //目标地址
	// $money = 1*1000000;//代表1USDT  注：合约精度6  
	// $ret = $TRC20->transfer($to,$money);
	// echo "\ntxid  ：" . $ret->tx->txID . PHP_EOL;
	// echo "\nresult：" . $ret->result . PHP_EOL; //result=true 代表广播成功-不代表交易成功,需调用查哈希地址进行查询交易结果