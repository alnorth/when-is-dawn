<?php

function hostip_get_info($ip) {
	$content = @file_get_contents('http://api.hostip.info/?ip='.$ip);
	if ($content != FALSE) {
		$xml = new SimpleXmlElement($content);
		$coordinates = $xml->children('gml', TRUE)->featureMember->children('', TRUE)->Hostip->ipLocation->children('gml', TRUE)->pointProperty->Point->coordinates;
		$longlat = explode(',', $coordinates);
		$location['longitude'] = $longlat[0];
		$location['latitude'] = $longlat[1];		
		$location['citystate'] = '==>'.$xml->children('gml', TRUE)->featureMember->children('', TRUE)->Hostip->children('gml', TRUE)->name;
		$location['country'] =  '==>'.$xml->children('gml', TRUE)->featureMember->children('', TRUE)->Hostip->countryName;
		return $location;
	}
	else return false;
}

?>