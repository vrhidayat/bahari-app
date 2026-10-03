<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WasteScanController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,bmp', 'max:10240'],
        ]);

        try {
            $response = Http::connectTimeout(10)
                ->timeout(60)
                ->attach(
                    'file',
                    $validated['file']->getContent(),
                    $validated['file']->getClientOriginalName(),
                    ['Content-Type' => $validated['file']->getMimeType()],
                )
                ->post(rtrim(config('services.wastewise.url'), '/').'/predict');
        } catch (ConnectionException $exception) {
            report($exception);

            return response()->json([
                'message' => 'Layanan scan sedang tidak dapat dihubungi. Coba lagi nanti.',
            ], 503);
        }

        $data = $response->json();

        return response()->json(
            is_array($data) ? $data : ['message' => 'Layanan scan mengembalikan respons yang tidak valid.'],
            $response->status(),
        );
    }
}
