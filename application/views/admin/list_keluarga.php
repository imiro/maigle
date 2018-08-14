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
		<?php if ($this->session->flashdata('info')) { ?>
			$('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
			$('.success').attr('style','');
			$('.success').delay(10000).fadeOut('slow');
		<?php } ?>

		$('.delete-tab').click(function(){
			var page = $(this).attr("href");
			var $dialog = $('<div title="Hapus Kosan"></div>')
			.html('Semua informasi kosan akan ikut dihapus! Hapus kosan? <div class="clear"></div>').dialog({
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

		var rowTotalKmr = <?php if ($obj) 
									// echo sizeof($obj['kamar']);
									echo '0;';
								else echo '0;';
						?>

		$("#addKmr").click(function() {
			var namaKmr = $('#nama_kmr').val();
			var kmrFilled = $('#terisi_kmr').val();

			if ($('#editNumberKmr').val() != "") {
				var editNumberKmr = $('#editNumberKmr').val();
				$('#kmr_' + editNumberKmr + '').val(namaKmr);
				$('#kmr_td_' + editNumberKmr + '').text(namaKmr);
				$('#filledKmr_' + editNumberKmr + '').val(kmrFilled);
				$('#filledKmr_td_' + editNumberKmr + '').text(kmrFilled);
			} else {
				var rowCount = $('#tableKmr').find('tr').size();
				var tableClass = (rowCount % 2 == 0) ? 'row-two' : 'row-one';
				if (kmrFilled != '') {
					rowTotalKmr = rowTotalKmr + 1;
					$("#totalRowKmr").val(rowTotalKmr);

					var row1 = '<tr class=' + tableClass + '><td>' + rowCount + '</td>';
					var row2 = '<td id=kmr_td_' + rowTotalKmr + '>' + namaKmr + '</td>' + '<input type="hidden" name="kmr_' + rowTotalKmr + '" id="kmr_' + rowTotalKmr + '" value="' + namaKmr + '" />';
					var row3 = '<input type="hidden" name="kmr_' + rowTotalKmr + '" id="kmr_' + rowTotalKmr + '" value="' + namaKmr + '" />';
					var row4 = '<td id=filledKmr_td_' + rowTotalKmr + '>' + kmrFilled + '</td>' + '<input type="hidden" name="filledKmr_' + rowTotalKmr + '" id="filledKmr_' + rowTotalKmr + '" value="' + kmrFilled + '" />';
					var action = '<td class="action"><a href="javascript:void(0);" onClick="editKmr(\'' + rowTotalKmr + '\',\'' + namaKmr + '\',\'' + kmrFilled + '\')" id="editKmr" ><div class="tab-edit"></div></a> <a href="javascript:void(0);" id="deleteKmr"><div class="tab-delete"></div></a></td></tr>';

					$("#tableKmr").append(row1 + row2 + row3 + row4 + action);
					$('#nama_kmr').val('');
					$('#terisi_kmr').val('');
				}
			}
		});

		$("#tableKmr").on('click', '#deleteKmr', function() {
			$(this).parent().parent().remove();
			rowTotalKmr = rowTotalKmr - 1;
			$("#totalRowKmr").val(rowTotalKmr);
		});

		$("#cancelKmr").click(function() {
			$('#nama_kmr').val('');
			$('#terisi_kmr').val('');
			$("#addKmr").val('Tambah Kamar');
		});
	});

	function editKmr(noKmr, namaKmr, filledKmr) {
		$('#editNumberKmr').val(noKmr);
		$('#nama_kmr').val(namaKmr);
		$('#terisi_kmr').val(filledKmr);
		$("#addKmr").val('Ubah');
	}

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
	<p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data POI berhasil disimpan.</p>
	
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
				<td class="header">Lat</td>
				<td class="header">Lon</td>
				<td class="header delete" style="width: 52px;">Aksi</td>
			</tr>
		</thead>
		<tbody>
			<?php 
				$count=1;
				if(!empty($keluargas)){
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
				<input class="form-admin" name="no_kk" id="no_kk" type="text" class="text-medium" value="<?php if ($objkel) echo $objkel->no_kk ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Alamat</label>
				<input class="form-admin" name="alamat" id="alamat" type="text" class="text-medium" value="<?php if ($objkel) echo $objkel->alamat ?>" >	
				<div class="clear"></div>
			</li>
			<li>
				<label>Latitude</label>
				<input class="form-admin" name="lat" id="lat" type="text" class="text-medium" value="<?php if ($objkel) echo $objkel->lat ?>" >	
				<div class="clear"></div>
			</li>
			<li>
				<label>Longitude</label>
				<input class="form-admin" name="lon" id="lon" type="text" class="text-medium" value="<?php if ($objkel) echo $objkel->lon ?>" >	
				<div class="clear"></div>
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
	<table id="tableKmr" class="tab-admin">
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
			<td><?php echo $anggota->ttl ?></td>
			<td><?php echo $anggota->penyakit_saat_ini ?></td>
			<td class="action">
				<a href="<?php echo base_url();?>admin/keluarga_ctrl/edit/<?php echo $anggota->id_rumah . '/' . $anggota->id_individu ?>"><div class="tab-edit"></div></a>
				<a href="<?php echo base_url();?>admin/keluarga_ctrl/del_kmr/<?php echo $anggota->id_individu ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
				<input type="hidden" name="id_kamar" value="<?php echo $objanggota->id_kamar ?>" />
<?php } ?>
				<ul class="form-admin">
					<li>
						<label>Nama</label>
						<input class="form-admin" id="nama" name="nama" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->nama ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>NIK</label>
						<input class="form-admin" id="nik" name="nik" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->nik ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>BPJS</label>
						<input class="form-admin" id="bpjs" name="bpjs" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->bpjs ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Jenis Kelamin </label>
						<div class="form-admin-radio">
							<label><input type="radio" name="jk" value="L" <?php if (!empty($objanggota) && $objobjanggota->jk) echo 'checked'; ?> > L</label>
							<div class="clear"></div>
							<label><input type="radio" name="jk" value="P" <?php if (empty($objanggota) || !$objanggota->jk) echo 'checked'; ?>> P</label>
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<label>TTL</label>
						<input class="form-admin" id="ttl" name="ttl" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->ttl ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Agama</label>
						<select name="agama" class="form-admin">
							<option value="" selected>-Pilih Agama-</option>
							<?php foreach ($agama as $row) { ?>
								<?php if ((!empty($objanggota)) && $objanggota->agama == $row->id) { ?>
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
							<option value="" selected>-Pilih Pendidikan-</option>
							<?php foreach ($pendidikan as $row) { ?>
								<?php if ((!empty($objanggota)) && $objanggota->pendidikan == $row->id) { ?>
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
							<option value="" selected>-Pilih Pekerjaan-</option>
							<?php foreach ($pekerjaan as $row) { ?>
								<?php if ((!empty($objanggota)) && $objanggota->pekerjaan == $row->id) { ?>
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
						<input class="form-admin" id="bb" name="bb" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->bb ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Tinggi Badan (cm) </label>
						<input class="form-admin" id="tb" name="tb" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->tb ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Sistole </label>
						<input class="form-admin" id="tensi_sistol" name="tensi_sistol" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->tensi_sistol ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Diastole </label>
						<input class="form-admin" id="tensi_diastol" name="tensi_diastol" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->tensi_diastol ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Gula Darah </label>
						<input class="form-admin" id="gula_darah" name="gula_darah" type="text" class="text-medium" value="<?php if ($objanggota) echo $objanggota->gula_darah ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Penyakit Saat Ini</label>
						<textarea rows="1" cols="1" name="penyakit_saat_ini" class="form-admin"><?php if (!empty($objanggota)) echo $objanggota->penyakit_saat_ini; ?></textarea>
						<div class="clear"></div>
					</li>
				</ul>
			</div>
			<div class="kolom" id="fffooto">
				<p class="tit-form">Data Penyakit</p>
				<ul class="form-admin">
					<li>
						<label>Diabetes Melitus</label>
						<select name="dm" class="form-admin">
							<option value="" selected>-Pilih Status DM-</option>
							<?php foreach ($dm as $row) { ?>
								<?php if ((!empty($objanggota)) && $objanggota->dm == $row->id) { ?>
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
							<option value="" selected>-Pilih Status Hipertensi-</option>
							<?php foreach ($hipertensi as $row) { ?>
								<?php if ((!empty($objanggota)) && $objanggota->hipertensi == $row->id) { ?>
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
							<option value="" selected>-Pilih Status TBC-</option>
							<?php foreach ($tbc as $row) { ?>
								<?php if ((!empty($objanggota)) && $objanggota->tbc == $row->id) { ?>
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
							<label><input type="radio" name="dbd" value="TRUE" <?php if (!empty($objanggota) && $objanggota->dbd) echo 'checked'; ?> > Ya</label>
							<div class="clear"></div>
							<label><input type="radio" name="dbd" value="FALSE" <?php if (empty($objanggota) || !$objanggota->dbd) echo 'checked'; ?>> Tidak</label>
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<label>HIV </label>
						<div class="form-admin-radio">
							<label><input type="radio" name="hiv" value="TRUE" <?php if (!empty($objanggota) && $objanggota->hiv) echo 'checked'; ?> > Ya</label>
							<div class="clear"></div>
							<label><input type="radio" name="hiv" value="FALSE" <?php if (empty($objanggota) || !$objanggota->hiv) echo 'checked'; ?>> Tidak</label>
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<label>TB HIV </label>
						<div class="form-admin-radio">
							<label><input type="radio" name="tb_hiv" value="TRUE" <?php if (!empty($objanggota) && $objanggota->tb_hiv) echo 'checked'; ?> > Ya</label>
							<div class="clear"></div>
							<label><input type="radio" name="tb_hiv" value="FALSE" <?php if (empty($objanggota) || !$objanggota->tb_hiv) echo 'checked'; ?>> Tidak</label>
						</div>
						<div class="clear"></div>
					</li>
					<li>
						<label>Imunisasi</label>
						<select name="tbc" class="form-admin">
							<option value="" selected>-Pilih Status Imunisasi-</option>
							<?php foreach ($imunisasi as $row) { ?>
								<?php if ((!empty($objanggota)) && $objanggota->imunisasi == $row->id) { ?>
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
							<option value="" selected>-Pilih Status Kehamilan-</option>
							<?php foreach ($kehamilan as $row) { ?>
								<?php if ((!empty($objanggota)) && $objanggota->kehamilan == $row->id) { ?>
									<option value="<?php echo $row->id ?>" selected><?php echo $row->desc ?></option>
								<?php } else { ?>
									<option value="<?php echo $row->id ?>"><?php echo $row->desc ?></option>
								<?php } ?>
							<?php } ?>
						</select>
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

<?php 
} ?>
</div> <!-- div main -->
<div class="clear"></div>