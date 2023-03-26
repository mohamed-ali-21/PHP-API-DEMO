<?php

class IntegrationManager
{
    function GetData()
    {
        try
        {
            $response = file_get_contents('https://api.npoint.io/dd85ed11b9d8646c5709');
            return json_decode($response);
        }
        catch (Exception $ex)
        {
            throw new Exception("Integration Error");
        }
    }
}

?>