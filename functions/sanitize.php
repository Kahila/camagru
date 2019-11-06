<?php

function escape($string)
{
	//echo "inside here init \n";
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}
?>