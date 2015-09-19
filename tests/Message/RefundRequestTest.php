<?php

namespace Omnipay\Creditcall\Test\Message;

use Omnipay\Creditcall\Message\RefundRequest;
use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    /**
     * @var RefundRequest
     */
    protected $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'amount'               => '12.00',
            'transactionReference' => '6f3b812a-dafa-e311-983c-00505692354f',
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('6f3b812a-dafa-e311-983c-00505692354f', (string)$data->TransactionDetails->CardEaseReference);
        $this->assertSame('12.00', (string)$data->TransactionDetails->Amount);
        $this->assertSame('major', (string)$data->TransactionDetails->Amount->attributes()->unit);
    }
}
