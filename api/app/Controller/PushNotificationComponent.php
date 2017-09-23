<?php
/*
 * PushNotificationComponent is used to send push notifications on android/ios devices
 */
class PushNotificationComponent extends Component {
    /*
     * SendPushNotificationsIos($str,$msgtyp,$page,$badge)
     */
    public function SendPushNotificationsIos($device_token,$notification_id,$badge_count) {
        $ch = curl_init();
        $notification_array = ClassRegistry::init('Notification')->find('first',array('conditions' => array('Notification.id' => $notification_id)));
          
          if(!empty($notification_array)){
            //Title of the Notification.
                  $title = $notification_array['Notification']['title'];
            //Body of the Notification.
                  $body = $notification_array['Notification']['message'];
                     $data = array('data' => $title.' notification');
              }
         
        //Creating the notification array.
        $notification = array('title' => $title, 'body' => $body, 'vibrate' => true, "click_action" => "FCM_PLUGIN_ACTIVITY", 'sound' => true, 'content-available' => '1', 'priority' => 'high','badge'=>$badge_count);
        
       //This array contains, the token and the notification. The 'to' attribute stores the token.
        $arrayToSend = array('to' => $device_token, 'notification' => $notification, 'data' => $data);

         //print_r($arrayToSend);exit;
        //Generating JSON encoded string form the above array.
        $json = json_encode($arrayToSend);
       // print_r($json);

        //Setup headers:

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=AIzaSyD9jmtIEdFxnFDsboHhDAzbs7wkGKEnWyA';

        //Setup curl, add headers and post parameters.
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       
        //Send the request
        $response = curl_exec($ch);

        //Close request
        curl_close($ch);
        return $response;
    }
}
?>