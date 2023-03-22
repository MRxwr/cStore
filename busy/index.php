<?php
require ('../admin/includes/config.php');
require ('../admin/includes/functions.php');
require ('../admin/includes/translate.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $settingsTitle ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="" />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="vendor/bootstrap/css/bootstrap.min.css"
    />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="fonts/font-awesome-4.7.0/css/font-awesome.min.css"
    />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="fonts/iconic/css/material-design-iconic-font.min.css"
    />
	<link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css" />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="vendor/select2/select2.min.css"
    />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
	
    <!--===============================================================================================-->
  </head>
  <body>
    <div class="flex-w flex-str size1 overlay1">
      <div
        class="flex-w flex-col-sb wsize1 bg0 p-l-65 p-t-37 p-b-50 p-r-80 respon1"
      >
        <div class="wrappic1 text-center">
          <a href="#">
            <img
              src="../logos/<?php echo $settingslogo ?>"
              height=""
              width="300px"
              alt="IMG"
			  class="rounded"
            />
          </a>
        </div>

        <div class="w-full flex-c-m p-b-90">
          <div class="wsize2">
            <h3 class="l1-txt1 p-b-34 respon3" style="text-align: center;">Coming Soon</h3>

           <p class="m2-txt1 p-b-25" style="font-family: 'Almarai', sans-serif;text-align: center;">شكرا لزيارتكم</p>
            <p class="m2-txt1 p-b-25" style="font-family: 'Almarai', sans-serif;text-align: center;">Thanks for visiting us</p>
			<!--
			<p class="m2-txt1 p-b-25" style="font-family: 'Almarai', sans-serif;text-align: center;"><i class="fa fa-smile-o" aria-hidden="true"></i> يسعدنا خدمتكم</p>
            <p class="m2-txt1 p-b-25" style="font-family: 'Almarai', sans-serif;text-align: center;">Accepting orders everyday from 10:00am to 9:00pm</p>
			            <p class="m2-txt1 p-b-25" style="font-family: 'Almarai', sans-serif;text-align: center;">Except Friday from 4:00pm to 9:00pm</p>
						 <p class="m2-txt1 p-b-25" style="font-family: 'Almarai', sans-serif;text-align: center;">We are pleased to serve you <i class="fa fa-smile-o"></i></p> -->


          </div>
        </div>
		<?php
		if( $sMedia = selectDB("s_media","`id` = '1'") ){
			$instagram = $sMedia[0]["instagram"];
		}
		?>
        <div class="flex-w">
          <a href="https://www.instagram.com/<?php echo $instagram ?>" class="size3 flex-c-m how-social trans-04 m-r-15 m-b-10">
            <i class="fa fa-instagram"></i>
          </a>

        </div>
      </div>

      <div class="wsize1 simpleslide100-parent respon2">
        <!--  -->
        <div class="simpleslide100">
          <div
            class="simpleslide100-item bg-img1"
            style="background-image: url('../logos/<?php echo $settingsImage ?>')"
          ></div>
          <div
            class="simpleslide100-item bg-img1"
            style="background-image: url('../logos/<?php echo $settingsImage ?>')"
          ></div>
          <div
            class="simpleslide100-item bg-img1"
            style="background-image: url('../logos/<?php echo $settingsImage ?>')"
          ></div>
        </div>
      </div>
    </div>

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/tilt/tilt.jquery.min.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>
  </body>
</html>
