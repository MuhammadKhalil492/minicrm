<?php
namespace App\Classes;

use App\Models\Client;

class ClientClass
{
    private $model;

    public function __construct()
    {
        $this->model = new Client();
    }

    /**
     * This function retrieves all user records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Builder A query builder instance for the User model.
     *
     * @throws \Exception If any error occurs during the database query.
     */
    public function getAllClientList()
    {
        $query = $this->model->query();
        return $query;
    }

    public function saveClient($fields, $client_id = null)
    {
        if ($client_id) {
            $client = $this->model->find($client_id);
        } else {
            $client = new $this->model;
        }
        $client->contact_name    = $fields['contact_name'];
        $client->contact_email   = $fields['contact_email'];
        $client->phone           = $fields['phone'];
        $client->company_name    = $fields['company_name'];
        $client->company_vat     = $fields['company_vat'];
        $client->company_address = $fields['company_address'];
        $client->company_city    = $fields['company_city'];
        $client->company_zip     = $fields['company_zip'];
        $client->save();
        return $client;
    }
}
