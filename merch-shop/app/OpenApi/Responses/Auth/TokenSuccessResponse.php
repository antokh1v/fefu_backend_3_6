<?php

namespace App\OpenApi\Responses\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class TokenSuccessResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(
                Schema::object()->properties(
                    Schema::string('token')
                )
            )
        );
    }
}
