<?php
require_once 'my_merge_image.php';

/*
**	Supprime le chemin pour ne conserver que le nom de l'image accompagnée de
**	son extension
*/
function cut_img_path(&$img_name)
{
	if (preg_match('#/#', $img_name))
	{
		$img_name = strpbrk($img_name, '/');
		$img_name = substr($img_name, 1);
		cut_img_path($img_name);
	}
}

/*
**	Supprime l'extension pour ne garder que le nom de l'image
*/
function cut_img_name($img_path)
{
	cut_img_path($img_path);
	$img_name = strrev($img_path);
	$img_name = strpbrk($img_name, '.');
	$img_name = strrev($img_name);
	$img_name = substr($img_name, 0, -1);
	return $img_name;
}

/*
**	Remplit le fichier CSS passé en paramètre
*/
function fill_css(&$main_array, $array_name)
{
	$i = 0;
	$position = 0;
	$array_length = count($main_array) - 1;
	foreach ($main_array as $key => $value)
	{
		if ($i != 0) {
			$position = '-' . $value['position'] . 'px';
		}
		$i++;
		$img_class = cut_img_name($value['name']);
		$string = "." . $img_class . "\n" . "{\n"
				. "\tbackground-image: url('" . $array_name['sprite'] . "');\n"
				. "\tbackground-repeat: no-repeat;\n"
				. "\tbackground-position: " . $position . " 0;\n"
				. "\twidth: " . $value['width'] . "px;\n"
				. "\theight: " . $value['height'] . "px;\n" . "}";
		if ($array_length != $key)
		{
			$string .= "\n\n";
		}
		file_put_contents($array_name['css'], $string, FILE_APPEND);
	}
}

/*
**	Lance les fonctions ci-dessus et génère un fichier CSS
*/
function my_generate_css($array_path_img, $array_name, $array_bonus)
{
	$main_array = [];
	image_details($main_array, $array_path_img, $array_bonus);
	$css_file_name = fopen($array_name['css'], 'w+');
	fill_css($main_array, $array_name);
	fclose($css_file_name);
}