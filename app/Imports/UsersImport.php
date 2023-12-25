<?php

namespace App\Imports;

use App\Models\User;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;
use Hash;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        dd($row);
        if (empty($row[0])) {
            return null;
        }
        
            
        $contactNo = str_replace('+', '', $row[2]);
        $contactNo = str_replace(' ', '', $contactNo);
        $contactNo2 = str_replace('+', '', $row[3]);
        $contactNo2 = str_replace(' ', '', $contactNo2);

        $email = str_replace(' ', '.', strtolower($row[0])).'@thesupervan.co.uk';
            $userData = [
            'name'         =>  $row[0],
            'email'        =>  $email,
            'password'        => Hash::make($email),
            //'owner_name'       =>  $row[1],
            'shop_name'         =>  $row[7],
            'contact_no'  =>  $contactNo2,
            'phone'  =>  $contactNo,
            'address'     =>  $row[4],
            //'town'     =>  $row[6],
            'city'     =>  $row[5],
            'postal_code'     =>  $row[6],
            'notes'     =>  $row[1],
            'type' => 'shopkeeper'
        ];

        $user = User::updateOrCreate(
            ['phone' => $contactNo, 'email' => $email],
            $userData
        );
        
        return $user;
        
        return null;
    }
}
