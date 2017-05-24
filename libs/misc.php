<?php

//Calculo el timestamp del servidor.
function timestamp()
{
	$fecha = date_create();
	return date_timestamp_get($fecha);
}

//Extraer extension
function extraer_tipo($nombre)
{
	$tmp = explode(".", $nombre);
	return end($tmp);	
}

//Tipo compatible de archivo de imagen.
function formato_imagen($formato)
{
	$permitidos = array("gif", "jpeg", "jpg", "png");
	
	if (in_array($formato, $permitidos))
		return true;
	else
		return false;	
}

//Remplaza caracteres a los caracteres html.
function corregir_html($txt)
{
	$txt = str_replace("á", "&aacute;", $txt);
	$txt = str_replace("é", "&eacute;", $txt);
	$txt = str_replace("í", "&iacute;", $txt);
	$txt = str_replace("ó", "&oacute;", $txt);
	$txt = str_replace("ú", "&uacute;", $txt);
	$txt = str_replace("Á", "&Aacute;", $txt);
	$txt = str_replace("É", "&Eacute;", $txt);
	$txt = str_replace("Í", "&Iacute;", $txt);
	$txt = str_replace("Ó", "&Oacute;", $txt);
	$txt = str_replace("Ú", "&Uacute;", $txt);
	$txt = str_replace("ñ", "&ntilde;", $txt);
	$txt = str_replace("Ñ", "&Ntilde;", $txt);	
	
	return $txt; 
}

//Limpiar caracteres
function limpiar($str)
{
    $str= str_replace("'", "&#39;", $str);
    $str= str_replace('"', "&#34;", $str);
    $str= str_replace(";", "&#59;", $str);
    $str= str_replace("<", "&#60;", $str);
    $str= str_replace(">", "&#62;", $str);
    $str= str_replace("drop", "&#100;&#114;&#111;&#112;", $str);
    $str= str_replace("javascript", "&#106;&#97;&#118;&#97;&#115;&#99;&#114;&#105;&#112;&#116;", $str);
    $str= str_replace("script", "&#118;&#98;&#115;&#99;&#114;&#105;&#112;&#116;", $str);
    $str= str_replace("vbscript", "&#115;&#99;&#114;&#105;&#112;&#116;", $str);
    return $str;
}

//Redireccionar
function redireccionar($delay,$url)
{
	echo "<meta http-equiv='Refresh' content='".$delay.";url=".$url."'>";	
}

?>