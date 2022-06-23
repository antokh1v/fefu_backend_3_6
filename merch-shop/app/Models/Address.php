<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Address extends Model
{
    use HasFactory;

    public static function createFromRequest(array $data): self
    {
        $address = new self();
        $address->city = $data['city'] ?? null;
        $address->street = $data['street'] ?? null;
        $address->house = $data['house'] ?? null;
        $address->apartment = $data['apartment'] ?? null;
        $address->save();
        return $address;
    }
}
