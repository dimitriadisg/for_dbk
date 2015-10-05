<?php

	include 'constants.php';
	
	/*
	** roundup
	**
	** Returns the greater integer closest to the input value.
	**
	** @param	float	float_input		The variable we want to roundup.
	** @return	int						The greater integer closest to float_input.
	*/
	function roundup($float_input)
	{
		$result = $float_input;
		if($float_input - ((int)$float_input))
		{
			$result = (int)($float_input + 1);
		}
		
		return $result;
	}
	
	/*
	** caa_homonymous_fi
	**
	** Checks and if successful assigns the value of the homonymous form input <br>
	** into the desired variable that is passed by reference. If the check fails <br>
	** the variable is assigned a default value as given in the function.
	**
	** @param	ANY		variable		The variable we want to assign a value to.
	** @param	STRING	variable_name	The name of the input field.
	** @param	ANY		default_value	The default value if the input was invalid.
	** @param	STRING	method			The method of the form used (default is "POST").
	** @return	VOID 
	*/
	function caa_homonymous_fi (&$variable, $variable_name, $default_value, $method="POST")
	{
		global ${"_".$method};
		if(isset(${"_".$method}[$variable_name]) && ${"_".$method}[$variable_name] != '')
		{
			$variable = ${"_".$method}[$variable_name];
		}
		else
		{
			$variable = $default_value;
		}
		
		if(is_double($variable))
		{
			$variable = round($variable, 2);
		}
	}
	
?>
