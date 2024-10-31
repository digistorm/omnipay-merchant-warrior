<?php

declare(strict_types=1);

namespace League\MerchantWarrior\Test;

use Omnipay\MerchantWarrior\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public $options;

    /** @var Gateway */
    protected $gateway;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = ['amount' => '10.00', 'card' => $this->getValidCard()];
    }

    public function testAuthorize(): void
    {
        $this->markTestSkipped('Authorize is not implemented in the MerchantWarrior driver currently.');

        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $response = $this->gateway->authorize($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('1234', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }
}
