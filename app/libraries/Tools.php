<?php

class Tools {
	public static function permalink($title)
	{
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $title);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
		return $clean;
	}


	public static function string_convert($title)
	{
		$clean = preg_replace("/[^a-zA-Z0-9\/_|.+ -]/", '', $title);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
		return $clean;
	}

}