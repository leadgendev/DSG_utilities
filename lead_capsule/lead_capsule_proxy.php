<?php
/***************************************************************
 * File: DSG_utilities/lead_capsule/lead_capsule_proxy.php
 *
 * Author: eamohl@leadsanddata.net
 *
 * Created: June 27, 2013
 **************************************************************/
 
$config = parse_ini_file('lead_capsule_proxy.ini');

$request = "http://datastream.leadcapsule.com/Leads/LeadPost.aspx";

$_proxy_for = $_GET['_proxy_for'];
unset($_GET['_proxy_for']);

$campaign_id = $config[$_proxy_for]['campaign_id'];
$redirect_accept = $config[$_proxy_for]['redirect_accept'];
$redirect_reject = $config[$_proxy_for]['redirect_reject'];

$request = $request . "?CampaignID=$campaign_id";
foreach ($_GET as $key => $value) {
	$request .= "&$key=$value";
}

$response = file_get_contents($request);
$xml = simplexml_load_string($response);
$is_valid = $xml->Response->IsValid;

if ( $is_valid == 'True' ) {
	header( "Location: $redirect_accept" );
} else {
	header( "Location: $redirect_reject" );
}

die;
?>