<?php

class api
{
    public function getAllCategories(){
        $ch = curl_init("http://localhost:7777/categories");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}