<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
	<title><?php bloginfo('name'); ?></title>
	
	<link rel="stylesheet" href="<?PHP bloginfo('template_directory'); ?>/css/global.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP bloginfo('template_directory'); ?>/css/print.css" type="text/css" media="print" />
	
	<script type="text/javascript" src="<?PHP bloginfo('template_directory'); ?>/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?PHP bloginfo('template_directory'); ?>/js/jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript" src="<?PHP bloginfo('template_directory'); ?>/js/jquery.ad-gallery.js"></script>
	
	<script src="http://api.maps.yahoo.com/ajaxymap?v=3.8&amp;appid=BFGndILV34FjaUmI1jEpF0P.osPBRimrsbXD6v_17g6CDQja3.DhoaPBVfJWJYZt._oazA--" type="text/javascript"></script>
	
</head>
<body>
<div id="header">
	<div class="content">
		<h1 id="logo"><a href="/">Lake Tomahawk Bible Church</a></h1>
		<div class="login">
			<?PHP /*<xsl:apply-templates select="/root/page/module[@zone='login']">
				<xsl:sort select="@order" order="ascending" />
			</xsl:apply-templates>*/ ?>
		</div>
		<ul id="nav">
			<li><a href="/messages/">Messages</a></li>
			<!--<li><a href="/requests/">Prayer Requests</a></li>
			<li><a href="members.html">Members</a></li>-->
			<li class="last"><a href="/contact/">Contact</a></li>
		</ul>
	</div>
</div>
<div id="container">

	<div class="clearfix<?PHP echo is_page('homepage') ? ' homepage' : ''; ?>">