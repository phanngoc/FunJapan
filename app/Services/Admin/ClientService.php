<?php

namespace App\Services\Admin;

use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Validator;
use DB;

class ClientService extends BaseService
{
    public static function validate($inputs)
    {
        $validationRules = [
            'name' => 'required|max:255',
        ];

        return Validator::make($inputs, $validationRules)->setAttributeNames([
            'name' => 'Name',
        ]);
    }

    public static function getAll()
    {
        return Client::orderBy('created_at', 'desc')->get();
    }

    public static function filterClients($options)
    {
        $clients = new Client();

        if (isset($options['keyword']) && $options['keyword']) {
            $keyword = escape_like($options['keyword']);

            $clients = $clients->whereIn(
                'id',
                Client::where('name', 'like', "%$keyword%")
                    ->pluck('id')
                    ->toArray()
            );
        }
        $orderBy = $options['orderBy'] ?? null;
        $optionSort = [
            'id.desc',
            'id.asc',
            'name.desc',
            'name.asc',
        ];

        if (!in_array($orderBy, $optionSort)) {
            $orderBy = 'id.desc';
        }

        $orders = explode('.', $orderBy);
        $clients = $clients->orderBy($orders[0], $orders[1]);

        $clients = $clients->paginate(config('limitation.articles.default_per_page'));

        return $clients;
    }

    public static function getList()
    {
        return Client::pluck('name', 'id')->all();
    }

    public static function store($inputs)
    {
        return Client::create([
            'name' => trim($inputs['name']),
        ]);
    }

    public static function update($inputs, $id)
    {
        $client = Client::find($id);
        if ($client) {
            DB::beginTransaction();
            try {
                $client->update([
                    'name' => trim($inputs['name']),
                ]);

                DB::commit();

                return $client;
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e);

                return false;
            }
        }

        return false;
    }
}
