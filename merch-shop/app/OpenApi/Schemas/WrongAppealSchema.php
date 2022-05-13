<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class WrongAppealSchema extends SchemaFactory implements Reusable
{
    /**
     * @return SchemaContract
     */

    public function build(): SchemaContract
    {
        return Schema::object('WrongAppeal')
            ->properties(
                Schema::object('errors')->properties(
                    Schema::array('name')->nullable()->items(Schema::string('description')),
                    Schema::array('phone')->nullable()->items(Schema::string('description')),
                    Schema::array('email')->nullable()->items(Schema::string('description')),
                    Schema::array('message')->nullable()->items(Schema::string('description')),
                )
            );
    }
}
