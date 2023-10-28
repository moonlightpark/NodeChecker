<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;background:#1f303a;">
    <!-- navbar-header -->
	<div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>	
    </div>
</nav>
<div style='margin:10px;'>
	<div class="row padding-top20 text-center" style='width:100%;'>
		<!-- qna  -->
		<div  style='width:80%;display:inline-block;'>
			<div class="panel panel-default">
				<div class="panel-heading" style='text-align:left;'>
					<i class="fas fa-question-circle"></i> <?=$this->title?>
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body text-center"  >
					<?=$this->msg?>		
				</div>
				<div class='text-center padding-top20' style='padding-bottom:10px;'>
					<button type="button" class="btn btn-primary" onclick="Utility.fun.gotoUrl('<?=$this->gourl?>')">홈</button>
				</div>
			</div>
		</div>
		<!--// qna -->
	</div>
</div>
<!-- container -->
<div>
