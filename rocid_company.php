<?php
class CRocidCompany {
    
    /**
     *
     * @param  int   $companyId
     * @return array 
     */
    static public function Get($companyID)
    {
        $data = CRocidGate::Instance()->Get('company/get', array('CompanyId' => $companyID));
        return
            new CRocidCompanyResult($data);
    }
    
    /**
     *
     * @param  array $companyIds
     * @return array 
     */
    static public function GetList($companyIDs)
    {
        $companies = CRocidGate::Instance()->Get('company/list', array(
                'CompanyID' => implode(',', $companyIDs)
            ));
        
        $result = array();
        
        foreach($companies as $company)
        {
            $result[] = new CRocidCompany($company);
        }
        return $result;
    }
   
    
    /**
     *
     * @param  string $query
     * @param  int    $maxResults
     * @param  string $pageToken
     * @return array 
     */
    static public function Search($query, $maxResults = 200, $pageToken = '')
    {
       return
           CRocidGate::Instance()->Get('company/search', array(
               'Query'      => $query,
               'MaxResults' => $maxResults,
               'PageToken'  => $pageToken
           ));
    }
    
}
?>
