<?php
if (isset($_POST['bln_pilih'])) { $bln_pilih=$_POST['bln_pilih']; }
else { $bln_pilih=0; }

if (isset($_POST['thn_pilih'])) { $thn_pilih=$_POST['thn_pilih']; }
else { $thn_pilih=date("Y"); }

if ($act=='add') {
	include 'views/kegiatan/keg_form.php';
}
elseif ($act=='save') {
	include 'views/kegiatan/aktif_save.php';
}
elseif ($act=='edit') {
	include 'views/kegiatan/keg_form_edit.php';
}
elseif ($act=='update') {
	include 'views/kegiatan/keg_update.php';
}
elseif ($act=='view') {
	include 'views/kegiatan/keg_view.php';
}
elseif ($act=='delete') {
	include 'views/kegiatan/keg_delete.php';
}
else {
	include 'views/kegiatan/keg_list.php';
}
?>