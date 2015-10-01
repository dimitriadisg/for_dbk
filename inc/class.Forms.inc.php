<?php

	class Forms
	{
		public function _construct()
		{
			
		}
		
		public function euro_input($name,$value,$default_value, $onchange="")
		{
			if($onchange != "")
			{
				$onchange = ' onchange="'.$onchange.'"';
			}
			return '<span class="currency_input">€<input type="number" step="any" required name="'.$name.'" value="'.$value.'" min="1" onfocus="clear_field(this,'.$default_value.');"'.$onchange.'></span>';
		}
		
		public function percentage_input($name,$value,$default_value, $onchange="")
		{
			if($onchange != "")
			{
				$onchange = ' onchange="'.$onchange.'"';
			}
			return '<span class="percentage_input"><input type="number" step="any" required name="'.$name.'" value="'.$value.'" min="0" max="100" onfocus="clear_field(this,'.$default_value.');"'.$onchange.'>%</span>';
		}
		
		public function text_input($name,$value)
		{
			return '<input class="text_input" type="text" required name="'.$name.'" value="'.$value.'">';
		}
		
		public function textarea($name, $value)
		{
			return '<textarea class="paragraph_input" name="'.$name.'">'.$value.'</textarea>';
		}
		
		public function submit($value="Submit")
		{
			return '<input class="blue_button" type="submit" value="'.$value.'">';
		}
		
		public function hidden($name,$value)
		{
			return '<input type="hidden" name="'.$name.'" value="'.$value.'">';
		}
		
		public function marge_selector($name, $value, $onchange="")
		{
			if($onchange != "")
			{
				$onchange = ' onchange="'.$onchange.'"';
			}
			$selected0 = "";
			$selected1 = "";
			if((int)$value)
			{
				$selected1 = "selected";
			}
			else
			{
				$selected0 = "selected";
			}
			
			return '<select name="'.$name.'"'.$onchange.'>
						<option value="0" '.$selected0.'>&gt;15%</option>
						<option value="1" '.$selected1.'>&lt;15%</option>
					</select>
					';
		}
	}
?>
