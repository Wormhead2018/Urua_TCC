<?php

header ( 'Content-Type: text/html: charset=utf-8');
header ( 'Expires: Sat, 26 Jun 1997 05:00:00 GMT');
header ( 'Last-Modified: ' .gmdate ('D, d M Y H:i:s' ) . ' GMT' );
header ( 'Cache-Control: no-store, no-cache, must-revalidate');
header ( 'Cache-Control: post-check=0, pre-check=0' ,false);
header ( 'Pragma: no-cache');

require_once 'Global.php';

$param = getParam('param');

if ($param!=null)
{
	switch ($param)	
	{
		case 'incluir';
			$nome=getParam('nome');
			$email=getParam('email');
			$senha=getParam('senha');
			echo CUsuario::incluir($nome, $email, $senha);
			break;
			
		case 'efetuarLogin';
			$email=getParam('email');
			$senha=getParam('senha');
			echo CUsuario::efetuarLogin($email, $senha);
			break;
			
		default :
			break;
	}
}
class CUsuario{
		public static function incluir ($nome, $email, $senha)
		{
			require_once 'MySQLDC.php';
			$query = "call SP_INCLUIRUSUARIO('$nome', '$email', '$senha');";
			$mysql = new MySQLDC();
			$result = $mysql->execSPForInsUpd($query);
			
			if ($result) {
				return '{"data" :' . $result .'}';
				
			} else {
				return '{"data":"-1"}';
			}
		}
		
		public static function efetuarLogin ($email, $senha)
		{
			require_once 'MySQLDC.php';
			
			$query = "call SP_LOGIN('$email', '$senha');";
			
			$mysql = new MySQLDC();
			
			$result = $mysql->execSPForDataSet($query);
			
			$JSON = json_encode ($result);
			
			if($JSON =="null"){
				$JSON="[]";
			}
			//return $JSON;
			return  '{"data":' . $JSON . '}';
		}
}
			
?>			
			
		
		