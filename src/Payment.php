<?php
namespace App;

class Payment
{
    const API_ID = 123456;
    const TRANS_KEY = 'TRANSACTION KEY';

    public function processPayment(\AuthorizeNetAIM $transaction, array $paymentDetails) {
        $transaction->amount = $paymentDetails['amount'];
        $transaction->card_num = $paymentDetails['card_num'];
        $transaction->exp_date = $paymentDetails['exp_date'];

        $response = $transaction->authorizeAndCapture();

        if ($response->approved) {
            return $this->savePayment($response->transaction_id);
        } else {
            throw new \Exception($response->error_message);
        }
    }

    public function savePayment($transactionid) {
        // lógica para salvar o ID da transação no banco ou em outro lugar vai aqui
        return true;
    }
}