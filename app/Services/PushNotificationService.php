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

    public function send($input)
    {
        $uri = env('NOTIFICATION_URL');
        $data = [
            "notification"=> [
                "title"=> $input['title'],
                "body"=> $input['body'],
                "click_action"=> $input['click_action']
            ],
            "to" => "fM0mZuwgLAqx101MaUJkRM:APA91bFvsRncMfzVZ_wnJ4mUs4DvH9TvRKL5xV0rgztTJd4bQr8gnK_jhlU-NE8F9ZcWnD2PhpojY4s7glxo82tYU4nvxdZmb5-C5NGwc4lwaHdzDVfotWTz6LaYR93MyY2AThRJyCZE"
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
