<?php


namespace App\Services;


use App\Models\Notification;
use GuzzleHttp\Client;

class PushNotificationService
{
    /**
     * @param $input
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list($input): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Notification::query()->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1
        );

    }

    /**
     * @param $input
     * @return Notification
     */
    public function store($input)
    {
        return Notification::query()->create($input);
    }

    public function find($id)
    {
        return Notification::find($id);
    }

    public function update($id, $input):int
    {
        return Notification::query()->where('id',$id)->update($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return Notification::query()->where('id',$id)->delete();
    }

    public function send()
    {
        $uri = "https://fcm.googleapis.com/fcm/send";
        $data = [
            "notification"=> [
                "title"=> "Test de notificacion",
                "body"=> "Cuerpo el MSG"
            ],
            "to" => "eoP9sGe7o5B3JxFdcQ7UEo:APA91bEJhkNPjKfJXD0iWuoxVhcTQkUyRrcyGyuJoBH9CA8dRXOmkClAY0JQq6KETLL2rD2mkSiBUjnlYr2usqJZrFKl2T-Qsov3jl_B3f-GIAkoLRqvaS-EKbvwqEi4MMOuly948a-O"
        ];
        $params['headers'] = [
            'Authorization' => 'key=AAAA431j5UU:APA91bEiAFwHoMFHg3qF6akvf2cawX--RfGg4ZSqXWunBnewGWJe1Ywl7WjMUi3fS60ij86ZifLe9rZMWCpVgC4K2LnUDsQ_0vGeeCX5dbnJjoCj1OeNbnXHEfDiIhKjMgmRmHcymkVg',
            'Content-type' => 'application/json'
        ];
        $params['body'] = json_encode($data);
        $client = new Client();
        $response = $client->request('POST', $uri, $params);
        $data = json_decode($response->getBody(), true);
        return  $data;
    }
}
