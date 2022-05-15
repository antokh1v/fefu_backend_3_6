<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppealApiRequest;
use App\Models\Appeal;
use App\OpenApi\Parameters\AppealParameters;
use App\OpenApi\Responses\AppealFailedResponse;
use App\OpenApi\Responses\AppealSuccessResponse;
use App\Sanitizers\PhoneSanitizer;
use Cviebrock\EloquentSluggable\Tests\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class AppealApiController extends Controller
{
    /**
     * Send params to make appeal form.
     *
     * @param AppealApiRequest $request
     * @return JsonResponse
     */

    #[OpenApi\Operation(tags: ["appeal"])]
    #[OpenApi\Parameters(factory: AppealParameters::class)]
    #[OpenApi\Response(factory: AppealSuccessResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AppealFailedResponse::class, statusCode: 422)]
    public function send(AppealApiRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $appeal = new Appeal();
        $appeal->name = $data['name'];
        $appeal->phone = PhoneSanitizer::sanitize($data['phone'] ?? null);
        $appeal->email = $data['email'] ?? null;
        $appeal->message = $data['message'];
        $appeal->save();

        return response()->json([
            'message' => 'Appeal successfully sent'
        ]);

    }
}
