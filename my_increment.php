<?php
function my_increment($int)
{
	static $i = 0;
	if ($i <= 10)
	{
		$i++;
		my_increment($int + 1);
	}
}