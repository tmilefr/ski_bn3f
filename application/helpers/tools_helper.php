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
?>
