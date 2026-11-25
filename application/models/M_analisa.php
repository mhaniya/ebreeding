<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
Class M_analisa extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getTotalSC($data)
	{
		$sql = "SELECT sum(sc) as totalsc FROM (select sapi.kelamin,
				(select kodepropinsi from farm where farm.idfarm=sapi.idfarm) as kodepropinsi,
				(select kodekabupaten from farm where farm.idfarm=sapi.idfarm) as kodekabupaten,
				(select kodekecamatan from farm where farm.idfarm=sapi.idfarm) as kodekecamatan,
				(select namafarm from farm where farm.idfarm=sapi.idfarm) as namafarm,
				r.nomorregister,sapi.tagsapi,
				reproduksi_kelahiran.idsapi,reproduksi_kelahiran.xlaktasi,reproduksi_kelahiran.tanggal as tglmelahirkan,
				(SELECT COUNT(*) FROM reproduksi_ib ib where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal and ib.tanggal >
				(SELECT k.tanggal FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 ORDER BY tanggal DESC LIMIT 1)) as sc
				FROM reproduksi_kelahiran 
				LEFT JOIN sapi ON sapi.idsapi=reproduksi_kelahiran.idsapi
				LEFT JOIN register r ON r.idsapi=sapi.idsapi WHERE sapi.kelamin='Betina'";
			if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				$sql .= "HAVING 1 ";
			if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
        		if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
        		if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
       		//if($data['tahun']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
       		// if($data['bulan']!='0') $this->db->where('MONTH(pengukuran_produksisusu.tanggal)',$data['bulan']);
        		// if($data['tagsapi']!='0') $sql .= " AND tagsapi='$data[tagsapi]'";

			$sql .= ") tabelSC"; 
		$rs=$this->db->query($sql);
		$row=$rs->row();
		return $row->totalsc;
	}
	function getnDataSC($data)
	{
		$sql = "SELECT count(sc) as totalsc FROM (select sapi.kelamin,
				(select kodepropinsi from farm where farm.idfarm=sapi.idfarm) as kodepropinsi,
				(select kodekabupaten from farm where farm.idfarm=sapi.idfarm) as kodekabupaten,
				(select kodekecamatan from farm where farm.idfarm=sapi.idfarm) as kodekecamatan,
				(select namafarm from farm where farm.idfarm=sapi.idfarm) as namafarm,
				r.nomorregister,sapi.tagsapi,
				reproduksi_kelahiran.idsapi,reproduksi_kelahiran.xlaktasi,reproduksi_kelahiran.tanggal as tglmelahirkan,
				(SELECT COUNT(*) FROM reproduksi_ib ib where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal and ib.tanggal >
				(SELECT k.tanggal FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 ORDER BY tanggal DESC LIMIT 1)) as sc
				FROM reproduksi_kelahiran 
				LEFT JOIN sapi ON sapi.idsapi=reproduksi_kelahiran.idsapi
				LEFT JOIN register r ON r.idsapi=sapi.idsapi WHERE sapi.kelamin='Betina'";
			if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				$sql .= "HAVING 1 ";
			if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
        		if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
        		if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
       		//if($data['tahun']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
       		// if($data['bulan']!='0') $this->db->where('MONTH(pengukuran_produksisusu.tanggal)',$data['bulan']);
        		// if($data['tagsapi']!='0') $sql .= " AND tagsapi='$data[tagsapi]'";

			$sql .= ") tabelSC";
		$rs=$this->db->query($sql);
		$row=$rs->row();
		return $row->totalsc;
	}
	function getnDataSCTerhitung($data)
	{
		$sql = "SELECT count(sc) as totalsc FROM (select sapi.kelamin,
				(select kodepropinsi from farm where farm.idfarm=sapi.idfarm) as kodepropinsi,
				(select kodekabupaten from farm where farm.idfarm=sapi.idfarm) as kodekabupaten,
				(select kodekecamatan from farm where farm.idfarm=sapi.idfarm) as kodekecamatan,
				(select namafarm from farm where farm.idfarm=sapi.idfarm) as namafarm,
				r.nomorregister,sapi.tagsapi,
				reproduksi_kelahiran.idsapi,reproduksi_kelahiran.xlaktasi,reproduksi_kelahiran.tanggal as tglmelahirkan,
				(SELECT COUNT(*) FROM reproduksi_ib ib where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal and ib.tanggal >
				(SELECT k.tanggal FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 ORDER BY tanggal DESC LIMIT 1)) as sc
				FROM reproduksi_kelahiran 
				LEFT JOIN sapi ON sapi.idsapi=reproduksi_kelahiran.idsapi
				LEFT JOIN register r ON r.idsapi=sapi.idsapi WHERE sapi.kelamin='Betina'";
			if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				$sql .= "HAVING 1 ";
			if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
        		if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
        		if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
       		//if($data['tahun']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
       		// if($data['bulan']!='0') $this->db->where('MONTH(pengukuran_produksisusu.tanggal)',$data['bulan']);
        		// if($data['tagsapi']!='0') $sql .= " AND tagsapi='$data[tagsapi]'";

			$sql .= ") tabelSC WHERE sc>0";
		$rs=$this->db->query($sql);
		$row=$rs->row();
		return $row->totalsc;
	}
	function getnDataSCTakTerhitung($data)
	{
		$sql = "SELECT count(sc) as totalsc FROM (select sapi.kelamin,
				(select kodepropinsi from farm where farm.idfarm=sapi.idfarm) as kodepropinsi,
				(select kodekabupaten from farm where farm.idfarm=sapi.idfarm) as kodekabupaten,
				(select kodekecamatan from farm where farm.idfarm=sapi.idfarm) as kodekecamatan,
				(select namafarm from farm where farm.idfarm=sapi.idfarm) as namafarm,
				r.nomorregister,sapi.tagsapi,
				reproduksi_kelahiran.idsapi,reproduksi_kelahiran.xlaktasi,reproduksi_kelahiran.tanggal as tglmelahirkan,
				(SELECT COUNT(*) FROM reproduksi_ib ib where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal and ib.tanggal >
				(SELECT k.tanggal FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 ORDER BY tanggal DESC LIMIT 1)) as sc
				FROM reproduksi_kelahiran 
				LEFT JOIN sapi ON sapi.idsapi=reproduksi_kelahiran.idsapi
				LEFT JOIN register r ON r.idsapi=sapi.idsapi WHERE sapi.kelamin='Betina'";
			if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				$sql .= "HAVING 1 ";
			if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
        		if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
        		if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
       		//if($data['tahun']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
       		// if($data['bulan']!='0') $this->db->where('MONTH(pengukuran_produksisusu.tanggal)',$data['bulan']);
        		// if($data['tagsapi']!='0') $sql .= " AND tagsapi='$data[tagsapi]'";

			$sql .= ") tabelSC WHERE sc=0";
		$rs=$this->db->query($sql);
		$row=$rs->row();
		return $row->totalsc;
	}
	
	public function get_analisa_produksi_per_laktasi($idsapi)
	{
		$sql = "SELECT idsapi,xlaktasi,min(jml_produksi) min_produksi,max(jml_produksi) max_produksi
		,max(produksi_nyata) produksi_nyata,max(jhp) jhp,(SELECT produksi_terkoreksi from analisa_produksi_susu aps 
		where aps.idsapi=analisa_produksi_susu.idsapi 
		AND aps.xlaktasi=analisa_produksi_susu.xlaktasi AND aps.jhp=max(analisa_produksi_susu.jhp)) produksi_terkoreksi
		FROM `analisa_produksi_susu`
		where idsapi='$idsapi'
		group by idsapi,xlaktasi";
		$rs=$this->db->query($sql);
		$i=0;
		$data=null;
		foreach($rs->result() as $row){
			$data[$i]['idsapi']=$row->idsapi;
			$data[$i]['xlaktasi']=$row->xlaktasi;
			$data[$i]['minproduksi']=$row->min_produksi;
			$data[$i]['maxproduksi']=$row->max_produksi;
			$data[$i]['produksinyata']=$row->produksi_nyata;
			$data[$i]['jhp']=$row->jhp;
			$data[$i]['terkoreksi']=$row->produksi_terkoreksi;
			$i++;
		}
		$arrdata['data']=$data;
		return json_encode($arrdata);
	}
	
	public function get_all_analisaproduksi()
	{
		$tahunValue = trim((string) $this->session->userdata('tahun'));
		$bulanValue = trim((string) $this->session->userdata('bulan'));
		$tahun = $tahunValue === '' ? (int) date('Y') : (int) $tahunValue;
		$bulan = $bulanValue === '' ? (int) date('m') : (int) $bulanValue;
		$tanggal = trim((string) $this->session->userdata('tanggal'));
		$date = $tanggal === '' ? null : DateTime::createFromFormat('!Y-m-d', $tanggal);
		if ($bulan < 0 || $bulan > 12 || $tahun < 0 || $tahun > 9999 ||
			($tanggal !== '' && (!$date || $date->format('Y-m-d') !== $tanggal)) ||
			($date && (($tahun && $tahun !== (int) $date->format('Y')) ||
				($bulan && $bulan !== (int) $date->format('m'))))) {
			return json_encode(array());
		}

		$params = array();
		$where = array("pp.tanggal IS NOT NULL", "pp.tanggal >= '1000-01-01'");
		foreach (array('kodepropinsi', 'kodekabupaten', 'kodekecamatan', 'idfarm') as $field) {
			$value = trim((string) $this->session->userdata($field));
			if ($value !== '' && $value !== '0') {
				$where[] = 'farm.' . $field . ' = ?';
				$params[] = $value;
			}
		}
		// Read previous months as well, so display filters do not reset accumulated production.
		if ($date) {
			$where[] = 'pp.tanggal <= ?';
			$params[] = $tanggal;
		} elseif ($tahun > 0) {
			$end = new DateTime(sprintf('%04d-%02d-01', $tahun, $bulan ?: 12));
			$end->modify('+1 month');
			$where[] = 'pp.tanggal < ?';
			$params[] = $end->format('Y-m-d');
		}
		$where[] = '(birth.tgllaktasi IS NULL OR pp.tanggal >= birth.tgllaktasi)';
		$where[] = "(birth.tgllaktasi IS NULL OR NOT EXISTS (
			SELECT 1 FROM reproduksi_kelahiran later
			WHERE later.idsapi = pp.idsapi AND later.xlaktasi > 0 AND later.xlaktasi <> pp.xlaktasi
				AND later.tanggal > birth.tgllaktasi AND later.tanggal <= pp.tanggal))";

		// Keep the existing test-day rule, but clamp the day to each month's calendar.
		$eligible = "(birth.tgllaktasi IS NULL OR pp.tanggal >= GREATEST(
			DATE_ADD(birth.tgllaktasi, INTERVAL 8 DAY),
			STR_TO_DATE(CONCAT(DATE_FORMAT(pp.tanggal, '%Y-%m-'),
				LPAD(LEAST(DAY(DATE_ADD(birth.tgllaktasi, INTERVAL 8 DAY)),
					DAY(LAST_DAY(pp.tanggal))), 2, '0')), '%Y-%m-%d')))";
		if ($date) {
			// An exact-date filter selects that day's sample in the displayed month.
			$eligible = "(CASE WHEN YEAR(pp.tanggal) = " . (int) $date->format('Y') .
				" AND MONTH(pp.tanggal) = " . (int) $date->format('m') .
				" THEN pp.tanggal = '" . $date->format('Y-m-d') . "' ELSE " . $eligible . ' END)';
		}
		$sql = "SELECT monthly.*, sapi.tagsapi, DATE_FORMAT(sapi.tgllahir, '%Y-%m-%d') tgllahir,
			(SELECT r.nomorregister FROM register r WHERE r.idsapi = sapi.idsapi
				ORDER BY r.tanggal DESC, r.nomorregister DESC LIMIT 1) nomorregister,
			ROUND(sample.pagi + sample.sore, 2) jmlsusu,
			DATEDIFF(monthly.tglproduksi, monthly.tgllaktasi) jhp,
			FLOOR(DATEDIFF(monthly.tglproduksi, sapi.tgllahir) / 365) umurtahun,
			ROUND((DATEDIFF(monthly.tglproduksi, sapi.tgllahir) / 365 -
				FLOOR(DATEDIFF(monthly.tglproduksi, sapi.tgllahir) / 365)) * 12 / 100, 2) umurbulan,
			age_factor.koreksi koreksiumur, day_factor.koreksi koreksijhp
			FROM (
				SELECT pp.idsapi, pp.xlaktasi, YEAR(pp.tanggal) tahunproduksi,
					MONTH(pp.tanggal) bulanproduksi, birth.tgllaktasi,
					MIN(CASE WHEN " . $eligible . " THEN pp.tanggal END) tglproduksi
				FROM pengukuran_produksisusu pp
				JOIN sapi ON sapi.idsapi = pp.idsapi
				JOIN farm ON farm.idfarm = sapi.idfarm
				LEFT JOIN (
					SELECT idsapi, xlaktasi, MIN(tanggal) tgllaktasi
					FROM reproduksi_kelahiran
					WHERE xlaktasi > 0 AND tanggal IS NOT NULL AND tanggal >= '1000-01-01'
					GROUP BY idsapi, xlaktasi
				) birth ON birth.idsapi = pp.idsapi AND birth.xlaktasi = pp.xlaktasi
				WHERE " . implode(' AND ', $where) . "
				GROUP BY pp.idsapi, pp.xlaktasi, YEAR(pp.tanggal), MONTH(pp.tanggal), birth.tgllaktasi
			) monthly
			JOIN sapi ON sapi.idsapi = monthly.idsapi
			LEFT JOIN pengukuran_produksisusu sample ON sample.idsapi = monthly.idsapi
				AND sample.xlaktasi = monthly.xlaktasi AND sample.tanggal = monthly.tglproduksi
			LEFT JOIN con_koreksiumur age_factor ON age_factor.umur =
				ROUND(FLOOR(DATEDIFF(monthly.tglproduksi, sapi.tgllahir) / 365) +
					ROUND((DATEDIFF(monthly.tglproduksi, sapi.tgllahir) / 365 -
						FLOOR(DATEDIFF(monthly.tglproduksi, sapi.tgllahir) / 365)) * 12 / 100, 2), 2)
			LEFT JOIN con_koreksijhp day_factor ON day_factor.jhp =
				DATEDIFF(monthly.tglproduksi, monthly.tgllaktasi)
			ORDER BY monthly.idsapi, monthly.xlaktasi, monthly.tahunproduksi, monthly.bulanproduksi";
		$rows = $this->db->query($sql, $params)->result();
		return json_encode($this->production_analysis_rows($rows, $tahun, $bulan, $tanggal));
	}

	public function production_analysis_rows($rows, $tahun, $bulan, $tanggal = '')
	{
		$data = array();
		$previousKey = null;
		$monthNumber = 0;
		$cumulative = 0;
		foreach ($rows as $row) {
			$key = $row->idsapi . '/' . $row->xlaktasi;
			if ($key !== $previousKey) {
				$previousKey = $key;
				$monthNumber = 0;
				$cumulative = 0;
			}
			$monthNumber++;
			$calendar = new DateTime(sprintf('%04d-%02d-01', $row->tahunproduksi, $row->bulanproduksi));
			$days = (int) $calendar->format('t');
			$notes = array();
			if ($row->tgllaktasi === null) { $notes[] = 'Riwayat kelahiran/laktasi tidak tersedia'; }
			if ($row->tglproduksi === null) { $notes[] = 'Tidak ada catatan produksi pada rentang tanggal sampel bulan ini'; }
			if ($row->jmlsusu === null) { $notes[] = 'Nilai produksi sampel tidak tersedia'; }
			$monthly = $row->jmlsusu !== null && $row->jhp !== null && $row->jhp >= 0 ?
				round($row->jmlsusu * ($monthNumber === 1 ? $row->jhp : $days), 1) : null;
			$before = $cumulative;
			$cumulative = $cumulative !== null && $monthly !== null ? $cumulative + $monthly : null;
			if ($cumulative === null && $monthly !== null) { $notes[] = 'Akumulasi bulan sebelumnya tidak lengkap'; }
			$ageFactor = $row->koreksiumur !== null && $row->koreksiumur > 0 ? (float) $row->koreksiumur : null;
			$dayFactor = $row->koreksijhp !== null && $row->koreksijhp > 0 ? (float) $row->koreksijhp : null;
			if ($ageFactor === null) { $notes[] = 'Faktor koreksi umur tidak tersedia'; }
			if ($dayFactor === null) { $notes[] = 'Faktor koreksi JHP tidak tersedia'; }
			$corrected = $cumulative !== null && $ageFactor !== null && $dayFactor !== null ?
				round($cumulative * $ageFactor * $dayFactor, 1) : null;

			// Apply display filters only after calculating preceding months in this lactation.
			if (($tahun && (int) $row->tahunproduksi !== (int) $tahun) ||
				($bulan && (int) $row->bulanproduksi !== (int) $bulan) ||
				($tanggal !== '' && $row->tglproduksi !== $tanggal)) { continue; }
			$data[] = array(
				'idsapi' => $row->idsapi, 'nomorregister' => $row->nomorregister, 'tagsapi' => $row->tagsapi,
				'tgllahir' => $row->tgllahir, 'xlaktasi' => $row->xlaktasi,
				'laktasi_bulanke' => $monthNumber, 'laktasi_jumlahsusu' => $row->jmlsusu === null ? null : (float) $row->jmlsusu,
				'tgllaktasi' => $row->tgllaktasi, 'tglproduksi' => $row->tglproduksi,
				'tahunproduksi' => $row->tahunproduksi, 'bulanproduksi' => $row->bulanproduksi, 'jhp' => $row->jhp,
				'umur' => $row->umurtahun === null || $row->umurbulan === null ? null :
					number_format($row->umurtahun + $row->umurbulan, 2, ',', '.'),
				'jumlahhari' => $days, 'produksisebelum' => $before === null ? null : round($before, 1),
				'produksibulanan' => $monthly, 'produksinyata' => $cumulative === null ? null : round($cumulative, 1),
				'koreksiumur' => $ageFactor, 'koreksijhp' => $dayFactor, 'produksiterkoreksi' => $corrected,
				'status_koreksi' => implode('; ', $notes));
		}
		return $data;
	}
	
	public function get_analisa($idsapi)
	{

		$sql="SELECT idsapi,nomorregister,tagsapi,idfarm,xlaktasi,tgllahir,tgllaktasi,umurtahun
		,round(((datediff((SELECT pp1.tanggal FROM pengukuran_produksisusu pp1 WHERE pp1.idsapi=tabel.idsapi AND pp1.tanggal>=concat(tahunproduksi,'-',lpad( bulanproduksi,2,'0'),'-',LPAD(tanggal_8_hari_laktasi,2,'0')) ORDER BY pp1.tanggal LIMIT 1),tgllahir)/365)-(floor(datediff((SELECT pp1.tanggal FROM pengukuran_produksisusu pp1 WHERE pp1.idsapi=tabel.idsapi AND pp1.tanggal>=concat(tahunproduksi,'-',lpad( bulanproduksi,2,'0'),'-',LPAD(tanggal_8_hari_laktasi,2,'0')) ORDER BY pp1.tanggal LIMIT 1),tgllahir)/365 )))*12/100,2) as umurbulan
		,(SELECT koreksi FROM con_koreksiumur WHERE con_koreksiumur.umur=umurtahun+round(((datediff((SELECT pp1.tanggal FROM pengukuran_produksisusu pp1 WHERE pp1.idsapi=tabel.idsapi AND pp1.tanggal>=concat(tahunproduksi,'-',lpad( bulanproduksi,2,'0'),'-',LPAD(tanggal_8_hari_laktasi,2,'0')) ORDER BY pp1.tanggal LIMIT 1),tgllahir)/365)-(floor(datediff((SELECT pp1.tanggal FROM pengukuran_produksisusu pp1 WHERE pp1.idsapi=tabel.idsapi AND pp1.tanggal>=concat(tahunproduksi,'-',lpad( bulanproduksi,2,'0'),'-',LPAD(tanggal_8_hari_laktasi,2,'0')) ORDER BY pp1.tanggal LIMIT 1),tgllahir)/365 )))*12/100,2)) koreksiumur
		
		,(SELECT koreksi from con_koreksijhp WHERE con_koreksijhp.jhp=DATEDIFF( (SELECT pp1.tanggal FROM pengukuran_produksisusu pp1 WHERE pp1.idsapi=tabel.idsapi AND pp1.tanggal>=concat(tahunproduksi,'-',lpad( bulanproduksi,2,'0'),'-',LPAD(tanggal_8_hari_laktasi,2,'0')) ORDER BY pp1.tanggal LIMIT 1),tgllaktasi)) koreksijhp	
		,bulanproduksi,tahunproduksi
		,(SELECT pp1.tanggal FROM pengukuran_produksisusu pp1 WHERE pp1.idsapi=tabel.idsapi AND pp1.tanggal>=concat(tahunproduksi,'-',lpad( bulanproduksi,2,'0'),'-',LPAD(tanggal_8_hari_laktasi,2,'0')) ORDER BY pp1.tanggal LIMIT 1) tglproduksi
		
		,DATEDIFF( (SELECT pp1.tanggal FROM pengukuran_produksisusu pp1 WHERE pp1.idsapi=tabel.idsapi AND pp1.tanggal>=concat(tahunproduksi,'-',lpad( bulanproduksi,2,'0'),'-',LPAD(tanggal_8_hari_laktasi,2,'0')) ORDER BY pp1.tanggal LIMIT 1),tgllaktasi) jhp
		,(SELECT round(pp1.pagi+pp1.sore,2) FROM pengukuran_produksisusu pp1 WHERE pp1.idsapi=tabel.idsapi AND pp1.tanggal>=concat(tahunproduksi,'-',lpad( bulanproduksi,2,'0'),'-',LPAD(tanggal_8_hari_laktasi,2,'0')) ORDER BY pp1.tanggal LIMIT 1) jmlsusu
		,(SELECT jumlah FROM jumlahhari where idbulan=bulanproduksi) jumlahhari
		,(SELECT round(pp1.pagi+pp1.sore,2) FROM pengukuran_produksisusu pp1 WHERE pp1.idsapi=tabel.idsapi AND pp1.tanggal>=concat(tahunproduksi,'-',lpad( bulanproduksi,2,'0'),'-',LPAD(tanggal_8_hari_laktasi,2,'0')) ORDER BY pp1.tanggal LIMIT 1)*DATEDIFF( (SELECT pp1.tanggal FROM pengukuran_produksisusu pp1 WHERE pp1.idsapi=tabel.idsapi AND pp1.tanggal>=concat(tahunproduksi,'-',lpad( bulanproduksi,2,'0'),'-',LPAD(tanggal_8_hari_laktasi,2,'0')) ORDER BY pp1.tanggal LIMIT 1),tgllaktasi) produksi_bulanan
		FROM (
		SELECT sapi.idsapi,nomorregister,sapi.tagsapi,DATE_FORMAT(sapi.tgllahir,'%Y-%m-%d') tgllahir,sapi.idfarm,rk.xlaktasi,rk.tanggal tgllaktasi
		,FLOOR(DATEDIFF(pp.tanggal,sapi.tgllahir)/365 ) umurtahun

		,month(pp.tanggal) bulanproduksi,year(pp.tanggal) tahunproduksi,DAY( DATE_ADD(rk.tanggal,INTERVAL 8 day)) tanggal_8_hari_laktasi
		FROM sapi
		JOIN farm USING(idfarm)
		JOIN register USING(idsapi)
		JOIN pengukuran_produksisusu pp USING(idsapi)
		JOIN reproduksi_kelahiran rk ON (rk.idsapi=sapi.idsapi AND rk.xlaktasi=pp.xlaktasi)
		WHERE sapi.idsapi='$idsapi' ";

		 
		$tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
		$bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
		$tanggal = $this->session->userdata('tanggal');
		// $xlaktasi = $this->session->userdata('xlaktasi');
	
		 
		if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(tanggal)',$tahun);
		if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(tanggal)',$bulan);
		if(($tanggal!=""))  $this->datatables->where('tanggal',$tanggal);
		
		$sql .=" GROUP BY 
		sapi.idsapi
		,nomorregister
		,sapi.tagsapi
		,sapi.idfarm
		,umurtahun
		,rk.xlaktasi
		,rk.tanggal,month(pp.tanggal),year(pp.tanggal)
		order by sapi.idsapi,tahunproduksi,bulanproduksi) tabel";
		
		$rs_data=$this->db->query($sql);
		 	
		$i=0;
		$laktasi_bulanke=0;
		$prodsebelum=0;
		$tagsapi1="";
		$xlaktasi1="";
		$idsapi1="";
		$nomorregister="";
		$jumlahhari="1";
		$data=null;
		foreach($rs_data->result() as $rowdata){
			$i++;
			
			$sql="SELECT nomorregister,sapi.tagsapi,sapi.tgllahir
				,pp.xlaktasi
				,max(pagi+sore) as jmlsusu 
				,rk.tanggal as tgllaktasi
				,pp.tanggal as tglproduksi
				,month(pp.tanggal) as bulanproduksi
				,year(pp.tanggal) as tahunproduksi
				,datediff(pp.tanggal,rk.tanggal) as jhp
				,datediff(pp.tanggal,sapi.tgllahir)/365 as umur
				,floor(datediff(pp.tanggal,sapi.tgllahir)/365 ) as umurtahun
				,round(((datediff(pp.tanggal,sapi.tgllahir)/365)-(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )))*12/100,2) as umurbulan
				,jumlahhari.jumlah as jumlahhari,con_koreksiumur.koreksi as koreksiumur,con_koreksijhp.koreksi as koreksijhp
				from pengukuran_produksisusu pp
				join sapi using(idsapi)
				left join register using(idsapi) 
				left join reproduksi_kelahiran rk on rk.idsapi=sapi.idsapi and rk.xlaktasi=pp.xlaktasi
				left join jumlahhari on (jumlahhari.idbulan=month(pp.tanggal) )
				left join con_koreksiumur on con_koreksiumur.umur=(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )+round(((datediff(pp.tanggal,sapi.tgllahir)/365)-(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )))*12/100,2))
				join con_koreksijhp on con_koreksijhp.jhp=datediff(pp.tanggal,rk.tanggal)
				where sapi.tagsapi='".$rowdata->tagsapi."'
				AND pp.xlaktasi='".$rowdata->xlaktasi."'
				AND month(pp.tanggal)='".$rowdata->bulanproduksi."'";
				
				if(($xlaktasi1!=$rowdata->xlaktasi)||($idsapi1!=$rowdata->idsapi)){
					$idsapi1=$rowdata->idsapi;
					$laktasi_bulanke=1;
					$xlaktasi1=$rowdata->xlaktasi;
					$prodsebelum=0;
				}else{
					$laktasi_bulanke++;
				}
				
				$tglsebelum="0000-00-00";

				if($laktasi_bulanke==1){ 
					$sql .= " GROUP BY sapi.idsapi,nomorregister,sapi.tagsapi,pp.xlaktasi ,tgllaktasi ,tglproduksi,tgllahir ,pagi,sore,jumlahhari,koreksiumur ,koreksijhp ";
					$rs=$this->db->query($sql);
					$row=$rs->row();
					$tglsebelum=$row->tglproduksi;
				}else{
					if($tglsebelum!="0000-00-00") $sql .= " AND pp.tanggal between date_add('$tglsebelum', interval 1 day) and date_add('$tglsebelum', interval $jumlahhari day)  ";
					$sql .= " GROUP BY sapi.idsapi,nomorregister,sapi.tagsapi,pp.xlaktasi ,tgllaktasi ,tglproduksi,tgllahir ,pagi,sore,jumlahhari,koreksiumur ,koreksijhp ";
					$sql .= " ORDER BY tglproduksi DESC limit 1"; 
					$rs=$this->db->query($sql);
					if($rs->num_rows()>0){
						$row=$rs->row();
						$tglsebelum=$row->tglproduksi;
					}else{
						$tglsebelum="";
					}
					
				}
				 
				
				$dt['nomorregister']=$rowdata->nomorregister;
				$dt['tagsapi']=$rowdata->tagsapi;
				$dt['tgllahir']=$rowdata->tgllahir;
				$dt['xlaktasi']=$rowdata->xlaktasi;
				$dt['laktasi_bulanke']=$laktasi_bulanke;
				$dt['laktasi_jumlahsusu']=number_format($rowdata->jmlsusu,1);
				$dt['tgllaktasi']=$rowdata->tgllaktasi; 
				$dt['tglproduksi']=$rowdata->tglproduksi; 
				$dt['jhp']=$rowdata->jhp; 
				$dt['umur']=number_format($rowdata->umurtahun+$rowdata->umurbulan,2,",",".");
				$dt['produksisebelum']=round($prodsebelum,1);  //--------Produksi SEBELUM ---->
			
				if($rowdata->bulanproduksi!=2){
					$jumlahhari=$rowdata->jumlahhari;
				}else
				if(($rowdata->bulanproduksi==2)&&($rowdata->tahunproduksi%4==0)){
					$jumlahhari=29;
				}else
					$jumlahhari=28;
				$dt['jumlahhari']=$jumlahhari;  //<!---- Jumlah Hari ---->
			 
				if($laktasi_bulanke==1)
					$produksibulanan=round($rowdata->jmlsusu*$rowdata->jhp,1);
				else
					$produksibulanan=round($rowdata->jmlsusu*$jumlahhari,1);
			 
				$dt['produksibulanan']=$produksibulanan;   //<!---- Produksi Bulanan ---->
				$produksinyata=$prodsebelum+$produksibulanan;
				$dt['produksinyata']=round($produksinyata,1);   	//<!---- Produksi Nyata ---->
				$dt['koreksiumur']=number_format($rowdata->koreksiumur,2,",",".");	//<!---- Koreksi UMUR ---->
				$dt['koreksijhp']=number_format($rowdata->koreksijhp,2,",",".");	//<!---- Koreksi JHP ---->
				$koreksiumur=$rowdata->koreksiumur;
				$koreksijhp=$rowdata->koreksijhp;
				$prodterkoreksi=$produksinyata*$koreksiumur*$koreksijhp;
				$dt['produksiterkoreksi']=number_format($prodterkoreksi,1,",",".");
				$prodsebelum=$produksinyata; 
				$data[]=$dt; 

				$idsapi=$rowdata->idsapi;
				$xlaktasi=$rowdata->xlaktasi;
 
				$sql_produksi="REPLACE INTO analisa_produksi_susu VALUES('$idsapi','$xlaktasi','$laktasi_bulanke','$rowdata->jmlsusu','$rowdata->tglproduksi','$produksinyata','$rowdata->jhp','$prodterkoreksi')";
				$this->db->query($sql_produksi);
		} 
		// $this->db->replace('analisa_produksi_susu',$data);
		$data['data']=$data;

		return json_encode($data);
	}

	public function get_analisaproduksi()
	{
		$sql="SELECT nomorregister,sapi.tagsapi,DATE_FORMAT(sapi.tgllahir,'%Y-%m-%d') tgllahir
		,pp.xlaktasi
		,round(pagi+sore,2) as jmlsusu 
		,rk.tanggal as tgllaktasi
		,pp.tanggal as tglproduksi
		,MONTH(rk.tanggal) as bulanlaktasi
		,MONTH(pp.tanggal) as bulanproduksi
		,YEAR(pp.tanggal) as tahunproduksi
		,(YEAR(pp.tanggal)-YEAR(rk.tanggal))*12+MONTH(pp.tanggal)-MONTH(rk.tanggal) as bulanke
		,DATEDIFF(pp.tanggal,rk.tanggal) as jhp
		,DATEDIFF(pp.tanggal,sapi.tgllahir)/365 as umur
		,FLOOR(DATEDIFF(pp.tanggal,sapi.tgllahir)/365 ) +	
		ROUND(((DATEDIFF(pp.tanggal,sapi.tgllahir)/365)-(FLOOR(DATEDIFF(pp.tanggal,sapi.tgllahir)/365 )))*12/100,2) as umurtahun_bulan
		,jumlahhari.jumlah as jumlahhari,con_koreksiumur.koreksi as koreksiumur
		,cON_koreksijhp.koreksi as koreksijhp
		FROM pengukuran_produksisusu pp
		JOIN sapi using(idsapi)
		JOIN register using(idsapi) 
		JOIN reproduksi_kelahiran rk ON (rk.idsapi=sapi.idsapi AND rk.xlaktasi=pp.xlaktasi)
		JOIN jumlahhari ON (jumlahhari.idbulan=MONTH(pp.tanggal) )
		JOIN con_koreksiumur ON con_koreksiumur.umur=(FLOOR(DATEDIFF(pp.tanggal,sapi.tgllahir)/365 )+ROUND(((DATEDIFF(pp.tanggal,sapi.tgllahir)/365)-(FLOOR(DATEDIFF(pp.tanggal,sapi.tgllahir)/365 )))*12/100,2))
		JOIN con_koreksijhp ON con_koreksijhp.jhp=DATEDIFF(pp.tanggal,rk.tanggal)
		WHERE 1 
		GROUP BY bulanke,pp.xlaktasi
		ORDER BY tglproduksi";
		$rs=$this->db->query($sql);
		$data["draw"]=0;
		$data["recordsTotal"]=$rs->num_rows();
		$data["recordsFiltered"]=$rs->num_rows();
		$data['data']=$rs->result();
		return json_encode($data);
	}
	function getSC()
	{
		$sql = "SELECT sapi.kelamin,
				(select kodepropinsi from farm where farm.idfarm=sapi.idfarm) as kodepropinsi,
				(select kodekabupaten from farm where farm.idfarm=sapi.idfarm) as kodekabupaten,
				(select kodekecamatan from farm where farm.idfarm=sapi.idfarm) as kodekecamatan,
				(select namafarm from farm where farm.idfarm=sapi.idfarm) as namafarm,
				(SELECT namapropinsi FROM wil_propinsi p LEFT JOIN farm f USING(kodepropinsi) WHERE f.idfarm=sapi.idfarm) as namapropinsi,
				(SELECT namakabupaten FROM wil_kabupaten k LEFT JOIN farm f USING(kodepropinsi,kodekabupaten) WHERE f.idfarm=sapi.idfarm) as namakabupaten,
				(SELECT namakecamatan FROM wil_kecamatan k LEFT JOIN farm f USING(kodepropinsi,kodekabupaten,kodekecamatan) WHERE f.idfarm=sapi.idfarm) as namakecamatan,
				r.nomorregister,sapi.tagsapi,
				reproduksi_kelahiran.idsapi,reproduksi_kelahiran.xlaktasi,reproduksi_kelahiran.tanggal as tglmelahirkan,
				
				IF((SELECT count(k.tanggal) FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
					AND k.xlaktasi<reproduksi_kelahiran.xlaktasi)>0,
				(SELECT ib.tanggal FROM reproduksi_ib ib 
					where ib.idsapi=reproduksi_kelahiran.idsapi 
					and ib.tanggal<reproduksi_kelahiran.tanggal 
					and ibke='1'
					and 
						(ib.tanggal > 
						(SELECT k.tanggal FROM reproduksi_kelahiran k 
							where k.idsapi=reproduksi_kelahiran.idsapi 
							and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
							ORDER BY tanggal DESC LIMIT 1))
					limit 1)
				,(SELECT ib.tanggal FROM reproduksi_ib ib 
				where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal 
				and ibke='1' LIMIT 1
				))
				as ib1,
				
				IF((SELECT count(k.tanggal) FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
					AND k.xlaktasi<reproduksi_kelahiran.xlaktasi)>0,
				(SELECT ib.tanggal FROM reproduksi_ib ib 
					where ib.idsapi=reproduksi_kelahiran.idsapi 
					and ib.tanggal<reproduksi_kelahiran.tanggal 
					and ibke='2'
					and 
						(ib.tanggal > 
						(SELECT k.tanggal FROM reproduksi_kelahiran k 
							where k.idsapi=reproduksi_kelahiran.idsapi 
							and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
							ORDER BY tanggal DESC LIMIT 1))
					limit 1)
				,(SELECT ib.tanggal FROM reproduksi_ib ib 
				where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal 
				and ibke='2' LIMIT 1
				))
				as ib2,

				IF((SELECT count(k.tanggal) FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
					AND k.xlaktasi<reproduksi_kelahiran.xlaktasi)>0,
				(SELECT ib.tanggal FROM reproduksi_ib ib 
					where ib.idsapi=reproduksi_kelahiran.idsapi 
					and ib.tanggal<reproduksi_kelahiran.tanggal 
					and ibke='3'
					and 
						(ib.tanggal > 
						(SELECT k.tanggal FROM reproduksi_kelahiran k 
							where k.idsapi=reproduksi_kelahiran.idsapi 
							and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
							ORDER BY tanggal DESC LIMIT 1))
					limit 1)
				,(SELECT ib.tanggal FROM reproduksi_ib ib 
				where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal 
				and ibke='3' LIMIT 1
				))
				as ib3,
				
				IF((SELECT count(k.tanggal) FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
					AND k.xlaktasi<reproduksi_kelahiran.xlaktasi)>0,
				(SELECT ib.tanggal FROM reproduksi_ib ib 
					where ib.idsapi=reproduksi_kelahiran.idsapi 
					and ib.tanggal<reproduksi_kelahiran.tanggal 
					and ibke='4'
					and 
						(ib.tanggal > 
						(SELECT k.tanggal FROM reproduksi_kelahiran k 
							where k.idsapi=reproduksi_kelahiran.idsapi 
							and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
							ORDER BY tanggal DESC LIMIT 1))
					limit 1)
				,(SELECT ib.tanggal FROM reproduksi_ib ib 
				where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal 
				and ibke='4' LIMIT 1
				))
				as ib4,

				IF((SELECT count(k.tanggal) FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
					AND k.xlaktasi<reproduksi_kelahiran.xlaktasi)>0,
				(SELECT ib.tanggal FROM reproduksi_ib ib 
					where ib.idsapi=reproduksi_kelahiran.idsapi 
					and ib.tanggal<reproduksi_kelahiran.tanggal 
					and ibke='5'
					and 
						(ib.tanggal > 
						(SELECT k.tanggal FROM reproduksi_kelahiran k 
							where k.idsapi=reproduksi_kelahiran.idsapi 
							and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
							ORDER BY tanggal DESC LIMIT 1))
					limit 1)
				,(SELECT ib.tanggal FROM reproduksi_ib ib 
				where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal 
				and ibke='5' LIMIT 1
				))
				as ib5,

				IF((SELECT count(k.tanggal) FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
					AND k.xlaktasi<reproduksi_kelahiran.xlaktasi)>0,
				(SELECT ib.tanggal FROM reproduksi_ib ib 
					where ib.idsapi=reproduksi_kelahiran.idsapi 
					and ib.tanggal<reproduksi_kelahiran.tanggal 
					and ibke='6'
					and 
						(ib.tanggal > 
						(SELECT k.tanggal FROM reproduksi_kelahiran k 
							where k.idsapi=reproduksi_kelahiran.idsapi 
							and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
							ORDER BY tanggal DESC LIMIT 1))
					limit 1)
				,(SELECT ib.tanggal FROM reproduksi_ib ib 
				where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal 
				and ibke='6' LIMIT 1
				))
				as ib6,

				IF((SELECT count(k.tanggal) FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
					AND k.xlaktasi<reproduksi_kelahiran.xlaktasi)>0,
				(SELECT ib.tanggal FROM reproduksi_ib ib 
					where ib.idsapi=reproduksi_kelahiran.idsapi 
					and ib.tanggal<reproduksi_kelahiran.tanggal 
					and ibke='7'
					and 
						(ib.tanggal > 
						(SELECT k.tanggal FROM reproduksi_kelahiran k 
							where k.idsapi=reproduksi_kelahiran.idsapi 
							and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
							ORDER BY tanggal DESC LIMIT 1))
					limit 1)
				,(SELECT ib.tanggal FROM reproduksi_ib ib 
				where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal 
				and ibke='7' LIMIT 1
				))
				as ib7,

				IF((SELECT count(k.tanggal) FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
					AND k.xlaktasi<reproduksi_kelahiran.xlaktasi)>0,
				(SELECT ib.tanggal FROM reproduksi_ib ib 
					where ib.idsapi=reproduksi_kelahiran.idsapi 
					and ib.tanggal<reproduksi_kelahiran.tanggal 
					and ibke='8'
					and 
						(ib.tanggal > 
						(SELECT k.tanggal FROM reproduksi_kelahiran k 
							where k.idsapi=reproduksi_kelahiran.idsapi 
							and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
							ORDER BY tanggal DESC LIMIT 1))
					limit 1)
				,(SELECT ib.tanggal FROM reproduksi_ib ib 
				where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal 
				and ibke='8' LIMIT 1
				))
				as ib8,

				IF((SELECT count(k.tanggal) FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
					AND k.xlaktasi<reproduksi_kelahiran.xlaktasi)>0,
				(SELECT max(tanggal) FROM reproduksi_ib ib where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal and ib.tanggal >
				(SELECT k.tanggal FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 ORDER BY tanggal DESC LIMIT 1) 
				and is_bunting='1' )
				,(SELECT max(tanggal) FROM reproduksi_ib ib where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal 
				and is_bunting='1' ))
				 as IBBUNTING,

				 IF((SELECT count(k.tanggal) FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
				 AND k.xlaktasi<reproduksi_kelahiran.xlaktasi)>0,
			 	(SELECT max(ibke) FROM reproduksi_ib ib where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal and ib.tanggal >
				(SELECT k.tanggal FROM reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 ORDER BY tanggal DESC LIMIT 1))
				,(SELECT max(ibke) FROM reproduksi_ib ib where ib.idsapi=reproduksi_kelahiran.idsapi 
				and ib.tanggal<reproduksi_kelahiran.tanggal)) 
				as sc
				FROM reproduksi_kelahiran 
				JOIN sapi ON sapi.idsapi=reproduksi_kelahiran.idsapi
				JOIN farm ON farm.idfarm=sapi.idfarm
				LEFT JOIN register r ON r.idsapi=sapi.idsapi WHERE sapi.kelamin='Betina'";

			$kodepropinsi  = $this->session->userdata('kodepropinsi');
			$kodekabupaten = $this->session->userdata('kodekabupaten');
			$kodekecamatan = $this->session->userdata('kodekecamatan');
			$idfarm = $this->session->userdata('idfarm');
			$tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
			$bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
			$tanggal = $this->session->userdata('tanggal');
			// $xlaktasi = $this->session->userdata('xlaktasi');

			if(($kodepropinsi!="")&&($kodepropinsi!="0")) $sql .=" AND kodepropinsi='$kodepropinsi'";
			if(($kodekabupaten!="")&&($kodekabupaten!="0")) $sql .=" AND kodekabupaten='$kodekabupaten'";
			if(($kodekecamatan!="")&&($kodekecamatan!="0")) $sql .=" AND kodekecamatan='$kodekecamatan'";
			if(($idfarm!="")&&($idfarm!="0")) $sql .=" AND farm.idfarm='$idfarm'";
			if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(tanggal)',$tahun);
			if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(tanggal)',$bulan);
			if(($tanggal!=""))  $this->datatables->where('tanggal',$tanggal);

			$rs=$this->db->query($sql);
			$data["draw"]=0;
			$data["recordsTotal"]=$rs->num_rows();
			$data["recordsFiltered"]=$rs->num_rows();
			$data['data']=$rs->result();
			return json_encode($data);
	}
	
	function getCI()
	{
		$sql = "SELECT * FROM (SELECT reproduksi_kelahiran.idsapi,register.nomorregister,sapi.tagsapi,
				max(reproduksi_kelahiran.xlaktasi) as xlaktasi
				,max(reproduksi_kelahiran.tanggal) as tglmelahirkan,
				(SELECT tanggal from reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=max(reproduksi_kelahiran.xlaktasi)-1 limit 1) as tglmelahirkansebelumnya, 
				DATEDIFF(max(reproduksi_kelahiran.tanggal),(SELECT max(tanggal) from reproduksi_kelahiran k 
				WHERE k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=max(reproduksi_kelahiran.xlaktasi)-1 limit 1)) as selisihhari
				from reproduksi_kelahiran 
				JOIN sapi USING(idsapi)
				JOIN register USING(idsapi)
				JOIN farm ON farm.idfarm=sapi.idfarm
				WHERE 1 ";
				$kodepropinsi  = $this->session->userdata('kodepropinsi');
				$kodekabupaten = $this->session->userdata('kodekabupaten');
				$kodekecamatan = $this->session->userdata('kodekecamatan');
				$idfarm = $this->session->userdata('idfarm');
				$tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
				$bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
				$tanggal = $this->session->userdata('tanggal');
				// $xlaktasi = $this->session->userdata('xlaktasi');

				if(($kodepropinsi!="")&&($kodepropinsi!="0")) $sql .=" AND kodepropinsi='$kodepropinsi'";
				if(($kodekabupaten!="")&&($kodekabupaten!="0")) $sql .=" AND kodekabupaten='$kodekabupaten'";
				if(($kodekecamatan!="")&&($kodekecamatan!="0")) $sql .=" AND kodekecamatan='$kodekecamatan'";
				if(($idfarm!="")&&($idfarm!="0")) $sql .=" AND farm.idfarm='$idfarm'";
				if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(tanggal)',$tahun);
				if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(tanggal)',$bulan);
				if(($tanggal!=""))  $this->datatables->where('tanggal',$tanggal);
				
		
				//$sql .= " $filtersapi AND status='$status' ";
				$sql .= " GROUP BY nomorregister) tabel WHERE NOT ISNULL(tglmelahirkansebelumnya)";
	
		$rs=$this->db->query($sql);
		$data["draw"]=0;
		$data["recordsTotal"]=$rs->num_rows();
		$data["recordsFiltered"]=$rs->num_rows();
		$data['data']=$rs->result();
		return json_encode($data);       
	}
	
	
	function getnDataCI($data)
	{
		$sql = "SELECT reproduksi_kelahiran.idsapi,register.nomorregister,sapi.tagsapi,
				max(reproduksi_kelahiran.xlaktasi) as xlaktasi
				,max(reproduksi_kelahiran.tanggal) as tglmelahirkan,
				(SELECT tanggal from reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=max(reproduksi_kelahiran.xlaktasi)-1 limit 1) as tglmelahirkansebelumnya, 
				DATEDIFF(max(reproduksi_kelahiran.tanggal),(SELECT max(tanggal) from reproduksi_kelahiran k 
				WHERE k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=max(reproduksi_kelahiran.xlaktasi)-1 limit 1)) as selisihhari
				from reproduksi_kelahiran 
				left join sapi USING(idsapi)
				left join register USING(idsapi)
				left join farm ON farm.idfarm=sapi.idfarm
				WHERE ! ISNULL(nomorregister)";
				if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
				if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
				if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
				if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				if($data['tagsapi']!='0') $sql .= " AND sapi.tagsapi='$data[tagsapi]'";
		
				//$sql .= " $filtersapi AND status='$status' ";
				$sql .= " GROUP BY nomorregister";
			$sql="SELECT count(*) n FROM ($sql) tabel";
			$rs=$this->db->query($sql);
			$row=$rs->row();
			return $row->n;

	}

	function getnDataCITerhitung($data)
	{
		$sql = "SELECT reproduksi_kelahiran.idsapi,register.nomorregister,sapi.tagsapi,
				max(reproduksi_kelahiran.xlaktasi) as xlaktasi
				,max(reproduksi_kelahiran.tanggal) as tglmelahirkan,
				(SELECT tanggal from reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=max(reproduksi_kelahiran.xlaktasi)-1 limit 1) as tglmelahirkansebelumnya, 
				DATEDIFF(max(reproduksi_kelahiran.tanggal),(SELECT max(tanggal) from reproduksi_kelahiran k 
				WHERE k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=max(reproduksi_kelahiran.xlaktasi)-1 limit 1)) as selisihhari
				from reproduksi_kelahiran 
				left join sapi USING(idsapi)
				left join register USING(idsapi)
				left join farm ON farm.idfarm=sapi.idfarm
				WHERE ! ISNULL(nomorregister)";
				if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
				if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
				if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
				if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				if($data['tagsapi']!='0') $sql .= " AND sapi.tagsapi='$data[tagsapi]'";
		
				//$sql .= " $filtersapi AND status='$status' ";
				$sql .= " GROUP BY nomorregister";
			$sql="SELECT count(*) n FROM ($sql) tabel WHERE !ISNULL(selisihhari)";
			$rs=$this->db->query($sql);
			$row=$rs->row();
			return $row->n;
	}

	function getnDataCITakTerhitung($data)
	{
		$sql = "SELECT reproduksi_kelahiran.idsapi,register.nomorregister,sapi.tagsapi,
				max(reproduksi_kelahiran.xlaktasi) as xlaktasi
				,max(reproduksi_kelahiran.tanggal) as tglmelahirkan,
				(SELECT tanggal from reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=max(reproduksi_kelahiran.xlaktasi)-1 limit 1) as tglmelahirkansebelumnya, 
				DATEDIFF(max(reproduksi_kelahiran.tanggal),(SELECT max(tanggal) from reproduksi_kelahiran k 
				WHERE k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=max(reproduksi_kelahiran.xlaktasi)-1 limit 1)) as selisihhari
				from reproduksi_kelahiran 
				left join sapi USING(idsapi)
				left join register USING(idsapi)
				left join farm ON farm.idfarm=sapi.idfarm
				WHERE ! ISNULL(nomorregister)";
				if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
				if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
				if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
				if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				if($data['tagsapi']!='0') $sql .= " AND sapi.tagsapi='$data[tagsapi]'";
		
				//$sql .= " $filtersapi AND status='$status' ";
				$sql .= " GROUP BY nomorregister";
			$sql="SELECT count(*) n FROM ($sql) tabel WHERE ISNULL(selisihhari)";
			$rs=$this->db->query($sql);
			$row=$rs->row();
			return $row->n;
	}

	function getRerataCI($data)
	{
		$sql = "SELECT reproduksi_kelahiran.idsapi,register.nomorregister,sapi.tagsapi,
				max(reproduksi_kelahiran.xlaktasi) as xlaktasi
				,max(reproduksi_kelahiran.tanggal) as tglmelahirkan,
				(SELECT tanggal from reproduksi_kelahiran k where k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=max(reproduksi_kelahiran.xlaktasi)-1 limit 1) as tglmelahirkansebelumnya, 
				DATEDIFF(max(reproduksi_kelahiran.tanggal),(SELECT max(tanggal) from reproduksi_kelahiran k 
				WHERE k.idsapi=reproduksi_kelahiran.idsapi 
				and k.xlaktasi=max(reproduksi_kelahiran.xlaktasi)-1 limit 1)) as selisihhari
				from reproduksi_kelahiran 
				left join sapi USING(idsapi)
				left join register USING(idsapi)
				left join farm ON farm.idfarm=sapi.idfarm
				WHERE ! ISNULL(nomorregister)";
				if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
				if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
				if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
				if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				if($data['tagsapi']!='0') $sql .= " AND sapi.tagsapi='$data[tagsapi]'";
		
				//$sql .= " $filtersapi AND status='$status' ";
				$sql .= " GROUP BY nomorregister";
			$sql="SELECT avg(selisihhari) n FROM ($sql) tabel"; 
			$rs=$this->db->query($sql);
			$row=$rs->row();
			return $row->n;
	}

	function getDO()
	{
		$sql = "SELECT * FROM (SELECT register.nomorregister,sapi.tagsapi,
				reproduksi_kelahiran.xlaktasi,
				date_format(reproduksi_kelahiran.tanggal,'%d-%m-%Y') as tglmelahirkan ,
				(select date_format(p.tanggal,'%d-%m-%Y') from reproduksi_ib p 
				WHERE p.idsapi=reproduksi_kelahiran.idsapi and p.tanggal>reproduksi_kelahiran.tanggal
				and p.idib IN (SELECT idib FROM reproduksi_kelahiran) ORDER BY p.tanggal limit 1) as tgl_ib,
				DATEDIFF((select tanggal from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal and p.idib IN (SELECT idib FROM reproduksi_kelahiran) 
				ORDER BY tanggal limit 1),reproduksi_kelahiran.tanggal ) as selisihhari
				 from reproduksi_kelahiran
				JOIN sapi USING(idsapi)
				JOIN register USING(idsapi)
				JOIN farm ON farm.idfarm=sapi.idfarm
				where 1 ";
				$kodepropinsi  = $this->session->userdata('kodepropinsi');
				$kodekabupaten = $this->session->userdata('kodekabupaten');
				$kodekecamatan = $this->session->userdata('kodekecamatan');
				$idfarm = $this->session->userdata('idfarm');
				$tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
				$bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
				$tanggal = $this->session->userdata('tanggal');
				// $xlaktasi = $this->session->userdata('xlaktasi');
	
				if(($kodepropinsi!="")&&($kodepropinsi!="0")) $sql .=" AND kodepropinsi='$kodepropinsi'";
				if(($kodekabupaten!="")&&($kodekabupaten!="0")) $sql .=" AND kodekabupaten='$kodekabupaten'";
				if(($kodekecamatan!="")&&($kodekecamatan!="0")) $sql .=" AND kodekecamatan='$kodekecamatan'";
				if(($idfarm!="")&&($idfarm!="0")) $sql .=" AND farm.idfarm='$idfarm'";
				if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(tanggal)',$tahun);
				if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(tanggal)',$bulan);
				if(($tanggal!=""))  $this->datatables->where('tanggal',$tanggal);
				
				 
				//$sql .= " HAVING selisihhari>0";
		 
			$sql .= " ORDER BY selisihhari DESC) tabel WHERE NOT ISNULL(selisihhari) ";
			$rs=$this->db->query($sql);
			$data["draw"]=0;
			$data["recordsTotal"]=$rs->num_rows();
			$data["recordsFiltered"]=$rs->num_rows();
			$data['data']=$rs->result();
			return json_encode($data);     
	}
	
	function getRata2DO($data)
	{
		$sql = "select register.nomorregister,sapi.tagsapi,
				reproduksi_kelahiran.xlaktasi,
				date_format(reproduksi_kelahiran.tanggal,'%d-%m-%Y') as tglmelahirkan ,
				(select date_format(p.tanggal,'%d-%m-%Y') from reproduksi_ib p 
				WHERE p.idsapi=reproduksi_kelahiran.idsapi and p.tanggal>reproduksi_kelahiran.tanggal
				and is_bunting='1' ORDER BY p.tanggal limit 1) as tgl_ib,
				DATEDIFF((select tanggal from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal and is_bunting='1' ORDER BY tanggal limit 1),reproduksi_kelahiran.tanggal ) as selisihhari
				 from reproduksi_kelahiran
				left join sapi USING(idsapi)
				left join register USING(idsapi)
				left join farm ON farm.idfarm=sapi.idfarm
				where sapi.tagsapi<>'' ";
				//$sql .= "$filtersapi ";
				if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
				if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
				if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
				if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				if($data['tagsapi']!='0') $sql .= " AND sapi.tagsapi='$data[tagsapi]'";
				if($data['xlaktasi']!='-1') 
					$sql .= " AND reproduksi_kelahiran.xlaktasi='$data[xlaktasi]'";
				//else
				//	$sql .= " AND reproduksi_kelahiran.xlaktasi=(SELECT max(xlaktasi) FROM reproduksi_kelahiran k WHERE k.idsapi=sapi.idsapi)";
				
				//$sql .= " HAVING selisihhari>0";
			$sql1="SELECT avg(selisihhari) rata FROM ($sql) tabel";
			$rs=$this->db->query($sql1);          
			
			$row=$rs->row();
			return $row->rata;
	}
	
	function getCountDO($data)
	{
		$sql = "select register.nomorregister,sapi.tagsapi,
				reproduksi_kelahiran.xlaktasi,
				date_format(reproduksi_kelahiran.tanggal,'%d-%m-%Y') as tglmelahirkan ,
				(select date_format(p.tanggal,'%d-%m-%Y') from reproduksi_ib p 
				WHERE p.idsapi=reproduksi_kelahiran.idsapi and p.tanggal>reproduksi_kelahiran.tanggal
				and is_bunting='1' ORDER BY p.tanggal limit 1) as tgl_ib,
				DATEDIFF((select tanggal from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal and is_bunting='1' ORDER BY tanggal limit 1),reproduksi_kelahiran.tanggal ) as selisihhari
				 from reproduksi_kelahiran
				left join sapi USING(idsapi)
				left join register USING(idsapi)
				left join farm ON farm.idfarm=sapi.idfarm
				where sapi.tagsapi<>'' ";
				//$sql .= "$filtersapi ";
				if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
				if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
				if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
				if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				if($data['tagsapi']!='0') $sql .= " AND sapi.tagsapi='$data[tagsapi]'";
				if($data['xlaktasi']!='-1') 
					$sql .= " AND reproduksi_kelahiran.xlaktasi='$data[xlaktasi]'";
				//else
				//	$sql .= " AND reproduksi_kelahiran.xlaktasi=(SELECT max(xlaktasi) FROM reproduksi_kelahiran k WHERE k.idsapi=sapi.idsapi)";
			$sql1="SELECT count(selisihhari) n FROM ($sql) tabel ";
			$rs=$this->db->query($sql1);          
			
			$row=$rs->row();
			return $row->n;
	}
	
	function getFIPP()
	{
		$sql="select reproduksi_kelahiran.idsapi,register.nomorregister,
				sapi.tagsapi,
				reproduksi_kelahiran.xlaktasi as xlaktasi,
				date_format(reproduksi_kelahiran.tanggal,'%d-%m-%Y') as tglmelahirkan,
				date_format((select min(p.tanggal) from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal ),'%d-%m-%Y') as tglIB1PP,
				datediff((select min(p.tanggal) from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal ),reproduksi_kelahiran.tanggal) IB1PP,
				farm.idfarm,
				farm.kodekecamatan,
				farm.kodekabupaten,
				farm.kodepropinsi
				from reproduksi_kelahiran 
				left join sapi USING(idsapi)
				left join register USING(idsapi)
				LEFT JOIN farm ON farm.idfarm=sapi.idfarm
				WHERE 1 AND sapi.status='hidup' ";
				$kodepropinsi  = $this->session->userdata('kodepropinsi');
				$kodekabupaten = $this->session->userdata('kodekabupaten');
				$kodekecamatan = $this->session->userdata('kodekecamatan');
				$idfarm = $this->session->userdata('idfarm');
				$tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
				$bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
				$tanggal = $this->session->userdata('tanggal');
				// $xlaktasi = $this->session->userdata('xlaktasi');
	
				if(($kodepropinsi!="")&&($kodepropinsi!="0")) $sql .=" AND kodepropinsi='$kodepropinsi'";
				if(($kodekabupaten!="")&&($kodekabupaten!="0")) $sql .=" AND kodekabupaten='$kodekabupaten'";
				if(($kodekecamatan!="")&&($kodekecamatan!="0")) $sql .=" AND kodekecamatan='$kodekecamatan'";
				if(($idfarm!="")&&($idfarm!="0")) $sql .=" AND farm.idfarm='$idfarm'";
				if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(tanggal)',$tahun);
				if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(tanggal)',$bulan);
				if(($tanggal!=""))  $this->datatables->where('tanggal',$tanggal);
				
			$sql .= " ORDER BY IB1PP desc";
			$rs=$this->db->query($sql);
			$data["draw"]=0;
			$data["recordsTotal"]=$rs->num_rows();
			$data["recordsFiltered"]=$rs->num_rows();
			$data['data']=$rs->result();
			return json_encode($data);            
	}

	function getCountFIPP($data)
	{
		$sql="select reproduksi_kelahiran.idsapi,register.nomorregister,
				sapi.tagsapi,
				reproduksi_kelahiran.xlaktasi as xlaktasi,
				date_format(reproduksi_kelahiran.tanggal,'%d-%m-%Y') as tglmelahirkan,
				date_format((select min(p.tanggal) from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal ),'%d-%m-%Y') as tglIB1PP,
				datediff((select min(p.tanggal) from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal ),reproduksi_kelahiran.tanggal) IB1PP,
				farm.idfarm,
				farm.kodekecamatan,
				farm.kodekabupaten,
				farm.kodepropinsi
				from reproduksi_kelahiran 
				left join sapi USING(idsapi)
				left join register USING(idsapi)
				LEFT JOIN farm ON farm.idfarm=sapi.idfarm
				WHERE 1 AND sapi.status='hidup' ";
				if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
				if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
				if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
				if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				if($data['tagsapi']!='0') $sql .= " AND tagsapi='$data[tagsapi]'";
				// if(!empty($tahun))$sql.=" AND year(tglmelahirkan)='$tahun'";
				//  if($xlaktasi>0) $sql.=" AND xlaktasi=$xlaktasi";
		 
			$sql="SELECT count(*) n FROM ($sql) tabel";
			$row=$this->db->query($sql)->row();
			return $row->n;          
	}
	function getAVGFIPP($data)
	{
		$sql="select reproduksi_kelahiran.idsapi,register.nomorregister,
				sapi.tagsapi,
				reproduksi_kelahiran.xlaktasi as xlaktasi,
				date_format(reproduksi_kelahiran.tanggal,'%d-%m-%Y') as tglmelahirkan,
				date_format((select min(p.tanggal) from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal ),'%d-%m-%Y') as tglIB1PP,
				datediff((select min(p.tanggal) from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal ),reproduksi_kelahiran.tanggal) IB1PP,
				farm.idfarm,
				farm.kodekecamatan,
				farm.kodekabupaten,
				farm.kodepropinsi
				from reproduksi_kelahiran 
				left join sapi USING(idsapi)
				left join register USING(idsapi)
				LEFT JOIN farm ON farm.idfarm=sapi.idfarm
				WHERE 1 AND sapi.status='hidup' ";
				if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
				if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
				if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
				if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				if($data['tagsapi']!='0') $sql .= " AND tagsapi='$data[tagsapi]'";
				// if(!empty($tahun))$sql.=" AND year(tglmelahirkan)='$tahun'";
				//  if($xlaktasi>0) $sql.=" AND xlaktasi=$xlaktasi";
		 
			$sql="SELECT avg(IB1PP) n FROM ($sql) tabel";
			$row=$this->db->query($sql)->row();
			return $row->n;          
	}
	function getCountedFIPP($data)
	{
		$sql="select reproduksi_kelahiran.idsapi,register.nomorregister,
				sapi.tagsapi,
				reproduksi_kelahiran.xlaktasi as xlaktasi,
				date_format(reproduksi_kelahiran.tanggal,'%d-%m-%Y') as tglmelahirkan,
				date_format((select min(p.tanggal) from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal ),'%d-%m-%Y') as tglIB1PP,
				datediff((select min(p.tanggal) from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal ),reproduksi_kelahiran.tanggal) IB1PP,
				farm.idfarm,
				farm.kodekecamatan,
				farm.kodekabupaten,
				farm.kodepropinsi
				from reproduksi_kelahiran 
				left join sapi USING(idsapi)
				left join register USING(idsapi)
				LEFT JOIN farm ON farm.idfarm=sapi.idfarm
				WHERE 1 AND sapi.status='hidup' ";
				if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
				if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
				if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
				if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				if($data['tagsapi']!='0') $sql .= " AND tagsapi='$data[tagsapi]'";
				// if(!empty($tahun))$sql.=" AND year(tglmelahirkan)='$tahun'";
				//  if($xlaktasi>0) $sql.=" AND xlaktasi=$xlaktasi";
		 
			$sql="SELECT count(*) n FROM ($sql) tabel WHERE !ISNULL(IB1PP)";
			$row=$this->db->query($sql)->row();
			return $row->n;          
	}
	function getUnCountedFIPP($data)
	{
		$sql="select reproduksi_kelahiran.idsapi,register.nomorregister,
				sapi.tagsapi,
				reproduksi_kelahiran.xlaktasi as xlaktasi,
				date_format(reproduksi_kelahiran.tanggal,'%d-%m-%Y') as tglmelahirkan,
				date_format((select min(p.tanggal) from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal ),'%d-%m-%Y') as tglIB1PP,
				datediff((select min(p.tanggal) from reproduksi_ib p where p.idsapi=reproduksi_kelahiran.idsapi 
				and p.tanggal>reproduksi_kelahiran.tanggal ),reproduksi_kelahiran.tanggal) IB1PP,
				farm.idfarm,
				farm.kodekecamatan,
				farm.kodekabupaten,
				farm.kodepropinsi
				from reproduksi_kelahiran 
				left join sapi USING(idsapi)
				left join register USING(idsapi)
				LEFT JOIN farm ON farm.idfarm=sapi.idfarm
				WHERE 1 AND sapi.status='hidup' ";
				if($data['kodepropinsi']!='0') $sql .= " AND kodepropinsi='$data[kodepropinsi]'";
				if($data['kodekabupaten']!='0') $sql .= " AND kodekabupaten='$data[kodekabupaten]'";
				if($data['kodekecamatan']!='0') $sql .= " AND kodekecamatan='$data[kodekecamatan]'";
				if($data['idfarm']!='0') $sql .= " AND sapi.idfarm='$data[idfarm]'";
				if($data['tagsapi']!='0') $sql .= " AND tagsapi='$data[tagsapi]'";
				// if(!empty($tahun))$sql.=" AND year(tglmelahirkan)='$tahun'";
				//  if($xlaktasi>0) $sql.=" AND xlaktasi=$xlaktasi";
		 
			$sql="SELECT count(*) n FROM ($sql) tabel WHERE ISNULL(IB1PP)";
			$row=$this->db->query($sql)->row();
			return $row->n;          
	}
	 
}
