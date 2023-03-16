<?php

namespace App\Services;

use Twilio\Rest\Client;

class NotificationService
{
    /**
     * Send SMS to customer.
     * 
     * @param Customer $customer
     * @param string $message
     * @return void
     * @throws \Twilio\Exceptions\TwilioException
     */
    public static function sendSMS(string $receiverNumber, string $message): void
    {
        $accountSID = getenv("TWILIO_SID");
        $authToken = getenv("TWILIO_TOKEN");
        $virtualNumber = getenv("TWILIO_FROM");

        $client = new Client($accountSID, $authToken);

        $client->messages->create($receiverNumber, [
            'from' => $virtualNumber,
            'body' => $message
        ]);
    }
}
