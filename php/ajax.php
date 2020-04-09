<?php
if(file_exists("php/ajax/$action.php")) {
	
	include "php/ajax/$action.php";
} else {
	echo "error";
}
exit();