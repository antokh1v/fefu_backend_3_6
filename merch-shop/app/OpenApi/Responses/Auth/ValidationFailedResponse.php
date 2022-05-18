<?php

namespace App\OpenApi\Responses\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ValidationFailedResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::unprocessableEntity()->description('Failed response')->content(
            MediaType::json()->schema(
                Schema::object('errors')->properties(
                    Schema::array('')->nullable()->items(Schema::string()->default('The provided credentials are incorrect.')),
                    Schema::array('name')->nullable()->items(Schema::string()),
                    Schema::array('email')->nullable()->items(Schema::string()),
                    Schema::array('password')->nullable()->items(Schema::string())
                )
            )
        );
    }
}
