<?php

	//Specify a fixed way to identify custom classes
	function __autoload($which_class)
	{
		include_once 'inc/class.'.$which_class.'.inc.php';
	}
	
	include 'inc/helpers.php';
	
	//Input validation
	caa_homonymous_fi($monthly_income, "monthly_income", DEFAULT_INCOME);
	caa_homonymous_fi($product_value, "product_value", DEFAULT_PVALUE);
	caa_homonymous_fi($conversion_percentage, "conversion_percentage", DEFAULT_CPERCENTAGE);
	caa_homonymous_fi($shop_url, "shop_url", DEFAULT_SURL);
	caa_homonymous_fi($keywords, "keywords", DEFAULT_KEYS);
	caa_homonymous_fi($marge, "marge", DEFAULT_MARGE);
	
	//Validate the marketing budget input
	$mb_percentage = DEFAULT_MB_PERCENTAGE;
	$mb_euro = DEFAULT_MB_EURO;
	if(isset($_POST["mb_percentage"]) && $_POST["mb_percentage"]!='')
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
	
	caa_homonymous_fi($direct_percentage, "direct_percentage", DEFAULT_DIRECT);
	caa_homonymous_fi($google_percentage, "google_percentage", DEFAULT_GOOGLE);
	caa_homonymous_fi($adwords_percentage, "adwords_percentage", DEFAULT_ADWORDS);
	caa_homonymous_fi($links_percentage, "links_percentage", DEFAULT_LINKS);
	caa_homonymous_fi($unpaid_percentage, "unpaid_percentage", DEFAULT_UNPAID);
	caa_homonymous_fi($additional_percentage, "additional_percentage", DEFAULT_ADDITIONAL);
	
	//Print the page's head and menu (same for all pages of this webplace)
	$strct = new Structure($shop_url,"Calculate the investment return of ".$shop_url);
	echo $strct->get_head();
	echo $strct->get_menu();
	
	//Body here
	
	//Show a list of errors if any
	print('<ul id="error_list" class="negative">');
	
	//Check possible error 
	$sum_percentage = $direct_percentage + $google_percentage + $adwords_percentage + $links_percentage + $unpaid_percentage + $additional_percentage;
	if($sum_percentage != 100)
	{
		print('<li id="percentage_sum_error">The sum of the visitors percentages must be 100%. However, in this case, it is '.$sum_percentage.'%</li>');
	}
	
	print('</ul>');
	//End of errors list
	
	//Get keywords virtual data
	$keys = explode(',',$keywords); //Keywords are seperated by comma, get an array of keywords
	$k_CPC = array();
	$k_volume = array();
	$total_volume = 0;
	$average_CPC = 0;
	$table_contents = "";
	
	srand(1); //make a static seed
	$data_exists = false; //A boolean to check if there is at least one keyword used as search data
	
	//Iterate through the keywords array and gather the necessary information
	foreach($keys as $i => $value)
	{
		if(trim($value) != '')
		{
			$data_exists = true;
			$k_CPC[$i] = rand(5, 30)/10.0; //Produce static values
			$k_volume[$i] = rand(0,200000000); //Produce static values
			
			//Sum all the CPCs and later we'll divide this with the total volume
			$average_CPC += $k_CPC[$i]*$k_volume[$i];
			
			//Sum all the search volumes
			$total_volume += $k_volume[$i];
			
			//Construct a table to show the data for each keyword
			//We'll print this table later.
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
	
	//Check if valid keywords were processed
	if($data_exists)
	{
		$average_CPC = round($average_CPC/$total_volume, 2);
	}
	
	//Calculate the Least-orders demand
	$orders_demand = 0;
	if($product_value > 0)
	{
		$orders_demand = (int)($monthly_income/$product_value);
	}
	
	//Calculate the total visitors
	$visitors = 0;
	if($conversion_percentage > 0)
	{
		$visitors = roundup($orders_demand/($conversion_percentage/100.0));
	}
	
	//Calculate the possible visitors from adwords
	$adwords_visitors = roundup($adwords_percentage/100.0 * $visitors);
	
	//We assume a fraction of 10% of the total volume search
	$volume_of_interest = (int)($total_volume/10);
	
	//Generate a response to the user about the reliability of this probe
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
	
	//Calculate the budget per visitor
	$budget_per_visitor = 0;
	if($buying_visitors > 0)
	{
		$budget_per_visitor = round($mb_euro/$buying_visitors,2);
	}
	
	//Generate a response for the user about the profit of this probe
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
	
	//Front end part
	
	print
	('
		<form  autocomplete="off" method="POST">
			<div class="options">
				'.$forms->label("conversion_percentage","Conversion percentage").'<br>
				'.$forms->percentage_input("conversion_percentage", $conversion_percentage, DEFAULT_CPERCENTAGE).'
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
				'.$forms->label("product_value","Average product value").'<br>
				'.$forms->euro_input("product_value", $product_value, DEFAULT_PVALUE).'
			</div>
			
			<div class="options">
				<img class="small_image" src="https://cloud.githubusercontent.com/assets/14919500/10214555/0c857cc6-6822-11e5-82fb-2faf3e8b7822.png"></img>
			</div>
			
			<div class="options">
				'.$forms->label("monthly_income","Aimed income per month").'<br>
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
				'.$forms->label("marge","Marge").' '.$forms->marge_selector("marge", $marge, "marge_relation(this);").'<br>
				<img class="square_image rotate270" src="https://cloud.githubusercontent.com/assets/14919500/10214555/0c857cc6-6822-11e5-82fb-2faf3e8b7822.png"></img>
			</div>
			
			<br>
			<div class="options">
				<div class="options">
					'.$forms->label("direct_percentage","Direct:").' <br>
					'.$forms->label("google_percentage","Google:").' <br>
					'.$forms->label("adwords_percentage","Adwords:").' <br>
					'.$forms->label("links_percentage","Link Referals:").' <br>
					'.$forms->label("unpaid_percentage","Unpaid:").' <br>
					'.$forms->label("additional_percentage","Additional:").' <br>
				</div>
				
				<div class="options">
					'.$forms->percentage_input("direct_percentage", $direct_percentage, DEFAULT_DIRECT, "sum_to_100();").'<br>
					'.$forms->percentage_input("google_percentage", $google_percentage, DEFAULT_GOOGLE, "sum_to_100();").'<br>
					'.$forms->percentage_input("adwords_percentage", $adwords_percentage, DEFAULT_ADWORDS, "sum_to_100();").'<br>
					'.$forms->percentage_input("links_percentage", $links_percentage, DEFAULT_LINKS, "sum_to_100();").'<br>
					'.$forms->percentage_input("unpaid_percentage", $unpaid_percentage, DEFAULT_UNPAID, "sum_to_100();").'<br>
					'.$forms->percentage_input("additional_percentage", $additional_percentage, DEFAULT_ADDITIONAL, "sum_to_100();").'<br>
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
				'.$forms->label("mb_percentage","Marketing budget").$forms->label("mb_euro","Marketing budget","invisible").'<br>
				'.$forms->percentage_input("mb_percentage", $mb_percentage, DEFAULT_MB_PERCENTAGE, "mb_percentage_relation(this);").' = 
				'.$forms->euro_input("mb_euro", $mb_euro, DEFAULT_MB_EURO, "mb_euro_relation(this);").'
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
				'.$forms->hidden("shop_url", $shop_url).'
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
	
	//Print the page's footer (same for all pages of this webplace)
	echo $strct->get_footer();
?>
