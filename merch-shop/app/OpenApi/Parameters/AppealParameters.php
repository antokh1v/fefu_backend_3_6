<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class AppealParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [

            Parameter::query()
                ->name('name')
                ->required()
                ->schema(Schema::string()->maxLength(100)),
            Parameter::query()
                ->name('phone')
                ->required(false)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('email')
                ->required(false)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('message')
                ->required()
                ->schema(Schema::string()->maxLength(1000)),
        ];
    }
}
