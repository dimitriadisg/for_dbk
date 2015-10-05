//Define constants
var DEFAULT_DIRECT = 20;
var DEFAULT_GOOGLE = 25;
var DEFAULT_ADWORDS = 35;
var DEFAULT_LINKS = 10;
var DEFAULT_UNPAID = 10;
var DEFAULT_ADDITIONAL = 0;

/*
** mb_percentage_relation
**
** Calculates the value of its sibling input as the fraction of the income. <br>
** The formula is: marketing budget = income * prefered percentage <br>
** The result is then assigned to the sibling's input in euros.
**
** @param	element	triggered_input	The element that triggers this function.
** @return	VOID 
*/
function mb_percentage_relation(triggered_input)
{
	var mb_euro = document.getElementsByName("mb_euro")[0];
	var monthly_income = document.getElementsByName("monthly_income")[0];
	
	mb_euro.value = Math.round(monthly_income.value*triggered_input.value)/100;
}

/*
** mb_euro_relation
**
** Calculates the value of its sibling input as the percentage ratio. <br>
** The formula is: marketing percentage = (income/marketing budget)*100 <br>
** The result is then assigned to the sibling's input as a percentage relation.
**
** @param	element	triggered_input	The element that triggers this function.
** @return	VOID 
*/
function mb_euro_relation(triggered_input)
{
	var mb_percentage = document.getElementsByName("mb_percentage")[0];
	var monthly_income = document.getElementsByName("monthly_income")[0];
	
	mb_percentage.value = Math.round(triggered_input.value/monthly_income.value*100*100)/100;
}

/*
** marge_relation
**
** The marge can have one of two values: 0 and 1. Upon selecting <br>
** a marge, a default value is passed to the mb_percentage input <br>
** and then the marketing budget is calculated according to this <br>
** percentage ratio by calling the mentioned function mb_percentage_relation.
**
** @param	element	triggered_input	The element that triggers this function.
** @return	VOID 
*/
function marge_relation(triggered_input)
{
	var mb_percentage = document.getElementsByName("mb_percentage")[0];
	
	if(triggered_input.value == 0)
	{
		mb_percentage.value = 7.5;
	}
	else
	{
		mb_percentage.value = 2.5;
	}
	
	mb_percentage_relation(mb_percentage);
}

/*
** sum_to_100
**
** Simply calculates the sum of six different percentage input fields <br>
** which share a relationship among them: They represent fractions of <br>
** the same value. This bonds the fractions to necessarily sum up to 100%. <br>
** If this condition is not served, this function makes sure to append an <br>
** error on the errors list.
**
** @param	VOID
** @return	VOID 
*/
function sum_to_100()
{
	var direct_percentage = document.getElementsByName("direct_percentage")[0].value;
	var google_percentage = document.getElementsByName("google_percentage")[0].value;
	var adwords_percentage = document.getElementsByName("adwords_percentage")[0].value;
	var links_percentage = document.getElementsByName("links_percentage")[0].value;
	var unpaid_percentage = document.getElementsByName("unpaid_percentage")[0].value;
	var additional_percentage = document.getElementsByName("additional_percentage")[0].value;
	
	//If the input fields have no value, assign them the default one
	if(direct_percentage == '')
	{
		direct_percentage = DEFAULT_DIRECT;
	}
	
	if(google_percentage == '')
	{
		google_percentage = DEFAULT_GOOGLE;
	}
	
	if(adwords_percentage == '')
	{
		adwords_percentage = DEFAULT_ADWORDS;
	}
	
	if(links_percentage == '')
	{
		links_percentage = DEFAULT_LINKS;
	}
	
	if(unpaid_percentage == '')
	{
		unpaid_percentage = DEFAULT_UNPAID;
	}
	
	if(additional_percentage == '')
	{
		additional_percentage = DEFAULT_ADDITIONAL;
	}
	
	var sum = parseFloat(direct_percentage) + parseFloat(google_percentage) + parseFloat(adwords_percentage) + parseFloat(links_percentage) + parseFloat(unpaid_percentage) + parseFloat(additional_percentage);
	
	//Delete the current message for this error if any
	var percentage_error = document.getElementById("percentage_sum_error");
	if(percentage_error != null)
	{
		percentage_error.parentNode.removeChild(percentage_error);
	}
	else
	{
		//The message does not exist
	}
	
	if(sum != 100.0)
	{	
		//Create a new error indicator element
		var percentage_error = document.createElement("LI");
		percentage_error.setAttribute("id", "percentage_sum_error");
		var text = document.createTextNode("The sum of the visitors percentages must be 100%. However, in this case, it is " + sum + "%");
		percentage_error.appendChild(text);
		
		//Now add this indicator on the errors-list
		var error_list = document.getElementById("error_list");
		error_list.appendChild(percentage_error);
	}
}

/*
** validate_number
**
** Makes sure that the input field that triggers this function has <br>
** always a valid numeric value.
**
** @param	element	triggered_input	The element that triggers this function.
** @return	VOID 
*/
function validate_number(triggered_input)
{
	var val = triggered_input.value;
	var regex = new RegExp("^[0-9]+[.]$");
	
	//Case where the user just typed a dot
	if(regex.test(val))
	{
		//Do nothing, we'll wait for his next input
	}
	else
	{
		val = val.replace(/[^0-9\.]+/g,''); //Keep only numbers and dots
		if(val != '' && val != '.')
		{
			val = parseFloat(val); //Parse the filtered string to a float type
			val = val*100; //Append the next two decimals
			val_int_part = parseInt(val); //Cut off rest decimals
		
			triggered_input.value = parseFloat(val_int_part/100);
		}
		else
		{
			triggered_input.value = '';
		}
	}
}
