<?php


namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;

class TwilioService
{
    private $sid = 'AC23f040c923fd5a42a9f32d148fd79695';
    private $token = '9f80005b27d076ba5b14e4bd832b3837';
    private $twilio_phone_number = '+12055709346';
    private $client;

    public function __construct()
    {
        $this->client = new Client($this->sid, $this->token);
    }

    public function createMessage($phone_number, $token_2fa)
    {
        $client = $this->client;

        try {
            $client->messages->create(
                $phone_number,
                array(
                    'from' => $this->twilio_phone_number,
                    'body' => '2Fa code: ' . $token_2fa
                )
            );
        }
        catch (RestException $exception)
        {
            session()->flash('error', $exception->getMessage());
            Auth::logout();
        }

    }
}
