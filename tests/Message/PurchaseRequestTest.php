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
}
