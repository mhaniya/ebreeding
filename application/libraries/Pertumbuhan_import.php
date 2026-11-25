<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/Ib_import.php';

class Pertumbuhan_import extends Ib_import
{
    public function read($file, $extension, $columnCount = 9, $dateColumns = array(1), $timeColumns = array())
    {
        return parent::read($file, $extension, $columnCount, $dateColumns, $timeColumns);
    }

    private function number($value)
    {
        if ($value === '') { return null; }
        // Decimal comma is accepted; thousands separators are intentionally not inferred.
        if (!preg_match('/^\d+(?:[.,]\d{1,2})?$/D', $value)) { return false; }
        $number = (float) str_replace(',', '.', $value);
        return $number <= 999.99 ? $number : false;
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
            $first = strtolower(preg_replace('/\s+/', '', $row[0]));
            if (in_array($first, array('tanggal', 'tgl', 'date'), true)) { continue; }
            if (count($row) !== 9) {
                $errors[] = 'Baris ' . ($index + 1) . ': harus berisi 9 kolom sesuai urutan, tanpa No. Register, kolom #/nomor urut atau aksi.';
                continue;
            }
            $date = $this->date($row[0]);
            if (!$date || $row[1] === '' || mb_strlen($row[1], 'UTF-8') > 50) {
                $errors[] = 'Baris ' . ($index + 1) . ': tanggal atau No. Tag tidak valid.';
                continue;
            }
            $data = array('line' => $index + 1, 'tanggal' => $date,
                'tagsapi' => $row[1]);
            $valid = true;
            foreach (array(3 => 'bobotkg', 4 => 'lingkar_dada', 6 => 'panjang_badan',
                7 => 'tinggi_gumba', 8 => 'lingkar_skrotum') as $column => $field) {
                $value = $this->number($row[$column]);
                if ($value === false || ($value === null && in_array($column, array(3, 4), true))) {
                    $errors[] = 'Baris ' . ($index + 1) . ': kolom ' . ($column + 1) . ' harus angka 0–999,99, maksimal dua desimal; BB dan LD wajib diisi.';
                    $valid = false;
                    break;
                }
                $data[$field] = $value;
            }
            // Age and predicted weight are derived by the page, not authoritative input.
            if ($valid) { $records[] = $data; }
        }
        if (!$records && !$errors) { $errors[] = 'Tidak ada data pengukuran dalam file.'; }
        return array('records' => $records, 'errors' => $errors);
    }
}
