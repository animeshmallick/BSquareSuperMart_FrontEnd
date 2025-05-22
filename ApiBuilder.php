<?php
require_once __DIR__ . '/vendor/autoload.php';

class ApiBuilder {
    private String $protocol;
    private String $hostname;
    private int $port;
    private String $path;
    private string $method;
    private array $queryParams;
    private array $headers;
    private array $requestBody;
    private object $responseData;
    private int $statusCode;
    private String $url;
    public function __construct(){
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }
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

        if ($_ENV['BACKEND_ENV'] == 'QA')
            return $_ENV['BACKEND_ENV'];

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
        $curl_cmd = $this->prepareCurlCommand();
        $response = curl_exec($curl_cmd);
        if ($response === false){
            $this->responseData = (object) ["message" => "Curl Error", "error" => curl_error($curl_cmd)];
        }else {
            $this->responseData = (object)json_decode($response);
            $this->statusCode = curl_getinfo($curl_cmd, CURLINFO_HTTP_CODE);
        }
        curl_close($curl_cmd);
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

    private function prepareCurlCommand(): CurlHandle|bool
    {
        $this->url = $this->protocol . "://" . $this->hostname . ":" . $this->port . $this->path;
        if ($this->method == 'GET') {return $this->prepareGetCall();}
        if ($this->method == 'POST') {return $this->preparePostCall();}
        return false;
    }
    private function prepareGetCall(): CurlHandle|bool
    {
        $url_with_query_params = $this->url;
        if (!empty($this->queryParams)) {
            $url_with_query_params .= '?' . http_build_query($this->queryParams);
        }
        $ch = curl_init($url_with_query_params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return $ch;
    }
    private function preparePostCall(): CurlHandle|bool
    {
        $body = json_encode($this->requestBody);
        $hasContentType = false;
        foreach ($this->headers as $header) {
            if (stripos($header, 'Content-Type:') === 0) {
                $hasContentType = true;
                break;
            }
        }
        if (!$hasContentType) {
            $this->headers[] = 'Content-Type: application/json';
        }
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        return $ch;
    }
}
