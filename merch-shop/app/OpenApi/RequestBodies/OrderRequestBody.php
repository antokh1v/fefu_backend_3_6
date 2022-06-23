<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class OrderRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()
            ->description('Order creation')
            ->content(MediaType::json()->schema(
                Schema::object()->properties(
                    Schema::object('delivery_address')->nullable()->properties(
                        Schema::string('city'),
                        Schema::string('street'),
                        Schema::string('house'),
                        Schema::integer('apartment')->nullable(),
                    )
                )
            ));
    }
}
