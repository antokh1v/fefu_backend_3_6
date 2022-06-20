<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class FilterSchema extends SchemaFactory implements Reusable
{
    /**
     * @return SchemaContract
     */
    public function build(): SchemaContract
    {
        return Schema::object('Filter')
            ->properties(
                Schema::string('key'),
                Schema::string('name'),
                Schema::integer('type'),
                Schema::array('options')->items(Schema::object()->properties(
                    Schema::string('value'),
                    Schema::boolean('isSelected'),
                    Schema::integer('productCount')
                )),
            );
    }
}
