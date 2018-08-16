<html>

<!-- include another html page -->
<script>
var LOGINSTAT = false;
function includeHTML() {
	var z, i, elmnt, file, xhttp;
	/*loop through a collection of all HTML elements:*/
	z = document.getElementsByTagName("*");
	for (i = 0; i < z.length; i++) {
		elmnt = z[i];
		/*search for elements with a certain atrribute:*/
		file = elmnt.getAttribute("w3-include-html");
		if (file) {
			/*make an HTTP request using the attribute value as the file name:*/
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4) {
					if (this.status == 200) {elmnt.innerHTML = this.responseText;}
					if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
					/*remove the attribute, and call this function once more:*/
					elmnt.removeAttribute("w3-include-html");
					includeHTML();
				}
			}      
			xhttp.open("GET", file, true);
			xhttp.send();
			/*exit the function:*/
			return;
		}
	}
};
</script>
<!-- include another html page,, cara makenya: -->
<!-- <div w3-include-html="h1.html"></div>  -->

<head>
	<style>
			@font-face { font-family: sshh; src: url('../aset/fonts/sshh.ttf'); } 
			h1 {font-family: sshh}
	</style>
	<meta charset=utf-8 />
	<title>HEALTH POINT</title>
	<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />

<!-- klo ngambil dari luar -->
	<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet-src.js"></script>
	<script src="https://unpkg.com/esri-leaflet@2.0.6"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->

	<!-- bootstrap dan font awesome -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
	<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>favicon.ico">
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/font-awesome.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/bootleaf/leaflet.groupedlayercontrol.css" />
	<!-- <link rel="stylesheet" href="<?php echo base_url() ?>aset/bootleaf/L.Control.Locate.css" /> -->

	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/ResilientMaps.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/bootleaf/app.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leaflet102/leaflet.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/MarkerCluster.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/MarkerCluster.Default.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/L.Control.BetterScale.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leafletdraw/leaflet.draw.css"/>
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leaflet-search.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leaflet-measure-path.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/wind-js-leaflet.css" />
</head>

<body>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header" style="vertical-align:middle;">
				<!-- <img class="pull-left" style="width:41px;height:41px;margin-top:5px;z-index:999;" src="<?php echo base_url() ?>aset/img/1.png"> -->
				<img class="pull-left" style="vertical-align:middle; width:38px;height:38px;margin-top:5px;z-index:999;" src="<?php echo base_url() ?>aset/img/healthpoint2.png">
				<!-- <a class="navbar-brand" style="font-family:sshh;font-size:30;font-weight: normal;margin-top:0px;" href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="sidebar-legend-btn">&nbsp;Kost Putri EDUMEDIA</a> -->
				<a class="navbar-brand" style="vertical-align:middle; font-family:sshh;font-size:22;font-weight: normal;margin-bottom:0px;" href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="sidebar-legend-btn">&nbsp;HEALTH POINT&nbsp;</a>
			</div>

			<ul class="nav navbar-nav">
				<li class="btn-group btn-group-sm" style="vertical-align:middle; margin-top:10px;" role="group">
					<button type="button" class="btn btn-success" id="peta"><i class="fa fa-map"></i>  Peta</button>
					<!-- <button type="button" class="btn btn-primary" id="tabel"><i class="fa fa-table"></i>  Lihat Tabel</button> -->
					<button type="button" class="btn btn-warning" id="about"><i class="fa fa-info-circle"></i> About</button>
				</li>
				<li class="hidden-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="sidebar-form-btn"><i class="fa fa-pencil "></i>&nbsp;&nbsp;Detail Penyakit</a></li>
			</ul>
			<center>
				<p class="navbar-text" id="namapeta" style="padding-left:5%;color: white;margin-top:10px;margin-bottom:0px;font-size:23;">Peta ........&nbsp;</p>
			</center>
			<ul class="nav navbar-nav navbar-right">
				<!-- <p class="navbar-text" id="namapeta" style="color: white;margin-top:10px;margin-bottom:0px;font-size:23;">Peta .................&nbsp;</p> -->
				<li><a style="color: white;"><span class="fa fa-user"></span> Welcome <?php if ($username) echo $username ?>&nbsp;</a></li>
				<li class="btn-group btn-group-sm" style="vertical-align:middle; margin-top:10px;" role="group">
					
