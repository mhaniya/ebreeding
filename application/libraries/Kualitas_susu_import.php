<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/Ib_import.php';
class Kualitas_susu_import extends Ib_import
{
    public function read($file, $extension, $columnCount = 9, $dateColumns = array(1), $timeColumns = array())
    {
        return parent::read($file, $extension, $columnCount, $dateColumns, $timeColumns);
    }
    public function parse($rows)
    {
        $records = array(); $errors = array();
        $fields = array('kadarlemak', 'kadarair', 'kadarbk', 'protein', 'bahankeringtanpalemak', 'beratjenis', 'laktosa');
        foreach ($rows as $index => $row) {
            $row = array_map(function ($v) { return trim(str_replace(array("\xEF\xBB\xBF", "\xC2\xA0"), array('', ' '), (string) $v)); }, $row);
            if (trim(implode('', $row)) === '' || in_array(strtolower($row[0]), array('tanggal', 'tgl', 'date'), true)) { continue; }
            if (count($row) !== 9) { $errors[] = 'Baris ' . ($index + 1) . ': wajib sembilan kolom tanpa No. Register atau nomor urut.'; continue; }
            $date = $this->date($row[0]);
            if (!$date || $row[1] === '' || mb_strlen($row[1], 'UTF-8') > 100) { $errors[] = 'Baris ' . ($index + 1) . ': tanggal atau No. Tag tidak valid.'; continue; }
            $record = array('line' => $index + 1, 'tanggal' => $date, 'tagsapi' => $row[1]);
            $valid = true; $filled = false;
            foreach ($fields as $i => $field) {
                $value = str_replace(',', '.', $row[$i + 2]);
                if ($value === '') { $record[$field] = null; continue; }
                if (!preg_match('/^\d+(?:\.\d+)?$/D', $value) || !is_finite((float) $value) || (float) $value > 999999999.99) {
                    $errors[] = 'Baris ' . ($index + 1) . ': kolom ' . ($i + 3) . ' harus angka nonnegatif tanpa pemisah ribuan.'; $valid = false; break;
                }
                $record[$field] = round((float) $value, 2); $filled = true;
            }
            if ($valid && !$filled) { $errors[] = 'Baris ' . ($index + 1) . ': minimal satu nilai kualitas susu harus diisi.'; }
            elseif ($valid) { $records[] = $record; }
        }
        if (!$records && !$errors) { $errors[] = 'Tidak ada data kualitas susu dalam file.'; }
        return array('records' => $records, 'errors' => $errors);
    }
}
