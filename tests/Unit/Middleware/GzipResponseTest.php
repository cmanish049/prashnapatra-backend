<?php

use App\Http\Middleware\GzipResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

beforeEach(function (): void {
    $this->middleware = new GzipResponse;
});

test('it does not compress non-json responses', function (): void {
    $request = Request::create('/test', 'GET');
    $request->headers->set('Accept-Encoding', 'gzip');

    $htmlContent = str_repeat('<p>Hello World</p>', 100);
    $htmlResponse = new Response($htmlContent, 200, ['Content-Type' => 'text/html']);

    $response = $this->middleware->handle($request, fn (): \Illuminate\Http\Response => $htmlResponse);

    expect($response->headers->has('Content-Encoding'))->toBeFalse()
        ->and($response->getContent())->toBe($htmlContent);
});

test('it does not compress response that already has content-encoding', function (): void {
    $request = Request::create('/test', 'GET');
    $request->headers->set('Accept-Encoding', 'gzip');

    $data = ['data' => array_fill(0, 100, ['id' => 1, 'name' => 'Test University'])];
    $jsonResponse = new JsonResponse($data);
    $jsonResponse->headers->set('Content-Encoding', 'br');

    $response = $this->middleware->handle($request, fn (): \Illuminate\Http\JsonResponse => $jsonResponse);

    expect($response->headers->get('Content-Encoding'))->toBe('br');
});

test('it compresses json response when all conditions are met', function (): void {
    $request = Request::create('/test', 'GET');
    $request->headers->set('Accept-Encoding', 'gzip');

    $data = ['data' => array_fill(0, 100, ['id' => 1, 'name' => 'Test University'])];
    $jsonResponse = new JsonResponse($data);

    $response = $this->middleware->handle($request, fn (): \Illuminate\Http\JsonResponse => $jsonResponse);

    expect($response->headers->get('Content-Encoding'))->toBe('gzip')
        ->and($response->headers->get('Vary'))->toBe('Accept-Encoding');
});

test('it handles response with false content gracefully', function (): void {
    $request = Request::create('/test', 'GET');
    $request->headers->set('Accept-Encoding', 'gzip');

    $jsonResponse = new JsonResponse(['data' => []]);

    $response = $this->middleware->handle($request, fn (): \Illuminate\Http\JsonResponse => $jsonResponse);

    expect($response->headers->has('Content-Encoding'))->toBeFalse();
});
