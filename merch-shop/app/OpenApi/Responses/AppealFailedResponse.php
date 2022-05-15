<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\WrongAppealSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class AppealFailedResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::unprocessableEntity()->description('Failed response')->content(
            MediaType::json()->schema(
                WrongAppealSchema::ref()
            )
        );

    }
}
