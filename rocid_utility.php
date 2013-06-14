<?php
class CRocidUtility 
{
    /**
     *
     * @return string 
     */
    public static function GetAgreementText()
    {
	$result = CRocidGate::Instance()->Get('utility/agreement', array(), 604800);
	if (isset ($result->Text))
	{
	    return $result->Text;
	}
	else
	{
	    return '';
	}
    }
}
?>
