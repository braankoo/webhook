<?php

namespace BrankoDragovic\Webhook\Tests\Unit;

use BrankoDragovic\Webhook\HttpService;
use BrankoDragovic\Webhook\Tests\TestCase;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

class HttpServiceTest extends TestCase
{
    public function testSendRequest(): void
    {
        $mockClient = $this->createMock(\GuzzleHttp\ClientInterface::class);
        $mockResponse = new Response(200, [], 'fake response');
        $mockClient->method('request')->willReturn($mockResponse);

        $httpService = new HttpService($mockClient);

        $url = 'https://test.com/api';
        $method = 'POST';
        $data = ['foo' => 'bar'];
        $result = $httpService->sendRequest($url, $method, $data);

        $this->assertEquals('fake response', $result);
    }

}
