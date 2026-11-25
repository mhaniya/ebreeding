<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/Keswan_import.php';
class Pemeriksaan_reproduksi_import extends Keswan_import
{
    public function read($file, $extension, $columnCount = 6, $dateColumns = array(1), $timeColumns = array())
    {
        return parent::read($file, $extension, $columnCount, $dateColumns, $timeColumns);
    }
    public function parse($rows)
    {
        $input = array(); $notes = array(); $errors = array();
        foreach ($rows as $index => $row) {
            $first = trim(str_replace("\xEF\xBB\xBF", '', isset($row[0]) ? (string) $row[0] : ''));
            if (trim(implode('', $row)) === '' || in_array(strtolower($first), array('tanggal','tgl','date'), true)) { continue; }
            if (count($row) !== 6 || strlen((string) $row[5]) > 65535) {
                $errors[] = 'Baris ' . ($index + 1) . ': wajib enam kolom Tanggal, No. Tag, Diagnosa, Pengobatan, Petugas, Keterangan; keterangan maksimal 65535 byte.';
                continue;
            }
            $input[$index] = array_slice($row, 0, 5);
            $notes[$index + 1] = trim((string) $row[5]);
        }
        if (!$input) { return array('records'=>array(), 'errors'=>$errors ?: array('Tidak ada data pemeriksaan reproduksi dalam file.')); }
        $parsed = parent::parse($input);
        foreach ($parsed['records'] as &$record) { $record['keterangan'] = $notes[$record['line']]; } unset($record);
        $parsed['errors'] = array_merge($errors, $parsed['errors']);
        return $parsed;
    }
}
