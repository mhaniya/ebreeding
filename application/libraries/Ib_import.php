<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ib_import
{
    public function read($file, $extension, $columnCount = 9, $dateColumns = array(3), $timeColumns = array())
    {
        if ($extension === 'csv') {
            $handle = fopen($file, 'r');
            if (!$handle) { throw new RuntimeException('File tidak dapat dibaca.'); }
            try {
                $line = fgets($handle);
                if ($line === false) { return array(); }
                $delimiter = ',';
                foreach (array(';', "\t") as $candidate) {
                    if (count(str_getcsv($line, $candidate)) > count(str_getcsv($line, $delimiter))) {
                        $delimiter = $candidate;
                    }
                }
                rewind($handle);
                $rows = array();
                while (($row = fgetcsv($handle, 0, $delimiter)) !== false) { $rows[] = $row; }
                return $rows;
            } finally { fclose($handle); }
        }
        if ($extension === 'xlsx') { return $this->read_xlsx($file, $columnCount, $dateColumns, $timeColumns); }
        if ($extension === 'xls') {
            $ci = get_instance();
            $ci->load->library('excel_reader');
            $reader = $ci->excel_reader;
            $reader->setOutputEncoding('UTF-8');
            $reader->read($file);
            if (empty($reader->sheets[0])) { throw new RuntimeException('Sheet pertama tidak dapat dibaca.'); }
            $sheet = $reader->sheets[0];
            $rows = array();
            for ($i = 1; $i <= $sheet['numRows']; $i++) {
                $row = array();
                for ($j = 1; $j <= $columnCount; $j++) {
                    $row[] = isset($sheet['cells'][$i][$j]) ? $sheet['cells'][$i][$j] : '';
                }
                foreach ($dateColumns as $dateColumn) {
                    if (isset($sheet['cellsInfo'][$i][$dateColumn]['type']) &&
                        $sheet['cellsInfo'][$i][$dateColumn]['type'] === 'date' &&
                        isset($sheet['cellsInfo'][$i][$dateColumn]['raw'])) {
                        $row[$dateColumn - 1] = date('Y-m-d', $sheet['cellsInfo'][$i][$dateColumn]['raw']);
                    }
                }
                foreach ($timeColumns as $timeColumn) {
                    if (isset($sheet['cellsInfo'][$i][$timeColumn]['raw']) &&
                        isset($sheet['cellsInfo'][$i][$timeColumn]['type']) &&
                        $sheet['cellsInfo'][$i][$timeColumn]['type'] === 'date') {
                        $raw = $sheet['cellsInfo'][$i][$timeColumn]['raw'];
                        if (is_numeric($raw) && $raw >= 0 && $raw < 1) {
                            $row[$timeColumn - 1] = gmdate('H:i', (int) round($raw * 86400));
                        }
                    }
                }
                $rows[] = $row;
            }
            return $rows;
        }
        throw new RuntimeException('Gunakan file .xlsx, .xls, atau .csv.');
    }

    private function xml($content)
    {
        if ($content === false || strlen($content) > 20971520 ||
            stripos($content, '<!DOCTYPE') !== false) {
            throw new RuntimeException('Isi Excel tidak valid atau terlalu besar.');
        }
        $previous = libxml_use_internal_errors(true);
        $xml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        if ($xml === false) { throw new RuntimeException('Isi Excel tidak dapat dibaca.'); }
        return $xml;
    }

    private function read_xlsx($file, $columnCount, $dateColumns, $timeColumns)
    {
        if (!class_exists('ZipArchive')) { throw new RuntimeException('Dukungan ZIP untuk XLSX belum tersedia.'); }
        $zip = new ZipArchive();
        if ($zip->open($file) !== true) { throw new RuntimeException('File XLSX tidak valid.'); }
        try {
            $workbook = $this->xml($zip->getFromName('xl/workbook.xml'));
            $sheets = $workbook->xpath('//*[local-name()="sheet"]');
            if (!$sheets) { throw new RuntimeException('Workbook tidak memiliki sheet.'); }
            $attributes = $sheets[0]->attributes('http://schemas.openxmlformats.org/officeDocument/2006/relationships');
            $relationId = (string) $attributes['id'];
            $relations = $this->xml($zip->getFromName('xl/_rels/workbook.xml.rels'));
            $target = '';
            foreach ($relations->xpath('//*[local-name()="Relationship"]') as $relation) {
                if ((string) $relation['Id'] === $relationId && (string) $relation['TargetMode'] !== 'External') {
                    $target = (string) $relation['Target'];
                }
            }
            if ($target === '' || strpos($target, '..') !== false) {
                throw new RuntimeException('Sheet pertama tidak valid.');
            }
            $path = $target[0] === '/' ? ltrim($target, '/') : 'xl/' . $target;
            $shared = array();
            $sharedContent = $zip->getFromName('xl/sharedStrings.xml');
            if ($sharedContent !== false) {
                foreach ($this->xml($sharedContent)->xpath('//*[local-name()="si"]') as $item) {
                    $text = '';
                    foreach ($item->xpath('.//*[local-name()="t"]') as $part) { $text .= (string) $part; }
                    $shared[] = $text;
                }
            }
            $date1904 = false;
            foreach ($workbook->xpath('//*[local-name()="workbookPr"]') as $properties) {
                $date1904 = in_array((string) $properties['date1904'], array('1', 'true'), true);
            }
            $rows = array();
            foreach ($this->xml($zip->getFromName($path))->xpath('//*[local-name()="sheetData"]/*[local-name()="row"]') as $xmlRow) {
                $number = (int) $xmlRow['r'];
                if ($number < 1 || $number > 100000) { throw new RuntimeException('Jumlah baris Excel terlalu besar.'); }
                $row = array_fill(0, $columnCount, '');
                foreach ($xmlRow->xpath('./*[local-name()="c"]') as $cell) {
                    preg_match('/^([A-Z]+)[0-9]+$/', (string) $cell['r'], $match);
                    if (!$match) { continue; }
                    $column = 0;
                    foreach (str_split($match[1]) as $letter) { $column = $column * 26 + ord($letter) - 64; }
                    if ($column > $columnCount) { continue; }
                    $values = $cell->xpath('./*[local-name()="v"]');
                    $value = $values ? (string) $values[0] : '';
                    if ((string) $cell['t'] === 's') {
                        $value = isset($shared[(int) $value]) ? $shared[(int) $value] : '';
                    } elseif ((string) $cell['t'] === 'inlineStr') {
                        $value = '';
                        foreach ($cell->xpath('.//*[local-name()="t"]') as $part) { $value .= (string) $part; }
                    } elseif (in_array($column, $dateColumns, true) && is_numeric($value)) {
                        $value = gmdate('Y-m-d', strtotime($date1904 ? '1904-01-01 UTC' : '1899-12-30 UTC') + floor((float) $value) * 86400);
                    } elseif (in_array($column, $timeColumns, true) && is_numeric($value) && $value >= 0 && $value < 1) {
                        $value = gmdate('H:i', (int) round($value * 86400));
                    }
                    $row[$column - 1] = $value;
                }
                $rows[$number - 1] = $row;
            }
            return $rows;
        } finally { $zip->close(); }
    }

    public function date($value)
    {
        $value = str_ireplace(array('-Agu-', '-Okt-', '-Mei-', '-Des-'),
            array('-Aug-', '-Oct-', '-May-', '-Dec-'), trim((string) $value));
        foreach (array('Y-m-d', 'd-M-y', 'd-M-Y', 'd/m/Y', 'd-m-Y', 'd/M/Y', 'j/M/Y') as $format) {
            $date = DateTime::createFromFormat('!' . $format, $value);
            if ($date && strcasecmp($date->format($format), $value) === 0) { return $date->format('Y-m-d'); }
        }
        return false;
    }

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
            $row = array_pad($row, 9, '');
            $date = $this->date($row[2]);
            if (!preg_match('/^[0-9]+$/', $row[0]) || $row[1] === '' || $date === false ||
                !ctype_digit($row[3]) || (int) $row[3] < 1 || (int) $row[3] > 127 ||
                $row[5] === '' || mb_strlen($row[5], 'UTF-8') > 20 ||
                $row[6] === '' || mb_strlen($row[6], 'UTF-8') > 50 ||
                mb_strlen($row[7], 'UTF-8') > 255 ||
                ($row[8] !== '' && (!ctype_digit($row[8]) || strlen($row[8]) > 9))) {
                $errors[] = 'Baris ' . ($index + 1) . ': periksa No., EAR TAG, tanggal, IB Ke, kode straw, petugas, atau intensitas birahi.';
                continue;
            }
            $records[] = array('line' => $index + 1, 'tagsapi' => $row[1], 'tanggal' => $date,
                'ibke' => (int) $row[3], 'namastraw' => $row[4], 'kodesemen' => $row[5],
                'petugas' => $row[6], 'keterangan' => $row[7],
                'intensitas_birahi' => $row[8] === '' ? null : (int) $row[8]);
        }
        if (!$started) { $errors[] = 'Tidak ada data. Pastikan urutan kolom sesuai contoh dan kolom No. diisi angka.'; }
        return array('records' => $records, 'errors' => $errors);
    }
}
