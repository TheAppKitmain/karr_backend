<?php

namespace App\Imports;

use App\Models\Driver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class DriversImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
    public function model(array $row)
    {
        $userId = Auth::user()->id;
        return new Driver([
            'name' => $row['name'],
            'number' => $row['number'],
            'license' => $row['license'],
            'password' => bcrypt($row['password']),
            'email' => $row['email'],
            'user_id' =>$userId,
        ]);
    }

}
