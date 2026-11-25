<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/Ib_import.php';

class Keswan_import extends Ib_import
{
    public function read($file, $extension, $columnCount = 5, $dateColumns = array(1), $timeColumns = array())
    {
        return parent::read($file, $extension, $columnCount, $dateColumns, $timeColumns);
    }

    public function parse($rows)
    {
        $records = array();
        $errors = array();
        foreach ($rows as $index => $row) {
            $row = array_map(function ($value) {
                return trim(str_replace(array("\xEF\xBB\xBF", "\xC2\xA0"), array('', ' '), (string) $value));
            }, $row);
            if (trim(implode('', $row)) === '') { continue; }
            if (in_array(strtolower($row[0]), array('tanggal', 'tgl', 'date'), true)) { continue; }
            if (count($row) !== 5) {
                $errors[] = 'Baris ' . ($index + 1) . ': harus berisi lima kolom TANGGAL, EARTAG, DIAGNOSA, PENGGUNAAN OBAT, PETUGAS.';
                continue;
            }
            $date = $this->date($row[0]);
            if (!$date || $row[1] === '' || mb_strlen($row[1], 'UTF-8') > 100 ||
                $row[2] === '' || mb_strlen($row[2], 'UTF-8') > 100 ||
                strlen($row[3]) > 65535 || $row[4] === '' || mb_strlen($row[4], 'UTF-8') > 50) {
                $errors[] = 'Baris ' . ($index + 1) . ': periksa tanggal, eartag (maks. 100 karakter), diagnosa (wajib, maks. 100), obat (maks. 65535 byte), dan petugas (wajib, maks. 50 karakter).';
                continue;
            }
            $records[] = array('line' => $index + 1, 'tanggal' => $date, 'tagsapi' => $row[1],
                'diagnosa' => $row[2], 'pengobatan' => $row[3], 'petugas' => $row[4]);
        }
        if (!$records && !$errors) { $errors[] = 'Tidak ada data pemeriksaan dalam file.'; }
        return array('records' => $records, 'errors' => $errors);
    }
}
