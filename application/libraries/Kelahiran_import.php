<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/Ib_import.php';

class Kelahiran_import extends Ib_import
{
    public function parse($rows)
    {
        $records = array();
        $errors = array();
        $started = false;
        foreach ($rows as $index => $row) {
            $row = array_map(function ($value) {
                return trim(str_replace(array("\xEF\xBB\xBF", "\xC2\xA0"), array('', ' '),
                    html_entity_decode((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
            }, $row);
            if (trim(implode('', $row)) === '') { continue; }
            if (!$started && !preg_match('/^[0-9]+$/', $row[0])) { continue; }
            $started = true;
            $row = array_pad($row, 16, '');
            $tanggal = $this->date($row[2]);
            $tanggalIb = $this->date($row[4]);
            $jam = $this->time($row[10]);
            $sex = ucfirst(strtolower($row[11]));
            $dead = in_array(strtolower(preg_replace('/\s+/', ' ', $row[8])), array('lahir mati', 'mati', 'stillbirth'), true);
            $tag = $dead ? '' : $row[8];
            $numbers = array();
            foreach (array(9, 12, 13, 14, 15) as $column) {
                $value = str_replace(',', '.', $row[$column]);
                $numbers[] = $value === '' ? null :
                    (is_numeric($value) && is_finite((float) $value) && $value >= 0 && $value <= 999.99 ? (float) $value : false);
            }
            if (!preg_match('/^[0-9]+$/', $row[0]) || $row[1] === '' || mb_strlen($row[1], 'UTF-8') > 100 ||
                $tanggal === false || $tanggalIb === false || $tanggalIb >= $tanggal ||
                !ctype_digit($row[3]) || (int) $row[3] < 1 || (int) $row[3] > 127 ||
                !ctype_digit($row[5]) || (int) $row[5] < 1 || (int) $row[5] > 127 ||
                $row[6] === '' || mb_strlen($row[6], 'UTF-8') > 100 ||
                $row[7] === '' || mb_strlen($row[7], 'UTF-8') > 20 ||
                mb_strlen($tag, 'UTF-8') > 30 || $tag === $row[1] ||
                $jam === false || !in_array($sex, array('Jantan', 'Betina'), true) ||
                in_array(false, $numbers, true)) {
                $errors[] = 'Baris ' . ($index + 1) . ': periksa tag induk/pedet, tanggal, laktasi, IB Ke, pejantan, jam, jenis kelamin, atau angka ukuran tubuh.';
                continue;
            }
            $records[] = array('line' => $index + 1, 'tagsapi' => $row[1], 'tanggal' => $tanggal,
                'xlaktasi' => (int) $row[3], 'tanggal_ib' => $tanggalIb, 'ibke' => (int) $row[5],
                'namabull' => $row[6], 'kodestraw' => $row[7], 'tagpedet' => $tag,
                'statuspedet' => $dead ? 'mati' : 'hidup', 'bobotlahirpedet' => $numbers[0],
                'jam_lahir' => $jam, 'jkelpedet' => $sex, 'panjang_badan' => $numbers[1],
                'lingkar_dada' => $numbers[2], 'tinggi_gumba' => $numbers[3], 'lingkar_skrotum' => $numbers[4]);
        }
        if (!$started) { $errors[] = 'Tidak ada data. Pastikan urutan 16 kolom sesuai contoh dan No. diisi angka.'; }
        return array('records' => $records, 'errors' => $errors);
    }

    public function time($value)
    {
        if ($value === '') { return null; }
        if (!preg_match('/^([0-9]{1,2})[.,:]([0-9]{2})(?::([0-9]{2}))?$/', $value, $match) ||
            (int) $match[1] > 23 || (int) $match[2] > 59 ||
            (isset($match[3]) && (int) $match[3] > 59)) { return false; }
        return sprintf('%02d:%02d:%02d', $match[1], $match[2], isset($match[3]) ? $match[3] : 0);
    }
}
