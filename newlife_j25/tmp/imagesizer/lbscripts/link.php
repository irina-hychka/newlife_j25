<?PHP
/*------------------------------------------------------------------------
# link.php for PLG - SYSTEM - IMAGESIZER
# ------------------------------------------------------------------------
# author    reDim - Norbert Bayer
# copyright (C) 2011 redim.de. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.redim.de
# Technical Support:  Forum - http://www.redim.de/kontakt/
-------------------------------------------------------------------------*/
defined( '_JEXEC' ) or die( 'Restricted access' );

function ImageSizer_addon_GetImageHTML(&$ar,&$img,&$imagesizer){


	$output=plgSystemimagesizer::make_img_output($ar);

	if(isset($ar["title"])){
		$title=' title="'.$ar["title"].'"';
	}else{
		$title="";
	} 

	$output='<a class="'.$imagesizer->params->get("linkclass","linkthumb").'" target="_blank"'.$title.' href="'.$ar["href"].'"><img '.$output.' /></a>';	
	
	return $output;

}

