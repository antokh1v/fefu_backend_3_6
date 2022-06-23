<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class OrderSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Order')
            ->properties(
                Schema::string('customer_name'),
                Schema::string('customer_email'),
                Schema::string('payment_method'),
                Schema::string('delivery_type'),
                CartSchema::ref(),
                Schema::object('address')->nullable()->properties(
                    Schema::string('city'),
                    Schema::string('street'),
                    Schema::string('house'),
                    Schema::string('apartment')->nullable(),
                ),
            );
    }
}
