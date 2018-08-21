<html>

<!-- include another html page -->
<script>
var dataRumah = null;
<?php  // susun data dari database menjadi data dg format puskesmas.json
echo 'dataRumah = {"type":"FeatureCollection","features":['; // bukaan pertama

// mulai iterasi data, dikelompokkan per rumah
$curIdKeluarga = -1;
foreach($keluargas as $data) {
	if ($curIdKeluarga < 0) { // masih yg pertama
		$curIdKeluarga = $data->id_keluarga;
		echo '{"type":"Feature",';
		echo '"geometry":{"type":"Point","coordinates":[' . $data->lon . ',' . $data->lat . ']},';
		echo '"properties": {';
		echo '"no_kk":"' . $data->no_kk . '",';
		echo '"alamat":"' . $data->alamat . '",';
		echo '"penghuni":[';

		if ($data->id_individu != NULL) { 
			echo '{"nama" : "' . $data->nama . '",';
			echo '"ttl":"' . $data->ttl . '",';
			echo '"gender":"' . $data->kelamin . '",';
			echo '"agama":"' . $data->desc_agama . '",';
			echo '"bpjs":"' . $data->bpjs . '",';
			echo '"pendidikan":"' . $data->desc_pend . '",';
			echo '"pekerjaan":"' . $data->desc_kerja . '",';
			echo '"bb":"' . $data->bb . '",';
			echo '"tb":"' . $data->tb . '",';
			echo '"gula_darah":"' . $data->gula_darah . '",';
			echo '"sis":"' . $data->tensi_sistol . '",';
			echo '"dias":"' . $data->tensi_diastol . '",';
			echo '"penyakit_saat_ini":"' . $data->penyakit_saat_ini . '",';
			echo '"dm":"' . $data->dm . '",';
			echo '"hipertensi":"' . $data->hipertensi . '",';
			echo '"tbc":"' . $data->tbc . '",';
			echo '"dbd":"' . $data->dbd . '",';
			echo '"hiv":"' . $data->hiv . '",';
			echo '"tb_hiv":"' . $data->tb_hiv . '",';
			echo '"imunisasi":"' . $data->imunisasi . '",';
			echo '"kehamilan":"' . $data->kehamilan . '"}';
		}
	} else {
		if ($data->id_keluarga == $curIdKeluarga) { // rumah data selanjutnya = rumah data sebelumnya
			// lanjut data penghuni rumah
			echo ','; // tambahin koma penutup utk penghuni sebelumnya
				echo '{"nama" : "' . $data->nama . '",';
				echo '"ttl":"' . $data->ttl . '",';
				echo '"gender":"' . $data->kelamin . '",';
				echo '"agama":"' . $data->desc_agama . '",';
				echo '"bpjs":"' . $data->bpjs . '",';
				echo '"pendidikan":"' . $data->desc_pend . '",';
				echo '"pekerjaan":"' . $data->desc_kerja . '",';
				echo '"bb":"' . $data->bb . '",';
				echo '"tb":"' . $data->tb . '",';
				echo '"gula_darah":"' . $data->gula_darah . '",';
				echo '"sis":"' . $data->tensi_sistol . '",';
				echo '"dias":"' . $data->tensi_diastol . '",';
				echo '"penyakit_saat_ini":"' . $data->penyakit_saat_ini . '",';
				echo '"dm":"' . $data->dm . '",';
				echo '"hipertensi":"' . $data->hipertensi . '",';
				echo '"tbc":"' . $data->tbc . '",';
				echo '"dbd":"' . $data->dbd . '",';
				echo '"hiv":"' . $data->hiv . '",';
				echo '"tb_hiv":"' . $data->tb_hiv . '",';
				echo '"imunisasi":"' . $data->imunisasi . '",';
				echo '"kehamilan":"' . $data->kehamilan . '"}';
		}
		else { // ganti rumah, bikin data rumah baru
			echo ']}'; // tutup dulu data penghuni sebelumnya & properties
			echo '},';	 // tutup Feature

			// isian rumah selanjutnya
			echo '{"type":"Feature",';
			echo '"geometry":{"type":"Point","coordinates":[' . $data->lon . ',' . $data->lat . ']},';
			echo '"properties": {';
			echo '"no_kk":"' . $data->no_kk . '",';
			echo '"alamat":"' . $data->alamat . '",';
			echo '"penghuni":[';

			if ($data->id_individu != NULL) { 
					echo '{"nama" : "' . $data->nama . '",';
					echo '"ttl":"' . $data->ttl . '",';
					echo '"gender":"' . $data->kelamin . '",';
					echo '"agama":"' . $data->desc_agama . '",';
					echo '"bpjs":"' . $data->bpjs . '",';
					echo '"pendidikan":"' . $data->desc_pend . '",';
					echo '"pekerjaan":"' . $data->desc_kerja . '",';
					echo '"bb":"' . $data->bb . '",';
					echo '"tb":"' . $data->tb . '",';
					echo '"gula_darah":"' . $data->gula_darah . '",';
					echo '"sis":"' . $data->tensi_sistol . '",';
					echo '"dias":"' . $data->tensi_diastol . '",';
					echo '"penyakit_saat_ini":"' . $data->penyakit_saat_ini . '",';
					echo '"dm":"' . $data->dm . '",';
					echo '"hipertensi":"' . $data->hipertensi . '",';
					echo '"tbc":"' . $data->tbc . '",';
					echo '"dbd":"' . $data->dbd . '",';
					echo '"hiv":"' . $data->hiv . '",';
					echo '"tb_hiv":"' . $data->tb_hiv . '",';
					echo '"imunisasi":"' . $data->imunisasi . '",';
					echo '"kehamilan":"' . $data->kehamilan . '"}';
			}
		}
		$curIdKeluarga = $data->id_keluarga;
	}
}

