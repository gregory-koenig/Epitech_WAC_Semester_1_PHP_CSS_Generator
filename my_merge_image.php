<?php
/*
**	Récupère les informations de chaque image du tableau d'images passée
**	en paramètre et les stocke dans le tableau principal
*/
function image_details(&$main_array, $array_img_path, $array_bonus)
{
	$i = 0;
	foreach ($array_img_path as $value)
	{
		$array_img = [];
		$img_png = imagecreatefrompng($value);
		$array_img['name'] = $value;
		$array_img['width'] = imagesx($img_png);
		$array_img['height'] = imagesy($img_png);
		imagedestroy($img_png);
		$array_img['position'] = $i;
		$i += $array_img['width'] + $array_bonus['padding'];
		$main_array[] = $array_img;
	}
}

/*
**	Calcule la largeur totale pour le sprite
*/
function calc_width(&$main_array, $array_bonus)
{
	$count_width = 0;
	foreach ($main_array as $value)
	{
		$count_width = $count_width + $value['width'] + $array_bonus['padding'];
	}
	$count_width -= $array_bonus['padding'];
	return $count_width;
}

/*
**	Calcule la hauteur maximale pour le sprite
*/
function calc_height(&$main_array)
{
	$count_height = 0;
	foreach ($main_array as $value)
	{
		if ($value['height'] > $count_height)
		{
			$count_height = $value['height'];
		}
	}
	return $count_height;
}

/*
**	Crée un sprite vide
*/
function create_sprite(&$main_array, &$array_img_path, $array_bonus)
{
	image_details($main_array, $array_img_path, $array_bonus);
	$sprite_width = calc_width($main_array, $array_bonus);
	$sprite_height = calc_height($main_array);
	$sprite = imagecreatetruecolor($sprite_width, $sprite_height);
	imagesavealpha($sprite, true);
	$sprite_alpha = imagecolorallocatealpha($sprite, 0, 0, 0, 127);
	imagefill($sprite, 0, 0, $sprite_alpha);
	return $sprite;
}

/*
**	Fusionne les images passées en paramètres dans un sprite, puis génère
**	un fichier PNG contenant le résultat
*/
function my_merge_image($array_img_path, $array_name, $array_bonus)
{
	$main_array = [];
	$sprite = create_sprite($main_array, $array_img_path, $array_bonus);
	foreach ($main_array as $value)
	{
		$sprite_png = imagecreatefrompng($value['name']);
		imagecopy($sprite, $sprite_png, $value['position'], 0, 0, 0,
			$value['width'], $value['height']);
		imagedestroy($sprite_png);
	}
	imagepng($sprite, $array_name['sprite']);
	imagedestroy($sprite);
}