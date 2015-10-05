<?php

	/*
	** Forms
	**
	** A class used to create elements for constructing forms <br>
	** Its input fields use an id equal to their name, so make sure to use unique <br>
	** names when using this class.
	**
	** @author	George Dimitriadis
	** @version	1.0
	*/
	class Forms
	{
		/*
		** CONSTRUCTOR
		**
		** Just the default constructor, doesn't do anything but build the object.
		**
		** @param	VOID
		** @return	OBJECT	An empty Object of this class. 
		*/
		public function _construct()
		{
			
		}
		
		/*
		** Forms::label
		**
		** Creates a label for an input field. The label corresponds to the tag with <br>
		** the id given in $for variable and has the text of the $text variable. <br>
		** The id of this label has a fixed form: label_$for.
		**
		** @param	string	for		The ID of the input field which this label refers to.
		** @param	string	text	The text content of the label.
		** @param	string	class	Optional: A styling class for this label.
		** @return	string			The structure of this label tag. 
		*/
		public function label($for, $text,$class="")
		{
			//For some reason labels have problems with classes
			//So I'm assigning a class for it outside the label tag
			$enclosure_start = "";
			$enclosure_end = "";
			
			if($class != '')
			{
				$enclosure_start = '<span class="'.$class.'">';
				$enclosure_end = '</span>';
			}
			return $enclosure_start.'<label id="label_'.$for.'" for="'.$for.'">'.$text.'</label>'.$enclosure_end;
		}
		
		/*
		** Forms::euro_input
		**
		** Creates an input field that accepts only numeric values. Its placeholder <br>
		** shows its default value, in case the field is not filled (No pun intended). <br>
		** A euro symbol is attached with this input as a notation to the user.
		**
		** @param	string	name			The name of this input field.
		** @param	string	value			The value of the input. It's type is string, but represents a number.
		** @param	double	default_value	The default value of this field.
		** @param	string	onchange		Optional: One or more functions to execute upon interaction.
		** @return	string					The structure of this input tag. 
		*/
		public function euro_input($name,$value,$default_value, $onchange="")
		{
			return '<span class="currency_input">&euro;<input type="text" step="any" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'.$default_value.'" onchange="validate_number(this);'.$onchange.'" onkeypress="this.onchange();" onpaste="this.onchange();" oncut="this.onchange();" oninput="this.onchange();"></span>';
		}
		
		/*
		** Forms::percentage_input
		**
		** Creates an input field that accepts only numeric values. Its placeholder <br>
		** shows its default value, if the field is empty. A percentage symbol is attached <br>
		** with this input as a notation to the user.
		**
		** @param	string	name			The name of this input field.
		** @param	string	value			The value of the input. It's type is string, but represents a number.
		** @param	double	default_value	The default value of this field.
		** @param	string	onchange		Optional: One or more functions to execute upon interaction.
		** @return	string					The structure of this input tag. 
		*/
		public function percentage_input($name,$value,$default_value, $onchange="")
		{
			return '<span class="percentage_input"><input type="text" step="any" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'.$default_value.'" onchange="validate_number(this);'.$onchange.'" onkeypress="this.onchange();" onpaste="this.onchange();" oncut="this.onchange();" oninput="this.onchange();">%</span>';
		}
		
		/*
		** Forms::text_input
		**
		** Creates an input field for text. Its placeholder shows the default value of this <br>
		** field in case the field is empty. <br>
		**
		** @param	string	name			The name of this input field.
		** @param	string	value			The value of the input.
		** @param	string	default_value	The default value of this field.
		** @return	string					The structure of this input tag. 
		*/
		public function text_input($name,$value,$default_value)
		{
			return '<input class="text_input" type="text" name="'.$name.'" value="'.$value.'" id="'.$name.'" placeholder="'.$default_value.'">';
		}
		
		/*
		** Forms::text_area
		**
		** Creates a small textarea field.
		**
		** @param	string	name	The name of this textarea.
		** @param	string	value	The content of this textarea.
		** @return	string			The structure of this textarea tag. 
		*/
		public function textarea($name, $value)
		{
			return '<textarea class="paragraph_input" name="'.$name.'" id="'.$name.'">'.$value.'</textarea>';
		}
		
		/*
		** Forms::submit
		**
		** Creates a submit button.
		**
		** @param	string	value	Optional: The name of the button.
		** @return	string			The structure of this submit button. 
		*/
		public function submit($value="Submit")
		{
			return '<input class="blue_button" type="submit" value="'.$value.'">';
		}
		
		/*
		** Forms::hidden
		**
		** Creates a hidden input field.
		**
		** @param	string	name	The name of this input field.
		** @param	string	value	The value of the input.
		** @return	string			The structure of this hidden input tag. 
		*/
		public function hidden($name,$value)
		{
			return '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$value.'">';
		}
		
		/*
		** Forms::marge_selector
		**
		** Creates a select tag for specifying the prefered marge. <br>
		**
		** @param	string	name		The name of the selector.
		** @param	boolean	value		The value of the selector.
		** @param	string	onchange	Optional: One or more functions to execute upon interaction.
		** @return	string				The structure of this label tag. 
		*/
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
			
			return '<select name="'.$name.'" id="'.$name.'"'.$onchange.'>
						<option value="0" '.$selected0.'>&gt;15%</option>
						<option value="1" '.$selected1.'>&lt;15%</option>
					</select>
					';
		}
	}
?>