<?php if ($permission) { ?>
					<button type="button" class="btn btn-info" id="backend"><i class="fa fa-gears"></i>  Halaman Admin</button>
					<button type="button" class="btn btn-danger" id="logout" onclick="location.href='http://google.com';"><i class="fa fa-sign-out"></i>  Logout</button>
<?php } else { ?>       
					<button type="button" class="btn btn-info" id="login"><i class="fa fa-gears"></i>  Login</button>
<?php } ?> 
				</li>
				<!-- <form class="navbar-form navbar-left" role="search">
				  <div class="form-group">
				    <input type="text" class="form-control" placeholder="cari nama orang">
				  </div>
				  <button type="submit" class="btn btn-default">Submit</button>
				</form> -->
			</ul>
				
			<!-- </div> /.navbar-collapse  -->
		</div>
	</div>

	<!-- <div id="atasbar">
			<div id="logonoah"><img src="<?php echo base_url() ?>aset/img/logo atas.png"></div>
			<div style="font-size:24;"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TPAS </b>
				<l style="font-size:13;">- Theatre Planning Analysis System</l>
						<button type="button" class="btn btn-xs btn-default pull-right" id="sidebar-hide-btn">KANAN</button>
						<button type="button" class="btn btn-xs btn-default pull-right" id="sidebar-hide-btn">KIRI</button>      
			</div>
	</div>  -->
	
	<!-- <div id="infokiri">sdgdfgdfgdfg</div> -->
	<!-- <div id="infokanan"></div> -->
	

	<div id="container">
		<div id="sidebar">
			<div class="sidebar-wrapper">
				<!-- <div class="panel panel-default" style="max-height: 100%; overflow-y: scroll; overflow-x: hidden;" id="features"> -->
				<div class="panel panel-default" style="max-height: 100%; " id="features">
					
					<!-- <div class="panel-heading">
						<h3 class="panel-title">Legend Draw Map
						<button type="button" class="btn btn-xs btn-default pull-right" id="tutupS"><i class="fa fa-chevron-left"></i></button></h3>
					</div> -->

					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input type="text" class="form-control search" id="myinput" onkeyup="ngefilter()" placeholder="cari nama / alamat" />
							</div>
							<!-- <div class="col-xs-2 col-md-2">
								<button type="button" class="btn btn-primary pull-right sort" data-sort="feature-name" id="download-btn"><i class="fa fa-download"></i>&nbsp;&nbsp;Download All</button>
								<button type="button" class="btn btn-primary pull-right sort" data-sort="feature-name" id="filtertabel-btn"><i class="fa fa-search"></i>&nbsp;</button>
							</div> -->
						</div>
					</div>
					
					<div class="sidebar-table">
						<table class="table table-hover table-striped table-condensed" id="feature-list" style="font-size:12px;" >
							<!-- <thead class="hidden"> -->
							<thead>
								<tr>
									<th>Jenis</th>
									<th>Judul</th>
									<th>Deskripsi</th>
									<th style="display: none;">orang</th>
								<tr>
							</thead>
							<tbody class="list">
							 <!--  <tr>
									<td><img src="<?php echo base_url() ?>aset/img/lingkaran.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr>
								<tr>
									<td><img src="<?php echo base_url() ?>aset/img/marker.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr>
								<tr>
									<td><img src="<?php echo base_url() ?>aset/img/markerbulat.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr><tr>
									<td><img src="<?php echo base_url() ?>aset/img/polyline.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr>
								<tr>
									<td><img src="<?php echo base_url() ?>aset/img/polygon.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr>
								<tr>
									<td><img src="<?php echo base_url() ?>aset/img/kotak.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr> -->
							</tbody>
						</table>
					</div>
				
				</div>
			</div>
		</div>

		<div id="rightbar">
	      <div class="rightbar-wrapper">
	        <!-- <div class="panel panel-default" style="max-height: 100%; overflow-y: scroll; overflow-x: hidden;" id="features"> -->
	        <div class="panel panel-default" style="max-height: 100%;" id="features">
	          
	          <!-- FORM INPUT LAPORAN -->
	          <!-- <div class="right-panel-heading">
	            <a data-toggle="collapse" href="#formlaporan">
	              <h3 class="panel-title">
	                <button type="button" class="btn btn-xs btn-default pull-right" id="tutupR"><i class="fa fa-chevron-right"></i></button>
	                <i class="fa fa-sort"></i>&nbsp;&nbsp;Form Input Laporan
	              </h3>
	            </a>
	          </div>

	          <div class="right-panel-body collapse" id="formlaporan" >
	          <form style="font-size:12px;">
	            <div class="form-group">
	              <div class="row">
	                <div class="col-md-2" style="vertical-align: middle;"><i>Judul : </i></div>
	                <div class="col-md-10"><input id="formjudul" class="form-control" type="text" placeholder="Judul Laporan"></div>
	              </div>
	            </div>
	            <div class="form-group">
	              <div class="row">
	                <div class="col-md-2" style="vertical-align: middle;"><i>Kategori : </i></div>
	                <div class="col-md-7"><select id="formkategori" class="form-group" name="kategori">
	                  <option value="rompak">Perompakan (Robbery)</option>
	                  <option value="bajak">Pembajakan (Piracy)</option>
	                  <option value="teror">Terrorisme</option>
	                  <option value="sabotase">Sabotase</option>
	                  <option value="curiikan">Pencurian Ikan (Illegal Fishing)</option>
	                  <option value="curikayu">Penyelundupan Kayu (Illegal Logging)</option>
	                  <option value="curitambang">Penyelundupan Hasil Tambang (Illegal Mining)</option>
	                  <option value="curibarang">Penyelundupan Komoditi (Illegal Trading)</option>
	                </select></div>
	                <div class="col-md-3"><select id="formtingkat" class="form-group">
	                  <option value="low">Low</option>
	                  <option value="med">Medium</option>
	                  <option value="high">High</option>
	                </select></div>
	              </div>
	              <div class="row">
	                <div class="col-md-2" style="vertical-align: middle;"><i>Tanggal : </i></div>
	                <div class="col-md-10">
	                  <input id="formtanggal" type="date" placeholder="tanggal">
	                  <input id="formtanggal" type="datetime-local" placeholder="jam & tgl">
	                </div>
	              </div>
	            </div>
	            <div class="form-group">
	              <div class="row">
	                <div class="col-md-2" style="vertical-align: middle;"><i>Lokasi : </i></div>
	                <div class="col-md-1" style="vertical-align: middle;"><button style="vertical-align: middle;" id="formselectloc"><i class="fa fa-map-marker"></i></button></div>
	                <div class="col-md-3"><input id="formlat" class="form-control" type="text" placeholder="Lat"></div>
	                <div class="col-md-3"><input id="formlon" class="form-control" type="text" placeholder="Lon"></div>
	                <div class="col-md-3"><input id="formlokasi" class="form-control type="text" placeholder="Ket Lokasi"></div>
	              </div>
	            </div>
	            <div class="form-group">
	              <div class="row">
	                <div class="col-md-2" style="vertical-align: middle;"><i>Penjelasan Laporan : </i></div>
	                <div class="col-md-10">
	                  <textarea id="formisi" class="form-control" placeholder="Isi laporan"></textarea>
	                </div>
	              </div>
	            </div>
	            <div class="form-group">
	              <div class="row">
	                <div class="col-md-2" style="vertical-align: middle;"><i>Foto : </i></div>
	                <div class="col-md-5">
	                  <input type="file" id="formfotokjadian1">
	                </div>
	                <div class="col-md-5">
	                  <input type="file" id="formfotokjadian2">
	                </div>
	              </div>
	            </div> 

	            <i class="fa fa-user"></i>&nbsp;ORANG TERLIBAT :
	            <a data-toggle="modal" href="#nambahorang"><i class="fa fa-user-plus pull-right"> &nbsp;ORANG</i></a>
	            
	            
	            <div class="modal fade" id="nambahorang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	              <div class="modal-dialog" role="document">
	                <div class="modal-content">
	                  <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                    <h4 class="modal-title" id="myModalLabel">ORANG TERLIBAT</h4>
	                  </div>
	                  <div class="modal-body">
	                    <div class="form-group"><div class="row">
	                    <div class="col-md-4"><input id="formorgnama" class="form-control" type="text" placeholder="nama org terlibat"></div>
	                    <div class="col-md-3"><input id="formorgumur" class="form-control" type="text" placeholder="umur"></div>
	                    <div class="col-md-3"><input id="formorgsuku" class="form-control" type="text" placeholder="suku"></div>
	                    <div class="col-md-2"><select id="formorgsebagai" class="form-group" name="sebgai">
	                      <option value="Pelaku">Pelaku</option>
	                      <option value="Kurir">Kurir</option>
	                      <option value="Pengedar">Pengedar</option>
	                      <option value="Bandar">Bandar</option>
	                      <option value="Saksi">Saksi</option>
	                    </select></div>
	                    </div></div>
	                    <div class="form-group"><div class="row">
	                      <div class="col-md-3"><input id="formorgagama" class="form-control" type="text" placeholder="agama"></div>
	                      <div class="col-md-9"><input id="formorgalamat" class="form-control" type="text" placeholder="alamat"></div>
	                    </div></div>
	                    FOTO 1 : <div class="form-group"><input id="formorgfoto1" type="file"></br></div>
	                    FOTO 2 : <div class="form-group"><input id="formorgfoto2" type="file"></br></div>
	                    FOTO 3 : <div class="form-group"><input id="formorgfoto3" type="file"></br></div>
	                  </div>
	                  <div class="modal-footer">
	                    <button id="formorgbersih" type="button" class="btn btn-default" data-dismiss="modal">Reset</button>
	                    <button id="formorgkirim" type="button" class="btn btn-primary">Tambah</button>
	                  </div>
	                </div>
	              </div>
	            </div>

	            <table class="table table-hover table-striped table-condensed" style="font-size:11px;" id="formtabelorg">
	              <thead>
	                <tr>
	                  <th>Nama</th>
	                  <th>Umur</th>
	                  <th>Sebagai</th>
	                  <th>Suku</th>
	                  <th>Agama</th>
	                  <th>Alamat</th>
	                  <th>Foto</th>
	                <tr>
	              </thead>
	              <tbody class="list">
	                <tr>
	                  <td>Gopal</td>
	                  <td>17</td>
	                  <td>Saksi</td>
	                  <td>Sunda</td>
	                  <td>Islam</td>
	                  <td>Jl kemanaja no1</td>
	                  <td><a href><i class="fa fa-file"></i></a></td>
	                </tr>
	                <tr>
	                  <td>Sesdika</td>
	                  <td>37</td>
	                  <td>Saksi</td>
	                  <td>Batak</td>
	                  <td>Islam</td>
	                  <td>Jl hahaha no1</td>
	                  <td><a href><i class="fa fa-file"></i></a></td>
	                </tr>
	              </tbody>
	            </table>
	            </br>
	            <button type="submit" id="formkirim" class="btn btn-success"><i class="fa fa-send-o"></i>&nbsp;&nbsp;Submit</button>
	            <button type="reset" id="formbersih" class="btn btn-warning"><i class="fa fa-undo"></i>&nbsp;&nbsp;Reset Form</button>
	          </form>                        
	          </div>  -->
	          <!-- FORM INPUT LAPORAN -->
	          
	          <!-- TABEL LAPORAN -->
	          <!-- <div class="right-panel-heading">
	            <a data-toggle="collapse" href="#tabellaporan">
	              <h3 class="panel-title">
	                <button type="button" class="btn btn-xs btn-default pull-right" id="tutupR"><i class="fa fa-chevron-right"></i></button>
	                <i class="fa fa-sort"></i>&nbsp;&nbsp;Tabel Laporan
	              </h3>
	            </a>
	          </div> -->

      		  <div class="right-panel-body">
			  	<div class="row">
					<div class="col-xs-12 col-md-12">
						<!-- <input type="text" class="form-control search" id="myinput" onkeyup="ngefilter()" placeholder="cari nama / alamat" /> -->
						<div id="piechart"></div>
					</div>
					<div class="rightbar-table">
		              <table class="table table-hover table-striped table-condensed" id="tabellap" style="font-size:12px;">
		                <thead>
		                  <tr>
		                    <th>Nama</th>
		                    <th>Alamat</th>
		                    <th>Gender</th>
		                    <th>TTL</th>
		                    <th>Keterangan Penyakit</th>
		                    <th></th>
		                  <tr>
		                </thead>
		                <tbody class="list">
		                  	<tr>
				                  <td>Dani</td>
				                  <td>Jl Angkur no4</td>
				                  <td>L</td>
				                  <td>Bandung, 12 Agustus 1977</td>
				                  <td>TB Resisten</td>
				                  <td><a href><i class="fa fa-file"></i></a></td>
			                </tr>
			                <tr>
				                  <td>Indro</td>
				                  <td>Jl Angkur no2</td>
				                  <td>L</td>
				                  <td>Bandung, 11 Agustus 1977</td>
				                  <td>TB Paru</td>
				                  <td><a href><i class="fa fa-file"></i></a></td>
			                </tr>
			                <tr>
				                  <td>Kasino</td>
				                  <td>Jl Angkur no1</td>
				                  <td>L</td>
				                  <td>Bandung, 10 Agustus 1977</td>
				                  <td>TB Paru</td>
				                  <td><a href><i class="fa fa-file"></i></a></td>
			                </tr>
			                <tr>
				                  <td>Izul</td>
				                  <td>Jl Angkur no3</td>
				                  <td>L</td>
				                  <td>Bandung, 23 Agustus 1977</td>
				                  <td>TB Extra Paru</td>
				                  <td><a href><i class="fa fa-file"></i></a></td>
			                </tr>
			                <tr>
				                  <td>Angga</td>
				                  <td>Jl Angkur no5</td>
				                  <td>L</td>
				                  <td>Bandung, 21 Agustus 1977</td>
				                  <td>TB Extra Paru</td>
				                  <td><a href><i class="fa fa-file"></i></a></td>
			                </tr>
			                <tr>
				                  <td>Budi</td>
				                  <td>Jl Angkur no6</td>
				                  <td>L</td>
				                  <td>Bandung, 20 Agustus 1977</td>
				                  <td>TB Extra Paru</td>
				                  <td><a href><i class="fa fa-file"></i></a></td>
			                </tr>
		                </tbody>
		              </table>
		            </div>
				</div>
			  </div>

	          <!-- <div class="right-panel-body" id="tabellaporan" > -->
	            <!-- <div class="rightbar-table">
	              <table class="table table-hover table-striped table-condensed" id="tabellap" style="font-size:12px;">
	                <thead>
	                  <tr>
	                    <th>Nama</th>
	                    <th>Alamat</th>
	                    <th>Gender</th>
	                    <th>TTL</th>
	                    <th>Keterangan Penyakit</th>
	                  <tr>
	                </thead>
	                <tbody class="list">
	                  
	                </tbody>
	              </table>
	            </div> -->

	          <!-- </div> --> <!-- right panel body -->
	        
	        </div>
	      </div>
	    </div>
		



		<div id="map"></div>

		<!-- Modal content -->
		<!-- <div id="modalcoba" class="modal">
			<div class="modal-content">
				<span class="close">&times;</span>
				<p>Some text in the Modal..</p>
			</div>
		</div> -->
					<!-- <div class="modal fade" id="modalcoba" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Detail Kamar</h4>
								</div>
									<div id="modalcobabody" class="modal-body">
								</div>
							</div>
						</div>
					</div> -->


					<!-- MODAL GALERY -->
					<!-- <div class="modal fade" id="modalgalery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">GALERY</h4>
								</div>
								<div class="modal-body" style="text-align: center;">
									
									<a id="goleft" style="position:absolute; left:10px;" class="fa fa-chevron-left"></a>
									<div style="position:absolute; left:50%;" id="modalgaleryinfo"> </div>
									<a id="goright" style="position:absolute; right:10px;" class="fa fa-chevron-right"></a><br>
									<img id="modalgaleryviewer" src="" width="100%" />

								</div>
							</div>
						</div>
					</div> -->

					<div class="modal fade" id="modalcoba" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			            <div class="modal-dialog" role="document">
			              <div class="modal-content">
			                <div class="modal-header">
			                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                  <h4 class="modal-title" id="myModalLabel">REKAM MEDIS</h4>
			                </div>
			                <div class="modal-body">

			                  <!-- Nav tabs -->
			                  <ul class="nav nav-tabs" role="tablist">
			                    <li role="presentation" class="active"><a href="#biodata" aria-controls="biodata" role="tab" data-toggle="tab">Biodata</a></li>
			                    <li role="presentation"><a href="#puskesmas" aria-controls="puskesmas" role="tab" data-toggle="tab">Program Puskesmas</a></li>
			                    <li role="presentation"><a href="#menular" aria-controls="menular" role="tab" data-toggle="tab">Penyakit Menular</a></li>
			                    <li role="presentation"><a href="#tdkmenular" aria-controls="tdkmenular" role="tab" data-toggle="tab">Penyakit Tdk Menular</a></li>
			                  </ul>

			                  <!-- Tab panes -->
			                  <div class="tab-content">
			                    <!-- biodata -->
			                    <div role="tabpanel" class="tab-pane active" id="biodata">
			                      <table class="table table-hover table-striped table-condensed" id="tblbiodata" style="font-size:12px;" >
			                        <thead>
			                          <tr>
			                            <!-- <th>Key</th> -->
			                            <!-- <th>Value</th> -->
			                          <tr>
			                        </thead>
			                        <tbody class="list">
			                         <!-- <tr>
			                            <td>Foto : </td>
			                            <td><img src="aset/img/pasfoto.jpg" width="51" height="70"></td>
			                          </tr> -->
			                        </tbody>
			                      </table>
			                    </div>
			                    <!-- puskesmas -->
			                    <div role="tabpanel" class="tab-pane" id="puskesmas">
			                      <table class="table table-hover table-striped table-condensed" id="tblpuskesmas" style="font-size:12px;" >
			                        <tbody class="list">
			                        </tbody>
			                      </table>
			                    </div>
			                    <!-- menular -->
			                    <div role="tabpanel" class="tab-pane" id="menular">
			                      <table class="table table-hover table-striped table-condensed" id="tblmenular" style="font-size:12px;" >
			                        <tbody class="list">
			                        </tbody>
			                      </table>
			                    </div>
			                    <!-- tdkmenular -->
			                    <div role="tabpanel" class="tab-pane" id="tdkmenular">
			                      <table class="table table-hover table-striped table-condensed" id="tbltdkmenular" style="font-size:12px;" >
			                        <tbody class="list">
			                        </tbody>
			                      </table>
			                    </div>
			                  </div>
			                  


			                </div>
			                <!-- <div class="modal-footer">
			                  <button id="formorgbersih" type="button" class="btn btn-default" data-dismiss="modal">Reset</button>
			                  <button id="formorgkirim" type="button" class="btn btn-primary">Tambah</button>
			                </div> -->
			              </div>
			            </div>
			          </div>

	</div>

	<!-- <div id="map"></div>    -->
	<!-- <div id="logoresilient" > -->
		<!-- <img src="<?php echo base_url() ?>aset/img/logosk.png"> -->
	<!-- </div> -->




	<!-- leaflet -->
	<script src="<?php echo base_url() ?>aset/leaflet102/leaflet-src.js"></script>
	<script src="<?php echo base_url() ?>aset/leaflet.rotatedMarker.js"></script>
	<script src="<?php echo base_url() ?>aset/esri-leaflet-2.0.6.js"></script>
	<script src="<?php echo base_url() ?>aset/esri-leaflet-cluster-debug.js"></script>
	<script src="<?php echo base_url() ?>aset/jQuery-v3.1.1.js"></script>

	<!-- leaflet search -->
	<script src="<?php echo base_url() ?>aset/leaflet-search.js"></script>

	<!-- leaflet grouplayer -->
	<script src="<?php echo base_url() ?>aset/bootleaf/leaflet.groupedlayercontrol.js"></script>

	<!-- wind -->
	<script src="<?php echo base_url() ?>aset/wind-js-leaflet.js"></script>

	<!-- leaflet control locate -->
	<!-- <script src="<?php echo base_url() ?>aset/bootleaf/L.Control.Locate.min.js"></script> -->

	<!-- marker cluster -->
	<script src="<?php echo base_url() ?>aset/MarkerCluster.js"></script>
	<script src="<?php echo base_url() ?>aset/DistanceGrid.js"></script>
	<script src="<?php echo base_url() ?>aset/MarkerClusterGroup.js"></script>
	<script src="<?php echo base_url() ?>aset/MarkerOpacity.js"></script>
	<script src="<?php echo base_url() ?>aset/MarkerClusterGroup.Refresh.js"></script>
	<script src="<?php echo base_url() ?>aset/MarkerCluster.Spiderfier.js"></script>
	<script src="<?php echo base_url() ?>aset/MarkerCluster.QuickHull.js"></script>

	<!-- scale -->
	<script src="<?php echo base_url() ?>aset/leaflet.nauticscale.js"></script>
	<script src="<?php echo base_url() ?>aset/L.Control.BetterScale.js"></script>

	<!-- measurement -->
	<script src="<?php echo base_url() ?>aset/leaflet-measure-path.js"></script>
	
	<!-- draw -->
	<script src="<?php echo base_url() ?>aset/leafletdraw/Leaflet.draw.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/Leaflet.Draw.Event.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/Toolbar.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/Tooltip.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/GeometryUtil.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/LatLngUtil.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/LineUtil.Intersect.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/Polygon.Intersect.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/Polyline.Intersect.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/TouchEvents.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/DrawToolbar.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Feature.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.SimpleShape.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Polyline.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Circle.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Marker.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerMerah.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerBulat.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerBiru.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerAbu.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerHijau.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerUngu.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Polygon.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Rectangle.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/EditToolbar.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/EditToolbar.Edit.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/EditToolbar.Delete.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/Control.Draw.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/Edit.Poly.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/Edit.SimpleShape.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/Edit.Circle.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/Edit.Rectangle.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/Edit.Marker.js"></script>

	<!-- button menu -->
	<!-- <script src="<?php echo base_url() ?>aset/easy-button.js"></script> -->
	<!-- <link rel="stylesheet" href="<?php echo base_url() ?>aset/easy-button.css" /> -->
	<script src="<?php echo base_url() ?>aset/Leaflet.Control.Custom.js"></script>
	
	<!-- ESRI -->
	<!-- <script src="https://unpkg.com/esri-leaflet-vector@1.0.5"></script> -->
	<!-- <script src="https://unpkg.com/esri-leaflet-cluster@2.0.0"></script> -->

	<!-- piechar -->
	<script src="<?php echo base_url() ?>aset/piechartloader.js"></script>

	<!-- bootstrap -->
	<script src="<?php echo base_url() ?>aset/bootstrap.min.js"></script>

	<!-- JSONjs -->
	<script src="<?php echo base_url() ?>aset/JSONjs/json2.js"></script>

	<!-- MAP ASLI -->
	<script src="<?php echo base_url() ?>aset/ResilientMaps.js"></script>
	<script>
		



		// ga kepake
