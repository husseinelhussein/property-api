<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\PropertyType;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

class FetchProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches properties from the API.';


    /**
     * The Http Client.
     *
     * @var Client
     */
    protected $client;

    /**
     * The API URL
     *
     * @var string
     */
    protected $api_url = "";

    /**
     * The API Key
     * @var string
     */
    protected $api_key = "";

    /**
     * @var ProgressBar
     */
    protected $progress;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $httpClient)
    {
        parent::__construct();
        $this->client = $httpClient;
        $this->api_url = env('API_URL');
        $this->api_key = env('API_KEY');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $res = $this->next();
        if ($this->progress) {
            $this->progress->finish();
        }
        return $res;
    }


    /**
     * Fetches the first or the next page.
     *
     * @param string|null $url
     * @param int $total
     *
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function next($url = null, $total = 0)
    {
        $params = [];
        $err = null;

        if (!isset($url)) {
            $url = $this->api_url . "/properties";
            $params = [
                'query' => [
                    'api_key' => $this->api_key
                ]
            ];
        }
        try {
            $response = $this->client->request('GET', $url, $params);
        } catch (GuzzleException $e) {
            $err['message'] = $e->getMessage();
            $err['code'] = $e->getCode();
        }
        if ($err) {
            $this->error('Something bad happened, Server responded with ' . $err['code'] . ': ' . $err['message']);
            return -1;
        }
        $response = json_decode($response->getBody()->getContents(), true);

        // Save the data:
        if (isset($response['data'])) {
            foreach ($response['data'] as $property) {
                $this->save($property);
            }
        }
        if ($total) {
            $this->handleProgress($total);
        }

        // Fetch next page:
        if (isset($response['next_page_url']) && !empty($response['next_page_url'])) {
            $res = $this->next($response['next_page_url'], $response['last_page']);
            if($res < 0) {
                return $res;
            }
        }
        return 0;
    }

    /**
     * Creates a new progress bar or advances it.
     *
     * @param int $total
     */
    protected function handleProgress($total = 1){
        if(!$this->progress){
            $this->progress = $this->output->createProgressBar($total);
            $this->progress->start();
        }
        $this->progress->advance();
    }

    /**
     * Saves the property into the database.
     *
     * @param array $data The Property data.
     */
    protected function save($data){
        $propertyType = $this->getOrCreatePropertyType($data['property_type']);
        $property = new Property();
        $property->county = $data['county'];
        $property->country = $data['country'];
        $property->town = $data['town'];
        $property->description = $data['description'];
        $property->displayable_address = $data['address'];
        $property->image = $data['image_full'];
        $property->thumbnail = $data['image_thumbnail'];
        $property->latitude = $data['latitude'];
        $property->longitude = $data['longitude'];
        $property->number_of_bedrooms = $data['num_bedrooms'];
        $property->number_of_bathrooms = $data['num_bathrooms'];
        $property->price = $data['price'];
        $property->type = $data['type'];
        $property->propertyType()->associate($propertyType);
        $property->save();
    }

    /**
     * Gets existing PropertyType, or create new one.
     *
     * @param $data
     */
    protected function getOrCreatePropertyType($data){
        $propertyId = $data['id'];
        $property = PropertyType::where('remote_id', $propertyId)->first();
        if (!$property) {
            $property = new PropertyType($data);
            $property->remote_id = $data['id'];
            $property->save();
        }
        return $property;
    }


}
