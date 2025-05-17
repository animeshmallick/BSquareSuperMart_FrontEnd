<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
class ApiBuilder {
    private String $protocol;
    private String $hostname;
    private int $port;
    private String $path;
    private String $method;
    private $queryParams;
    private $headers;
    private $requestBody;
    private $responseData;
    private int $statusCode;
    function init(): ApiBuilder
    {
        $this->protocol = $_ENV['BACKEND_PROTOCOL'];
        $this->hostname = $this->getHostname();
        $this->port = $_ENV['BACKEND_PORT'];
        $this->path = '/';
        $this->queryParams = [];
        $this->headers = [];
        $this->requestBody = [];
        $this->responseData = (object) ["status" => "Curl Not Executed"];
        $this->statusCode = 999;
        return $this;
    }

    private function getHostname(): String|null
    {
        if ($_ENV['BACKEND_ENV'] == 'PROD')
            return $_ENV['BACKEND_PROD_IP'];
        if ($_ENV['BACKEND_ENV'] == 'LOCAL')
            return $_ENV['BACKEND_LOCAL_IP'];
        return null;
    }

    function setMethod($method): ApiBuilder
    {
        $this->method = $method;
        return $this;
    }
    function setPath($path): ApiBuilder
    {
        $this->path = $path;
        return $this;
    }
    function setQueryParams($queryParams): ApiBuilder
    {
        $this->queryParams = $queryParams;
        return $this;
    }
    function setHeaders($headers): ApiBuilder
    {
        $formattedHeaders = [];
        foreach ($headers as $key => $value) {
            $formattedHeaders[] = "$key: $value";
        }
        $this->headers = $formattedHeaders;
        return $this;
    }
    function setRequestBody($requestBody):ApiBuilder{
        $this->requestBody = $requestBody;
        return $this;
    }
    function execute(): ApiBuilder
    {
        $url = $this->protocol . "://" . $this->hostname . ":" . $this->port . $this->path;
        if ($this->method == "GET") {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $this->responseData = (object) json_decode($response);
            $this->statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        }
        if ($this->method == "POST") {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->requestBody));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
            $response = curl_exec($ch);
            $this->responseData = (object) json_decode($response);
            $this->statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        }
        return $this;
    }
    function getResponse(): object
    {
        return (object) $this->responseData;
    }
    function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
