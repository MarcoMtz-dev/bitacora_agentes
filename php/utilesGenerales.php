<?php
require_once 'conexiones.php';

function sanitizedString($str){

    $strResp = accentReplacer( $str );
    $strResp = delQuotes( $strResp );

    return $strResp;
}
function accentReplacer($str){
    $pattern = ['/á/','/é/','/í/','/ó/','/ú/','/Á/','/É/','/Í/','/Ó/','/Ú/','/ñ/','/Ñ/'];
    $replacers = ['a','e','i','o','u','A','E','I','O','U','n','N'];
    
    return preg_replace($pattern, $replacers, $str );
}
function delQuotes($str){
    $regex = '/(\'|\"|\|)/';
    return preg_replace( $regex, '', $str);
}