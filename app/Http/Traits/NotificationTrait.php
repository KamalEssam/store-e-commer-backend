<?php


namespace App\Http\Traits;

trait NotificationTrait
{
    /**
     * @param $title
     * @param $body
     * @param $tokens
     * @param $product_id
     * @return bool|string
     */
    public function push_notification($title, $body, $tokens, $product_id)
    {
        #prep the bundle
        $notification_object = array
        (
            'title' => $title,
            'body' => $body,
            'click_action' => 'product',
            'sound' => 'default',
            'icon' => 'assets/images/logo/logo-125.png',
            'product_id' => $product_id,
        );

        $data = array
        (
            'title' => $title,
            'body' => $body,
            'click_action' => 'product',
            'sound' => 'default',
            'icon' => 'assets/images/logo/logo-125.png',
            'product_id' => $product_id,
        );


        $fields = array
        (
            'registration_ids' => $tokens,
            'notification' => $notification_object,
            'data' => $data,

        );


        $headers = array
        (
            'Authorization: key=AAAA3V4NE_A:APA91bGOkBhrNoDNeiTVwH08zJfNsk5YZKf1Ro9icsRwWtmtH7vgE36cfjMka7uh1sv_w1PvNgDsHOwvrhPR8hn1IgA22Oug9oJ2KR-x_CpF3YWvYhelvxN7WkvV4JMUcl4jMJ3CAnUP',
            'Content-Type: application/json'
        );

        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
