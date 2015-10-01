<?php
	
	class Structure
	{
		private $title;
		private $header;
		
		public function __construct($title,$header)
		{
			$this->title = $title;
			$this->header = $header;
		}
		
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