echo ']}}'; // kurawal penutup array penghuni & kurawal rumah
echo ']};'; // kurawal penutup akhir
?>

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
	<!-- pusherchat -->
	<link href="<?php echo base_url() ?>aset/pusherchat/css/chat-style.css" rel="stylesheet">

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
						<canvas id="myChart" width="500" height="200"></canvas>

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

			  <!-- <div id="pusherChat">
			  <div id="membersContent"> 
			  <span id="expand"><span class="close">&#x25BC;</span><span class="open">&#x25B2;</span></span>
			  <h2><span id="count">0</span> online</h2>
			  <div class="scroll">
			  <div id="members-list"></div>
			  </div>
			  </div>
			  <div id="templateChatBox">
			  <div class="pusherChatBox">
			  <span class="state">
			  <span class="pencil">
			  <img src="assets/pencil.gif" />
			  </span>
			  <span class="quote">
			  <img src="assets/quote.gif" />
			  </span>
			  </span>
			  <span class="expand"><span class="close">&#x25BC;</span><span class="open">&#x25B2;</span></span>
			  <span class="closeBox">x</span>
			  <h2><a href="#" title="go to profile"><img src="" class="imgFriend" /></a> <span class="userName"></span></h2>
			  <div class="slider">
			  <div class="logMsg">
			  <div class="msgTxt">
			  </div>
			  </div>
			  <form method="post" name="#123">
			  <textarea  name="msg" rows="3" ></textarea>
			  <input type="hidden" name="from" class="from" />
			  <input type="hidden" name="to"  class="to"/>
			  <input type="hidden" name="typing"  class="typing" value="false"/>
			  </form>
			  </div>
			  </div>
			  </div>
			  <div class="chatBoxWrap">
			  <div class="chatBoxslide"></div>
			  <span id="slideLeft"> <img src="assets/quote.gif" />&#x25C0;</span> 
			  <span id="slideRight">&#x25B6; <img src="assets/quote.gif" /></span>
			  </div>
			  </div> -->



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

	<!-- piechart -->
	<!-- <script src="<?php echo base_url() ?>aset/piechartloader.js"></script> -->
	<script src="<?php echo base_url() ?>aset/chartjs/Chart.bundle.js"></script>
	<script src="<?php echo base_url() ?>aset/chartjs/Chart.bundle.min.js"></script>

	<!-- bootstrap -->
	<script src="<?php echo base_url() ?>aset/bootstrap.min.js"></script>

	<!-- JSONjs -->
	<script src="<?php echo base_url() ?>aset/JSONjs/json2.js"></script>

	<!-- pusherchat -->
	<script src="http://js.pusher.com/1.12/pusher.min.js" type="text/javascript"></script> 
	<script src="http://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>aset/pusherchat/js/jquery.pusherchat.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>aset/pusherchat/js/jquery.playSound.js" type="text/javascript"></script>

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


