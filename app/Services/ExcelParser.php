<?php

namespace App\Services;

use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use App\Models\ServerInfo;

class ExcelParser implements ExcelParserInterface
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
                if ($this->isMatchingRam($rowData[1]) && $this->isMatchingStorage($rowData[2]) && $this->isMatchingDiskType($rowData[2]) && $this->isMatchingLocation($rowData[3]))
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

    private function isMatchingRam(string $ram): bool
    {
        if (!array_key_exists('ram', $this->filters) || is_null($this->filters['ram'])) return true;
        $ramValue = explode(self::GB, $ram);

        return in_array($ramValue[0], $this->filters['ram']);
    }

    private function isMatchingStorage(string $storage): bool
    {
        if ((!array_key_exists('storageFrom', $this->filters) || is_null($this->filters['storageFrom'])) &&
            (!array_key_exists('storageTo', $this->filters) || is_null($this->filters['storageTo']))
        ) {
            return true;
        }

        $storage = $this->parseStorageValue($storage);

        return $storage >= $this->storageInGB($this->filters['storageFrom']) && $storage <= $this->storageInGB($this->filters['storageTo']);
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

    private function storageInGB(string $value): int
    {
        if (strpos($value, self::TB)) {
            $value  = str_replace(self::TB, '', $value) * 1024;
        } else if (strpos($value, self::GB)) {
            $value  = str_replace(self::GB, '', $value);
        }

        return $value;
    }

    private function isMatchingDiskType(string $hdd): bool
    {
        return !array_key_exists('harddiskType', $this->filters) || is_null($this->filters['harddiskType']) || (strpos($hdd, $this->filters['harddiskType']) !== false);
    }

    private function isMatchingLocation(string $location): bool
    {
        return !array_key_exists('location', $this->filters) || is_null($this->filters['location']) || ($location == $this->filters['location']);
    }
}
