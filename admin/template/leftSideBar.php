<div class="fixed-sidebar-left">
	<ul class="nav navbar-nav side-nav nicescroll-bar">
		<li class="navigation-header">
			<span><?php echo $settingsTitle ?></span> 
			<i class="zmdi zmdi-more"></i>
		</li>
		<li>
			<a href="javascript:void(0);" data-toggle="collapse" data-target="#pos" class="collapsed" aria-expanded="false">
				<div class="pull-left">
					<i class="fa fa-spin fa-cog mr-20"></i>
					<span class="right-nav-text"><?php echo direction("POS","نقطة البيع") ?></span>
				</div>
				<div class="pull-right">
					<i class="zmdi zmdi-caret-down"></i>
				</div>
				<div class="clearfix"></div>
			</a>
			<ul id="pos" class="collapse-level-1 collapse" aria-expanded="true" style="">
				<li>
					<a href="purchases.php" ><div class="pull-left">
					<i class="fa fa-file-image-o mr-20"></i>
					<span class="right-nav-text"><?php echo direction("Purchases","المشتريات") ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="product-posOrders.php" ><div class="pull-left">
					<i class="fa fa-file-image-o mr-20"></i>
					<span class="right-nav-text"><?php echo direction("Orders","الطلبات") ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="posReports.php" ><div class="pull-left">
					<i class="fa fa-pie-chart mr-20"></i>
					<span class="right-nav-text"><?php echo direction("Reports","التقارير") ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
			</ul>
		</li>
		
		<li>
			<a href="javascript:void(0);" data-toggle="collapse" data-target="#myShop" class="collapsed" aria-expanded="false">
				<div class="pull-left">
					<i class="pe-7s-shopbag mr-20"></i>
					<span class="right-nav-text"><?php echo direction("Online Store","المحل الإلكتروني") ?></span>
				</div>
				<div class="pull-right">
					<i class="zmdi zmdi-caret-down"></i>
				</div>
				<div class="clearfix"></div>
			</a>
			<ul id="myShop" class="collapse-level-1 collapse" aria-expanded="true" style="">
				<li>
					<a href="users.php" ><div class="pull-left">
					<i class="fa fa-users mr-20"></i>
					<span class="right-nav-text"><?php echo $Users ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="reports.php" ><div class="pull-left">
					<i class="icon-pie-chart mr-20"></i>
					<span class="right-nav-text"><?php echo $Reports ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="banners.php" ><div class="pull-left">
					<i class="fa fa-file-image-o mr-20"></i>
					<span class="right-nav-text"><?php echo $Banners ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="socialMedia.php"><div class="pull-left">
					<i class="fa fa-share-alt mr-20"></i>
					<span class="right-nav-text"><?php echo $sMediaText ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="maintenance.php"><div class="pull-left">
					<i class="pe-7s-tools mr-20"></i>
					<span class="right-nav-text"><?php echo $Maintenance ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
			</ul>
		</li>
		
		<li>
			<a href="javascript:void(0);" data-toggle="collapse" data-target="#orders" class="collapsed" aria-expanded="false">
				<div class="pull-left">
					<i class="fa fa-spin ti-mobile mr-20"></i>
					<span class="right-nav-text"><?php echo direction("online Orders","طلبات الأونلاين") ?></span>
				</div>
				<div class="pull-right">
					<i class="zmdi zmdi-caret-down"></i>
				</div>
				<div class="clearfix"></div>
			</a>
			<ul id="orders" class="collapse-level-1 collapse" aria-expanded="true" style="">
				<li>
					<a href="product-orders.php" ><div class="pull-left">
					<i class="ti-mobile mr-20"></i>
					<span class="right-nav-text"><?php echo direction("All Orders","جميع الطلبات") ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="product-orders.php?type=1" ><div class="pull-left">
					<i class="ti-mobile mr-20"></i>
					<span class="right-nav-text"><?php echo direction("Paid","مدفوعه") ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="product-orders.php?type=2" ><div class="pull-left">
					<i class="ti-mobile mr-20"></i>
					<span class="right-nav-text"><?php echo direction("Preparing","جاري التجهيز") ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="product-orders.php?type=3" ><div class="pull-left">
					<i class="ti-mobile mr-20"></i>
					<span class="right-nav-text"><?php echo direction("On Delivery","جاري التوصيل") ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="product-orders.php?type=4" ><div class="pull-left">
					<i class="ti-mobile mr-20"></i>
					<span class="right-nav-text"><?php echo direction("Delivered","تم التسليم") ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="product-orders.php?type=5" ><div class="pull-left">
					<i class="ti-mobile mr-20"></i>
					<span class="right-nav-text"><?php echo direction("Failed","فاشلة") ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="product-orders.php?type=6" ><div class="pull-left">
					<i class="ti-mobile mr-20"></i>
					<span class="right-nav-text"><?php echo direction("Returned","مسترجع") ?></span>
					</div>
					<div class="pull-right"></div><div class="clearfix"></div>
					</a>
				</li>
			</ul>
		</li>
		
		<li>
			<a href="categories.php" ><div class="pull-left">
			<i class="glyphicon glyphicon-th-large mr-20"></i>
			<span class="right-nav-text"><?php echo $Categories ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
		<li>
			<a href="attributes.php" ><div class="pull-left">
			<i class="fa fa-list mr-20"></i>
			<span class="right-nav-text"><?php echo direction("Attributes","المتغيرات") ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
		<li>
			<a href="extras.php" ><div class="pull-left">
			<i class="fa fa-cart-plus mr-20"></i>
			<span class="right-nav-text"><?php echo direction("Add-ons","الإضافات") ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
		<li>
			<a href="product.php" ><div class="pull-left">
			<i class="zmdi zmdi-shopping-basket mr-20"></i>
			<span class="right-nav-text"><?php echo $Products ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
		<li>
			<a href="inventory.php" ><div class="pull-left">
			<i class="fa fa-stack-overflow mr-20"></i>
			<span class="right-nav-text"><?php echo direction("Inventory","المخزون") ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
		<li>
			<a href="voucher.php" ><div class="pull-left">
			<i class="glyphicon glyphicon-scissors mr-20"></i>
			<span class="right-nav-text"><?php echo $Vouchers ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
		<li>
			<a href="shops.php" ><div class="pull-left">
			<i class="fa fa-university mr-20"></i>
			<span class="right-nav-text"><?php echo direction("Shops","المحلات") ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
		<li>
			<a href="currency.php" ><div class="pull-left">
			<i class="fa fa-money mr-20"></i>
			<span class="right-nav-text"><?php echo direction("Currencies","العملات") ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
		<li>
			<a href="listOfEmployees.php" ><div class="pull-left">
			<i class="ti-user mr-20"></i>
			<span class="right-nav-text"><?php echo $listOfEmployees ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
		<li>
			<a href="countries.php" ><div class="pull-left">
			<i class="fa fa-flag mr-20"></i>
			<span class="right-nav-text"><?php echo $countriesText ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
		<li>
			<a href="areas.php" ><div class="pull-left">
			<i class="fa fa-globe mr-20"></i>
			<span class="right-nav-text"><?php echo $areas ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
	</ul>
</div>