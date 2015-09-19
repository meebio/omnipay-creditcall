<?php

namespace Omnipay\Creditcall\Test\Message;

use Omnipay\Creditcall\Message\AuthorizeRequest;

class AuthorizeCardReferenceRequestTest extends AuthorizeRequestTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array_merge($this->getOptions(), array(
            'card'          => null,
            'cardReference' => 'a4f483ca-55fc-e311-8ca6-001422187e37',
            'cardHash'      => 'qo3tCvArxWUxsCONcIWGyHUhXKs=',
        )));
    }

    public function testTransactionData()
    {
        $data = $this->request->getData();

        $this->assertSame('123', (string)$data->TransactionDetails->Reference);
        $this->assertSame('12.00', (string)$data->TransactionDetails->Amount);
        $this->assertSame('major', (string)$data->TransactionDetails->Amount->attributes()->unit);
        $this->assertSame('826', (string)$data->TransactionDetails->CurrencyCode);

        $this->assertNull($this->request->getCard());

        $manual = $data->CardDetails->Manual;
        $this->assertSame('cnp', (string)$manual->attributes()->type);
        $this->assertSame('a4f483ca-55fc-e311-8ca6-001422187e37', (string)$manual->CardReference);
        $this->assertSame('qo3tCvArxWUxsCONcIWGyHUhXKs=', (string)$manual->CardHash);
        $this->assertSame('826', (string)$data->TransactionDetails->CurrencyCode);
    }

    public function testGetDataCustomerDetails()
    {
        //
    }
}
