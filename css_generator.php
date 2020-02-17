<?php
require 'my_scandir.php';
require 'my_merge_image.php';
require 'my_generate_css.php';
require 'my_bonus.php';

/*
**	Détermine le type de scan suivant l'option correspondante
*/
function scandir_option($dir_path, $my_scandir, &$array_img_path)
{
	if ($my_scandir == false)
	{
		if (is_dir($dir_path))
		{
			my_recursive_scandir($dir_path, $array_img_path);
		} else {
			throw new Exception("le dossier n'existe pas.\n");
		}
	} else {
		my_scandir($dir_path, $array_img_path);
	}
}

/*
**	Modifie le nom par défaut du sprite
*/
function sprite_name($argv, $key, $value, &$array_name)
{
	if ($value == '-i')
	{
		$array_name['sprite'] = $argv[$key + 1];
	}
	elseif (substr($value, 0, 15) == '--output-image=')
	{
		$array_name['sprite'] = substr($argv[$key], 15);
	}
}

/*
**	Modifie le nom par défaut du fichier CSS
*/
function css_name($argv, $key, $value, &$array_name)
{
	if ($value == '-s')
	{
		$array_name['css'] = $argv[$key + 1];
	}
	elseif (substr($value, 0, 15) == '--output-style=')
	{
		$array_name['css'] = substr($argv[$key], 15);
	}
}

/*
**	Gère les options et lance les fonctions idoines
*/
function options($argv, &$my_scandir, &$array_name)
{
	foreach ($argv as $key => $value)
	{
		if ($value == '-r' || $value == '--recursive')
		{
			$my_scandir = false;
		}
		if ($value == '-i' || substr($value, 0, 15) == '--output-image=')
		{
			sprite_name($argv, $key, $value, $array_name);
		}
		if ($value == '-s' || substr($value, 0, 15) == '--output-style=')
		{
			css_name($argv, $key, $value, $array_name);
		}
	}
}

/*
**	Lance toutes les fonctions et gère les options et les erreurs
*/
function css_generator($argv)
{
	$dir_path = end($argv);
	$my_scandir = true;
	$array_img_path = [];
	$array_name = ['sprite' => 'sprite.png', 'css' => 'style.css'];
	$array_bonus = ['padding' => 0, 'resize' => 0, 'columns' => 0];
	try
	{
		options($argv, $my_scandir, $array_name);
		scandir_option($dir_path, $my_scandir, $array_img_path);
		my_bonus($argv, $array_bonus);
		my_merge_image($array_img_path, $array_name, $array_bonus);
		my_generate_css($array_img_path, $array_name, $array_bonus);
	}
	catch (Exception $e)
	{
		echo 'Message d\'erreur : ', $e->getMessage();
	}
}

css_generator($argv);