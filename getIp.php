<?php
/**
 * ��ȡ�û���ʵ IP
 */
function getIP()
{
    static $realip;
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
 
 
    return $realip;
}

/**
 * ��ȡ IP  ����λ��
 * �Ա�IP�ӿ�
 * @Return: array
 */
function getCity($ip)
{
$url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
$ip=json_decode(file_get_contents($url)); 
if((string)$ip->code=='1'){
  return false;
  }
  $data = (array)$ip->data;
return $data; 
}

$ip=getIP();
//echo $ip;
//echo $_SERVER['HTTP_USER_AGENT'];
//echo $_SERVER['REMOTE_ADDR'];
//echo $_SERVER['REMOTE_HOST'];

$sheng="";
$city="";

if($ip !=null && $ip !=""){
	if(strpos($ip,':')){
		$ip = substr($ip,0,strpos($ip,':'));
	}
	$addr = getCity($ip);
	if($addr){
		$sheng = $addr['region'];
		$city = $addr['city'];
	}

	$fp = fopen("files/logtrace.txt",'a');
	fwrite($fp, $ip . " ". $_SERVER['HTTP_USER_AGENT'] . $sheng . $city . "\r\n");
	fclose($fp);
}



	//$addr = getCity("123.138.79.29");
	//if($addr){
		//foreach ($addr as $key=>$value){
		//	echo $key." - ".$value."<br/>";
		//}
	//	echo $addr['region'];
	//	echo $addr['city'];
	//}