<?php if ($permission) { ?>
	function modalkamar(i,ii){
		// console.log("bikin append");
		// console.log(KOSANS);
		$("#modalcobabody").empty();
		
		$("#modalcobabody").append(
			'<ul class="nav nav-tabs" role="tablist">'+
				'<li role="presentation" class="active"><a href="#ketdetail" aria-controls="ketdetail" role="tab" data-toggle="tab">Keterangan</a></li>'+
				'<li role="presentation"><a onclick="gambarkamar('+i+','+ii+')" href="#ketgalery" aria-controls="ketgalery" role="tab" data-toggle="tab">Galery</a></li>'+
				'<li role="presentation"><a href="#ketpenghuni" aria-controls="ketpenghuni" role="tab" data-toggle="tab">Penghuni (khusus admin)</a></li>'+
			'</ul>'+
			'<div class="tab-content">'+
				'<div role="tabpanel" class="tab-pane active" id="ketdetail">'+
					'<table class="table table-hover table-striped table-condensed" style="font-size:12px;" >'+
						'<tbody class="list">'+
							'<tr><td>Nama :</td>                  <td>'+KOSANS[i].properties.kamar[ii].nama+'</td></tr>'+ 
							'<tr><td>Luas :</td>                  <td>'+KOSANS[i].properties.kamar[ii].luas+'</td></tr>'+
							'<tr><td>Fasilitas :</td>             <td>'+KOSANS[i].properties.kamar[ii].fasilitas+'</td></tr>'+
							'<tr><td>Harga /thn :</td>            <td>'+KOSANS[i].properties.kamar[ii].hargath+'</td></tr>'+
							'<tr><td>Terisi :</td>                <td>'+KOSANS[i].properties.kamar[ii].terisi+'</td></tr>'+
						'</tbody>'+
					'</table>'+
				'</div>'+
				'<div role="tabpanel" style="text-align: center;" class="tab-pane" id="ketgalery">'+
					'<a id="gileft" style="position:absolute; left:10px;" class="fa fa-chevron-left"></a>'+
					'<div style="position:absolute; left:50%;" id="modalkamarinfo"> </div>'+
					'<a id="giright" style="position:absolute; right:10px;" class="fa fa-chevron-right"></a><br>'+
					'<img id="modalkamarviewer" src="" width="80%" />'+
				'</div>'+
				'<div role="tabpanel" class="tab-pane" id="ketpenghuni">'+
					'<table class="table table-hover table-striped table-condensed" style="font-size:12px;" >'+
						'<tbody class="list">'+
							'<tr><td>Foto :</td>             <td>'+KOSANS[i].properties.kamar[ii].penghunifoto+'</td></tr>'+
							'<tr><td>Nama Penghuni :</td>     <td>'+KOSANS[i].properties.kamar[ii].penghuninama+'</td></tr>'+ 
							'<tr><td>No HP :</td>            <td>'+KOSANS[i].properties.kamar[ii].penghunihp+'</td></tr>'+
							'<tr><td>No HP darurat :</td>    <td>'+KOSANS[i].properties.kamar[ii].penghunihpdarurat+'</td></tr>'+
							'<tr><td>Alamat :</td>           <td>'+KOSANS[i].properties.kamar[ii].penghunialamat+'</td></tr>'+
							'<tr><td>No KTP :</td>           <td>'+KOSANS[i].properties.kamar[ii].penghuninoktp+'</td></tr>'+
							'<tr><td>Foto KTP :</td>         <td><a>'+KOSANS[i].properties.kamar[ii].penghunifotoktp+'</a></td></tr>'+
							'<tr><td>Foto KTM :</td>         <td><a>'+KOSANS[i].properties.kamar[ii].penghunifotoktm+'</a></td></tr>'+
							'<tr><td>Latar Belakang :</td>   <td>'+KOSANS[i].properties.kamar[ii].penghunilatar+' </td></tr>'+
							'<tr><td>Tgl Masuk :</td>        <td>'+KOSANS[i].properties.kamar[ii].tglmasuk+'</td></tr>'+
							'<tr><td>Tgl Keluar :</td>       <td>'+KOSANS[i].properties.kamar[ii].tglkeluar+'</td></tr>'+
							'<tr><td>Pembayaran :</td>       <td>'+KOSANS[i].properties.kamar[ii].pmbayaran+'</td></tr>'+
							'<tr><td>Sisa Pembayaran :</td>  <td>'+KOSANS[i].properties.kamar[ii].sisapmbayaran+' </td></tr>'+
						'</tbody>'+
					'</table>'+
				'</div>'+
			'</div>');
		
		syncSidebar();
	}
<?php } else { ?>
	function modalkamar(i,ii){
		// console.log("bikin append");
		// console.log(KOSANS);
		$("#modalcobabody").empty();
		
		$("#modalcobabody").append(
			'<ul class="nav nav-tabs" role="tablist">'+
				'<li role="presentation" class="active"><a href="#ketdetail" aria-controls="ketdetail" role="tab" data-toggle="tab">Keterangan</a></li>'+
				'<li role="presentation"><a onclick="gambarkamar('+i+','+ii+')" href="#ketgalery" aria-controls="ketgalery" role="tab" data-toggle="tab">Galery</a></li>'+
			'</ul>'+
			'<div class="tab-content">'+
				'<div role="tabpanel" class="tab-pane active" id="ketdetail">'+
					'<table class="table table-hover table-striped table-condensed" style="font-size:12px;" >'+
						'<tbody class="list">'+
							'<tr><td>Nama :</td>                  <td>'+KOSANS[i].properties.kamar[ii].nama+'</td></tr>'+ 
							'<tr><td>Luas :</td>                  <td>'+KOSANS[i].properties.kamar[ii].luas+'</td></tr>'+
							'<tr><td>Fasilitas :</td>             <td>'+KOSANS[i].properties.kamar[ii].fasilitas+'</td></tr>'+
							'<tr><td>Harga /thn :</td>            <td>'+KOSANS[i].properties.kamar[ii].hargath+'</td></tr>'+
							'<tr><td>Terisi :</td>                <td>'+KOSANS[i].properties.kamar[ii].terisi+'</td></tr>'+
						'</tbody>'+
					'</table>'+
				'</div>'+
				'<div role="tabpanel" style="text-align: center;" class="tab-pane" id="ketgalery">'+
					'<a id="gileft" style="position:absolute; left:10px;" class="fa fa-chevron-left"></a>'+
					'<div style="position:absolute; left:50%;" id="modalkamarinfo"> </div>'+
					'<a id="giright" style="position:absolute; right:10px;" class="fa fa-chevron-right"></a><br>'+
					'<img id="modalkamarviewer" src="" width="80%" />'+
				'</div>'+
			'</div>');
		
		syncSidebar();
	}
<?php } ?>
	</script>
</body>
</html>
