<?php

require_once("../lib/simplehtmldom.php");

$ch = curl_init();
$options = [
	CURLOPT_RETURNTRANSFER  => true,
	CURLOPT_URL             => "http://www.google.co.jp/design/spec/style/color.html#color-color-palette",
];
curl_setopt_array($ch, $options);
$html = curl_exec ($ch);
curl_close ($ch);
unset($ch);

$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($html);
$xpath = new DOMXpath($doc);
$color_groups = $xpath->query('//section[@class="color-group"]');

$colors = [];

$i = 0;
foreach ($color_groups as $color_group) {
	foreach ($color_group->childNodes as $c1) {
		if ($c1->tagName == "ul") {
			$shade_count = 0;
			foreach ($c1->childNodes as $c2) {
				if (isset($c2->tagName) && $c2->tagName == "li") {
					foreach ($c2->childNodes as $c3) {
						if (isset($c3->tagName) && $c3->tagName == "span") {
							if (ctype_alpha(str_replace(' ', '', $c3->nodeValue))) {
								$colors[$i]["name"] = strtolower(str_replace(' ', '_', $c3->nodeValue));
							} else if (preg_match("/^(A[0-9]{3}|[0-9]{2,3})/", $c3->nodeValue)) {
								$colors[$i]["variations"][$shade_count]["shade"] = strtolower($c3->nodeValue);
							} else if (preg_match("/^#[a-zA-Z0-9]{6}/", $c3->nodeValue)) {
								$colors[$i]["variations"][$shade_count]["hex"] = $c3->nodeValue;
								$shade_count++;
							} else {}
							}
						}
				}
			}
		}
	}
	$i++;
}

//	Because who needs black and white.
unset($colors[19]);

$export = "";

foreach ($colors as $color) {
	$color_prefix = "@md_".$color["name"];
	$export .= $color_prefix.": ".$color["variations"][0]["hex"].";\n";
	foreach ($color["variations"] as $variations) {
		//	Since we don't want the color with 500 shade exported again
		if ($variations["shade"] != 500) {
			$export .= $color_prefix."_".$variations["shade"].": ".$variations["hex"].";\n";
		}
	}
}

$file = fopen("material_design_colors.less","w");
fwrite($file, $export);
fclose($file);
