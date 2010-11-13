<?php
require 'markdown.php';

preg_match_all('/{{{(.*)}}}/sU', file_get_contents('data.txt'), $matches);

if (!empty($matches[1])) {
	$data = array();
	foreach ($matches[1] as $item) {
		$tags_content = explode(PHP_EOL, $item, 2);
		$tags = $tags_content[0];
		$content = $tags_content[1];
		foreach(explode(' ', $tags) as $tag) {
			if (empty($tag))
				continue;
			$data[$tag][] = markdown($content)."<br />tag: ".$tags;
		}
	}
}

uasort($data, function($a, $b){
	return (count($a) > count($b)) ? 0 : 1;
});

$data = json_encode($data);

require 'view.php';