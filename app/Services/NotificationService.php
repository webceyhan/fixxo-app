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
        // get twilio credentials
        $accountSID = getenv("TWILIO_SID");
        $authToken = getenv("TWILIO_TOKEN");
        $virtualNumber = getenv("TWILIO_FROM");

        // check if credentials are set
        if (!$accountSID || !$authToken || !$virtualNumber) {
            throw new \Exception("Twilio credentials are not set.");
        }

        // create rest client
        $client = new Client($accountSID, $authToken);

        // send sms
        $client->messages->create($receiverNumber, [
            'from' => $virtualNumber,
            'body' => $message
        ]);
    }
}
