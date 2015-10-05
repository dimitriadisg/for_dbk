<?php

	//Specify a fixed way to identify custom classes
	function __autoload($which_class)
	{
		include_once 'inc/class.'.$which_class.'.inc.php';
	}
	
	include 'inc/helpers.php';
	
	//Print the page's head and menu (same for all pages of this webplace)
	$strct = new Structure("Ad-marketting","Welcome to our FREE investment calculator tool !");
	echo $strct->get_head();
	echo $strct->get_menu();
	
	//Body here
	
	/*
	** We have only front-end development here, the code is pretty straight forward,
	** just create the prefered elements to fill the form and print them.
	** Note: the names used here are the same as the names on the redirect page to
	** keep things simple.
	*/
	$forms = new Forms();
	
	print('<h1 class="subheader">Calculate the investment\'s return</h1>');
	print('<br>');
	
	print
		('
			<div class="options big">
				'.$forms->label("monthly_income","Aimed income per month:").' <br>
				'.$forms->label("product_value","Average product value:").' <br>
				'.$forms->label("conversion_percentage","Conversion percentage:").' <br>
				'.$forms->label("shop_url","URL webshop:").' <br>
				'.$forms->label("keywords","Search data:").' <br>
			</div>
		');
	
	print
		('
			<div class="options big">
				<form method="POST" autocomplete="off" action="./investment_calc.php">
		');
	print
		(
			$forms->euro_input("monthly_income",DEFAULT_INCOME,DEFAULT_INCOME).' '.$forms->label("marge","marge").$forms->marge_selector("marge",0).'<br>'.
			$forms->euro_input("product_value",DEFAULT_PVALUE,DEFAULT_PVALUE).'<br>'.
			$forms->percentage_input("conversion_percentage",DEFAULT_CPERCENTAGE,DEFAULT_CPERCENTAGE).'<br>'.
			$forms->text_input("shop_url",DEFAULT_SURL,DEFAULT_SURL).'<br>'.
			$forms->textarea("keywords",DEFAULT_KEYS).'<br>'.
			'<br>'.$forms->submit("Proceed to calculator").'
				</form>
			</div>
		');
	
	print
		('
			<div class="options">
				<br>
				<br>
				*leave it at 1% if you are unsure about this<br>
				<br>
				<br>
				*seperate keywords with a comma (,)
			</div>
		');
	//End body
	
	//Print the page's footer (same for all pages of this webplace)
	echo $strct->get_footer();
?>
