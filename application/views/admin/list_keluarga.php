<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/util.js"> </script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/geo.js"></script>

<script>
	$(document).ready(function(){
		
<?php if ($this->session->flashdata('success')) { ?>
		$('.success').html("<strong> <?php echo $this->session->flashdata('success'); ?>");
		$('.success').attr('style','');
		$('.success').delay(10000).fadeOut('slow');
<?php } else if ($this->session->flashdata('failed')) { ?>
		$('.error').html("<strong> <?php echo $this->session->flashdata('failed'); ?>");
		$('.error').attr('style','');
		$('.error').delay(10000).fadeOut('slow');
<?php } ?>

		$("#ttl").datepicker({dateFormat: 'yy-mm-dd'});
		$("#tgl_periksa").datepicker({dateFormat: 'yy-mm-dd'});

		$('.delete-tab').click(function(){
			var page = $(this).attr("href");
			var $dialog = $('<div title="Hapus Keluarga"></div>')
			.html('Semua informasi keluarga akan ikut dihapus! Hapus keluarga? <div class="clear"></div>').dialog({
				autoOpen: false,
				width: 280,
				show: "fade",
				hide: "fade",
				modal: true,
				resizable: false,
				buttons: {
					"Ok": function() {
						$(this).dialog("close");
						window.location = page;
					},
					"Cancel": function() {
						$(this).dialog("close");
					}
				}
			});
			$dialog.dialog('open');
			return false;
		});
	});

	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (!((charCode >= 48 && charCode <= 57) || (charCode == 46) || (charCode == 8) || (charCode == 9)))
			return false;

		return true;
	}
	function create_url(){
		var url = $('#form_search_filter').attr('action')+'/?filter=true&';
		var param = '';
		$('.filter_param').each(function(){
			param += $(this).attr('name')+'='+$(this).val()+'&';
		});
		
		$('#form_search_filter').attr('action',url+param).submit();
	}

	function redirect(){
		window.location = "<?php echo base_url() ?>admin/keluarga_ctrl";
	}

	function deletePenghuni(id_penghuni){
		window.location = "<?php echo base_url() ?>admin/kost_ctrl/delPenghuni/" + id_penghuni;
	}

</script>

<style>
	#backlight{
		margin: -15px 0 0 0;
		position: absolute;
		cursor: pointer;
		width: 100%;
		background: rgba(0, 0, 0, 0.5);
	}

	#spotting-holder{
		width: 700px;
		left: 50%;
		margin: 20px 0 0 -355px;
		background: #eee;
		position: fixed;
		z-index: 999;
		padding: 5px;
	}
</style>
<!-- Added by D3 - Disable enter -->
<script type="text/javascript"> 
function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = stopRKey; 
</script> 
<div id="spotting-holder" style="display: none;"></div>
<div id="backlight" style="display: none;"></div>

