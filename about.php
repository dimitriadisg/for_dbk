<?php

	function __autoload($which_class)
	{
		include_once 'inc/class.'.$which_class.'.inc.php';
	}
	
	$strct = new Structure("About","Some information you might be interested in about me.");
	echo $strct->get_head();
	echo $strct->get_menu();
	
	define("MY_SKYPE","dimitriadis.h.george");
	define("MY_MAIL","dimitriadisg@outlook.com");
	define("GITHUB_HOME","https://github.com/");
	define("MY_GITHUB","dimitriadisg");
	
	//Body here
	print
	('
		<p class="big"> Hello, this tool is built in accordance to DBK\'s <a href="http://omgekeerderoi.nl/">Omgekeerde</a>.
		If you need any help, feel free to contact me through the following means:<p>
		<br>
		<br>
		<div class="options">
			Skype:<br>
			E-mail:<br>
			Github:
		</div>
		<div class="options">
			<span class="number_of_interest">'.MY_SKYPE.'<br>
			'.MY_MAIL.'<br>
			<a href="'.GITHUB_HOME.MY_GITHUB.'">'.MY_GITHUB.'</a>
		</div>
	');
	//End body
	
	echo $strct->get_footer();
?>
