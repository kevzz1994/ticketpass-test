<?php


namespace App\Plugins\PasswordValidation;


use GuzzleHttp\Exception\GuzzleException;

class HaveIBeenPwned implements IPasswordValidator
{
    /**
     * The API endpoint of HaveIBeenPwned
     */
    private const API_ENDPOINT = 'https://api.pwnedpasswords.com/range/';

    /**
     * Validates if the password passes the HaveIBeenPwned API
     * @param string $password the password to validate
     * @return bool returns true on successful validation, false otherwise
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function validate(string $password): bool
    {
        // Get the hash:
        $hash = strtoupper(sha1($password));
        // Create the prefix:
        $hashPrefix = substr($hash, 0, 5);
        // Create the suffix:
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
                // Delimit the password
                $hashedPassword = explode(':', $line);
                // Check if the password is the same:
                if ($hashSuffix === $hashedPassword[0]) {
                    return false;
                }
            }
            // Return success:
            return true;
        // Catch failures:
        } catch (GuzzleException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
