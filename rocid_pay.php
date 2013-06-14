<?php
class CRocidPay
{
    /**
     *
     * @param  int $productId
     * @param  int $payerRocId
     * @param  int $ownerRocId
     * @return CRocidOrderItemData
     */
    public static function Add ($productId, $payerRocId, $ownerRocId = null)
    {
    	if ($ownerRocId === null) 
      {
      	$ownerRocId = $payerRocId;
      }
        
			$result = CRocidGate::Instance()->Post('pay/add', array(
	    	'ProductId'  => $productId,
	    	'PayerRocId' => $payerRocId,
	    	'OwnerRocId' => $ownerRocId
			));
	
			if (isset($result->Error) && $result->Error === true)
			{
				return null;
			}
			else 
			{
				return $result;
			}
    }
    
    /**
     *
     * @param  int $couponCode
     * @param  int $payerRocId
     * @param  int $ownerRocId
     * @return float 
     */
    public static function Coupon ($couponCode, $payerRocId, $ownerRocId = null)
    {
	    if ($ownerRocId === null) 
	    {
	    	$ownerRocId = $payerRocId;
	    }
        
			$result = CRocidGate::Instance()->Post('pay/coupon', array(
				'CouponCode' => $couponCode,
			  'PayerRocId' => $payerRocId,
			  'OwnerRocId' => $ownerRocId
			));
	
			if (isset($result->Error) && $result->Error === true)
			{
				return 0;
			}
			else 
			{
				return $result->Discount;
			}
    }
    
    /**
     *
     * @param  int $orderItemId
     * @param  int $payerRocId
     * @return bool
     */
    public static function Delete ($orderItemId, $payerRocId)
    {
			$result = CRocidGate::Instance()->Post('pay/delete', array(
				'OrderItemId' => $orderItemId,
			  'PayerRocId'  => $payerRocId
			));
			
			return $result->Success;
    }
    
    /**
     *
     * @param int $payerRocId
     * @param int $ownerRocId 
     */
    public static function DeleteByOwnerRocId ($payerRocId, $ownerRocId)
    {
	    $orderList = self::GetOrderList($payerRocId);
	    if ( !empty ($orderList->Items))
	    {
	      foreach ($orderList->Items as $item) 
	      {
	        if ($item->Owner->RocId == $ownerRocId)
	        {
	        	self::Delete($item->OrderItemId, $payerRocId);
	        }
	      }
	    }
    }
    
    /**
     *
     * @param  type $payerRocId
     * @return stdClass
     */
    public static function GetOrderList ($payerRocId)
    {
			$result = CRocidGate::Instance()->Get('pay/list', array(
				'PayerRocId' => $payerRocId
			));
		
			if (isset($result->Error) && $result->Error === true)
			{
				return null;
			}
	    return $result;
    }
    
    /**
     *
     * @return CRocidProductData[] 
     */
    public static function Products ()
    {
      $result = CRocidGate::Instance()->Get('pay/product');
      if (isset($result->Error) && $result->Error === true)
      {
        return null;
      }
      return $result;
    }
    
    /**
     *
     * @return int 
     */
    public static function GetDefaultProductId ()
    {
      return (int) CRocidSettings::DefaultProductId;
    }
    
    /**
     *
     * @param  int $payerRocId
     * @return string 
     */
    public static function GetUrl ($payerRocId)
    {
      $result = CRocidGate::Instance()->Get('pay/url', array(
        'PayerRocId' => $payerRocId 
      ));
      if (isset($result->Error) && $result->Error = true)
      {
        return null;
      }
      return $result->URL;
    }
    
    /**
     *
     * @param string $manager
     * @param array  $params
     * @param array $filter 
     */
    public static function FilterList ($manager, $params, $filter)
    {
    	$result = CRocidGate::Instance()->Get('pay/filter/list', array(
      	'Manager' => $manager,
        'Params'  => $params,
        'Filter'  => $filter
      ));
        
      if (isset($result->Error) && $result->Error = true)
      {
        return null;        
      }
      return $result;
    }
    
    /**
     *
     * @param  string $manager
     * @param  array $params
     * @param  int   $bookTime
     * @param  int   $payerRocId
     * @param  int   $ownerRocId
     * @return CRocidOrderItemData
     */
    public static function FilterBook ($manager, $params, $bookTime, $payerRocId, $ownerRocId = null)
    {
      if ($ownerRocId === null)
      {
        $ownerRocId = $payerRocId;
      }
        
      $result = CRocidGate::Instance()->Post('pay/filter/book', array(
        'Manager'    => $manager,
        'Params'     => $params,
        'BookTime'   => $bookTime,
        'PayerRocId' => $payerRocId,
        'OwnerRocId' => $ownerRocId
      ));
        
      if (isset($result->Error) && $result->Error = true)
      {
        return null;        
      }
      return $result;
    }
}
?>