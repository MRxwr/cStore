<div class="fixed-sidebar-left">
	<ul class="nav navbar-nav side-nav nicescroll-bar">
		<li class="navigation-header">
			<span><?php echo $settingsTitle ?></span> 
			<i class="zmdi zmdi-more"></i>
		</li>
<?php 
if( $pages = selectDB("pages","`status` = '0' AND `section` = '0'") ){
	if( $roles = selectDB("roles","`id` = '{$userType}'") ){
		$list = json_decode($roles[0]["pages"],true);
	}else{
		$list = array();
	}
	for( $i = 0; $i < sizeof($pages); $i++ ){
		if ( $userType == '0' || in_array($pages[$i]["id"],$list) ){
			if( $sections = selectDB("pages","`section` = '{$pages[$i]["id"]}'") ){
				$anchor = "href='javascript:void(0);' data-toggle='collapse' data-target='#".str_replace(" ","_",$pages[$i]["enTitle"])."' class='collapsed' aria-expanded='false'";
				$arrowDown = "<i class='zmdi zmdi-caret-down'></i>";
			}else{
				$anchor = "href='{$pages[$i]["fileName"]}'";
				$arrowDown = '';
			}
			?>
			<li>
				<a <?php echo $anchor ?> >
					<div class="pull-left">
						<i class="<?php echo $pages[$i]["icon"] ?> mr-20"></i>
						<span class="right-nav-text"><?php echo direction($pages[$i]["enTitle"],$pages[$i]["arTitle"]) ?></span>
					</div>
					<div class="pull-right">
						<?php echo $arrowDown ?>
					</div>
					<div class="clearfix"></div>
				</a>
			<?php
			if ( $subSections = selectDB("pages","`section` = '{$pages[$i]["id"]}'") ){
				?>
				<ul id="<?php echo str_replace(" ","_",$pages[$i]["enTitle"]) ?>" class="collapse-level-1 collapse" aria-expanded="true">
				<?php
				for( $y = 0; $y < sizeof($subSections); $y++ ){
					?>
						<li>
							<a href="<?php echo $subSections[$y]["fileName"] ?>" >
								<div class="pull-left">
									<i class="<?php echo $subSections[$y]["icon"] ?> mr-20"></i>
									<span class="right-nav-text"><?php echo direction($subSections[$y]["enTitle"],$subSections[$y]["arTitle"]) ?></span>
								</div>
								<div class="pull-right"></div>
								<div class="clearfix"></div>
							</a>
						</li>
					<?php
				}
				?>
				</ul>
				<?php
			}
		}
		?>
		</li>
		<?php
	}
}
?>
	</ul>
</div>