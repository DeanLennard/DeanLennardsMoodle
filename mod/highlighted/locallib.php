<?php

/**
 * @package    mod
 * @subpackage highlighted
 * @copyright  2012 onwards Dean Lennard (PsyberPixie) {@link http://www.lawfullychaotic.co.uk}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class highlighted_keywords{
	public function highlight($text, $keywords){
		$words = explode(',', $keywords);
		foreach($words as $word){
			$replace[] = '<span class="keyword">'.$word.'</span>';
		}
		$content = str_replace($words, $replace, $text);
		return $content;
	}
}
