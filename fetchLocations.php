<?php


$file = 'fba_locations.json';
if(!file_exists($file))  die("The file doesn't exist.");
$fbaLocations =  json_decode(file_get_contents($file),true);

    foreach ($fbaLocations as $key => $fbaLocation) {



            $ShipToAddress = $fbaLocation['address'];
            if(strpos($ShipToAddress,',')!== false) {

                $address = null;
                $city = null;
               // $stateWithZip = null;
                $state = null;
                $zip = null;

                list($address, $city, $stateWithZip) = explode(',', $ShipToAddress);

                if(!preg_match("/[a-zA-Z]/i", $stateWithZip)) {
                    //number
                    echo($stateWithZip.PHP_EOL);
                    list($address, $state, $zip) = explode(',', $ShipToAddress);

                } else {
                    //letter.
                    //list($state, $zip) = explode(' ',ltrim($stateWithZip));
                    //echo($ShipToAddress.PHP_EOL);
                }

                $to= array(
                    'Name' =>'Amazon.com',
                    'AddressLine1' => $address,
                    'City' => $city,
                    'StateOrProvinceCode' => $state,
                    'CountryCode' =>'US',
                    'PostalCode' => $zip
                );
                //echo($zip);
            }
            else {
                echo($fbaLocation['address'] ." no commas  ".PHP_EOL);
            }

            //print_r($ShipToAddress);

    }
