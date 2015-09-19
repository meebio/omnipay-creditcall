<?php

namespace Omnipay\Creditcall\Test\Message;

use Omnipay\Creditcall\Message\AuthorizeResponse;
use Omnipay\Tests\TestCase;

class ResponseTest extends TestCase
{
    public function testAuthorizeSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('AuthorizeSuccess.txt');
        $response = new AuthorizeResponse($this->getMockRequest(), $httpResponse->xml());

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertSame('6f3b812a-dafa-e311-983c-00505692354f', $response->getTransactionReference());
        $this->assertSame('a4f483ca-55fc-e311-8ca6-001422187e37', $response->getCardReference());
        $this->assertSame('qo3tCvArxWUxsCONcIWGyHUhXKs=', $response->getCardHash());

        $this->assertFalse($response->isCvvNotMatched());
        $this->assertFalse($response->isAddressNotMatched());
        $this->assertFalse($response->isZipNotMatched());
    }

    public function testAuthorizeFailure()
    {
        $httpResponse = $this->getMockHttpResponse('AuthorizeFailure.txt');
        $response = new AuthorizeResponse($this->getMockRequest(), $httpResponse->xml());

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('CvvNotMatched', $response->getMessage());

        $this->assertTrue($response->isCvvNotMatched());
        $this->assertFalse($response->isAddressNotMatched());
        $this->assertFalse($response->isZipNotMatched());
    }
}
