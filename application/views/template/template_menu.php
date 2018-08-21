<body>
	<div id="container">
		<ul id="side-menu">
			<li class="category">HEALTH POINT</li>
			<li id="logo">
			<img src="<?php echo base_url() ?>aset/img/healthpoint2.png"  />
			</li>
			
			<!-- <li class="sub-category"> -->
				<!-- <a href="#"><span>Data lagi</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a> -->
			<!-- </li> -->

<?php if ($permission) { ?>
			<li>
				<a href="<?php echo base_url() . 'admin/dashboard_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/dashboard_ctrl') echo 'class="current"' ?>>
					<i class='fa fa-dashboard'></i>&nbsp;DASHBOARD
				</a>
			</li>
<?php } ?>
		<li>
			<a href="<?php echo base_url() . 'admin/keluarga_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/keluarga_ctrl') echo 'class="current"' ?>>
				<i class='fa fa-history'></i>&nbsp;KELUARGA
			</a>
		</li>

		</ul>

		<div id="content">

			<div id="title-up">
				<?php if (isset($title)) echo $title ?>
				<a class="red" href="<?php echo base_url() . 'home/logout' ?>"><i class='fa fa-sign-out'></i>&nbsp;Keluar</a> 
				<a class="blue" href="<?php echo base_url() ?>html/map"><i class='fa fa-map'></i>&nbsp;Halaman depan</a>				
			</div>

			<div class="clear"></div>
			<br />
