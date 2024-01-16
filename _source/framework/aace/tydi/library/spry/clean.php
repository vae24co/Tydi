<?php
/*** CLEAN ~ CLEAN Constant » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

const CLEAN_STRING = [
	// Strip out JS
	'@<script[^>]*?>.*?</script>@si',

	// Strip out HTML tags
	'@<[\ /\!]*?[^<>]*?>@si',

	// Strip style tags properly
	'@<style[^>]*?>.*?</style>@siU',

	// Strip multi-line comments
	'@<![\s\S]*?--[ \t\n\r]*>@'
];