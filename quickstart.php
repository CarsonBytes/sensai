<?php
require __DIR__ . '/vendor/autoload.php';

/* if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
} */

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
    $client->setAuthConfig('client_secret_451583457139-5rmuni8rscp1p4p0ubgpjnqms15bqda0.apps.googleusercontent.com.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }
    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1E7VbUFsKXXLpejchDN0ovPR0o-_nyXuJJ2S6Y3uiLZg/edit
$spreadsheetId = '1E7VbUFsKXXLpejchDN0ovPR0o-_nyXuJJ2S6Y3uiLZg';
$range = 'cat-structure!A2:E';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

if (empty($values)) {
    print "No data found.\n";
} else {
    foreach ($values as $row) {
        foreach ($row as $value) {
            if ($value != null) printf("%s\n", $value);
        }
    }
}