<?php
class Common {
    public function is_user_logged_in($authToken): bool
    {
        if($authToken === null)
            return false;
        if(strlen($authToken) <= 0)
            return false;
        $auth = array("X-Authorization" => "Bearer " . $authToken);
        $api = (new ApiBuilder())
            ->init()
            ->setMethod('POST')
            ->setPath("/isValidToken")
            ->setHeaders($auth)
            ->execute();
        $response = $api->getResponse();
        if(isset($response->error))
            return false;
        if(!isset($response->is_valid_user))
            return false;
        return $response->is_valid_user === true;
    }
}
