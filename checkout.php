<?php session_start() ?>
<?php include 'templates/header.php'; ?>
<?php include 'admin/includes/config.php'; ?>
<style>
.loader{
    position: absolute;
    left: 25%;
    top: 50%;
    z-index: 1;
}
</style>
<div id="loader" class="loader" style="display:none"><img src="https://i.imgur.com/FKEilQc.gif" style="height:200px;width:200px"></div>
<div style="padding-top:20px" id="mainView">
<?php include 'templates/checkout.php'; ?>
<?php include 'templates/footer.php'; ?>
</div>