<?php


	#CLEAN • Clean up STRING/ARRAY [STRING] - //TODO: improve code
 function clean($i, $tags=''){
		if(empty($tags)){
			#To strip out javascript | HTML tags | Style tags | multi-line comments
			$tags = ['@<script[^>]*?>.*?</script>@si', '@<[\ /\!]*?[^<>]*?>@si', '@<style[^>]*?>.*?</style>@siU', '@
			<![\s\S]*?--[ \t\n\r]*>@'];
		}
		if(!is_array($i)){
			$o = '';
			$o = preg_replace($tags, '', $i);
			$o = strip_tags($o);
		}
		else {
			$o = array();
			foreach ($i as $key => $v){
				$clean = preg_replace($tags, '', $v);
				$clean = strip_tags($clean);
				$o[$key] = $clean;
			}
		}
		$o = preg_replace("/&#?[a-z0-9]+;/i","", $o);
		return trim($o);
	}
