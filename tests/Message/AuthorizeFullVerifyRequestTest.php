<?php

namespace Omnipay\Creditcall\Test\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Creditcall\Message\AuthorizeRequest;

class AuthorizeFullVerifyRequestTest extends AuthorizeRequestTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array_merge($this->getOptions(), array(
            'verifyCvv'     => true,
            'verifyAddress' => true,
            'verifyZip'     => true,
        )));

        $card = $this->request->getCard();
        $card->setIssueNumber('12345');
        $card->setStartMonth('01');
        $card->setStartYear('2015');
    }

    public function testAdditionalVerification()
    {
        /** @var CreditCard $card */
        $card = $this->request->getCard();
        $data = $this->request->getData();

        $this->assertSame((string)$card->getCvv(), (string)$data->CardDetails->AdditionalVerification->CSC);
        $this->assertSame((string)$card->getAddress1(), (string)$data->CardDetails->AdditionalVerification->Address);
        $this->assertSame((string)$card->getPostcode(), (string)$data->CardDetails->AdditionalVerification->Zip);

        $manual = $data->CardDetails->Manual;
        $this->assertSame((string)$card->getStartDate('ym'), (string)$manual->StartDate);
        $this->assertSame((string)$card->getIssueNumber(), (string)$manual->IssueNumber);
    }
}
