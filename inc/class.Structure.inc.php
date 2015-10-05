<?php
	
	/*
	** Structure
	**
	** A class that maintains a global structure for the webplace of this tool.
	**
	** @author	George Dimitriadis
	** @version	1.0
	*/
	class Structure
	{
		//The title of the page
		private $title;
		
		//The title of the content
		private $header;
		
		/*
		** COSTRUCTOR
		**
		** Simply assigns the given parameters to its private variables. <br>
		**
		** @param	string	title	The prefered title of the page as shown in tab or window name of the browser.
		** @param	string	header	The prefered title of the content of this page.
		** @return	OBJECT			An object of this class.
		*/
		public function __construct($title,$header)
		{
			$this->title = $title;
			$this->header = $header;
		}
		
		/*
		** Structure::get_head
		**
		** Builds and returns the head of the page, anything contained inside <br>
		** the head tag of the html goes here.
		**
		** @param	VOID
		** @return	string	The head structure of the page
		*/
		public function get_head()
		{
			$temp = '
					<!DOCTYPE html>
					<html lang="en">
						<head>
							<link rel="shortcut icon" href="./images/favicon.ico">
							<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
							<title>'.$this->title.'</title>
							
							<link rel="stylesheet" type="text/css" href="./css/general.css"/>
							<link rel="stylesheet" type="text/css" href="./css/buttons.css"/>
							<link rel="stylesheet" type="text/css" href="./css/menu.css"/>
							<script type="text/javascript" src="./javascript/input_helpers.js"></script>
						</head>
					';
			return $temp;
		}
		
		/*
		** Structure::get_menu
		**
		** Initiates the body tag of the page and builds the navigation menu of <br>
		** the page. Then returns this structure.
		**
		** @param	VOID
		** @return	string	The structure of the navigation menu.
		*/
		public function get_menu()
		{
			$temp = '
					<body>
					<div id="all">
						<div id="top">
							<ul id="coolMenu">
								<li><span id="title">'.$this->header.'</span></li>
								<li><a href="./index.php" class="menu_tab">Home</a></li>
								<li><a href="./about.php" class="menu_tab">About</a></li>
							</ul>
						</div>
						<hr>
						<div id="container">
					';
			return $temp;
		}
		
		/*
		** Structure::get_footer
		**
		** Creates the footer of the page and closes the body tag of the page. <br>
		** Then returns this result.
		**
		** @param	VOID
		** @return	string	The structure of the footer.
		*/
		public function get_footer()
		{
			$temp = '
							</div>
							<div id="footer">
								<hr>
								<p>Created by George Dimitriadis, for DBK, 2015</p>
							</div>
						 </div>
						</body>
					</html>
					';
			return $temp;
		}
	}
	
?>
