<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/Ib_import.php';

class Pkb_import extends Ib_import
{
    public function parse($rows)
    {
        $records = array();
        $errors = array();
        $started = false;
        foreach ($rows as $index => $row) {
            $row = array_map(function ($value) {
                return trim(str_replace(array("\xEF\xBB\xBF", "\xC2\xA0"), array('', ' '), (string) $value));
            }, $row);
            if (trim(implode('', $row)) === '') { continue; }
            if (!$started && !preg_match('/^[0-9]+$/', $row[0])) { continue; }
            $started = true;
            $row = array_pad($row, 12, '');
            $tanggal = $this->date($row[2]);
            $tanggalIb = $this->date($row[3]);
            $hpl = $row[10] === '' ? null : $this->date($row[10]);
            $hasilText = strtolower(preg_replace('/\s+/', '', $row[8]));
            $hasil = null;
            if (in_array($hasilText, array('positif', 'positive', 'p', '+', 'pkb(+)', 'pkb(+)positif'), true)) {
                $hasil = 'P';
            } elseif (in_array($hasilText, array('negatif', 'negative', 'n', '-', 'pkb(-)'), true)) {
                $hasil = 'N';
            } elseif (in_array($hasilText, array('dubius', 'ragu', 'ragu-ragu'), true)) {
                $hasil = 'Dubius';
            }
            if (!preg_match('/^[0-9]+$/', $row[0]) || $row[1] === '' ||
                $tanggal === false || $tanggalIb === false || $tanggalIb > $tanggal ||
                !ctype_digit($row[4]) || (int) $row[4] < 1 || (int) $row[4] > 127 ||
                $row[6] === '' || mb_strlen($row[6], 'UTF-8') > 20 ||
                $row[7] === '' || mb_strlen($row[7], 'UTF-8') > 50 ||
                $hasil === null || $row[9] === '' || mb_strlen($row[9], 'UTF-8') > 30 ||
                mb_strlen($row[11], 'UTF-8') > 30 || $hpl === false ||
                ($hpl !== null && ($hasil !== 'P' || $hpl <= $tanggal))) {
                $errors[] = 'Baris ' . ($index + 1) . ': periksa EAR TAG, tanggal PKB/IB, IB Ke, kode straw, petugas, hasil PKB, HPL, atau keterangan (maksimal 30 karakter).';
                continue;
            }
            $records[] = array('line' => $index + 1, 'tagsapi' => $row[1], 'tanggal' => $tanggal,
                'tanggal_ib' => $tanggalIb, 'ibke' => (int) $row[4], 'namastraw' => $row[5],
                'kodesemen' => $row[6], 'petugas_ib' => $row[7], 'hasil' => $hasil,
                'petugas' => $row[9], 'hpl' => $hpl, 'keterangan' => $row[11]);
        }
        if (!$started) { $errors[] = 'Tidak ada data. Pastikan urutan 12 kolom sesuai contoh dan No. diisi angka.'; }
        return array('records' => $records, 'errors' => $errors);
    }
}
