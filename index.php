<?php
require('simple_html_dom.php');
function saveAsFile($content) {
    $file = fopen("fba_locations.json", "w") or die("Unable to open file!");
    fwrite($file, $content);
    fclose($file);
}

$locationsHtml = file_get_contents('locations.html');
$locationsHtml = str_get_html($locationsHtml);

foreach($locationsHtml->find('tr') as $locationHtml) {
    $location['state']     = $locationHtml->find('td', 0)->plaintext;
    $location['code']     = $locationHtml->find('td', 1)->plaintext;
    $location['type']     = $locationHtml->find('td', 2)->plaintext;
    $location['address']     = $locationHtml->find('td', 3)->plaintext;

    $locations[$location['code']] = $location;
    
}
$locationsJson = json_encode($locations);
saveAsFile($locationsJson);

