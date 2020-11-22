<?php


namespace App\Plugins\PasswordValidation;


class HaveIBeenPwned implements IPasswordValidator
{

    private const API_ENDPOINT = 'https://api.pwnedpasswords.com/range/';

    public function validate($password): bool
    {
        // Get the hash
        $hash = strtoupper(sha1($password));
        $hashPrefix = substr($hash, 0, 5);
        $hashSuffix = substr($hash, 5);

        try {
            // The client:
            $client = new \GuzzleHttp\Client();
            // Execute API call, and catch the exception if 400, or 500 response codes being thrown:
            $response = $client->request('GET', self::API_ENDPOINT . $hashPrefix, ['verify' => false]);
            // Get the body:
            $body = $response->getBody()->getContents();
            // Loop through every line:
            foreach (explode(PHP_EOL, $body) as $line) {
                $hashedPassword = explode(':', $line);
                if ($hashSuffix === $hashedPassword[0]) {
                    return false;
                }
            }
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
