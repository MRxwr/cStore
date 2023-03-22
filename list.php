<?php session_start(); ?>
<?php require 'templates/header.php'; ?>
<?php require 'templates/saveOrder.php'; ?>
<style>
.marginingTheSearchBar{
	bottom: 10px;
    position: absolute;
}
ul.social-icons {
    
}

@media only screen and (max-width: 1025px) {
	  .marginingTheSearchBar{
		bottom: 0px;
		position: relative;
		margin-top: 800px;
	}
	ul.social-icons {
		margin-top: 100px;
	}
}

@media only screen and (max-width: 768px) {
	  .marginingTheSearchBar{
		bottom: 0px;
		position: relative;
		margin-top: 0px;
	}
	ul.social-icons {
		margin-top: 150px;
		
	}
}

@media only screen and (max-width: 430px) {
	  .marginingTheSearchBar{
		bottom: 0px;
		position: relative;
		margin-top: 0px;
	}
	ul.social-icons {
		margin-top: 20px;
		
	}
}

@media only screen and (max-width: 380px) {
	  .marginingTheSearchBar{
		bottom: 0px;
		position: relative;
		margin-top: 0px;
	}
	ul.social-icons {
		margin-top: 20px;
		
	}
}

@media only screen and (max-width: 330px) {
	  .marginingTheSearchBar{
		bottom: 0px;
		position: relative;
		margin-top: 0px;
	}
	ul.social-icons {
		margin-top: 20px;
	}
}

.glow {
  font-size: 30px;
  color: #fff;
  text-align: center;
  animation: glow 1s ease-in-out infinite alternate;
}

@-webkit-keyframes glow {
  from {
    text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 15px #000, 0 0 20px #000, 0 0 25px #000, 0 0 30px #000, 0 0 35px #000;
  }
  
  to {
    text-shadow: 0 0 10px #fff, 0 0 15px #000, 0 0 20px #000, 0 0 25px #000, 0 0 30px #000, 0 0 35px #000, 0 0 40px #000;
  }
}

.preorder{
    font-family: 'Almarai', sans-serif;
    font-size: 10px;
    color: rgb(255, 255, 255);
    line-height: 24px;
    background-color: #000000;
    padding-left: 10px;
    padding-right: 10px;
    display: inline-block;
    position: absolute;
    top: 10px;
	left: 10px;
    z-index: 3;
    border-radius: 12px;
    font-weight: 700;
}
</style>

<?php require 'templates/slider.php'; ?>
<?php //require 'templates/mobile-menu.php'; ?>
<?php //require 'templates/coupons.php'; ?>
<?php //require 'templates/sidebar.php'; ?>
<?php require 'templates/main-container.php'; ?>
<?php //require 'templates/categories.php'; ?>
<?php require 'templates/footer.php'; ?>