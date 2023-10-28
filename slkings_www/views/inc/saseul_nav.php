<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;background:#1f303a;">
    <!-- navbar-header -->
	<div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="/" class="navbar-brand" style="color:#fff;"><?=__ENV_ADMIN_TITLE__?>&nbsp;</a>				
    </div>
	<ul class="nav navbar-top-links navbar-right">
		<span style='color:#fff;font-weight:bold;'>
			User : &nbsp;<?=$this->_userid?>
		</span>
		<li class="nav-item">
		  <a class="nav-link" href="/saseul/logout" style='color:red'>
		  <i class="fas fa-sign-out-alt"></i>Logout</a>
		</li>
	</ul>
    <!-- //navbar-header -->
    <!-- navbar -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <?php                
	                include "saseul_nav_menu.php";
                ?>                                
            </ul>
        </div>
    </div>
    <!-- //navbar -->
</nav>
