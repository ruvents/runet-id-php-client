<?php
class CRocidGeo 
{
    /**
     *
     * @return array 
     */
    public static function GetCountries()
    {
	return CRocidGate::Instance()->Get('geo/countrylist', array(), 86400);
    }
    
    /**
     *
     * @param  int $countryId
     * @return array 
     */
    public static function GetRegions ($countryId) 
    {
	return CRocidGate::Instance()->Get('geo/regionlist', array(
	    'CountryId' => $countryId
	), 86400);
    }
    
    /**
     *
     * @param  int $regionId
     * @return array
     */
    public static function GetCities ($regionId)
    {
	return CRocidGate::Instance()->Get('geo/citylist', array(
	   'RegionId' => $regionId 
	), 86400);
    }
}
?>
