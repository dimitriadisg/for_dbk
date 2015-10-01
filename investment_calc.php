<?php

	function __autoload($which_class)
	{
		include_once 'inc/class.'.$which_class.'.inc.php';
	}
	
	function roundup($float_input)
	{
		$result = $float_input;
		if($float_input - ((int)$float_input))
		{
			$result = (int)($float_input + 1);
		}
		
		return $result;
	}
	
	//declare constants
	define("DEFAULT_INCOME", 100000.0);
	define("DEFAULT_PVALUE", 10000.0);
	define("DEFAULT_BPERCENTAGE", 1.0);
	define("DEFAULT_SURL", "webshop.nl");
	define("DEFAULT_KEYS", "");
	define("DEFAULT_MARGE", 0);
	define("DEFAULT_DIRECT", 20);
	define("DEFAULT_GOOGLE", 25);
	define("DEFAULT_ADWORDS", 35);
	define("DEFAULT_LINKS", 10);
	define("DEFAULT_UNPAID", 10);
	define("DEFAULT_ADDITIONAL", 0);
	
	
	//Input validation
	$monthly_income = DEFAULT_INCOME; //default value
	if(isset($_POST["monthly_income"]))
	{
		$monthly_income = (double)round($_POST['monthly_income'],2);
	}
	
	$product_value = DEFAULT_PVALUE; //default value
	if(isset($_POST["product_value"]))
	{
		$product_value = (double)round($_POST['product_value'],2);
	}
	
	$conversion_percentage = DEFAULT_BPERCENTAGE; //default value
	if(isset($_POST["conversion_percentage"]))
	{
		$conversion_percentage = (float)round($_POST['conversion_percentage'],2);
	}
	
	$shop_url = DEFAULT_SURL; //default value
	if(isset($_POST["shop_url"]))
	{
		$shop_url = $_POST['shop_url'];
	}
	
	$keywords = DEFAULT_KEYS; //default value
	if(isset($_POST["keywords"]))
	{
		$keywords = $_POST['keywords'];
	}
	
	$marge = DEFAULT_MARGE; //default value
	if(isset($_POST["marge"]))
	{
		$marge = $_POST["marge"];
	}
	
	$mb_percentage = 0;
	$mb_euro = 0;
	if(isset($_POST["mb_percentage"]))
	{
		$mb_percentage = round($_POST["mb_percentage"],2);
		$mb_euro = round($monthly_income*$mb_percentage/100,2);
	}
	else
	{
		if(!$marge)
		{
			$mb_percentage = 7.5;
		}
		else
		{
			$mb_percentage = 2.5;
		}
		$mb_euro = round($monthly_income*$mb_percentage/100);
	}
	
	$direct_percentage = DEFAULT_DIRECT; //default value
	if(isset($_POST["direct_percentage"]))
	{
		$direct_percentage = round($_POST["direct_percentage"],2);
	}
	
	$google_percentage = DEFAULT_GOOGLE; //default value
	if(isset($_POST["google_percentage"]))
	{
		$google_percentage = round($_POST["google_percentage"],2);
	}
	
	$adwords_percentage = DEFAULT_ADWORDS; //default value
	if(isset($_POST["adwords_percentage"]))
	{
		$adwords_percentage = round($_POST["adwords_percentage"],2);
	}
	
	$links_percentage = DEFAULT_LINKS;
	if(isset($_POST["links_percentage"]))
	{
		$links_percentage = round($_POST["links_percentage"],2);
	}
	
	$unpaid_percentage = DEFAULT_UNPAID; //default value
	if(isset($_POST["unpaid_percentage"]))
	{
		$unpaid_percentage = round($_POST["unpaid_percentage"],2);
	}
	
	$additional_percentage = DEFAULT_ADDITIONAL; //default value
	if(isset($_POST["additional_percentage"]))
	{
		$additional_percentage = round($_POST["additional_percentage"],2);
	}
	
	$strct = new Structure($shop_url,"Calculate the investment return of ".$shop_url);
	echo $strct->get_head();
	echo $strct->get_menu();
	
	//Body here
	
	$sum_percentage = $direct_percentage + $google_percentage + $adwords_percentage + $links_percentage + $unpaid_percentage + $additional_percentage;
	if($sum_percentage != 100)
	{
		print('<ul><li><span class="negative">The sum of the visitors percentages must be 100%. However it is '.$sum_percentage.'%</span></li></ul>');
	}
	
	//Get keywords virtual data
	$keys = explode(',',$keywords);
	$k_CPC = array();
	$k_volume = array();
	$total_volume = 0;
	$average_CPC = 0;
	$table_contents = "";
	
	srand(1); //make a static seed
	foreach($keys as $i => $value)
	{
		if(trim($value) != '')
		{
			$k_CPC[$i] = rand(5, 30)/10.0;
			$k_volume[$i] = rand(0,200000000);
			$average_CPC += $k_CPC[$i]*$k_volume[$i];
			$total_volume += $k_volume[$i];
			$table_contents .= 
			'
			<tr>
				<td>'.$value.'</td>
				<td>&euro;'.$k_CPC[$i].'</td>
				<td>'.$k_volume[$i].'</td>
			</tr>
			';
		}
	}
	if($i>0)
	{
		$average_CPC = round($average_CPC/$total_volume, 2);
	}
	
	$orders_demand = (int)($monthly_income/$product_value);
	$visitors = roundup($orders_demand/($conversion_percentage/100.0));
	$adwords_visitors = roundup($adwords_percentage/100.0 * $visitors);
	$volume_of_interest = (int)($total_volume/10);
	$adwords_message = "";
	$possibility = "";
	
	if($adwords_visitors < $volume_of_interest)
	{
		$adwords_message = "possible!";
		$possibility = "positive";
	}
	else
	{
		$adwords_message = "not possible.";
		$possibility = "negative";
	}
	
	$buyers_percentage = $adwords_percentage + $links_percentage;
	$buying_visitors = round($visitors*$buyers_percentage/100);
	$budget_per_visitor = round($mb_euro/$buying_visitors,2);
	$budget_message = "";
	$sufficiency = "";

	if($budget_per_visitor >= $average_CPC)
	{
		$budget_message = "sufficient!";
		$sufficiency = "positive";
	}
	else
	{
		$budget_message = "not sufficient.";
		$sufficiency = "negative";
	}
	
	$forms = new Forms();
	
	print
	('
		<form method="POST">
			<div class="options">
				Conversion percentage<br>
				'.$forms->percentage_input("conversion_percentage", $conversion_percentage, DEFAULT_BPERCENTAGE).'
			</div>
			
			<div class="options">
				<img class="small_image" src="https://cloud.githubusercontent.com/assets/14919500/10214555/0c857cc6-6822-11e5-82fb-2faf3e8b7822.png"></img>
			</div>
			
			<div class="options">
				Least-orders demand<br>
				<span class="big number_of_interest">'.$orders_demand.'</span>
			</div>
			
			<div class="options">
				<img class="small_image" src="https://cloud.githubusercontent.com/assets/14919500/10214555/0c857cc6-6822-11e5-82fb-2faf3e8b7822.png"></img>
			</div>
			
			<div class="options">
				Average product value<br>
				'.$forms->euro_input("product_value", $product_value, DEFAULT_PVALUE).'
			</div>
			
			<div class="options">
				<img class="small_image" src="https://cloud.githubusercontent.com/assets/14919500/10214555/0c857cc6-6822-11e5-82fb-2faf3e8b7822.png"></img>
			</div>
			
			<div class="options">
				Aimed income per month<br>
				'.$forms->euro_input("monthly_income", $monthly_income, DEFAULT_INCOME).'
			</div>
			
			<div class="options">
				<img class="square_image" src="https://cloud.githubusercontent.com/assets/14919500/10214558/0ccce868-6822-11e5-8a9e-d83bbb2af91a.png"></img>
			</div>
			
			<br>
			<div class="options">
				<img class="wide_image" src="https://cloud.githubusercontent.com/assets/14919500/10214562/0cd8f996-6822-11e5-9a88-4ccdd8311664.png"></img>
			</div>
			
			<div class="options">
				Marge '.$forms->marge_selector("marge", $marge, "marge_relation(this);").'<br>
				<img class="square_image rotate270" src="https://cloud.githubusercontent.com/assets/14919500/10214555/0c857cc6-6822-11e5-82fb-2faf3e8b7822.png"></img>
			</div>
			
			<br>
			<div class="options">
				<div class="options">
					Direct:<br>
					Google:<br>
					Adwords:<br>
					Link Referals: <br>
					Unpaid: <br>
					Additional: <br>
				</div>
				
				<div class="options">
					'.$forms->percentage_input("direct_percentage", $direct_percentage, DEFAULT_DIRECT).'<br>
					'.$forms->percentage_input("google_percentage", $google_percentage, DEFAULT_GOOGLE).'<br>
					'.$forms->percentage_input("adwords_percentage", $adwords_percentage, DEFAULT_ADWORDS).'<br>
					'.$forms->percentage_input("links_percentage", $links_percentage, DEFAULT_LINKS).'<br>
					'.$forms->percentage_input("unpaid_percentage", $unpaid_percentage, DEFAULT_UNPAID).'<br>
					'.$forms->percentage_input("additional_percentage", $additional_percentage, DEFAULT_ADDITIONAL).'<br>
				</div>
				
				<div class="options">
					<img class="vertical_image" src="https://cloud.githubusercontent.com/assets/14919500/10214557/0cc66ef2-6822-11e5-9704-bef5a5101fb3.png"></img>
				</div>
				
				<div class="options big visitors_indicator">
					<span class="number_of_interest">'.$visitors.'</span><br>
					Visitors
				</div>
			</div>
			<div class="options bordered">
				<p>'.$adwords_percentage.'% of the '.$visitors.' visitors is '.$adwords_visitors.'.
				With the defined search options it is possible to achieve '.$volume_of_interest.' visitors.<br>
				<span class="'.$possibility.'">As a result, the scenario is '.$adwords_message.'</span></p>
			</div>
			<div class="options right_end">
				Marketing budget<br>
				'.$forms->percentage_input("mb_percentage", $mb_percentage, -1, "mb_percentage_relation(this);").' = 
				'.$forms->euro_input("mb_euro", $mb_euro, -1, "mb_euro_relation(this);").'
				<img class="square_image rotate270" src="https://cloud.githubusercontent.com/assets/14919500/10214555/0c857cc6-6822-11e5-82fb-2faf3e8b7822.png"></img><br>
				Average CPC is<br>
				<span class="big">&euro;'.$mb_euro.'/'.$buying_visitors.' visitors</span><br>
				<span class="number_of_interest">'.$budget_per_visitor.' budget per visitor</span><br>
				<div class="bordered">
					<p>The average CPC of the search keywords is &euro;'.$average_CPC.'<br>
					<span class="'.$sufficiency.'">As a result, your budget is '.$budget_message.'</span></p>
				</div>
			</div>
			
			<br>
			<div class="options">
				<img class="square_image" src="https://cloud.githubusercontent.com/assets/14919500/10214556/0caf8282-6822-11e5-812c-216c42176cc2.png"></img>
			</div>
			
			<div class="options paragraph">
				<p>Buying traffic corresponds to '.$adwords_percentage.'% from Adwords and '.$links_percentage.'% from links.<br><span class="big">Total '.$buyers_percentage.'%</span></p>
			</div>
			
			<div class="options">
				<img class="small_image rotate180" src="https://cloud.githubusercontent.com/assets/14919500/10214555/0c857cc6-6822-11e5-82fb-2faf3e8b7822.png"></img>
			</div>
			
			<div class="options paragraph">
				The '.$buyers_percentage.'% of the '.$visitors.' visitors is <span class="number_of_interest">'.$buying_visitors.'</span> buying visitors.
			</div>
			
			<div class="options">
				<img class="small_image rotate180" src="https://cloud.githubusercontent.com/assets/14919500/10214555/0c857cc6-6822-11e5-82fb-2faf3e8b7822.png"></img>
			</div>
			<br>
			<br>
			<br>
			<br>
			<div class="centered_submit">
				'.$forms->hidden("keywords", $keywords).'
				'.$forms->submit("Re-process input").'
			</div>
		</form>
		<br>
		<table class="keywords_table">
			<tr>
				<th>Search data</th>
				<th>Average CPC</th>
				<th>Search volume</th>
			</tr>
			'.$table_contents.'
			<tr class="big">
				<td>Total</td>
				<td>&euro;'.$average_CPC.'</td>
				<td>'.$total_volume.'</td>
			</tr>
		</table>
	');
	
	//End body
	
	echo $strct->get_footer();
?>
