<?php

use App\Models\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

test('authenticated users can scan a valid image through the WasteWise API', function () {
    Http::fake([
        'https://wastewise-pied-three.vercel.app/predict' => Http::response([
            'prediction' => [
                'class' => 'plastic',
                'confidence' => 0.9919,
                'status' => 'accepted',
            ],
            'recommendation' => [
                'summary' => 'Pisahkan plastik untuk didaur ulang.',
                'steps' => ['Kosongkan isi botol.'],
                'warnings' => ['Periksa aturan fasilitas setempat.'],
            ],
        ]),
    ]);

    $user = User::factory()->create(['email_verified_at' => now()]);

    $response = $this->actingAs($user)->postJson(route('waste-scan.predict'), [
        'file' => UploadedFile::fake()->image('bottle.jpg'),
    ]);

    $response->assertOk()
        ->assertJsonPath('prediction.class', 'plastic')
        ->assertJsonPath('recommendation.summary', 'Pisahkan plastik untuk didaur ulang.');

    Http::assertSent(fn (ClientRequest $request): bool => $request->method() === 'POST'
        && $request->url() === 'https://wastewise-pied-three.vercel.app/predict'
        && str_contains($request->body(), 'filename="bottle.jpg"')
    );
});

test('guests cannot use the waste scan endpoint', function () {
    $this->post(route('waste-scan.predict'))
        ->assertRedirect(route('login'));
});

test('unsupported image formats are rejected before forwarding', function () {
    Http::fake();

    $user = User::factory()->create(['email_verified_at' => now()]);

    $this->actingAs($user)
        ->postJson(route('waste-scan.predict'), [
            'file' => UploadedFile::fake()->create('animation.gif', 20, 'image/gif'),
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('file');

    Http::assertNothingSent();
});