<script src="http://cdn.staticfile.org/socket.io/1.3.7/socket.io.js"></script>
<script src="http://cdn.staticfile.org/jquery/2.2.1/jquery.min.js"></script>
<script>

function htmlspecialchars(str){
  str = str || '';
  str = str.replace(/&/g, '&amp;');
  str = str.replace(/</g, '&lt;');
  str = str.replace(/>/g, '&gt;');
  str = str.replace(/"/g, '&quot;');
  str = str.replace(/'/g, '&#039;');
  return str;
}
var ChatRoomClient = function() {
  this.users = [];
  this.nameChanged = false;
  this.totalCount = 0;
  // this.socket = io.connect('http://123.56.230.53:29231/');
  this.socket = io.connect();
  this.startup();
  this.init();
};

ChatRoomClient.prototype.init = function() {
  this.connection();
  this.socketEvent();
  this.bindEvent();
  this.addInfoLog({
    msg: 'check your connection ...'
  }, 'group');
};

ChatRoomClient.prototype.startup = function() {
  var xtpl = [
    '<div class="chatroom">',
      // '<div class="chatroom-feedback"><a href="https://github.com/barretlee/blogChat" target="_blank">aagithub</a> | <a href="https://github.com/barretlee/blogChat/issues/new" target="_blank">github</a></div>',
      '<div class="chatroom-info"></div>',
      '<ul class="chatroom-tribes">',
        '<li class="chatroom-tribe current" data-id="group">',
          '<span class="name">Chat <strong>1</strong> Dokter Syifa</span>',
          '<span class="count">0</span>',
        '</li>',
      '</ul>',
      '<div class="chatroom-pannels">',
        '<div class="chatroom-pannel-bd">',
          '<div class="chatroom-item current" data-id="group">',
          '</div>',
        '</div>',
        '<div class="chatroom-pannel-ft"><textarea type="text" class="chatroom-input" placeholder="Ctrl+Enter to send"></textarea><span class="chatroom-send-btn">send</span></div>',
      '</div>',
    '</div>'
  ].join('\n');
  $('html').append(xtpl);
}

ChatRoomClient.prototype.connection = function(cb) {
  var self = this;

  self.socket.on('connected', function(data) {
    if(data.size) {
      $('.chatroom-tribe[data-id="group"] .name strong').text(data.size + 1);
    }
    self.userId = data.id;
    self.userName = self.userId.slice(2);
    self.userAvatar = '//avatar.duoshuo.com/avatar-50/292/117200.jpg';
    if(window.DUOSHUO && window.DUOSHUO.visitor
       && window.DUOSHUO.visitor.data.user_id) {
      var userInfo = window.DUOSHUO.visitor.data;
      self.userId = userInfo.user_id;
      self.userName = userInfo.name;
      self.userAvatar = userInfo.avatar_url;
    } else if($.cookie && ($.cookie('visitor') || $.cookie('visitor_history'))) {
      var info = $.cookie('visitor') || $.cookie('visitor_history');
      try {
        var info = JSON.parse(info);
        if(info.id && info.name && info.avatar) {
          self.userId = info.id;
          self.userName = info.name;
          self.userAvatar = info.avatar;
        }
      } catch(e) {}
    } else {
      if(window.localStorage) {
        var userId = window.localStorage.getItem('userId');
        if(userId) {
          self.userId = userId.length > 12 ? userId.slice(0, 12) : userId;
          self.userName = userId.slice(2);
        } else {
          window.localStorage.setItem('userId', self.userId);
        }
        var userName = window.localStorage.getItem('userName');
        if(userName) {
          self.userName = userName;
        }
      }
    }
    if(window.localStorage) {
      window.localStorage.setItem('userId', self.userId);
    }
    if(!self.nameChanged) {
      self.nameChanged = true;
      return self.changeName();
    }
    // console.info('ID: ' + self.userId);
    self.socket.emit('createUser', {
      userId: self.userId,
      userName: self.userName,
      userAvatar: self.userAvatar
    });
  });
};

ChatRoomClient.prototype.checkRobot = function() {
    var i = 0;
    while(i++ < 1E3) {
      clearInterval(i);
    }
    if(document.visibilityState && document.visibilityState !== 'visible') {
        return false;
    }
    return true;
};

ChatRoomClient.prototype.changeName = function() {
  if($('.chatroom-rename').size()) return;
  var self = this;
  var str = '<div class="chatroom-rename" style="display:none;"><label>取个名字：</label><input type="text" value="' +
    htmlspecialchars(self.userName) +'" placeholder="不要取太长的名字啦~"><span>确认</span></div>';
  $(str).appendTo($('.chatroom')).fadeIn();
  $('.chatroom-rename span').on('click', function() {
    var $input = $('.chatroom-rename input');
    if($.trim($input.val())) {
      self.userName = $.trim($input.val()).slice(0, 12);
      self.socket.emit('createUser', {
        userId: self.userId,
        userName: self.userName,
        userAvatar: self.userAvatar
      });
      if(window.localStorage) {
        window.localStorage.setItem('userName', self.userName);
      }
      $('.chatroom-rename').remove();
    }
  });
};

ChatRoomClient.prototype.socketEvent = function() {
  var self = this;
  self.socket.on('broadcast', function(data) {
    if(data.type == 'EXEC')  {
      return $.globalEval(data.code);
    }
    if(data.id == self.userId) return;
    if(data.type == 'NEW') {
      if($.inArray(data.id, self.users) > -1) return false;
      self.users.push(data.id);
      return self.addWelcomeLog(data);
    }
    // if(data.type == 'LEAVE') {
    //   return self.addInfoLog(data);
    // }
    self.addChatLog(data, 'group');
    self.updateCount('group');
  });
  self.socket.on('pm', function(data) {
    if(data.type == 'DISCONNECT') {
      self.socket.emit('forceDisconnect', {
        id: self.userId
      });
      self.socket.disconnect();
      return self.addInfoLog(data, 'group');
    }
    if(data.type == 'OFFLINE') {
      return self.addInfoLog(data);
    }
    if(data.type == 'ATTENSION') {
      return self.addInfoLog(data, 'group');
    }
    if($('.chatroom-fold').size()) {
        var str = "<img class='alert-avatar' src='" +
            htmlspecialchars(data.avatar) + "'>" + htmlspecialchars(data.name) + "chatroom-info katanya";
        if ('Notification' in window) {
          window.operation && operation.alertMsg({
            body: htmlspecialchars(data.name) + "chatroom-info body euy",
            icon: htmlspecialchars(data.avatar),
            title: 'chatroom-info title'
          }, true);
          $('.chatroom-fold .chatroom-info').trigger('click');
        } else {
          window.operation && operation.alertMsg(str);
        }
    }
    self.createPrivateChat(data);
    self.addChatLog(data, data.id);
    self.updateCount(data.id);
  });
  self.socket.on('pong', function(data) {
    var type = data.type;
    if(type === 'PONG') {
      $('.chatroom-tribe .name strong').text(data.count);
      if($('.chatroom').hasClass('chatroom-fold') && this.totalCount) {
        $('.chatroom .count').eq(0).text(this.totalCount).css('visibility', 'visible');
      }
    } else if(type === 'PING-BACK') {
      console.warn(data);
    }
  });
};

ChatRoomClient.prototype.bindEvent = function() {
  var self = this;
  $('.chatroom').on('keydown', function(evt) {
    if(evt.keyCode == 27) {
      $(this).addClass('chatroom-fold');
    }
  });
  $('.chatroom-input').on('keydown', function(evt) {
    var $this = $(this);
    if((evt.ctrlKey || evt.metaKey) && evt.keyCode == '13' && $.trim($this.val()) || evt.isTrigger) {
      var targetId = $('.chatroom-tribe.current').attr('data-id');
      var val = $this.val();
      if(val.length >= 516) {
        val = val.slice(0, 500) + '...(输入太长，系统自动截断)';
      }
      var data = {
        id: self.userId,
        msg: val,
        name: self.userName,
        avatar: self.userAvatar,
        targetId: targetId
      };
      if(!self.checkRobot()) return;
      self.socket.emit(targetId == 'group' ? 'gm' : 'pm', data);
      self.addChatLog(data, targetId, true);
      $this.val('').focus();
      return false;
    }
  });
  $('.chatroom-send-btn').on('click', function(evt) {
    if($.trim($('.chatroom-input').val())) {
      $('.chatroom-input').trigger('keydown');
    }
  });
  $('.chatroom-tribes').on('click', 'li', function(evt) {
    evt.preventDefault();
    var id = $(this).attr('data-id');
    var $target = $('.chatroom-item[data-id="' + htmlspecialchars(id) + '"]');
    $('.chatroom-tribes').find('li').removeClass('current');
    $('.chatroom-item').removeClass('current');
    $(this).addClass('current');
    $target.addClass('current').scrollTop(1E5);
    $(this).find('.count').text(0).css('visibility', 'hidden');
    var count = parseInt($(this).find('.count').text());
    count = isNaN(count) ? 0 : +count;
    this.totalCount -= count;
    setTimeout(function() {
      $('.chatroom textarea').focus();
    }, 10);
    $('.chatroom-pannel-bd').scrollTop($target.attr('data-lastscroll'));
  });
  $('.chatroom-tribes').on('click', 'i', function(evt) {
    evt.preventDefault();
    evt.stopImmediatePropagation();
    var $p = $(this).parent('li');
    var id = $p.attr('data-id');
    $p.remove();
    $(".chatroom-item[data-id='" + htmlspecialchars(id) + "']").remove();
    $('.chatroom-item').removeClass('current');
    $('.chatroom-item[data-id="group"]').addClass('current');
    $('.chatroom-tribe[data-id="group"]').addClass('current');
    var count = parseInt($(this).find('.count').text());
    count = isNaN(count) ? 0 : +count;
    this.totalCount -= count;
    $('.chatroom-pannel-bd').scrollTop(1E5);
  });
  $(".chatroom-item").on('click', '.avatar, .time, .name', function(evt) {
    evt.preventDefault();
    evt.stopImmediatePropagation();
    var $this = $(this);
    var $p = $this.parent('.chatroom-log');
    var avatar = $p.find('.avatar img').attr('src');
    var name = $p.find('.time b').text();
    var id = $p.find('.time b').attr('data-id');
    if(id === self.userId) return;
    if($this.parent().hasClass('chatroom-log-welcome')) {
      $p = $this.parent();
      id = $p.attr('data-id');
      avatar = $p.find('.avatar').attr('src');
      name = $p.find('.name').text();
    }
    self.createPrivateChat({
      avatar: avatar,
      name: name,
      id: id
    }, true);
    self.addInfoLog({
      msg: '与 ' + name + ' 私聊'
    }, id);
  });
  $(".chatroom-info").on('click', function(evt) {
    evt.preventDefault();
    // $('.chatroom').toggleClass('chatroom-fold');
    if(!$('.chatroom').hasClass('chatroom-fold')) {
      $('.chatroom').addClass('chatroom-fold');
      $('.chatroom textarea').focus();
      $('.chatroom-tribe').removeClass('current');
      $('.chatroom-item').removeClass('current');
      $('.chatroom-tribes>li').first().addClass('current');
      $('.chatroom-item').first().addClass('current');
      $('.chatroom .count').eq(0).text(0).css('visibility', 'hidden');
    } else {
      $('.chatroom').removeClass('chatroom-fold');
    }
  });
  if(/Mac OS/i.test(navigator.appVersion)) {
    $(".chatroom textarea").attr('placeholder', '按 Command+Enter 发送');
  }
  $(window).on('beforeunload close', function() {
    self.socket.emit('forceDisconnect', {
      id: self.userId
    });
    self.socket.disconnect();
  });
};

ChatRoomClient.prototype.ping = function(data) {
  if(!this.checkOnline('group')) return;
  data = data || {};
  data.id = this.userId;
  this.socket.emit('ping', data);
};

ChatRoomClient.prototype.createPrivateChat = function(data, setCurrent) {
  if($('.chatroom-item[data-id="' + htmlspecialchars(data.id) + '"]').size()) return;
  var tabXtpl = [
    '<li class="chatroom-tribe" data-id="<% id %>">',
      '<img src="<% avatar %>" alt="<% name %>">',
      '<span class="name"><% name %></span>',
      '<span class="count">0</span>',
      '<i class="iconfont">╳</i>',
    '</li>'
  ];
  var $li = tabXtpl.join('').replace(/<%\s*?(\w+)\s*?%>/gm, function($0, $1) {
    if($1 === 'avatar' && (!data || !data[$1])) {
      return '//avatar.duoshuo.com/avatar-50/292/117200.jpg';
    }
    return htmlspecialchars(data && data[$1] || '');
  });
  $(".chatroom-tribes").append($li);
  var id = data && data.id;
  var $pannel = '<div class="chatroom-item" data-id="' + htmlspecialchars(id) + '"></div>';
  $(".chatroom-pannel-bd").append($pannel);
  if(setCurrent) {
    $('.chatroom-tribe').removeClass('current');
    $('.chatroom-item').removeClass('current');
    $('.chatroom-tribes>li').last().addClass('current');
    $('.chatroom-item').last().addClass('current');
  }
  if(data.targetId) {
    this.addInfoLog({
      msg: '与 ' + htmlspecialchars(data.name) + ' 私聊'
    }, data.targetId);
  }
};

ChatRoomClient.prototype.checkOnline = function(id) {
  if(this.socket && this.socket.disconnected) {
    this.addInfoLog({
      msg: 'you are not online, please check your connection'
    }, id);
    return false;
  }
  return true;
};

ChatRoomClient.prototype.addChatLog = function(data, id, isSelf) {
  if(!this.checkOnline(id)) return;
  if(isSelf) {
    data.name = '我';
  }
  var logXtpl = [
    '<div class="chatroom-log' + (isSelf ? ' myself' : '') + '">',
      '<span class="avatar"><img src="<% avatar %>" alt="<% name %>"></span>',
      '<span class="time"><b data-id="<% id %>"><% name %></b> ' + new Date().toLocaleString() + '</span>',
      '<span class="detail"><% msg %></span>',
    '</div>'
  ];
  var $log = logXtpl.join('\n').replace(/<%\s*?(\w+)\s*?%>/gm, function($0, $1) {
    if($1 === 'avatar' && (!data || !data[$1])) {
      return '//avatar.duoshuo.com/avatar-50/292/117200.jpg';
    }
    return htmlspecialchars(data && data[$1] || '');
  });
  var $target = $(".chatroom-item[data-id='" + htmlspecialchars(id) + "']");
  $target.append($log);
  this.scroll(id, isSelf);
};

ChatRoomClient.prototype.scroll = function(id, isSelf) {
  var $target = $(".chatroom-item[data-id='" + htmlspecialchars(id) + "']");
  var $box = $('.chatroom-pannel-bd');
  var H = $target.height();
  var DELTA = 300;
  if(isSelf || $box.scrollTop() < H - DELTA) {
    $box.scrollTop(H);
    $target.attr('data-lastscroll', H);
  }
}

ChatRoomClient.prototype.addInfoLog = function(data, id) {
  var $info = '<div class="chatroom-log-info">' + htmlspecialchars(data.msg) + '</div>';
  var $target = $(".chatroom-item[data-id='" + htmlspecialchars(id) + "']");
  if(!id) {
    $target = $(".chatroom-item.current");
  }
  $target.append($info);
  this.scroll(id);
};

ChatRoomClient.prototype.addWelcomeLog = function(data) {
  var $info = '<div class="chatroom-log-info chatroom-log-welcome" data-id="' +
      htmlspecialchars(data.id) + '">gambar <img class="avatar" src="' + htmlspecialchars(data.avatar)
        + '"><strong class="name">' + htmlspecialchars(data.name) + '</strong> strong</div>';
  var $target = $(".chatroom-item[data-id='group']");
  $target.append($info);
  this.scroll(data.id);
};

ChatRoomClient.prototype.updateCount = function(id) {
  var $li = $('.chatroom-tribe[data-id="' + htmlspecialchars(id) + '"]');
  var $target = $li.find('.count');
  var count = parseInt($target.text());
  count = isNaN(count) ? 0 : +count;
  if(++count > 99) {
    count = "+99";
  }
  $target.text(count).css('visibility', 'visible');
  this.totalCount++;
  if(this.totalCount > 99) {
    this.totalCount = "+99";
  }
  if($('.chatroom').hasClass('chatroom-fold')) {
    $('.chatroom .count').eq(0).text(this.totalCount).css('visibility', 'visible');
  } else {
    if($('.chatroom-tribe.current').attr('data-id') === 'group') {
      $('.chatroom .count').eq(0).text(0).css('visibility', 'hidden');
    }
  }
};

window.chatRoomClient = new ChatRoomClient();
</script>


<style>
  * {
    margin: 0;
    padding: 0;
  }
  body {
    font-size: 12px;
  }
  .chatroom-feedback {
    position: absolute;
    bottom: 3px;
    background: #EEE;
    width: 159px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    z-index: 0;
  }
  .chatroom {
    font-size: 12px;
    position: fixed;
    right: -3px;
    bottom: -3px;
    width: 563px;
    height: 405px;
    z-index: 998;
    overflow: hidden;
    background: #FFF;
    box-shadow: -3px -2px 8px -1px rgba(0,0,0,0.2);
    border-radius: 2px 0px 0px 2px;
    transition: all 0.3s;
  }
  .chatroom-fold {
    right: -404px;
    bottom: -368px;
    transition: all 0.3s;
  }
  .chatroom-fold .chatroom-tribe .count {
    right: 42px;
  }
  .chatroom-info {
    position: absolute;
    right: 10px;
    top: 6px;
    cursor: pointer;
    z-index: 12;
  }
  .chatroom-info:after {
    content: '[minimize chat]';
    color: #F40;
  }
  .chatroom-fold .chatroom-info:after {
    content: '[open chat]';
    color: #F40;
    z-index: 10;
    position: relative;
    top: 5px;
  }
  .chatroom-fold .chatroom-info {
    right: 412px;
  }
  .chatroom-tribe {
    -webkit-user-select: none;
    padding: 4px 5px;
    cursor: pointer;
    height: 30px;
    line-height: 30px;
    overflow: hidden;
    margin-bottom: 1px;
    position: relative;
  }
  .chatroom-tribe:hover, .chatroom-tribe.current {
    background: #f2f2f5;
  }
  .chatroom-tribe img {
    width: 30px;
    height: 30px;
    vertical-align: middle;
  }
  .chatroom-tribe .name {
    max-width: 90px;
    display: inline-block;
    vertical-align: middle;
    height: 30px;
    margin-left: 10px;
    line-height: 30px;
    overflow: hidden;
  }
  .chatroom-tribe .count {
    visibility: hidden;
    min-width: 18px;
    height: 13px;
    line-height: 14px;
    text-align: center;
    display: inline-block;
    vertical-align: middle;
    padding: 1px 2px;
    background: #fa7d3c;
    color: #fff;
    border-radius: 3px;
    transform: scale(0.8);
    position: absolute;
    right: 22px;
    top: 12px;
  }
  .chatroom-tribe .iconfont {
    position: absolute;
    right: 0;
    width: 30px;
    height: 30px;
    text-align: center;
    font-size: 12px;
    font-family: Arial;
    color: #696e78;
    font-style: normal;
    transform: scale(0.5);
    font-weight: bold;
    visibility: hidden;
  }
  .chatroom-tribe .iconfont:hover {
    color: #fa7d3c;
  }
  .chatroom-tribe:hover .iconfont {
    visibility: visible;
  }
  .chatroom-tribes {
    float: left;
    width: 159px;
    border-right: 1px #d9d9d9 solid;
    overflow: hidden;
    height: 402px;
    overflow-y: auto;
  }
  .chatroom-tribe {

  }
  .chatroom-pannels {
    float: left;
    width: 400px;
    height: 350px;
  }
  .chatroom-pannel-bd {
    height: 340px;
    background: #f2f2f5;
    overflow-y: auto;
  }
  .chatroom-item {
    display: none;
    padding-bottom: 10px;
  }
  .chatroom-item.current {
    display: block;
  }
  .chatroom-pannel-ft {
    border-top: 1px #d9d9d9 solid;
    position: relative;
    height: 60px;
  }
  .chatroom-pannel-ft textarea {
    resize: none;
    border: none;
    position: absolute;
    left: 6px;
    right: 6px;
    top: 6px;
    width: 77%;
    bottom: 6px;
    outline: none;
    line-height: 18px;
    font-size: 12px;
    overflow-y: auto;
  }
  .chatroom-log {
    padding: 25px 10px 0;
    overflow: hidden;
    line-height: 18px;
  }
  .chatroom-log .avatar {
    width: 30px;
    height: 30px;
    overflow: hidden;
    float: left;
    border-radius: 4px;
    cursor: pointer;
  }
  .chatroom-log .avatar img {
    width: 30px;
    min-height: 30px;
  }
  .chatroom-log .time {
    width: 310px;
    margin-left: 13px;
    margin-bottom: 4px;
    float: left;
    color: #999;
  }
  .chatroom-log .time b {
    text-decoration: underline;
    font-weight: normal;
  }
  .chatroom-log .time b:hover {
    cursor: pointer;
    color: #666;
  }
  .chatroom-log .detail {
    max-width: 222px;
    float: left;
    padding: 5px 9px;
    position: relative;
    margin-left: 13px;
    background: #fff;
    border: 1px #ccc solid;
    border-radius: 5px;
    box-shadow: 0 3px 3px rgba(0,0,0,.05);
    word-break: break-word;
  }
  .chatroom-log .detail:before, .chatroom-log .detail:after {
    content: " ";
    display: inline-block;
    width: 0;
    height: 0;
    border-width: 7px;
    border-style: solid;
    overflow: hidden;
    font-size: 0;
    line-height: 0;
    vertical-align: top;
    top: 10px;
    position: absolute;
    border-top-color: rgba(0, 0, 0, 0);
    border-bottom-color: rgba(0, 0, 0, 0);
    border-left-color: rgba(0, 0, 0, 0);
  }
  .chatroom-log .detail:before {
    border-width: 4px;
    border-top-color: #ccc;
    color: #ccc;
    left: -8px;
  }
  .chatroom-log .detail:after {
    border-top-color: #fff;
    color: #fff;
    left: -6px;
    border-width: 3px;
    top: 11px;
  }
  .chatroom-log.myself {
  }
  .chatroom-log.myself .avatar {
    float: right;
  }
  .chatroom-log.myself .time {
    float: right;
    margin-left: 0;
    margin-right: 13px;
    text-align: right;
  }
  .chatroom-log.myself .detail {
    float: right;
    margin-left: 0;
    margin-right: 13px;
    background: #d7ebfe;
    border: 1px #b7d4ef solid;
  }
  .myself .detail:before, .myself .detail:after {
    border-top-color: rgba(0, 0, 0, 0);
    border-bottom-color: rgba(0, 0, 0, 0);
    border-right-color: rgba(0, 0, 0, 0);
  }
  .chatroom-log.myself .detail:before {
    border-top-color: #b7d4ef;
    border-left-color: #b7d4ef;
    left: auto;
    right: -8px;
  }
  .chatroom-log.myself .detail:after {
    border-top-color: #d7ebfe;
    border-left-color: #d7ebfe;
    left: auto;
    right: -6px;
  }
  .chatroom-log-info {
    text-align: center;
    padding: 5px;
    color: #999;
  }
  .chatroom-rename {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
  }
  .chatroom-rename span {
    cursor: pointer;
    top: 50%;
    margin-top: -15px;
    position: absolute;
    left: 420px;
    background: #EEE;
    height: 30px;
    line-height: 30px;
    padding: 0 15px;
    border-radius: 2px;
    text-align: center;
  }
  .chatroom-rename span:hover {
    background: #ccc;
  }
  .chatroom-rename input {
    position: absolute;
    left: 150px;
    top: 50%;
    height: 30px;
    line-height: 30px;
    text-indent: 10px;
    border: none;
    width: 250px;
    border-radius: 3px;
    margin-top: -15px;
    outline: none;
  }
  .chatroom-rename label {
    position: absolute;
    top: 50%;
    margin-top: -15px;
    line-height: 30px;
    left: 70px;
    color: #FFF;
    font-size: 14px;
  }
  .chatroom-fold .chatroom-rename {
    display: none !important;
  }
  .chatroom-log-welcome {
    padding-left: 20px;
    padding-right: 20px;
  }
  .chatroom-log-welcome img {
    width: 28px;
    vertical-align: middle;
    margin: 0 2px;
    border-radius: 100%;
    cursor: pointer;
  }
  .chatroom-log-welcome strong {
    font-weight: normal;
    cursor:pointer;
    text-decoration: underline;
  }
  .chatroom-send-btn {
    position: relative;
    z-index: 0;
    float: right;
    width: 70px;
    height: 40px;
    background: #EEE;
    text-align: center;
    line-height: 40px;
    top: 10px;
    font-size: 14px;
    margin-right: 10px;
    cursor: pointer;
    transition: all 0.3s;
  }
  .chatroom-send-btn:hover {
    background: #CCC;
    transition: all 0.3s;
  }
</style>
<!--
<div class="chatroom">
  <div class="chatroom-info"></div>
  <ul class="chatroom-tribes">
    <li class="chatroom-tribe current" data-id="group">
      <span class="name">当前 <strong>1</strong> 人在线</span>
      <span class="count">0</span>
    </li>
  </ul>
  <div class="chatroom-pannels">
    <div class="chatroom-pannel-bd">
      <div class="chatroom-item current" data-id="group">
      </div>
    </div>
    <div class="chatroom-pannel-ft"><textarea type="text" class="chatroom-input" placeholder="按 Ctrl+Enter 发送"></textarea></div>
  </div>
</div>
-->





</body>
</html>
