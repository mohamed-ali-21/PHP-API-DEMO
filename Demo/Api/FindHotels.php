<?php

require '../Logic/JsonResult.php';
require '../Logic/HotelManager.php';

header('Access-Control-Allow-Origin: *');
header('Content-type: json/application');

$method = $_SERVER['REQUEST_METHOD'];
$res = new JsonResult;

if ($method === 'GET')
{
    try
    {
        $hotelManager = new HotelManager;
        $data = $hotelManager->FindHotels();
        
        echo $res->Success($data);
        exit;
    }
    catch (Exception $ex)
    {
        echo $res->InternalServerError($ex->getMessage());
        exit;
    }
}
else
{
    echo $res->MethodNotAllowed();
    exit;
}

?>