<?php

function remover_caracter($string) {
   $string = preg_replace("/[áàâãä]/", "a", $string);
   $string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
   $string = preg_replace("/[éèê]/", "e", $string);
   $string = preg_replace("/[ÉÈÊ]/", "E", $string);
   $string = preg_replace("/[íì]/", "i", $string);
   $string = preg_replace("/[ÍÌ]/", "I", $string);
   $string = preg_replace("/[óòôõö]/", "o", $string);
   $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
   $string = preg_replace("/[úùü]/", "u", $string);
   $string = preg_replace("/[ÚÙÜ]/", "U", $string);
   $string = preg_replace("/ç/", "c", $string);
   $string = preg_replace("/Ç/", "C", $string);
   $string = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", "", $string);
   //$string = preg_replace("/ /", "_", $string);
   return $string;
}

function alterarCaracter($string){
	
   $string = preg_replace("/[á]/","&aacute;",$string);
   $string = preg_replace("/[à]/","&agrave;",$string);
   $string = preg_replace("/[ã]/","&atilde;",$string);
   $string = preg_replace("/[ä]/","&auml;",$string);
   $string = preg_replace("/[â]/","&acirc;",$string);	
   $string = preg_replace("/[Á]/","&Aacute;",$string);
   $string = preg_replace("/[À]/","&Agrave;",$string);
   $string = preg_replace("/[Ã]/","&Atilde;",$string);
   $string = preg_replace("/[Ä]/","&Auml;",$string);
   $string = preg_replace("/[Â]/","&Acirc;",$string);	
   
   $string = preg_replace("/[é]/","&eacute;",$string);
   $string = preg_replace("/[è]/","&egrave;",$string);
   $string = preg_replace("/[ê]/","&ecirc;",$string);	
   $string = preg_replace("/[É]/","&Eacute;",$string);
   $string = preg_replace("/[È]/","&Egrave;",$string);
   $string = preg_replace("/[Ê]/","&Ecirc;",$string);
   
   $string = preg_replace("/[í]/", "&iacute;", $string);
   $string = preg_replace("/[ì]/", "&igrave;", $string);
   $string = preg_replace("/[Í]/", "&Iacute;", $string);
   $string = preg_replace("/[Ì]/", "&Igrave;", $string);
   
   $string = preg_replace("/[ó]/","&aacute;",$string);
   $string = preg_replace("/[ò]/","&agrave;",$string);
   $string = preg_replace("/[õ]/","&atilde;",$string);
   $string = preg_replace("/[ö]/","&auml;",$string);
   $string = preg_replace("/[ô]/","&ocirc;",$string);
   $string = preg_replace("/[Ó]/","&Oacute;",$string);
   $string = preg_replace("/[Ò]/","&Ograve;",$string);
   $string = preg_replace("/[Õ]/","&Otilde;",$string);
   $string = preg_replace("/[Ö]/","&Ouml;",$string);
   $string = preg_replace("/[Ô]/","&Ocirc;",$string);
   
   $string = preg_replace("/[ú]/","&uacute;",$string);
   $string = preg_replace("/[ù]/","&ugrave;",$string);
   $string = preg_replace("/[ü]/","&uuml;",$string);
   $string = preg_replace("/[Ú]/","&Uacute;",$string);
   $string = preg_replace("/[Ù]/","&Ugrave;",$string);
   $string = preg_replace("/[Ü]/","&Uuml;",$string);
   
   $string = preg_replace("/[ç]/","&ccedil;",$string);
   $string = preg_replace("/[Ç]/","&Ccedil;",$string);
   return $string;
}

?>