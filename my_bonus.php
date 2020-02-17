<?php
/*
**	Modifie le padding entre les images dans le sprite
*/
function sprite_padding ($argv, $key, $value, &$array_bonus)
{
	if ($value == '-p' || substr($value, 0, 10) == '--padding=')
	{
		if ($value == '-p')
		{
			$array_bonus['padding'] = intval($argv[$key + 1]);
		}
		elseif (substr($value, 0, 10) == '--padding=')
		{
			$array_bonus['padding'] = intval(substr($argv[$key], 10));
		}
	}
}

/*
**	Modifie les dimensions des images dans le sprite
*/
function sprite_resize($argv, $key, $value, &$array_bonus)
{
	if ($value == '-o' || substr($value, 0, 16) == '--override-size=')
	{
		if ($value == '-o')
		{
			$array_bonus['resize'] = intval($argv[$key + 1]);
		}
		elseif (substr($value, 0, 16) == '--override-size=')
		{
			$array_bonus['resize'] = intval(substr($argv[$key], 16));
		}
	}
}

/*
**	Détermine le nombre d'images affichées horizontalement dans le sprite
*/
function sprite_columns($argv, $key, $value, &$array_bonus)
{
	if ($value == '-c' || substr($value, 0, 17) == '--columns_number=')
	{
		if ($value == '-c')
		{
			$array_bonus['columns'] = intval($argv[$key + 1]);
		}
		elseif (substr($value, 0, 17) == '--columns_number=')
		{
			$array_bonus['columns'] = intval(substr($argv[$key], 17));
		}
	}
}

/*
**	Gère les options bonus
*/
function my_bonus($argv, &$array_bonus)
{
	foreach ($argv as $key => $value)
	{
		sprite_padding($argv, $key, $value, $array_bonus);
		sprite_resize($argv, $key, $value, $array_bonus);
		sprite_columns($argv, $key, $value, $array_bonus);
	}
}