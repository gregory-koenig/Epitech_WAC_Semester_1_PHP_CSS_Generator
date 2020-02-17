<?php
/*
**	Stocke dans un tableau les fichiers PNG contenus uniquement dans le dossier
**	passé en paramètre
*/
function my_scandir($dir_path, &$array_img_path)
{
	if (is_dir($dir_path) && $handle = opendir($dir_path))
	{
		while (($entry = readdir($handle)) !== false)
		{
			if (($entry != '.' && $entry != '..')
				&& (preg_match('#.png#', $entry)))
			{
				$array_img_path[] = $dir_path . '/' . $entry;
			}
		}
		closedir($handle);
	} else {
		throw new Exception("le dossier n'existe pas.\n");
	}
}

/*
**	Stocke dans un tableau les fichiers PNG contenus dans le dossier passé
**	en paramètre ainsi que dans tous ses sous-dossiers
*/
function my_recursive_scandir($dir_path, &$array_img_path)
{
	if (is_dir($dir_path) && $handle = opendir($dir_path))
	{
		while (($entry = readdir($handle)) !== false)
		{
			if ($entry != '.' && $entry != '..')
			{
				if (preg_match('#.png#', $entry))
				{
					$array_img_path[] = $dir_path . '/' . $entry;
				}
				my_recursive_scandir($dir_path . '/' . $entry, $array_img_path);
			}
		}
		closedir($handle);
	}
}