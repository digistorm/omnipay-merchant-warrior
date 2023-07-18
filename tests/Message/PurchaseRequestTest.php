<?php

namespace League\MerchantWarrior\Test\Message;

use Omnipay\Common\CreditCard;
use Omnipay\MerchantWarrior\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            [
                'amount' => '10.00',
                'currency' => 'USD',
                'card' => $this->getValidCard(),
            ]
        );
    }

    public function testGetData()
    {
        $card = new CreditCard($this->getValidCard());
        $card->setStartMonth(1);
        $card->setStartYear(2000);

        $this->request->setCard($card);
        $this->request->setTransactionProduct('abc123');

        $data = $this->request->getData();

        $this->assertSame('abc123', $data['transactionProduct']);

        $this->assertSame($card->getExpiryDate('my'), $data['paymentCardExpiry']);
    }

    public function testSendData()
    {
        $data = [
            'method' => 'processCard',
            'merchantUUID' => null,
            'apiKey' => null,
            'transactionAmount' => '10.00',
            'transactionCurrency' => 'USD',
            'transactionProduct' => 'abc123',
            'storeID' => null,
            'custom1' => null,
            'custom2' => null,
            'custom3' => null,
            'hash' => '0f9d4640d2b5f9627b7dbc1f20daab20',
            'customerName' => 'Example User',
            'customerCountry' => 'US',
            'customerState' => 'CA',
            'customerCity' => 'Billstown',
            'customerAddress' => '123 Billing St',
            'customerPostCode' => '12345',
            'customerEmail' => null,
            'customerPhone' => '(555) 123-4567',
            'paymentCardNumber' => '4111111111111111',
            'paymentCardExpiry' => '0128',
            'paymentCardName' => 'Example User',
            'paymentCardCSC' => 742,
        ];

        $this->setMockHttpResponse('ProcessCardSuccess.txt');

        $response = $this->request->sendData($data);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('1336-20be3569-b600-11e6-b9c3-005056b209e0', $response->getTransactionId());
        $this->assertSame('Transaction approved', $response->getMessage());
    }
}
