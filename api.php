<?php
class api
{
    private $protocol;
    private $localhost;
    private $port;
    function __construct(){
        $this->protocol = 'http';
        $this->localhost = "localhost";
        $this->port = 7777;
    }
    function get_end_point(): string {
        return $this->protocol . '://' . $this->localhost . ':' . $this->port;
    }
    /**
     * @throws Exception
     */
    public function getAllCategories(){
        $ch = curl_init($this->get_end_point() . "/categories");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            // Fall back to PROD API
            curl_close($ch);
            throw new Exception("!!! == BackEnd Server Not Running == !!!");

        }
        curl_close($ch);
        return json_decode($response, true);
    }
}