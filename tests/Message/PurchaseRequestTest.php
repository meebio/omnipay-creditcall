<?php

namespace Omnipay\Creditcall\Test\Message;

use Omnipay\Creditcall\Message\PurchaseRequest;

class PurchaseRequestTest extends AuthorizeRequestTest
{
    /**
     * @var PurchaseRequest
     */
    protected $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getOptions());
    }

    public function testAutoconfirmProperty()
    {
        $data = $this->request->getData();

        $this->assertSame('true', (string)$data->TransactionDetails->MessageType->attributes()->autoconfirm);
    }
}
