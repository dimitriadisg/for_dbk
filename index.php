<?php

	function __autoload($which_class)
	{
		include_once 'inc/class.'.$which_class.'.inc.php';
	}
	
	$strct = new Structure("Ad-marketting","Welcome to our FREE investment calculator tool !");
	echo $strct->get_head();
	echo $strct->get_menu();
	
	//Body here
	
	print('<h1 class="subheader">Calculate the investment\'s return</h1>');
	print('<br>');
	
	print
		('
			<div class="options big">
				Aimed income per month: <br>
				Average product value: <br>
				Conversion percentage: <br>
				URL webshop: <br>
				Search data: <br>
			</div>
		');
	
	$forms_builder = new Forms();
	print
		('
			<div class="options big">
				<form method="POST" action="./investment_calc.php">
		');
	print
		(
			$forms_builder->euro_input("monthly_income","100000","100000").' marge'.$forms_builder->marge_selector("marge",0).'<br>'.
			$forms_builder->euro_input("product_value","10000","10000").'<br>'.
			$forms_builder->percentage_input("conversion_percentage","1","1").'<br>'.
			$forms_builder->text_input("shop_url","webshop.nl").'<br>'.
			$forms_builder->textarea("keywords","").'<br>'.
			'<br>'.$forms_builder->submit("Proceed to calculator").'
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
	
	echo $strct->get_footer();
?>
