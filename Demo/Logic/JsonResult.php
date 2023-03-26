<?php

class JsonResult
{
    function MethodNotAllowed()
    {
        http_response_code(405);
        $res = [
            'error' => [
                'code' => 405,
                'message' => "Method Not Allowed"
            ]
        ];
    
        return json_encode($res);
    }
    
    function InternalServerError($message)
    {
        http_response_code(500);
        $res = [
            'error' => [
                'code' => 500,
                'message' => $message
            ]
        ];
    
        return json_encode($res);
    }

    function Success($data)
    {
        http_response_code(200);
        $res = [
           
            'code' => 200,
            'message' => "Successfully",
            'data' => $data
        
        ];
    
        return json_encode($res);
    }
}

?>