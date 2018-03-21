<?php
function list_tahun_kegiatan() {
	$db_keg = new db();
	$conn_keg = $db_keg -> connect();
	$sql_kegiatan = $conn_keg -> query("select year(keg_start) as tahun from kegiatan group by year(keg_start) order by tahun asc") or die(mysqli_error($conn_keg));
	$cek=$sql_kegiatan->num_rows;
	$data_keg=array("error"=>false);
	if ($cek > 0) {
		$data_keg["error"]=false;
		$data_keg["thn_total"]=$cek;
		$i=1;
		while ($r=$sql_kegiatan->fetch_object()) {
			$data_keg["item"][$i]=array(
				"thn_keg"=>$r->tahun
			);
			$i++;
		}
	}
	else {
		$data_keg["error"]=true;
		$data_keg["pesan_error"]='Data tidak tersedia';
	}
	return $data_keg;
	$conn_keg->close();
}
function progress_kegiatan($keg_id) {
	$db_keg = new db();
	$conn_keg = $db_keg -> connect();
	$sql_kegiatan = $conn_keg -> query("select keg_id,keg_d_jenis,sum(keg_d_jumlah) as jumlah from keg_detil where keg_id='$keg_id' group by keg_d_jenis order by keg_d_jenis asc") or die(mysqli_error($conn_keg));
	$cek=$sql_kegiatan->num_rows;
	$data_keg=array("error"=>false);
	if ($cek > 0) {
		$data_keg["error"]=false;
		$data_keg["jenis_total"]=$cek;
		$i=1;
		while ($r=$sql_kegiatan->fetch_object()) {
			$data_keg["item"][$i]=array(
				"keg_id"=>$r->keg_id,
				"jenis_id"=>$r->keg_d_jenis,
				"jenis_jumlah"=>$r->jumlah
			);
			$i++;
		}
	}
	else {
		$data_keg["error"]=true;
		$data_keg["pesan_error"]='Data tidak tersedia';
	}
	return $data_keg;
	$conn_keg->close();
}
function list_keg_detil_kabkota($keg_id,$unit_kode,$keg_jenis,$detil=false) {
	$db_keg = new db();
	$conn_keg = $db_keg -> connect();
	if ($detil==false) {
		//semua untuk 1 kegiatan
		$sql_kegiatan = $conn_keg -> query("select keg_detil.*,unit_nama from keg_detil inner join unitkerja on keg_detil.keg_d_unitkerja=unitkerja.unit_kode where keg_id='$keg_id' and keg_d_jenis='$keg_jenis' order by keg_d_tgl asc") or die(mysqli_error($conn_keg));
	}
	else {
		//1 keg 1 kabkota saja
		$sql_kegiatan = $conn_keg -> query("select keg_detil.*,unit_nama from keg_detil inner join unitkerja on keg_detil.keg_d_unitkerja=unitkerja.unit_kode where keg_id='$keg_id' and keg_d_jenis='$keg_jenis' and keg_d_unitkerja='$unit_kode' order by keg_d_tgl asc") or die(mysqli_error($conn_keg));
	}
	$cek=$sql_kegiatan->num_rows;
	$data_keg=array("error"=>false);
	if ($cek > 0) {
		$data_keg["error"]=false;
		$data_keg["detil_total"]=$cek;
		$i=1;
		while ($r=$sql_kegiatan->fetch_object()) {
			$data_keg["item"][$i]=array(
				"keg_id"=>$r->keg_id,
				"detil_id"=>$r->keg_d_id,
				"detil_unitkerja"=>$r->keg_d_unitkerja,
				"detil_unitnama"=>$r->unit_nama,
				"detil_tanggal"=>$r->keg_d_tgl,
				"detil_jumlah"=>$r->keg_d_jumlah,
				"detil_dibuat_oleh"=>$r->keg_d_dibuat_oleh,
				"detil_dibuat_waktu"=>$r->keg_d_dibuat_waktu,
				"detil_diupdate_oleh"=>$r->keg_d_diupdate_oleh,
				"detil_diupdate_waktu"=>$r->keg_d_diupdate_waktu,
				"detil_jenis"=>$r->keg_d_jenis,
				"detil_link_laci"=>$r->keg_d_link_laci,
				"detil_ket"=>$r->keg_d_ket
			);
			$i++;
		}
	}
	else {
		$data_keg["error"]=true;
		$data_keg["pesan_error"]='Data tidak tersedia';
	}
	return $data_keg;
	$conn_keg->close();
}
function list_target_keg_kabkota($keg_id,$unit_kode,$detil=false) {
	$db_keg = new db();
	$conn_keg = $db_keg -> connect();
	if ($detil==false) {
		//semua untuk 1 kegiatan
		$sql_kegiatan = $conn_keg -> query("select keg_target.*, unitkerja.unit_nama from keg_target inner join unitkerja on keg_target.keg_t_unitkerja=unitkerja.unit_kode where keg_id='$keg_id' and keg_t_target>0 order by keg_target.keg_t_unitkerja asc") or die(mysqli_error($conn_keg));
	}
	else {
		//1 keg 1 kabkota saja
		$sql_kegiatan = $conn_keg -> query("select keg_target.*, unitkerja.unit_nama from keg_target inner join unitkerja on keg_target.keg_t_unitkerja=unitkerja.unit_kode where keg_id='$keg_id' and keg_t_unitkerja='$unit_kode' and keg_t_target>0 ") or die(mysqli_error($conn_keg));
	}
	$cek=$sql_kegiatan->num_rows;
	$data_keg=array("error"=>false);
	if ($cek > 0) {
		$data_keg["error"]=false;
		$data_keg["target_total"]=$cek;
		$i=1;
		while ($r=$sql_kegiatan->fetch_object()) {
			$data_keg["item"][$i]=array(
				"keg_id"=>$r->keg_id,
				"target_id"=>$r->keg_t_id,
				"target_unitkerja"=>$r->keg_t_unitkerja,
				"target_unitnama"=>$r->unit_nama,
				"target_jumlah"=>$r->keg_t_target,
				"target_dibuat_oleh"=>$r->keg_t_dibuat_oleh,
				"target_dibuat_waktu"=>$r->keg_t_dibuat_waktu,
				"target_diupdate_oleh"=>$r->keg_t_diupdate_oleh,
				"target_diupdate_waktu"=>$r->keg_t_diupdate_waktu,
				"target_poin_waktu"=>$r->keg_t_point_waktu,
				"target_poin_jumlah"=>$r->keg_t_point_jumlah,
				"target_poin_total"=>$r->keg_t_point
			);
			$i++;
		}
	}
	else {
		$data_keg["error"]=true;
		$data_keg["pesan_error"]='Data tidak tersedia';
	}
	return $data_keg;
	$conn_keg->close();
}
function list_kegiatan($keg_id,$detil=false,$before=false,$bulan_keg,$tahun_keg) {
	$db_keg = new db();
	$conn_keg = $db_keg -> connect();
	if ($detil==false) {
		//semua kegiatan
		if ($before==false) {
			//semua kegiatan harus ada tahun kegiatan
			if ($bulan_keg>0) {
				//ada bulan kegiatan
				$sql_kegiatan = $conn_keg -> query("select kegiatan.*,unit_nama,unit_jenis,unit_parent from kegiatan inner join unitkerja on kegiatan.keg_unitkerja=unitkerja.unit_kode where month(keg_end)='$bulan_keg' and year(keg_end)='$tahun_keg' order by keg_end desc") or die(mysqli_error($conn_keg));
			}
			else {
				//tanpa bulan
				$sql_kegiatan = $conn_keg -> query("select kegiatan.*,unit_nama,unit_jenis,unit_parent from kegiatan inner join unitkerja on kegiatan.keg_unitkerja=unitkerja.unit_kode where year(keg_end)='$tahun_keg' order by keg_end desc") or die(mysqli_error($conn_keg));
			}
		}
		else {
			//hanya list kegiatan mendekati waktu
			$sql_kegiatan = $conn_keg -> query("select kegiatan.*,unit_nama,unit_jenis,unit_parent from kegiatan inner join unitkerja on kegiatan.keg_unitkerja=unitkerja.unit_kode where (keg_end BETWEEN date_add(now(), INTERVAL -2 day) and date_add(now(),INTERVAL 7 day)) order by keg_end asc") or die(mysqli_error($conn_keg));
		}
	}
	else {
		//satu detil kegiatan
		$sql_kegiatan = $conn_keg -> query("select kegiatan.*,unit_nama,unit_jenis,unit_parent from kegiatan inner join unitkerja on kegiatan.keg_unitkerja=unitkerja.unit_kode where kegiatan.keg_id='$keg_id'") or die(mysqli_error($conn_keg));
	}
	$cek = $sql_kegiatan -> num_rows;
	$data_keg=array("error"=>false);
	if ($cek>0) {
		$data_keg["error"]=false;
		$data_keg["keg_total"]=$cek;
		$i=1;
		while ($r= $sql_kegiatan -> fetch_object()) {
			$data_keg["item"][$i]=array(
				"keg_id"=>$r->keg_id,
				"keg_nama"=>$r->keg_nama,
				"keg_unitkerja"=>$r->keg_unitkerja,
				"keg_start"=>$r->keg_start,
				"keg_end"=>$r->keg_end,
				"keg_dibuat_oleh"=>$r->keg_dibuat_oleh,
				"keg_dibuat_waktu"=>$r->keg_dibuat_waktu,
				"keg_diupdate_oleh"=>$r->keg_diupdate_oleh,
				"keg_diupdate_waktu"=>$r->keg_diupdate_waktu,
				"keg_jenis"=>$r->keg_jenis,
				"keg_total_target"=>$r->keg_total_target,
				"keg_target_satuan"=>$r->keg_target_satuan,
				"keg_spj"=>$r->keg_spj,
				"keg_info"=>$r->keg_info,
				"keg_unitnama"=>$r->unit_nama,
				"keg_unitjenis"=>$r->unit_jenis,
				"keg_unitparent"=>$r->unit_parent
			);
			$i++;
		}
	}
	else {
		$data_keg["error"]=true;
		$data_keg["pesan_error"]="Data kegiatan tidak tersedia";		
	}
	return $data_keg;
	$conn_keg->close();
}
function list_kegiatan_bidang($unit_kode,$bulan_keg,$tahun_keg) {
	$db_keg = new db();
	$conn_keg = $db_keg -> connect();
	if ($unit_kode>0) {
		//kegiatan 1 bidang berdasarkan bulan
			if ($bulan_keg>0) {
				//ada bulan kegiatan
				$sql_kegiatan = $conn_keg -> query("select kegiatan.*,unit_nama,unit_jenis,unit_parent from kegiatan inner join unitkerja on kegiatan.keg_unitkerja=unitkerja.unit_kode where month(keg_end)='$bulan_keg' and year(keg_end)='$tahun_keg' and unit_parent='$unit_kode' order by keg_end desc") or die(mysqli_error($conn_keg));
			}
			else {
				//tanpa bulan
				$sql_kegiatan = $conn_keg -> query("select kegiatan.*,unit_nama,unit_jenis,unit_parent from kegiatan inner join unitkerja on kegiatan.keg_unitkerja=unitkerja.unit_kode where year(keg_end)='$tahun_keg' and unit_parent='$unit_kode' order by keg_end desc") or die(mysqli_error($conn_keg));
			}
		
	}
	else {
		//satu detil kegiatan bidang
		if ($bulan_keg>0) {
				//ada bulan kegiatan
				$sql_kegiatan = $conn_keg -> query("select kegiatan.*,unit_nama,unit_jenis,unit_parent from kegiatan inner join unitkerja on kegiatan.keg_unitkerja=unitkerja.unit_kode where month(keg_end)='$bulan_keg' and year(keg_end)='$tahun_keg' order by keg_end desc") or die(mysqli_error($conn_keg));
			}
			else {
				//tanpa bulan
				$sql_kegiatan = $conn_keg -> query("select kegiatan.*,unit_nama,unit_jenis,unit_parent from kegiatan inner join unitkerja on kegiatan.keg_unitkerja=unitkerja.unit_kode where year(keg_end)='$tahun_keg' order by keg_end desc") or die(mysqli_error($conn_keg));
			}
	}
	$cek = $sql_kegiatan -> num_rows;
	$data_keg=array("error"=>false);
	if ($cek>0) {
		$data_keg["error"]=false;
		$data_keg["keg_total"]=$cek;
		$i=1;
		while ($r= $sql_kegiatan -> fetch_object()) {
			$data_keg["item"][$i]=array(
				"keg_id"=>$r->keg_id,
				"keg_nama"=>$r->keg_nama,
				"keg_unitkerja"=>$r->keg_unitkerja,
				"keg_start"=>$r->keg_start,
				"keg_end"=>$r->keg_end,
				"keg_dibuat_oleh"=>$r->keg_dibuat_oleh,
				"keg_dibuat_waktu"=>$r->keg_dibuat_waktu,
				"keg_diupdate_oleh"=>$r->keg_diupdate_oleh,
				"keg_diupdate_waktu"=>$r->keg_diupdate_waktu,
				"keg_jenis"=>$r->keg_jenis,
				"keg_total_target"=>$r->keg_total_target,
				"keg_target_satuan"=>$r->keg_target_satuan,
				"keg_spj"=>$r->keg_spj,
				"keg_info"=>$r->keg_info,
				"keg_unitnama"=>$r->unit_nama,
				"keg_unitjenis"=>$r->unit_jenis,
				"keg_unitparent"=>$r->unit_parent
			);
			$i++;
		}
	}
	else {
		$data_keg["error"]=true;
		$data_keg["pesan_error"]="Data kegiatan tidak tersedia";		
	}
	return $data_keg;
	$conn_keg->close();
}
function ranking_kabkota($bulan_keg,$tahun_keg) {
	$db_keg = new db();
	$conn_keg = $db_keg -> connect();
	$sql_ranking_keg = $conn_keg -> query("select unit_nama, keg.* from unitkerja inner join (select keg_t_unitkerja, count(*) as keg_jml, sum(keg_target.keg_t_target) as keg_jml_target, sum(keg_target.keg_t_point_waktu) as point_waktu, sum(keg_target.keg_t_point_jumlah) as point_jumlah, sum(keg_target.keg_t_point) as point_total, avg(keg_target.keg_t_point) as point_rata from keg_target,kegiatan where kegiatan.keg_id=keg_target.keg_id and month(kegiatan.keg_end)='$bulan_keg' and year(kegiatan.keg_end)='$tahun_keg' and keg_target.keg_t_target>0 group by keg_t_unitkerja) as keg on unitkerja.unit_kode=keg.keg_t_unitkerja order by keg.point_rata desc");
	$cek=$sql_ranking_keg->num_rows;
	$data_keg=array("error"=>false);
	if ($cek>0) {
		$data_keg["error"]=false;
		$data_keg["rank_total"]=$cek;
		$i=1;
		while ($r=$sql_ranking_keg->fetch_object()) {
			$data_keg["item"][$i]=array(
				"rank_nama"=>$r->unit_nama,
				"rank_unitkode"=>$r->keg_t_unitkerja,
				"rank_keg_jumlah"=>$r->keg_jml,
				"rank_target"=>$r->keg_jml_target,
				"rank_poin_waktu"=>$r->point_waktu,
				"rank_poin_jumlah"=>$r->point_jumlah,
				"rank_poin_total"=>$r->point_total,
				"rank_poin_rata"=>$r->point_rata
			);
			$i++;
		}
	}
	else {
		$data_keg["error"]=true;
		$data_keg["pesan_error"]='Data tidak tersedia';
	}
	return $data_keg;
	$conn_keg->close();	
}

