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
			$idusuario=getParam('idusuario');
			$placar=getParam('placar');
			echo CPartida::incluir($idusuario, $placar);
			break;
			
		default:
			break;
			
	}
}

class CPartida{
		public static function incluir($idusuario, $placar)
		{
			require_once 'MySQLDC.php';
			
			$query = "call SP_INCLUIRPARTIDA($idusuario, $placar);";
			
			$mysql = new MySQLDC();
			$result = $mysql->execSPForInsUpd($query);
			
			if ($result) {
				return $result;
			} else {
				return -1;
			}
		}
}
?>
			