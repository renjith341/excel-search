<?php

namespace App\Services;

use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use App\Models\ServerInfo;

class ExcelParser
{
    final public const GB = 'GB';
    final public const TB = 'TB';

    private $filters = [];

    /*
    * @throws UnsupportedTypeException
    * @throws IOException
    * @throws ReaderNotOpenedException
    */
    public function searchData(array $filters, string $dataSource): array
    {
        $this->filters = $filters;
        $serverList = [];
        $reader = ReaderEntityFactory::createReaderFromFile($dataSource);
        $reader->open($dataSource);
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $key => $row) {
                if ($key == 1) {
                    continue;
                }
                $rowData = $row->toArray();
                if ($this->hasRam($rowData[1]) && $this->hasStorage($rowData[2]) && $this->hasHarddidkType($rowData[2]) && $this->hasLocation($rowData[3]))
                    $serverList[] = (new ServerInfo)->setModel($rowData[0])
                        ->setRam($rowData[1])
                        ->setStorage($rowData[2])
                        ->setLocation($rowData[3])
                        ->setPrice($rowData[4]);
            }
        }
        $reader->close();

        return $serverList;
    }

    private function hasRam(string|array $ram): bool
    {
        if ($this->filters['ram'] == '') return true;
        $ramValue = explode(self::GB, $ram);

        return in_array($ramValue[0], $this->filters['ram']);
    }

    private function hasStorage(string $storage): bool
    {
        if ($this->filters['storage'] == '') return true;
        $storage = $this->parseStorageValue($storage);
        $filter = $this->getStorageRange($this->filters['storage']);

        return $storage >= $filter[0] && $storage <= $filter[1];
    }

    private function parseStorageValue(string $storage): int
    {
        $storageChunk = explode(self::GB, $storage);
        if (count($storageChunk) > 1) {
            $hdd = explode('x', $storageChunk[0]);
            $storageSize = $hdd[0] * $hdd[1];
        } else {
            $storageChunk = explode(self::TB, $storage);
            $hdd = explode('x', $storageChunk[0]);
            $storageSize = $hdd[0] * $hdd[1] * 1024;
        }

        return $storageSize;
    }

    private function getStorageRange(string $storageRange): array
    {
        $range = explode(' - ', $storageRange);
        $range[0] = $this->storageInGB($range[0]);
        $range[1] = $this->storageInGB($range[1]);

        return $range;
    }

    private function storageInGB(string $value): int
    {
        if (strpos($value, self::TB)) {
            $value  = str_replace(' ' . self::TB, '', $value) * 1024;
        } else if (strpos($value, self::GB)) {
            $value  = str_replace(' ' . self::GB, '', $value);
        }

        return $value;
    }

    private function hasHarddidkType(string $hdd): bool
    {
        if ($this->filters['harddiskType'] == '') return true;

        return strpos($hdd, $this->filters['harddiskType']) !== false;
    }

    private function hasLocation(string $location): bool
    {
        if ($this->filters['location'] == '') return true;
    }
}
