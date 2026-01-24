<?php

use App\Models\University;

test('it compresses response when client accepts gzip', function (): void {
    University::factory()->count(50)->create();

    $response = $this->withApiKey()
        ->withHeader('Accept-Encoding', 'gzip, deflate')
        ->get(route('api.v1.universities.index'));

    $response->assertSuccessful()
        ->assertHeader('Content-Encoding', 'gzip')
        ->assertHeader('Vary', 'Accept-Encoding');
});

test('it does not compress when client does not accept gzip', function (): void {
    University::factory()->count(50)->create();

    $response = $this->withApiKey()
        ->get(route('api.v1.universities.index'));

    $response->assertSuccessful();
    expect($response->headers->has('Content-Encoding'))->toBeFalse();
});

test('it does not compress small responses below 1kb threshold', function (): void {
    $response = $this->withApiKey()
        ->withHeader('Accept-Encoding', 'gzip, deflate')
        ->get(route('api.v1.universities.index'));

    $response->assertSuccessful();
    expect($response->headers->has('Content-Encoding'))->toBeFalse();
});

test('compressed content can be decompressed to valid json', function (): void {
    University::factory()->count(50)->create();

    $response = $this->withApiKey()
        ->withHeader('Accept-Encoding', 'gzip')
        ->get(route('api.v1.universities.index'));

    $response->assertSuccessful();

    $compressed = $response->getContent();
    $decompressed = gzdecode($compressed);

    expect($decompressed)->not->toBeFalse();

    $json = json_decode($decompressed, true);

    expect($json)->toBeArray()
        ->and($json)->toHaveKey('data')
        ->and($json['data'])->toHaveCount(50);
});

test('it removes content-length header when compressing', function (): void {
    University::factory()->count(50)->create();

    $response = $this->withApiKey()
        ->withHeader('Accept-Encoding', 'gzip')
        ->get(route('api.v1.universities.index'));

    $response->assertSuccessful()
        ->assertHeader('Content-Encoding', 'gzip')
        ->assertHeaderMissing('Content-Length');
});

test('it only compresses when gzip is in accept-encoding', function (): void {
    University::factory()->count(50)->create();

    $response = $this->withApiKey()
        ->withHeader('Accept-Encoding', 'deflate, br')
        ->get(route('api.v1.universities.index'));

    $response->assertSuccessful();
    expect($response->headers->has('Content-Encoding'))->toBeFalse();
});

test('compressed response is smaller than original', function (): void {
    University::factory()->count(50)->create();

    $uncompressedResponse = $this->withApiKey()
        ->get(route('api.v1.universities.index'));

    $compressedResponse = $this->withApiKey()
        ->withHeader('Accept-Encoding', 'gzip')
        ->get(route('api.v1.universities.index'));

    $originalSize = strlen($uncompressedResponse->getContent());
    $compressedSize = strlen($compressedResponse->getContent());

    expect($compressedSize)->toBeLessThan($originalSize);
});
