<?php
require('simple_html_dom.php');
function saveAsFile($content) {
    $file = fopen("fba_locations.json", "w") or die("Unable to open file!");
    fwrite($file, $content);
    fclose($file);
}

$locationsHtml = file_get_contents('locations.html');
$locationsHtml = str_get_html($locationsHtml);
//6835 W. Buckeye Rd. Phoenix, AZ, 85043"
//1901 Meadowville Technology Parkway, Chester, VA 23836
foreach($locationsHtml->find('tr') as $locationHtml) {

    $code     = $locationHtml->find('td', 1)->plaintext;
    $fullAddress     = $locationHtml->find('td', 3)->plaintext;
    
    if((strpos($fullAddress,',') !== false ) ) {
        
        $fullAddressArray = explode(',', $fullAddress);
        $address = $fullAddressArray[0]? $fullAddressArray[0]:'';
        $city = $fullAddressArray[1]? $fullAddressArray[1]:'';
        if (count($fullAddressArray) == 3) $stateWithZip = isset($fullAddressArray[2]) ? $fullAddressArray[2]:'';

        if($stateWithZip && preg_match("/[a-zA-Z]/", $stateWithZip) && strlen(trim($stateWithZip)) > 2) {

            list($state, $zip) = explode(' ',ltrim($stateWithZip));
            echo($fullAddress.PHP_EOL);
            echo($stateWithZip.PHP_EOL);
            $location = array(
                'Name' =>'Amazon.com',
                'AddressLine1' => $address,
                'City' => $city,
                'StateOrProvinceCode' => $state,
                'CountryCode' =>'US',
                'PostalCode' => $zip
            );
            $locations[$code] = $location;
            $locationsJson = json_encode($locations);
            saveAsFile($locationsJson);
        } else {

            echo($fullAddress.PHP_EOL);
        }
    } else {
        echo($code.$fullAddress.PHP_EOL);
    }
}


