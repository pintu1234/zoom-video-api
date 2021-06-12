<?php
namespace App\Traits;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;


trait ZoomJWT
{
    public $client;
    public $jwt;
    public $headers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function generateZoomToken()
    {
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');

        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];

        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function zoomRequest()
    {
        $this->client = new Client(['verify' => false]);

        $this->jwt = $this->generateZoomToken();

        return $this->headers = [
            'Authorization' => 'Bearer '.$this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function zoomGet(string $path, array $query = [])
    {
        $url = $this->retrieveZoomUrl();

        $request = $this->zoomRequest();

        return $request->get($url . $path, $query);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function zoomPost(string $path, array $body = [])
    {
        $url = $this->retrieveZoomUrl();

        $request = $this->zoomRequest();

        return $this->client->post($url . $path, $body);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function zoomPatch(string $path, array $body = [])
    {
        $url = $this->retrieveZoomUrl();

        $request = $this->zoomRequest();

        return $request->patch($url . $path, $body);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function zoomDelete(string $path, array $body = [])
    {
        $url = $this->retrieveZoomUrl();

        $request = $this->zoomRequest();

        return $request->delete($url . $path, $body);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch(\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : ' . $e->getMessage());

            return '';
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function toUnixTimeStamp(string $dateTime, string $timezone)
    {
        try {
            $date = new \DateTime($dateTime, new \DateTimeZone($timezone));

            return $date->getTimestamp();
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toUnixTimeStamp : ' . $e->getMessage());

            return '';
        }
    }
}
