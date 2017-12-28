<?php
namespace App\Test;

use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{

    public function testProcessPaymentReturnsTrueOnSuccessfulPayment()
    {
        $paymentDetails = array(
            'amount'   => 123.99,
            'card_num' => '4111-1111-1111-1111',
            'exp_date' => '03/2013'
        );

        $payment = new \App\Payment();

        $response = new \stdClass();
        $response->approved = true;
        $response->transaction_id = 123;

        $authorizeNet = $this->getMockBuilder('\AuthorizeNetAIM')
            ->setConstructorArgs(array($payment::API_ID, $payment::TRANS_KEY))
            ->getMock();

        $authorizeNet->expects($this->once())
            ->method('authorizeAndCapture')
            ->will($this->returnValue($response));

        $result = $payment->processPayment($authorizeNet, $paymentDetails);

        $this->assertTrue($result);
    }

    public function testProcessPaymentThrowsExceptionOnUnsuccessfulPayment()
    {
        $paymentDetails = array(
            'amount' => 123.99,
            'card_num' => '1444-1111-1111-1111',
            'exp_date' => '03/2013'
        );

        $payment = new \App\Payment();

        $response = new \stdClass();
        $response->approved = false;
        $response->error_message = 'Error message';

        $authorizeNet = $this->getMockBuilder('\AuthorizeNetAIM')
            ->setConstructorArgs(array($payment::API_ID, $payment::TRANS_KEY))
            ->getMock();

        $authorizeNet->expects($this->once())
            ->method('authorizeAndCapture')
            ->will($this->returnValue($response));

        $this->expectException(\Exception::class);
        $payment->processPayment($authorizeNet, $paymentDetails);
    }
}