<div id="main">
	<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"></p>
	<p class="notif error " style="display:none"></p>
	
	<p class="tit-form">Daftar Keluarga <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
	<div class="filtering" style="display: none;">
		<form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
			<ul class="filter-form">
				<li>
					<label>Filter POI</label><br />
					<input type="text" placeholder="Nama Area" name="poi_name" class='filter_param' value="<?php echo $this->input->get('poi_name'); ?>" onkeypress="search_enter_press(event);" />
				</li>
			</ul>

			<div class="clear"></div>
			<div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>
			<input type="button" value="Bersihkan Pencarian" onclick="redirect('')" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
			<input type="button" value="Cari" name="search_filter" onclick="create_url()" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
			<div class="clear"></div>
			<div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
		</form>
	</div>
	<table class="tab-admin">
		<thead>
			<tr class="tittab">
				<td class="header" style="width: 20px;">No</th>                     
				<td class="header">No KK</td>
				<td class="header">Alamat</td>
				<td class="header">Lintang</td>
				<td class="header">Bujur</td>
				<td class="header delete" style="width: 52px;">Aksi</td>
			</tr>
		</thead>
		<tbody>
			<?php 
				$count=1;
				if($keluargas){
					foreach($keluargas as $kel) {
			?>
						<tr class="<?php echo alternator("row-two", "row-one"); ?>">
							<td><?php echo ($count++) ?></td>
							<td><?php echo $kel->no_kk ?></td>
							<td><?php echo $kel->alamat ?></td>
							<td><?php echo $kel->lat ?></td>
							<td><?php echo $kel->lon ?></td>
							<td class="action">
								<a href="<?php echo base_url();?>admin/keluarga_ctrl/edit/<?php echo $kel->id_keluarga ?>"><div class="tab-edit"></div></a>
								<a href="<?php echo base_url();?>admin/keluarga_ctrl/delete/<?php echo $kel->id_keluarga ?>" class="delete-tab"><div class="tab-delete"></div></a>
							</td>
						</tr>
			<?php 	}
				} ?>

		</tbody>
	</table>
	<br />  

	<p class="tit-form"><?php if ($objkel) echo "Edit Keluarga"; else echo "Tambah Keluarga Baru"; ?></p>
	<form action="<?php if ($objkel) echo base_url() . 'admin/keluarga_ctrl/edit_keluarga'; else echo base_url() . 'admin/keluarga_ctrl/add_keluarga'; ?>" method="post" >
		<ul class="form-admin">
			<!-- <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" /> -->
			<?php if ($objkel) { ?>
				<input type="hidden" name="id_keluarga" value="<?php echo $objkel->id_keluarga ?>" >
			<?php } ?>
			<li>
				<label>No KK</label>
				<input class="form-admin" name="no_kk" type="text" class="text-medium" value="<?php if ($objkel) echo $objkel->no_kk ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Alamat</label>
				<input class="form-admin" name="alamat" type="text" class="text-medium" value="<?php if ($objkel) echo $objkel->alamat ?>" >	
				<div class="clear"></div>
			</li>
			<li>
				<label>Lintang</label>
				<input class="form-admin" name="lat" id="inputlat" type="text" class="text-medium" value="<?php if ($objkel) echo $objkel->lat ?>" >	
				<div class="clear"></div>
			</li>
			<li>
				<label>Bujur</label>
				<input class="form-admin" name="lon" id="inputlon" type="text" class="text-medium" value="<?php if ($objkel) echo $objkel->lon ?>" >	
				<div class="clear"></div>
			</li>
			<li>
				<label>Map</label>
				<div id="map" style="width: 800px; height: 300px"></div>
			</li>
		<p class="tit-form"></p>
		<label>&nbsp;</label>
		<input class="button-form" type="submit" value="<?php if ($objkel) echo 'Ubah'; else echo 'Tambah'; ?>">
		<input class="button-form" type="reset" onclick="redirect()" value="Batal">
		<div class="clear"></div>
		
	</form>
		
<?php if ($individus) { ?>
	<br/>
	<p class="tit-form">Daftar Anggota Keluarga</p>
	<table class="tab-admin">
		<tr class="tittab">
			<td>No</td>
			<td>Nama</td>
			<td>NIK</td>
			<td>Jenis Kelamin</td>
			<td>Usia</td>
			<td>Penyakit Saat Ini</td>
			<td style="width: 78px;">Aksi</td>
		</tr>
<?php $count_anggota = 1;
	foreach ($individus as $anggota) {
?>
		<tr class="<?php echo alternator("row-one", "row-two"); ?>">
			<td><?php echo $count_anggota; ?></td>
			<td><?php echo $anggota->nama ?></td>
			<td><?php echo $anggota->nik ?></td>
			<td><?php echo $anggota->kelamin ?></td>
			<td><?php echo calculateAge($anggota->ttl) ?></td>
			<td><?php echo $anggota->penyakit_saat_ini ?></td>
			<td class="action">
				<a href="<?php echo base_url();?>admin/keluarga_ctrl/edit/<?php echo $anggota->id_rumah . '/' . $anggota->id_individu ?>"><div class="tab-edit"></div></a>
				<a href="<?php echo base_url();?>admin/keluarga_ctrl/del_anggota/<?php echo $anggota->id_individu . '/' . $anggota->id_rumah ?>" class="delete-tab"><div class="tab-delete"></div></a>
			</td>
		</tr>
<?php
		$count_anggota++;
	} 
?>
	</table>
<?php } 

