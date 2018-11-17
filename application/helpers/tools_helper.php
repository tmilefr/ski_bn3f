<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('PassWordGenerator'))
{
	function PassWordGenerator($numAlpha=6){
		$listAlpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$listNonAlpha = ':!.*-+&@_+$-!';
		return substr(str_shuffle($listNonAlpha),0,1).substr(str_shuffle($listAlpha),0,$numAlpha).substr(str_shuffle($listNonAlpha),0,1);
	}
}

/**
 * Returns a human readable filesize
 *
 * @author      wesman20 (php.net)
 * @author      Jonas John
 * @version     0.3
 * @link        http://www.jonasjohn.de/snippets/php/readable-filesize.htm
 */
if ( ! function_exists('HumanReadableFilesize'))
{
	function HumanReadableFilesize($size, $unit = true) {
	 
		// Adapted from: http://www.php.net/manual/en/function.filesize.php
	
		$mod = 1024;
	 
		$units = explode(' ','B KB MB GB TB PB');
		for ($i = 0; $size > $mod; $i++) {
			$size /= $mod;
		}
	 
		return round($size, 2) .(($unit) ? ' ' . $units[$i]:'');
	}
}

if ( ! function_exists('NameToFilename'))
{
	function NameToFilename($name) {
		return str_replace(['\\',' ','/',','],['_','_','_','_'] ,$name);
	}
}



if ( ! function_exists('GetFormatDate'))
{
	function GetFormatDate($date,$mode = 'view',$notime = true){ //TODO : helper or in FormElement ? # Add by nL for WideVoip : 2013-04-19
		if ($date != '0000-00-00'){
			$regex_fr  = '`([0-9]{1,2})[-\/ \.]?([0-9]{1,2})[-\/ \.]?([0-9]{4})(.*)`';
			$regex_eng = '`([0-9]{4})[-\/ \.]?([0-9]{1,2})[-\/ \.]?([0-9]{1,2})(.*)`';

			$regex = $regex_fr;
			$format_bdd = '\\3-\\2-\\1 \\4';
			if ($notime){
				$format_vue = '\\1/\\2/\\3';
			} else {
				$format_vue = '\\1/\\2/\\3 \\4';
			}
			
			if (preg_match($regex_eng, $date, $array_date)){
				$regex = $regex_eng;
				$format_bdd = '\\1-\\2-\\3 \\4';
				if ($notime){
					$format_vue = '\\3/\\2/\\1';
				} else {
					$format_vue = '\\3/\\2/\\1 \\4';
				}
			}
			switch($mode){
				case 'bdd':
					return  preg_replace($regex, $format_bdd, $date);
				break;
				case 'view':
					return  preg_replace($regex, $format_vue, $date);
				break;
			}
		}	
	}	
}
?>
