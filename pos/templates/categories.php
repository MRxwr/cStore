<div class="container">
	<div class="row w-100 m-auto" style="padding-bottom: 4rem!important;">
		<?php
		echo getCategories();
		?>
	</div>
</div>

<button class="product-cart shopping-cart item-pad-cust right" data-toggle="modal" data-target="#cart_popup">
<span class="totalItems">
	<span><?php echo cartSVG(); ?></span>
	<span class="cartItemNo"><?php echo sizeof($_SESSION["cart"]["id"]) ?></span>
</span>
<span class="cart_price"><?php echo getCartPrice(); ?></span>
</button>