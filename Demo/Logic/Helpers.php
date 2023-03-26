<?php
class Helpers  
{
    function SortByPrice(string $data)
    {
        try
        {
            $d = json_decode($data, true);

            usort($d['hotels'], function($a, $b) {
                return $a['price'] - $b['price'];
            });
    
            return $d;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }


    function SortByName(string $data)
    {
        try
        {
            $d = json_decode($data, true);

            usort($d['hotels'], function($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
    
            return $d;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }

    function GetQueryParams()
    {
        try
        {
            $uri = $_SERVER["REQUEST_URI"];
            $query_str = parse_url($uri, PHP_URL_QUERY);
            parse_str($query_str, $query_params);
    
            return $query_params;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }

    

    function Filter($data)
    {
        try
        {
            $result = array_filter($data, function ($hotel)
            {
                $query_params = $this->GetQueryParams();
                $isInName = true;
                $isInCity = true;
                $fromPrice = true;
                $toPrice = true;
                $isAvailable = true;
    
                if (array_key_exists('name', $query_params))
                    $isInName = stripos($hotel->name,$query_params['name']) !== false;
                
                if (array_key_exists('city', $query_params))
                    $isInCity = stripos($hotel->city, $query_params['city']) !== false;
    
                if (array_key_exists('fromPrice', $query_params))
                    $fromPrice = $hotel->price >= $query_params['fromPrice'];
                    
                if (array_key_exists('toPrice', $query_params))
                    $toPrice = $hotel->price <= $query_params['toPrice'];
            
                if (array_key_exists('fromDate', $query_params) && array_key_exists('toDate', $query_params))
                {
                    $isAvailable = false;
                    foreach ($hotel->availability as $availability) 
                    {
                        $availabilityFrom = DateTime::createFromFormat('d-m-Y', $availability->from);
                        $availabilityTo = DateTime::createFromFormat('d-m-Y', $availability->to);
                        $fromDate = DateTime::createFromFormat('d-m-Y', $query_params['fromDate']);
                        $toDate = DateTime::createFromFormat('d-m-Y', $query_params['toDate']);
    
                        $isAvailable = $fromDate <= $availabilityFrom && $toDate >= $availabilityTo;
            
                        if ($isAvailable)
                        break;
                    }       
                }
            
                return $isInName && $isInCity && $fromPrice && $toPrice && $isAvailable;
            
            });
    
            return $result;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    } 
}
?>