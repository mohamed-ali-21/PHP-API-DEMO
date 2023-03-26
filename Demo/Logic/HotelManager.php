<?php

require 'IntegrationManager.php';
require 'Helpers.php';

class HotelManager
{
    function FindHotels()
    {
        try
        {
            $help = new Helpers;
            $integrationManager = new IntegrationManager;
        
            $query_params = $help->GetQueryParams();
            
            $data = $integrationManager->GetData();
            $data->hotels = $help->Filter($data->hotels);
        
            if (array_key_exists('sortByName', $query_params) && $query_params['sortByName'] == 'true')
                $data = $help->SortByName(json_encode($data));
            else if (array_key_exists('sortByPrice', $query_params) && $query_params['sortByPrice'] == 'true')
                $data = $help->SortByPrice(json_encode($data));
           
            return $data;   
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
}

?>