<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ResultImport implements ToCollection
{
    public $result = [];

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // Convert each row (which is a Collection) to an array
            $this->result[] = $row->toArray();
        }
    }

    public function getResult()
    {
        return $this->result;
    }
}
