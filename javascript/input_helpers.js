function clear_field(x,val)
{
	if(x.value == val) { x.value = ''; }
}

function mb_percentage_relation(x)
{
	var mb_euro = document.getElementsByName("mb_euro")[0];
	var monthly_income = document.getElementsByName("monthly_income")[0];
	
	mb_euro.value = Math.round(monthly_income.value*x.value)/100;
}

function mb_euro_relation(x)
{
	var mb_percentage = document.getElementsByName("mb_percentage")[0];
	var monthly_income = document.getElementsByName("monthly_income")[0];
	
	mb_percentage.value = Math.round(x.value/monthly_income.value*100*100)/100;
}

function marge_relation(x)
{
	var mb_percentage = document.getElementsByName("mb_percentage")[0];
	
	if(x.value == 0)
	{
		mb_percentage.value = 7.5;
	}
	else
	{
		mb_percentage.value = 2.5;
	}
	
	mb_percentage_relation(mb_percentage);
}
