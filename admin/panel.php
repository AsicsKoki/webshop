<?php 
	
 ?>

 <!doctype HTML>
 <html>
<head>
	<link rel ="stylesheet" href="../css/styles.css">
	<link rel ="stylesheet" href="../css/bootstrap.css">
	<link rel ="stylesheet" href="../css/bootstrap.min.css">
	<link rel ="stylesheet" href="../css/bootstrap-responsive.css">
	<link rel ="stylesheet" href="../css/bootstrap-responsive.min.css">
	<style>
	header{
	height:100px;
}
.bs-docs-sidenav.affix {
  	top: 10px;
}
@media (min-width: 1200px) {
  .bs-docs-sidenav {
      width: 258px;
  }
  .bs-docs-sidenav {
      width: 228px;
      margin: 10px 0 0;
      padding: 0;
      background-color: #fff;
      -webkit-border-radius: 6px;
      -moz-border-radius: 6px;
      border-radius: 6px;
      -webkit-box-shadow: 0 1px 4px rgba(0,0,0,.065);
      -moz-box-shadow: 0 1px 4px rgba(0,0,0,.065);
      box-shadow: 0 1px 4px rgba(0,0,0,.065);
      text-align: left;
  }
  .affix {
    position: fixed;
  }
}</style>
</head>
<body id="background">
<div id="mainElement">
	<header id="header">Konstantin's web shop</header>
	<div class="navbar">
		<div class="navbar-inner">
			<div width="100%">
				<ul class="nav">
		   			<li class="active">
						<a href="panel.php">Home</a>
					</li>
						<li><a href="#">Posts</a></li>
						<li><a href="#">Users</a></li>
				</ul>
			</div>
		</div>
	</div>
		<div id="elementOne">
			 <div class="span3 bs-docs-sidebar">
			    <ul class="nav nav-list bs-docs-sidenav affix-top" data-spy="affix" data-offset-top="100">
			      <li class="header"><h3>Sidebar</h3></li>
			      <li class="active"><a href="#global"><i class="icon-chevron-right"></i> Global styles</a></li>
			      <li><a href="#gridSystem"><i class="icon-chevron-right"></i> Grid system</a></li>
			      <li><a href="#fluidGridSystem"><i class="icon-chevron-right"></i> Fluid grid system</a></li>
			      <li><a href="#layouts"><i class="icon-chevron-right"></i> Layouts</a></li>
			      <li><a href="#responsive"><i class="icon-chevron-right"></i> Responsive design</a></li>
			    </ul>
			  </div>
			<div id="central">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
	<footer id="footer">(2013) All rights reserved</footer>
</div>
	<script src="../js/jquery-1.10.2.min.js"></script>
	<script src="../js/bootstrap.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/main.js"></script>
</body>
</html>