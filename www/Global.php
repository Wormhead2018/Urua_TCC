<?php
function getParam($param) {
	if (isset ($_GET [$param]))
		return $_GET [$param];
	if (isset ($_POST [$param]))
		return $_POST [$param];
	if (isset ($_REQUEST [$param]))
		return $_REQUEST [$param];	
	
	return null;
}
?>