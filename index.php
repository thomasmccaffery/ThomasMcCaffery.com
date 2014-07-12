<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width,initial-scale=1">	
	<title>Developer, Engineer, Maker | Thomas McCaffery</title>
	<!--<meta http-equiv="cleartype" content="on" /> -->
	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge" />-->
	<link rel="stylesheet" type="text/css" href="assets/css/main.css" />
	<link rel="shortcut icon" href="ico/favicon.ico">
	<!-- <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png"> -->
</head>

<body>
	<div class="header">
		<div class="Menu_Bar">
			<div class="mobile-nav">
				<a href="#" class="mobile-toggle"><span id="menu_Ico" class="icon-list main-m"></span><span class="menu-title">Menu</span></a>
			</div>
			<a href="./" class="header-logo">
				<img src="assets/img/Logo.png" class="white-logo" alt="Logo">
			</a>
			<ul class="nav left-align">
				<li><a href="./" title="Home">Home</a></li>
				<li><a href="./?About" title="About">About</a></li>
				<li><a href="./?Portfolio" title="Portfolio">Portfolio</a></li>
				<li><a href="./?Articles" title="Articles">Articles</a></li>
				<li><a href="./?Contact" title="Contact">Contact</a></li>
			</ul>
		</div>
	</div>
	
	<div class="mid_container">
		<noscript>This site will not load without JavaScript turned on. Sorry!</noscript>

		<div id="Ajax_Container">
			<div class="box3">
				<div class="box3_holder">
					<div class="box stack_quarter_block_third T"> 
						<div class="content_in i_block mid">
							<img src="assets/img/ajax-loader.gif" class="vmid" />
						</div> 
					</div>
		  
					<div class="box stack_quarter_block_third view-first"> 
						<div class="content_in i_block"></div>
					</div>
				</div>
			</div>
			
			<div class="box half_block"> 
				<div class="content_in main_b text_block"></div> 
			</div>
			
			<div class="spacer-3"></div>
			
			<div class="box3 last">
				<div class="box3_holder">
					<div class="box stack_quarter_block_third T"> 
						<div class="content_in text_block uni"></div> 
					</div>
		  
					<div class="box stack_quarter_block_third"> 
						<div class="content_in"></div> 
					</div>
				</div>
			</div>
			
			<div class="spacer-4"></div>
			
			<div class="clear_both"></div>
		</div>
	
		<div class="footer">
			<div class="f_text">
				<p class="blu">Email Me <a href="mailto:tom@thomasmccaffery.com" class="light">Tom@ThomasMcCaffery.com</a></p>
				<p><small>&copy; 2014 ThomasMcCaffery.com</small></p>
			</div>
		</div>
	</div>
	
	<div class="Quick-Up"><a href="#"><span class="icon-arrow-up3 QUI"></span></a></div>
	
	<?php
		$HeaderS = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), 0, 3);
		$HeaderP = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
		if($HeaderS == 'Abo') { $Current_Page = 'pages/about.php'; /*include('pages/about.php');*/ }
		else if($HeaderS == 'Por') { $Current_Page = 'pages/portfolio.php'; /*include('pages/portfolio.php');*/ }
		else if($HeaderS == 'Art') { $Current_Page = 'pages/articles.php'; /*include('pages/articles.php');*/ }
		else if($HeaderS == 'Con') { $Current_Page = 'pages/contact.php'; /*include('pages/contact.php');*/ }
		else if($HeaderS == 'Pro') { $Current_Page = 'pages/Details.php'; /*include('pages/Details.php');*/ }
		else { $Current_Page = 'pages/front.php'; /*include('pages/front.php');*/ }
	?>
	
	<script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.mobile.custom.min.js"></script>
	<script type="text/javascript" src="assets/js/TM.js"></script>
	<script>
		$(function(){ 
			$.ajax({
				type: 'get',
				url: '<? echo $Current_Page; ?>',
				data: '<? echo $HeaderP; ?>',
				success: function(data) { $( "#Ajax_Container" ).html( data ); }
			});
		});
	</script>
</body>
</html>