if ($objkel) {
?>
	<br />
	<form action="<?php if ($objanggota) echo base_url() . 'admin/keluarga_ctrl/edit_anggota'; else echo base_url() . 'admin/keluarga_ctrl/add_anggota'; ?>" method="post" >
		<div class="baris">
			<div class="kolom" id="ffform">
				<p class="tit-form"><?php if ($objanggota) echo 'Ubah Anggota'; else echo 'Input Anggota Baru' ?></p>
				<input type="hidden" name="id_keluarga" value="<?php echo $objkel->id_keluarga ?>" />
<?php if ($objanggota) { ?>
				<input type="hidden" name="id_individu" value="<?php echo $objanggota->id_individu ?>" />
<?php } ?>
				<ul class="form-admin">
					<li>
						<label>Nama</label>
						<input class="form-admin" name="nama" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->nama ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>NIK</label>
						<input class="form-admin" name="nik" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->nik ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>BPJS</label>
						<input class="form-admin" name="bpjs" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->bpjs ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Jenis Kelamin </label>
						<div class="form-admin-radio">
							<input type="radio" name="jk" value="L" <?php if ($objanggota && $objanggota->kelamin == 'L') echo 'checked'; ?> > L
							<input type="radio" name="jk" value="P" <?php if ($objanggota && $objanggota->kelamin == 'P') echo 'checked'; ?> > P
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<label>TTL</label>
						<input class="form-admin" id="ttl" name="ttl" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->ttl; else echo date('Y-m-d') ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Agama</label>
						<select name="agama" class="form-admin">
							<option value="0" selected>-Pilih Agama-</option>
							<?php foreach ($agama as $row) { ?>
								<?php if ($objanggota && $objanggota->agama == $row->id) { ?>
									<option value="<?php echo $row->id ?>" selected><?php echo $row->desc ?></option>
								<?php } else { ?>
									<option value="<?php echo $row->id ?>"><?php echo $row->desc ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div class="clear"></div>
					</li>
					<li>
						<label>Pendidikan</label>
						<select name="pendidikan" class="form-admin">
							<option value="0" selected>-Pilih Pendidikan-</option>
							<?php foreach ($pendidikan as $row) { ?>
								<?php if ($objanggota && $objanggota->pendidikan == $row->id) { ?>
									<option value="<?php echo $row->id ?>" selected><?php echo $row->desc ?></option>
								<?php } else { ?>
									<option value="<?php echo $row->id ?>"><?php echo $row->desc ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div class="clear"></div>
					</li>
					<li>
						<label>Pekerjaan</label>
						<select name="pekerjaan" class="form-admin">
							<option value="0" selected>-Pilih Pekerjaan-</option>
							<?php foreach ($pekerjaan as $row) { ?>
								<?php if ($objanggota && $objanggota->pekerjaan == $row->id) { ?>
									<option value="<?php echo $row->id ?>" selected><?php echo $row->desc ?></option>
								<?php } else { ?>
									<option value="<?php echo $row->id ?>"><?php echo $row->desc ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div class="clear"></div>
					</li>
					<li>
						<label>Berat Badan (gram) </label>
						<input class="form-admin" name="bb" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->bb; else echo '0' ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Tinggi Badan (cm) </label>
						<input class="form-admin" name="tb" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->tb; else echo '0' ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Sistole </label>
						<input class="form-admin" name="tensi_sistol" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->tensi_sistol; else echo '0' ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Diastole </label>
						<input class="form-admin" name="tensi_diastol" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->tensi_diastol; else echo '0' ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Gula Darah </label>
						<input class="form-admin" name="gula_darah" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->gula_darah; else echo '0' ?>" >
						<div class="clear"></div>
					</li>
				</ul>
			</div>
			<div class="kolom" id="fffooto">
				<p class="tit-form">Data Penyakit</p>
				<ul class="form-admin">
					<li>
						<label>Penyakit Saat Ini</label>
						<textarea rows="1" cols="1" name="penyakit_saat_ini" class="form-admin"><?php if ($objanggota) echo $objanggota->penyakit_saat_ini; ?></textarea>
						<div class="clear"></div>
					</li>
					<li>
						<label>Diabetes Melitus</label>
						<select name="dm" class="form-admin">
							<option value="0" selected>-Pilih Status DM-</option>
							<?php foreach ($dm as $row) { ?>
								<?php if ($objanggota && $objanggota->dm == $row->id) { ?>
									<option value="<?php echo $row->id ?>" selected><?php echo $row->desc ?></option>
								<?php } else { ?>
									<option value="<?php echo $row->id ?>"><?php echo $row->desc ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div class="clear"></div>
					</li>
					<li>
						<label>Hipertensi</label>
						<select name="hipertensi" class="form-admin">
							<option value="0" selected>-Pilih Status Hipertensi-</option>
							<?php foreach ($hipertensi as $row) { ?>
								<?php if ($objanggota && $objanggota->hipertensi == $row->id) { ?>
									<option value="<?php echo $row->id ?>" selected><?php echo $row->desc ?></option>
								<?php } else { ?>
									<option value="<?php echo $row->id ?>"><?php echo $row->desc ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div class="clear"></div>
					</li>
					<li>
						<label>TBC</label>
						<select name="tbc" class="form-admin">
							<option value="0" selected>-Pilih Status TBC-</option>
							<?php foreach ($tbc as $row) { ?>
								<?php if ($objanggota && $objanggota->tbc == $row->id) { ?>
									<option value="<?php echo $row->id ?>" selected><?php echo $row->desc ?></option>
								<?php } else { ?>
									<option value="<?php echo $row->id ?>"><?php echo $row->desc ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div class="clear"></div>
					</li>
					<li>
						<label>DBD </label>
						<div class="form-admin-radio">
							<input type="radio" name="dbd" value="FALSE" <?php if (!$objanggota || !$objanggota->dbd) echo 'checked'; ?>> Tidak
							<input type="radio" name="dbd" value="TRUE" <?php if ($objanggota && $objanggota->dbd) echo 'checked'; ?> > Ya
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<label>HIV </label>
						<div class="form-admin-radio">
							<input type="radio" name="hiv" value="FALSE" <?php if (!$objanggota || !$objanggota->hiv) echo 'checked'; ?>> Tidak
							<input type="radio" name="hiv" value="TRUE" <?php if ($objanggota && $objanggota->hiv) echo 'checked'; ?> > Ya
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<label>TB HIV </label>
						<div class="form-admin-radio">
							<input type="radio" name="tb_hiv" value="FALSE" <?php if (!$objanggota || !$objanggota->tb_hiv) echo 'checked'; ?>> Tidak
							<input type="radio" name="tb_hiv" value="TRUE" <?php if ($objanggota && $objanggota->tb_hiv) echo 'checked'; ?> > Ya
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<label>Imunisasi</label>
						<select name="tbc" class="form-admin">
							<option value="0" selected>-Pilih Status Imunisasi-</option>
							<?php foreach ($imunisasi as $row) { ?>
								<?php if ($objanggota && $objanggota->imunisasi == $row->id) { ?>
									<option value="<?php echo $row->id ?>" selected><?php echo $row->desc ?></option>
								<?php } else { ?>
									<option value="<?php echo $row->id ?>"><?php echo $row->desc ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div class="clear"></div>
					</li>
					<li>
						<label>Kehamilan</label>
						<select name="tbc" class="form-admin">
							<option value="0" selected>-Pilih Status Kehamilan-</option>
							<?php foreach ($hamil as $row) { ?>
								<?php if ($objanggota && $objanggota->kehamilan == $row->id) { ?>
									<option value="<?php echo $row->id ?>" selected><?php echo $row->desc ?></option>
								<?php } else { ?>
									<option value="<?php echo $row->id ?>"><?php echo $row->desc ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div class="clear"></div>
					</li>
					<li>
						<label>Tanggal Input</label>
						<input class="form-admin" id="tgl_periksa" name="tgl_periksa" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->tgl_periksa; else echo date('Y-m-d') ?>" >
						<div class="clear"></div>
					</li>
				</ul>
			</div> <!-- kolom -->
		</div> <!-- baris -->
		<p class="tit-form"></p>
		<label>&nbsp;</label>
		<input class="button-form" type="submit" value="<?php if ($objanggota) echo 'Ubah'; else echo 'Tambah'; ?>">
		<input class="button-form" type="reset" onclick="redirect()" value="Batal">
		<div class="clear"></div>
	</form>
<?php } ?>
</div> <!-- div main -->
<div class="clear"></div>

<script type="text/javascript">
	var configMap = {
		latCenter : -6.187638065886,
		lonCenter : 106.886608600,
		zoom :18,
		mapUrl : '<?php echo $this->config->item('map_url') ?>',
		mapStyleId : 22677
	};
	var minimal   = L.tileLayer(configMap.mapUrl, {styleId: configMap.mapStyleId});
	var southWest = new L.LatLng(85, -180);
	var northEast = new L.LatLng(-85, 180);
	var bounds = new L.LatLngBounds(southWest, northEast);
	var bounds_area_input = $("#bounds_area_input");

	//fixation for pan inside bounds

	L.Map.include({panInsideBounds: function(bounds) {
		bounds = L.latLngBounds(bounds);

		var viewBounds = this.getBounds(),
			viewSw = this.project(viewBounds.getSouthWest()),
			viewNe = this.project(viewBounds.getNorthEast()),
			sw = this.project(bounds.getSouthWest()),
			ne = this.project(bounds.getNorthEast()),
			dx = 0,
			dy = 0;

		if (viewNe.y < ne.y) { // north
			dy = ne.y - viewNe.y + Math.max(0, this.latLngToContainerPoint([85.05112878, 0]).y); // + extra vertical scroll
		}
		if (viewNe.x > ne.x) { // east
			dx = ne.x - viewNe.x;
		}
		if (viewSw.y > sw.y) { // south
			dy = sw.y - viewSw.y + Math.min(0, this.latLngToContainerPoint([-85.05112878, 0]).y - this.getSize().y); // + extra vertical scroll
		}
		if (viewSw.x < sw.x) { // west
			dx = sw.x - viewSw.x;
		}

		return this.panBy(new L.Point(dx, dy, true));
	}});

	//fixation for pan inside bounds
	var map = new L.map('map', {
		center: [configMap.latCenter, configMap.lonCenter],
		zoom: configMap.zoom,
		layers: [minimal],
		maxZoom : 19,
		minZoom : 3
	});

	var drawnItems = new L.FeatureGroup();
	map.addLayer(drawnItems);

	//View for Longitude and Latitude topright in the map
	var attrib = new L.Control.Attribution({position: 'topright'});
	map.addControl(attrib);
	attrib.setPrefix('Koordinat : ');
	map.on('mousemove', function(e) {
		var latlng = e.latlng;
		attrib.setPrefix('Koordinat : '+viewableCoordinate(latlng.lat,'lat') + ", " + viewableCoordinate(latlng.lng,'lng'));
	});

	map.on('click', function(e) {
		document.getElementById("inputlat").value = e.latlng.lat;
		document.getElementById("inputlon").value = e.latlng.lng; 
	});

</script>
	