function jumlah_kegiatan($bulan_keg,$tahun_keg) {
	$db_keg = new db();
	$conn_keg = $db_keg -> connect();
	$sql_ranking_keg = $conn_keg -> query("select unitkerja.unit_kode, unitkerja.unit_nama, keg.jumlah from unitkerja left join (select SUBSTRING(keg_unitkerja,1,4) as keg_unit, COUNT(*) as jumlah from kegiatan where month(kegiatan.keg_end)='$bulan_keg' and year(kegiatan.keg_end)='$tahun_keg' group by keg_unit) as keg on keg.keg_unit=SUBSTRING(unitkerja.unit_kode,1,4) where unitkerja.unit_jenis=1 and unitkerja.unit_eselon=3 group by unitkerja.unit_kode") or die(mysqli_error($conn_keg));
	$cek=$sql_ranking_keg->num_rows;
	$data_keg=array("error"=>false);
	if ($cek>0) {
		$data_keg["error"]=false;
		$data_keg["keg_bulan_total"]=$cek;
		$i=1;
		while ($r=$sql_ranking_keg->fetch_object()) {
			$data_keg["item"][$i]=array(
				"keg_bulan_unitnama"=>$r->unit_nama,
				"keg_bulan_unitkerja"=>$r->unit_nama,
				"keg_bulan_jumlah"=>$r->jumlah
			);
			$i++;
		}
	}
	else {
		$data_keg["error"]=true;
		$data_keg["pesan_error"]='Data tidak tersedia';
	}
	return $data_keg;
	$conn_keg->close();	
}
function jumlah_kegiatan_tahunan($tahun_keg,$detil=false) {
	$db_keg = new db();
	$conn_keg = $db_keg -> connect();
	if ($detil==false) {
		$sql_tahunan = $conn_keg -> query("select month(keg_end) as bulan, year(keg_end) as tahun, count(*) as jumlah from kegiatan where year(keg_end) <= '$tahun_keg' group by tahun asc limit 2") or die(mysqli_error($conn_keg));
	}
	else {
		$sql_tahunan = $conn_keg -> query("select month(keg_end) as bulan, year(keg_end) as tahun, count(*) as jumlah from kegiatan where year(keg_end)='$tahun_keg' group by bulan asc") or die(mysqli_error($conn_keg));
	}
	
	$cek=$sql_tahunan->num_rows;
	$data_keg=array("error"=>false);
	if ($cek>0) {
		$data_keg["error"]=false;
		$data_keg["keg_bln_total"]=$cek;
		$i=1;
		while ($r=$sql_tahunan->fetch_object()) {
			$data_keg["item"][$i]=array(
				"keg_bulan"=>$r->bulan,
				"keg_tahun"=>$r->tahun,
				"keg_jumlah"=>$r->jumlah
			);
			$i++;
		}
	}
	else {
		$data_keg["error"]=true;
		$data_keg["pesan_error"]='Data tidak tersedia';
	}
	return $data_keg;
	$conn_keg->close();	
}
function jumlah_keg_terima_kirim($tahun_keg) {
	$db_keg = new db();
	$conn_keg = $db_keg -> connect();
	$sql_terimakirim=$conn_keg->query("select year(kegiatan.keg_end) as keg_tahun, count(*) as keg_jumlah, detil.keg_d_jenis from kegiatan inner join (select keg_id, year(keg_d_tgl) as tahun, keg_d_jenis, count(*) as jumlah from keg_detil group by keg_id, keg_d_jenis, tahun) as detil on kegiatan.keg_id=detil.keg_id where year(kegiatan.keg_end)='2018' group by year(kegiatan.keg_end) asc, detil.keg_d_jenis") or die(mysqli_error($conn_keg));
	$cek=$sql_terimakirim->num_rows;
	$data_keg=array("error"=>false);
	if ($cek>0) {
		$data_keg["error"]=false;
		$data_keg["t_total"]=$cek;
		$i=1;
		while ($r=$sql_terimakirim->fetch_object()) {
			$data_keg["item"][$i]=array(
				"keg_tahun"=>$r->keg_tahun,
				"keg_jenis"=>$r->keg_d_jenis,
				"keg_jumlah"=>$r->keg_jumlah
			);
			$i++;
		}
	}
	else {
		$data_keg["error"]=true;
		$data_keg["pesan_error"]='Data tidak tersedia';
	}
	return $data_keg;
	$conn_keg->close();	
}

