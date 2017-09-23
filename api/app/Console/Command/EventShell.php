<?php
App::uses('Shell', 'Console');
App::uses('CakeEmail', 'Network/Email'); 
class EventShell extends Shell { 
  
	public function sendemail() {  
             Configure::write("debug", 0);
          $this->loadModel('Eventscheduler');
           $this->loadModel('Reminder');
            $Cuutent = date('Y-m-d H:i:s');
            $currentDate = strtotime($Cuutent);
            $beoreDate = $currentDate-(60*5);
            $beoretostartDate = date("Y-m-d H:i:s", $beoreDate);          
 
           $eventdata1 = $this->Eventscheduler->find('first',array('conditions'=>array('Eventscheduler.start_date <='=>$beoretostartDate,'Eventscheduler.end_date >='=>$beoretostartDate)));    
          if(!empty($eventdata1)){  
           $pro_id = explode(',', $eventdata1['Eventscheduler']['product_id']);    
          // $pro_id = unserialize($eventdata1['Eventscheduler']['product_id']);    
       $allriminder = $this->Reminder->find('all',array('recursive'=>1,'conditions'=>array('Reminder.product_id'=> $pro_id ))); 
     if(!empty($allriminder)){  
       foreach ($allriminder as $data){   
           if($data['Reminder']['mail_sent'] == 0){                  
                         $msg = '<h1>Product Event Reminder</h1><br/> '. $data['Product']['name'];  
                        $l = new CakeEmail('smtp');   
                        $l->emailFormat('html')->template('default', 'default')->subject('Product Event Reminder')->
                        to($data['User']['email'])->send($msg);
              $this->Reminder->updateAll(array('Reminder.mail_sent' =>1), array('Reminder.product_id' => $data['Product']['id']));           
                        
           }          
                        
        }
     }
        } 
 }
 }
