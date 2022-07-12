<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductRawImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
        foreach ($rows as $row){
            /*
            $rawPrd = new \stdClass();
            $rawPrd->id = $row[0];
            $rawPrd->id = $row[0];
            */

            print_r($row);
        }
    }
}
