{nocache}
<!DOCTYPE html>
<html>
<head>
<title>Analog Ocean | {$title|strip_tags}</title>
<!--<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>-->
<meta charset="UTF-8">
<meta name='viewport' content='width=device-width, initial-scale=1'>
<meta name="keywords" content="">
<meta content='text/html;charset=utf-8' http-equiv='content-type'>
<meta http-equiv="Pragma" content="no-cache">
<meta content='Welcome to Analog Ocean! With this site, we offer non-profit organizations a free platform to create, manage, and run multiple virtual machines using their own set hardware constraints.' name='description'>

<link href="{$theme_dir}/assets/stylesheets/mobirise-icons.css" rel="stylesheet" type="text/css" />
<link href="{$theme_dir}/assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="{$theme_dir}/assets/stylesheets/bootstrap-grid.min.css" rel="stylesheet" type="text/css" />
<link href="{$theme_dir}/assets/stylesheets/bootstrap-reboot.min.css" rel="stylesheet" type="text/css" />
<link href="{$theme_dir}/assets/stylesheets/socicon-styles.css" rel="stylesheet" type="text/css" />
<link href="{$theme_dir}/assets/stylesheets/tether.min.css" rel="stylesheet" type="text/css" />
<link href="{$theme_dir}/assets/stylesheets/dropdown-style.css" rel="stylesheet" type="text/css" />
<link href="{$theme_dir}/assets/stylesheets/style.css" rel="stylesheet" type="text/css" />
<link href="{$theme_dir}/assets/stylesheets/mbr-additional.css" rel="stylesheet" type="text/css" />
<link href="{$theme_dir}/assets/stylesheets/custom.css" rel="stylesheet" type="text/css" />
<link href="{$theme_dir}/assets/stylesheets/data-tables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

</head>
<body>
<script src="{$theme_dir}/assets/javascripts/jquery/jquery.min.js" type="text/javascript"></script>
<script src="{$theme_dir}/assets/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
<script src="{$theme_dir}/assets/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
<script src="{$theme_dir}/assets/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<section class="menu cid-qTkzRZLJNu" once="menu" id="menu1-0">
<nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top navbar-toggleable-sm">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <div class="menu-logo">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <a href="/">
                         <img src="/images/vm-temp-122x122.png" alt="Mobirise" title="" style="height: 3.8rem;">
                    </a>
                </span>
                <span class="navbar-caption-wrap"><a class="navbar-caption text-white display-4" href="/">
                        Analog Ocean</a></span>
            </div>
        </div>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                {if $is_authenticated eq false}
                <li class="nav-item">
                    <a class="nav-link link text-white display-4" href="/">
                        <span class="mbri-home mbr-iconfont mbr-iconfont-btn"></span>
                        Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link text-white display-4" href="/">
                        <span class="mbri-search mbr-iconfont mbr-iconfont-btn"></span>
                        About Us
                    </a>
                </li>
                {/if}
                {if $is_authenticated}
                    <div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="/account/create">
                    <font face="MobiriseIcons"><br></font>Create VM<br></a></div>
                    <div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="/account/manage">
                    <font face="MobiriseIcons"><br></font>Manage VMs<br></a></div>
                    
                <li class="nav-item">
                    <a class="nav-link link text-white display-4" href="/account/settings">
                        <span class="mbri-setting3 mbr-iconfont mbr-iconfont-btn"></span>
                        {$username}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link text-white display-4" href="/?logout">
                        <span class="mbri-logout mbr-iconfont mbr-iconfont-btn"></span>
                        Logout
                    </a>
                </li>
                {/if}
            </ul>
            {if $is_authenticated eq false}
            <div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="/login">
                    <font face="MobiriseIcons"><br></font>Login<br></a></div>
            {/if}
            
        </div>
    </nav>
</section>

<!--nav-->
<div id='wrapper'>
	{if $use_nav eq true}
	<div id='main-nav-bg'></div>
	<nav id='main-nav'>
		<div class='navigation'>
			<!-- <div class='hidden-xs hidden-sm' align="center" style="height: 85px"><a href='/'><img border="0" src="" height="90px"></a></div> -->
			<ul class='nav nav-stacked'>
				<li>
					<a class='dropdown-collapse' href='#'><i class='icon-reorder' style='color:#60ADE9'></i><span>Example</span><i class='icon-angle-down angle-down'></i></a>
					<ul class='nav nav-stacked' id='listings'>
						
						<li class=''><a href='/'><i class='icon-chevron-right' style='color:#60ADE9'></i><span>Item1</span></a></li>
					</ul>
				</li>
				
				<li class=''><a href='/'><i class='icon-tint' style='color:#60ADE9'></i><span>Example1</span></a></li>
				<li><a target='_new' href='/'><span>Example2</span></a></li> 
				
			</ul>
			
		</div>
	</nav>
	{/if}
	{if $use_nav eq true}
	
	{else}	
		
	{/if}
{/nocache}
