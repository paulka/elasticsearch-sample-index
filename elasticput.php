<?php
// CONFIGURE BELOW
$esHostProtocol = 'http'; // could be https, but may require changes to CURL opts?
$esHost = 'localhost';
$esPort = '9200';
$indexName = 'sk-loadtest-001';
$docType = 'birdstrike';
$documentId = 1;

// DO NOT EDIT BELOW THIS LINE!
ini_set("auto_detect_line_endings", true);

$row = 1;
if (($handle = fopen('indexme.csv', "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        $num = count($data);
        $row++;
        $acrafttype = $data[0];
        $airportname = $data[1];
        $alt = $data[2];
        $craftmodel = $data[3];
        $numberstruck = $data[4];
        $effect = $data[5];
        $effectother = $data[6];
        $location = $data[7];
        $flightnumber = $data[8];
        $date = $data[9];
        $recid = $data[10];
        $effectdamage = $data[11];
        $locationother= $data[12];
        $enginecount = $data[13];
        $airline = $data[14];
        $originstate = $data[15];
        $flightpahse = $data[16];
        $conditions = $data[17];
        $wildliferemainscollected = $data[18];
        $wildlifesenttosmithsonian = $data[19];
        $remarks = $data[20];
        $reporteddate = $data[21];
        $wildlifesize = $data[22];
        $conditionssky = $data[23];
        $wildlifespecies = $data[24];
        $time = $data[25];
        $timeoday = $data[26];
        $pilotwarned = $data[27];
        $aircraftoutofservicehours = $data[28];
        $costadjusted = $data[29];
        $costrepair = $data[30];
        $costtotal = $data[31];
        $milesfromairport = $data[32];
        $feetaboveground = $data[33];
        $humanfatalities = $data[34];
        $humaninjuries = $data[35];
        $ias = $data[36];

        echo 'INDEXING ROW: ' . $row . ' RECORD ID: ' . $recid . "\n";

        $json_data = array(
              "aircraft_type" => $acrafttype,
              "airport_name" => $airportname,
              "altitude" => $alt,
              "aircraft_make_model" => $craftmodel,
              "wildlife_number_struck" => $numberstruck,
              "effect_impact_on_flight" => $effect,
              "effect_other" => $effectother,
              "location_nearby_if_enroute" => $location,
              "aircraft_flight_number" => $flightnumber,
              "flight_date" => $date,
              "record_id" => $recid,
              "effect_indicated_damage" => $effectdamage,
              "location_freeform_en_route" => $locationother,
              "aircraft_number_of_engines" => $enginecount,
              "aircraft_airline_or_operator" => $airline,
              "origin_state" => $originstate,
              "when_flight_phase" => $flightpahse,
              "conditions_precipitation" => $conditions,
              "wildlife_collected" => $wildliferemainscollected,
              "wildlife_sent_to_smithsonian" => $wildlifesenttosmithsonian,
              "remarks" => $remarks,
              "reported_date" => $reporteddate,
              "wildlife_size" => $wildlifesize,
              "conditions_sky" => $conditionssky,
              "wildlife_species" => $wildlifespecies,
              "when_time" => $time,
              "when_time_of_day" => $timeoday,
              "pilot_warned" => $pilotwarned,
              "cost_aircraft_hours_out_of_service" => $aircraftoutofservicehours,
              "cost_other" => $costadjusted,
              "cost_repair" => $costrepair,
              "cost_total" => $costtotal,
              "location_miles_from_airport" => $milesfromairport,
              "feet_above_ground" => $feetaboveground,
              "human_fatalities" => $humanfatalities,
              "human_injuries" => $humaninjuries,
              "ias" => $ias	      
        );
        $jsonData = json_encode($json_data);

        $endPointURL = $esHostProtocol . '://' . $esHost . ':' . $esPort . '/' . $indexName . '/' . $docType . '/' . $documentId++;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endPointURL);
        curl_setopt($ch, CURLOPT_PORT, $esPort);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        $response = curl_exec($ch);
        echo 'RESPONSE: ' . $response . "\n\n";
        if (!$response) {
            return false;
        }
    }
    fclose($handle);
}
?>
