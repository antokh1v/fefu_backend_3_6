<?php

namespace App\OpenApi\Responses\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class UnauthenticatedResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::unauthorized()->description('Failed response')->content(
            MediaType::json()->schema(
                Schema::object()->properties(
                    Schema::string('message')->default('Unauthorized')
                )
            )
        );
    }
}