function seksi_terbanyak_kegiatan($tahun_keg) {
	$db_keg = new db();
	$conn_keg = $db_keg -> connect();
	$sql_terimakirim=$conn_keg->query("select unit_kode, unit_nama, keg.jumlah, keg.tahun from unitkerja inner join (select keg_unitkerja, COUNT(*) as jumlah, year(keg_end) as tahun from kegiatan where year(keg_end)='$tahun_keg' group by keg_unitkerja,tahun order by jumlah desc) as keg on unitkerja.unit_kode=keg.keg_unitkerja order by jumlah desc limit 1") or die(mysqli_error($conn_keg));
	$cek=$sql_terimakirim->num_rows;
	$data_keg=array("error"=>false);
	if ($cek>0) {
		$data_keg["error"]=false;
		$data_keg["keg_banyak"]=$cek;
		$i=1;
		while ($r=$sql_terimakirim->fetch_object()) {
			$data_keg["item"][$i]=array(
				"keg_unitkode"=>$r->unit_kode,
				"keg_unitnama"=>$r->unit_nama,
				"keg_jumlah"=>$r->jumlah,
				"keg_tahun"=>$r->tahun
			);
			$i++;
		}
	}
	else {
		$data_keg["error"]=true;
		$data_keg["pesan_error"]='Data tidak tersedia';
	}
	return $data_keg;
	$conn_keg->close();	
}
?>