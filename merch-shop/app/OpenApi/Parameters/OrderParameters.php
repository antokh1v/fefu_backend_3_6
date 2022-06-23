<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class OrderParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('customer_email')
                ->required()
                ->schema(Schema::string()),
            Parameter::query()
                ->name('customer_name')
                ->required()
                ->schema(Schema::string()),
            Parameter::query()
                ->name('delivery_type')
                ->required()
                ->schema(Schema::string()->default('courier')),
            Parameter::query()
                ->name('payment_method')
                ->required()
                ->schema(Schema::string()->default('cash')),
        ];
    }
}
