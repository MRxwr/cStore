<?php include 'templates/header.php'; ?>
<div style="padding-top:80px"></div>
<style>
.preorder{
    font-family: 'Tajawal';
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
<?php include 'templates/products/product.php';?>
<?php include 'templates/products/product-list.php';?>
<script type="">
    $(".img_producto_container")
    // tile mouse actions
    .on("mouseover", function() {
    $(this)
      .children(".img_producto")
      .css({ transform: "scale(" + $(this).attr("data-scale") + ")" });
    })
    .on("mouseout", function() {
    $(this)
      .children(".img_producto")
      .css({ transform: "scale(1)" });
    })
    .on("mousemove", function(e) {
    $(this)
      .children(".img_producto")
      .css({
        "transform-origin":
          ((e.pageX - $(this).offset().left) / $(this).width()) * 100 +
          "% " +
          ((e.pageY - $(this).offset().top) / $(this).height()) * 100 +
          "%"
      });
    });
    
     // product slider popup
    
    
    $().fancybox({
    selector : '.imglist .expand--img-popup',
    hash   : false,
    thumbs : {
    autoStart : false
    },
    buttons : [
    'fullScreen',
    'zoom',
    'download',
    'share',
    'close'
    
    ]
    
    });
</script>
<?php include 'templates/footer.php';?>