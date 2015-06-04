<?php

/**
* New Open Calais API call sample
* you can get API key from http://new.opencalais.com/opencalais-api/ 
*/

require('OCalais.php');

$key = "";  //your key #you can get API key from http://new.opencalais.com/opencalais-api/
$OCalais = new OCalais($key);
$contentBody ="Anas Jamil is a web developer at Oilwell7 co
			  Attended Al-albayt University
			  Lives in amman, Hashemite Kingdom of Jordan"; //the text you want to analyse
$extractedEntities = $OCalais->textAnalysis($contentBody);

echo "<pre>";
print_r($extractedEntities);