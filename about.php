<?php

	//Specify a fixed way to identify custom classes
	function __autoload($which_class)
	{
		include_once 'inc/class.'.$which_class.'.inc.php';
	}
	
	include 'inc/helpers.php';
	
	//Print the page's head and menu (same for all pages of this webplace)
	$strct = new Structure("About","Some information you might be interested in about me.");
	echo $strct->get_head();
	echo $strct->get_menu();
	
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
	
	//Print the page's footer (same for all pages of this webplace)
	echo $strct->get_footer();
?>
