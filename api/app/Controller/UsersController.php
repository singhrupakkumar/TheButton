<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email'); 

class UsersController extends AppController { 

////////////////////////////////////////////////////////////

    public function beforeFilter() {     
        parent::beforeFilter();
        $this->Auth->allow('login', 'admin_add','api_googlelogin','userorder',
                'invitebyemail','api_resendVerificationCode','api_verifyEmail', 'admin', 'admin_login', 
                'api_forgetpwd', 'api_trackorder', 'api_addresslist', 'api_resetpwd',
                'googlelogin','api_loginwork','facebook_connect','userlogin','usersignup','userdata');
    }
    public $components = array('RequestHandler'); 

////////////////////////////////////////////////////////////

///////////////////angular api/////////////////////////// 

	public function usersignup() {  
			Configure::write('debug', 0); 
			  $this->layout = 'ajax';
        if ($this->request->is('post')) {
         
            $this->request->data['User']['username'] = $this->request->data['email'];
			$this->request->data['User']['email'] = $this->request->data['email'];
            $email = $this->request->data['email'];
            $parts = explode('@', $email);
            $emailPart = $parts[0];
            $rand_no = rand(111111111,999999999);
            $password = $emailPart.$rand_no;
            $this->request->data['User']['password'] = $password;
            $encodepass  = base64_encode($password);
                    
            $this->request->data['User']['md_pass'] = $encodepass; 
            $this->request->data['User']['name'] = $emailPart;  
            
               // generate refferal code of a user 
            if(isset($this->request->data['referral_code'])){ 
                $referral_code_exists = $this->User->find('first',array('conditions'=>
                    array(
                        'User.referral_code'=>$this->request->data['referral_code']
                        )
                    ));
                $this->request->data['User']['used_referral_code'] = $this->request->data['referral_code'];
                
            }else{
                $this->request->data['User']['used_referral_code'] = '';  
              
            }
           
            if ($this->User->hasAny(array('User.username' => $this->request->data['email']))) {  
				$response['status'] = false;
                $response['msg'] = 'Email_id already exist';
			 
            } else { 
                  if($this->request->data['User']['used_referral_code'] != '' && empty($referral_code_exists)){  
                    $response['status'] = false;
                    $response['msg'] = 'Invalid refferal code';
                }else{
                       $this->User->create();  
                    $this->request->data['User']['role'] = 'customer';
                    $this->request->data['User']['active'] = 1; 
                    if ($this->User->save($this->request->data)) {
			$uid = $this->User->getLastInsertID();
                       
                        $user_referral_code =  substr($this->request->data['email'],0,3).rtrim(strtr(base64_encode($uid), '+/', '-_'), '='); 
                        $this->User->id = $this->User->getLastInsertID();
                        $this->User->saveField('referral_code', $user_referral_code);
                        
                      $url = Router::url(array('controller' => 'Users', 'action' => 'changepassword'), true);
                    
                        
                        $ms = "<b>Hi ".$emailPart.",</b><br/>Welcome to The Button App 
                             <b>Your temporary password is: ".$password." "
                                . "</b> Please create a new password <a href=".$url.">here</a> <br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Registration Successful!!!')->
                         to($this->request->data['email'])->send($ms);
                        
                         $this->request->data['User']['username'] = $this->request->data['email']; 
                         $this->request->data['User']['password'] = $password;  
                     
						$response['status'] = true;
						$response['uid'] = $uid;
						$response['msg'] = 'Registration Successfully Done.';
                        
    
                    } else {  
					$response['status'] = false;
				   $response['msg'] = 'Sorry please try again';
 
                    }
                  
                  }
 
              
            }
        } else {
			$response['status'] = false;
		   $response['msg'] = 'Post Method Required';
  
        }
		
      echo json_encode($response); 
       exit; 
    }	
		

	public function userlogin() {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
         
        $password = $this->request->data['password'];
        if ($this->request->is('post')) {
        
            $password_hash = AuthComponent::password($password); 
            $check = $this->User->find('first', array('conditions' => array(
                "AND"=>array(
                    "User.username" => $this->request->data['email'],
                    "User.password"=> $password_hash,
                )
                ), 'recursive' => '-1'));
            if($check){ 
                if($check['User']['active']==1){
    
                    if ($check['User']['image'] != '') {
                        if (!filter_var($check['User']['image'], FILTER_VALIDATE_URL) === false) {
                            $check['User']['image'] = $check['User']['image'];
                        } else {
                            $check['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $check['User']['image'];
                        }

                    } else {
                        $check['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                    }
                    $response['status'] = true;
                    $response['msg'] = 'You have successfully logged in';
                    $response['data'] = $check;
                    $response['id']= $check['User']['id']; 
                }else{
                    $response['status'] = false;
                    $response['verified']=  false;
                    $response['msg'] = 'Email is Registered but not Verified!';
                    $response['id']= $check['User']['id'];
                }
            }else{
                $response['status'] = false;
                $response['msg'] = 'User is not valid';
            }
        }

        echo json_encode($response);
        exit;
    }
    
    //////////////////////invite send email//////////////////////////////
    
            public function invitebyemail() { 
                 Configure::write("debug", 0);   
                 $this->layout = 'ajax';
               if ($this->request->is('post')) {  
                  $emailall = array();
                 $emailall[] = $this->request->data['email_1'];
                 $emailall[] = $this->request->data['email_2'];
                  $emailall[] = $this->request->data['email_3'];
                 $emailall[] = $this->request->data['email_4'];
                 $emailall[] = $this->request->data['email_5'];
                 $refer_link = $this->request->data['refer_link']; 
             
                  foreach($emailall as $email){ 
                    if(!empty($email)){
                      $ms = "<b>Hi ".$email.",</b><br/>Welcome to The Button App<br/> 
                              Please use this referral code for the button app account registration and get benefits <br/>
                              link ".$refer_link.""; 
                        $l = new CakeEmail('smtp');
                       $send = $l->emailFormat('html')->template('default', 'default')->subject('Registration Invite Code!')->
                         to($email)->send($ms);
               
                       
                     if($send){
                        $response['status'] = true; 
                         
                     }else{
                     $response['status'] = false; 
                     } 
                        }    
                  }
                    
                    
                    
               }   
              echo json_encode($response);
              exit;  
            }
            public function googlelogin() { 
                Configure::write("debug", 0);   
                 $this->layout = 'ajax';
               if ($this->request->is('post')) { 
              $email = $this->request->data['g_email'];
              
                $name = explode(" ", $this->request->data['full_name']);
                $fname = isset($name[0]) ? $name[0] : '';
                $lname = isset($name[1]) ? $name[1] : '';
              
            $parts = explode('@', $email);
            $emailPart = $parts[0];
            $rand_no = rand(111111111,999999999);
            $password = $emailPart.$rand_no;
            $this->request->data['User']['password'] = $password;
	
            $this->request->data['User']['username'] = $email;
            $this->request->data['User']['name'] = $fname;
            $this->request->data['User']['email'] = $email;
            $this->request->data['User']['google_id'] = $this->request->data['gid'];
            $encodepass  = base64_encode($password); 
            $this->request->data['User']['md_pass'] = $encodepass;   
            
              // generate refferal code of a user 
            if(isset($this->request->data['invitecode'])){ 
                $referral_code_exists = $this->User->find('first',array('conditions'=>
                    array(
                        'User.referral_code'=>$this->request->data['invitecode']
                        )
                    ));
                $this->request->data['User']['used_referral_code'] = $this->request->data['invitecode'];
                
            }else{
                $this->request->data['User']['used_referral_code'] = '';  
              
            } 
            
             if (!$this->User->hasAny(array(
                        'OR' => array('User.username' => $email, 'User.email' =>$email)
                    ))) {
                    if($this->request->data['User']['used_referral_code'] != '' && empty($referral_code_exists)){   
                    $response['status'] = false;
                    $response['msg'] = 'Invalid refferal code';
                   }else{  
                 
                $this->User->create();
                $this->request->data['User']['role'] = 'customer';
                $this->request->data['User']['active'] = 1;
                if ($this->User->save($this->request->data)) {

                         $url = Router::url(array('controller' => 'Users', 'action' => 'changepassword'), true);
                    
                        
                        $ms = "<b>Hi ".$fname.",</b><br/>Welcome to The Button App 
                             <b>Your temporary password is: ".$password." "
                                . "</b> Please create a new password <a href=".$url.">here</a> <br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Registration Successful!!!')->
                         to($email)->send($ms);
                    
                    $user = $this->User->find('first', array('conditions' => array('email' => $email)));
                    $user_referral_code =  substr($user['User']['username'],0,3).rtrim(strtr(base64_encode($user['User']['id']), '+/', '-_'), '='); 
                    $this->User->id = $this->User->getLastInsertID();
                    $this->User->saveField('referral_code', $user_referral_code);
                    
               
                     if ($user['User']['id']) {
                    $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $password;
                     $response['status']= true;
		     $response['uid']= $user['User']['id'];
                     $response['msg']= "Login successfully ";
                 
                }
                    
                    
                } else {
               
                     $response['status']= false;
                     $response['msg']= "Sorry.Please try again";
                
                  
                }
                    }
            } else {
                $user = $this->User->find('first', array('conditions' => array('email' =>$email)));
                
                if($user['User']['google_id'] != NULL){
                     $response['msgs']= "not null google";
                 
                          if ($user['User']['id']) {
                    $pass = $user['User']['md_pass'];
                     $decodepass = base64_decode($pass); 
                   $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $decodepass;
                      $response['status']= true;
		      $response['uid']= $user['User']['id'];
                     $response['msg']= "Login";
                     }
                }else{
                     $response['msgs']= " null fb";
                      $googleid = $this->request->data['gid'];
                     $this->User->updateAll(array('User.google_id' => "$googleid"), array('User.email' => $email));  
                     $pass = $user['User']['md_pass'];
                     $decodepass = base64_decode($pass); 
               
                     $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $decodepass; 
                     $response['status']= true;
		     $response['uid']= $user['User']['id'];
                     $response['msg']= "Login";
                   
                }

            } 

        } else {
		
             $response['status']= false;
             $response['msg']= "Sorry. Please try again";
        }
        
        echo json_encode($response);
        exit;
          }   
          
          
          
           private function refferalDiscountweb($user_id) { 
		$this->loadModel('User');
		$this->loadModel('Order');
		$this->loadModel('Setting');
        $user = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
            if($user){
                $refferal_code = $user['User']['referral_code'];
                $users = $this->User->find('list',array('conditions'=>array(
                    "AND"=>array(
                       'User.used_referral_code'=>$refferal_code,
                        'User.invitation_discount_used'=>0 
                    )
                        )));
                if($users){
                    $user_ids = array_keys($users);
                    $order = $this->Order->find('first',array('conditions'=>array(
                        'AND'=>array(
                            'Order.uid'=>$user_ids,
                            'Order.created >'=>date('Y-m-d h:i:s', strtotime('-1 months'))
                        )
                    ),
                        'fields'=>array('Order.*','User.*'),
                        //'group'=>'Order.uid',
                        'recursive'=>1,
                        'order'=>array('Order.created ASC')
                        ));
        
                    $discount_setting = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'discount_for_referral')));
                    if($discount_setting['Setting']['dimension']==2){
                        $discount['type']="$";
                       $discount_for_refferal= "$".$discount_setting['Setting']['value'];
                    }else if($discount_setting['Setting']['dimension']==1){
                        $discount['type']="%";
                        $discount_for_refferal= $discount_setting['Setting']['value']."%";
                    }else{
                        $discount_for_refferal= $discount_setting['Setting']['value'];
                    }
                    $discount['amount']=$discount_setting['Setting']['value'];
                    $discount['refreral_count']= count($users); 
                    $created_date = strtotime($order['Order']['created']);
                    return $discount;
                } 
            }
    }
          
          

	public function userdata(){
		    Configure::write('debug', 0);
			$this->loadModel('Country');
                        $this->loadModel('Address');
         $this->layout = 'ajax';
        if ($this->request->is('post')) {
		 $uid = $this->request->data['uid'];
		$userdata = $this->User->find('first',array('conditions'=>array('User.id'=>$uid)));
		$country = $this->Country->find('all');
                $address = $this->Address->find('all',array('conditions'=>array('Address.user_id'=>$uid)));  
             if(!empty($address)){        
              $d['user_address']= $address;      
             }else{
              $d['user_address']= 0;       
             }   
             

             $refferal_discount = $this->refferalDiscountweb($uid); 
            if($refferal_discount){
               
                    $d['refferal_discount']=$refferal_discount['amount'];
                    $d['refferal_count']=$refferal_discount['refreral_count'];
                    $d['total_wallet']= $refferal_discount['refreral_count'] *$refferal_discount['amount']; 
                
            }else{ 
                $d['refferal_discount']= 0;
                $d['refferal_count']= 0;
                $d['total_wallet']=0;   
            }
            
            if($userdata['User']['wallet_money'] !=0){
             $d['total_wallet'] = $d['total_wallet']+$userdata['User']['wallet_money'];          
            }
                
                $timezones = array(
    'Pacific/Midway'       => "(GMT-11:00) Midway Island",
    'US/Samoa'             => "(GMT-11:00) Samoa",
    'US/Hawaii'            => "(GMT-10:00) Hawaii",
    'US/Alaska'            => "(GMT-09:00) Alaska",
    'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
    'America/Tijuana'      => "(GMT-08:00) Tijuana",
    'US/Arizona'           => "(GMT-07:00) Arizona",
    'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
    'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
    'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
    'America/Mexico_City'  => "(GMT-06:00) Mexico City",
    'America/Monterrey'    => "(GMT-06:00) Monterrey",
    'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
    'US/Central'           => "(GMT-06:00) Central Time (US & Canada)",
    'US/Eastern'           => "(GMT-05:00) Eastern Time (US & Canada)",
    'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
    'America/Bogota'       => "(GMT-05:00) Bogota",
    'America/Lima'         => "(GMT-05:00) Lima",
    'America/Caracas'      => "(GMT-04:30) Caracas",
    'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
    'America/La_Paz'       => "(GMT-04:00) La Paz",
    'America/Santiago'     => "(GMT-04:00) Santiago",
    'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
    'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
    'Greenland'            => "(GMT-03:00) Greenland",
    'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
    'Atlantic/Azores'      => "(GMT-01:00) Azores",
    'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
    'Africa/Casablanca'    => "(GMT) Casablanca",
    'Europe/Dublin'        => "(GMT) Dublin",
    'Europe/Lisbon'        => "(GMT) Lisbon",
    'Europe/London'        => "(GMT) London",
    'Africa/Monrovia'      => "(GMT) Monrovia",
    'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
    'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
    'Europe/Berlin'        => "(GMT+01:00) Berlin",
    'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
    'Europe/Brussels'      => "(GMT+01:00) Brussels",
    'Europe/Budapest'      => "(GMT+01:00) Budapest",
    'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
    'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
    'Europe/Madrid'        => "(GMT+01:00) Madrid",
    'Europe/Paris'         => "(GMT+01:00) Paris",
    'Europe/Prague'        => "(GMT+01:00) Prague",
    'Europe/Rome'          => "(GMT+01:00) Rome",
    'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
    'Europe/Skopje'        => "(GMT+01:00) Skopje",
    'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
    'Europe/Vienna'        => "(GMT+01:00) Vienna",
    'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
    'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
    'Europe/Athens'        => "(GMT+02:00) Athens",
    'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
    'Africa/Cairo'         => "(GMT+02:00) Cairo",
    'Africa/Harare'        => "(GMT+02:00) Harare",
    'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
    'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
    'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
    'Europe/Kiev'          => "(GMT+02:00) Kyiv",
    'Europe/Minsk'         => "(GMT+02:00) Minsk",
    'Europe/Riga'          => "(GMT+02:00) Riga",
    'Europe/Sofia'         => "(GMT+02:00) Sofia",
    'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
    'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
    'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
    'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
    'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
    'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
    'Europe/Moscow'        => "(GMT+03:00) Moscow",
    'Asia/Tehran'          => "(GMT+03:30) Tehran",
    'Asia/Baku'            => "(GMT+04:00) Baku",
    'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
    'Asia/Muscat'          => "(GMT+04:00) Muscat",
    'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
    'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
    'Asia/Kabul'           => "(GMT+04:30) Kabul",
    'Asia/Karachi'         => "(GMT+05:00) Karachi",
    'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
    'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
    'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
    'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
    'Asia/Almaty'          => "(GMT+06:00) Almaty",
    'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
    'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
    'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
    'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
    'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
    'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
    'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
    'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
    'Australia/Perth'      => "(GMT+08:00) Perth",
    'Asia/Singapore'       => "(GMT+08:00) Singapore",
    'Asia/Taipei'          => "(GMT+08:00) Taipei",
    'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
    'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
    'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
    'Asia/Seoul'           => "(GMT+09:00) Seoul",
    'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
    'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
    'Australia/Darwin'     => "(GMT+09:30) Darwin",
    'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
    'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
    'Australia/Canberra'   => "(GMT+10:00) Canberra",
    'Pacific/Guam'         => "(GMT+10:00) Guam",
    'Australia/Hobart'     => "(GMT+10:00) Hobart",
    'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
    'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
    'Australia/Sydney'     => "(GMT+10:00) Sydney",
    'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
    'Asia/Magadan'         => "(GMT+12:00) Magadan",
    'Pacific/Auckland'     => "(GMT+12:00) Auckland",
    'Pacific/Fiji'         => "(GMT+12:00) Fiji",
 );
                //$this->loadModal('Order');  
                //$odata = $this->Order->find('count', array('conditions' => array('Order.uid' => $uid,'Order.order_status !=' =>0)));              
			if($userdata){
				 $response['status'] = true;
				 $response['user'] = $userdata;
                                 $response['userextrainfo'] = $d;    
				 $response['country'] = $country;
				 $response['timezone'] = $timezones;
                                 //$response['ordercount'] = $odata;  
          
			}else{
				 $response['status'] = false;
				 $response['user'] = '';
				 $response['msg'] = 'User Does not exist';
			}
		}
		
		echo json_encode($response);
        exit;
	}
	
	
	
	public function profileupdate(){
		Configure::write("debug",0);
        $id = $this->request->data['uid'];
        $this->User->id = $this->request->data['uid'];
        if (!$this->User->exists($id)) {
          $response['status'] = false;
		  $response['msg'] = 'User Does not exist';
          
        }
        if ($this->request->is('post') || $this->request->is('put')) {
          
           if ($this->User->hasAny(array('User.email' => $this->request->data['email'],'User.id !=' =>$id ))) {
               /*  $this->Session->setFlash('Email already exist!', 'flash_error'); 
                return $this->redirect(array('action' => 'profile')); */
				$response['status'] = false;
				$response['msg'] = 'Email already exist!';
            } else {
				if(!empty($this->request->data['phone'])){
					 $this->request->data['User']['phone'] = $this->request->data['phone'];
				}
				if(!empty($this->request->data['email'])){
					 $this->request->data['User']['email'] = $this->request->data['email'];
                                         $this->request->data['User']['username'] = $this->request->data['email'];
				}
				if(!empty($this->request->data['name'])){
					 $this->request->data['User']['name'] = $this->request->data['name'];
				}
				if(!empty($this->request->data['time_zone'])){
					 $this->request->data['User']['time_zone'] = $this->request->data['time_zone'];
				}
				if(!empty($this->request->data['country'])){
					 $this->request->data['User']['country'] = $this->request->data['country'];
				}
                                if(!empty($this->request->data['get_notification'])){  
					 $this->request->data['User']['get_notification'] = $this->request->data['get_notification'];
				}

                 $this->User->id = $this->request->data['uid'];
                if ($this->User->save($this->request->data)) { 
              /*        $this->Session->setFlash('Your profile has been Updated.', 'flash_success');
                    return $this->redirect(array('action' => 'profile')); */
					$response['status'] = true;
					$response['msg'] = 'Your profile has been Updated.';
                } else {
                    //$this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
					$response['status'] = false;
					$response['msg'] = 'The user could not be saved. Please, try again.';
                
                }
            }
        }
		echo json_encode($response); 
        exit;
	}
        
        
        
         public function changepassword() {
             Configure::write("debug",0);
             $this->layout = 'ajax';  
        if ($this->request->is('post')) {

            $password = AuthComponent::password($this->request->data['old_password']);
            
            $pass = $this->User->find('first', array('conditions' => array('AND' => array('User.password' => $password, 'User.id' => $this->request->data['id']))));
            if ($pass) {
                if ($this->request->data['new_password'] != $this->request->data['cpassword']) {
                    $response['status'] = false;
	            $response['msg'] = 'New password and Confirm password fields donot match.';
                   
                   
                } else {
                    $this->request->data['User']['password'] = $this->request->data['new_password'];
                      $encodepass  = base64_encode($this->request->data['new_password']);
                    $this->User->id = $this->request->data['id']; 
                  
                    if ($this->User->exists()) {
                        $this->request->data['User']['password'] = $this->request->data['new_password'];
                          $this->User->saveField('md_pass', $encodepass);  
                        if ($this->User->save($this->request->data)) {
                            
                             $response['status'] = true;
                              $response['msg'] = 'Password has been Updated.';
                   
                           
                        }
                    }
                }
            } else { 
                 $response['status'] = false;
                 $response['msg'] = 'Your old password donot match.';
 
            } 
        }
        
        echo json_encode($response);
        exit;
    }
    
    
          function userorder(){     
           Configure::write("debug",2);
             $this->layout = 'ajax';  
                $this->loadModel('Order'); 
          
            if ($this->request->is('post')) {
              
                $uid = $this->request->data['uid'];  
                        
                $odata = $this->Order->find('all', array('recursive'=>1,'conditions' => array('Order.uid' => $uid,'Order.order_status !=' =>0))); 
                    foreach ($odata as $res) { 
                if ($res['OrderItem'][0]['image']) {
                    $res['OrderItem'][0]['image'] = FULL_BASE_URL . $this->webroot . 'files/product/' . $res['OrderItem'][0]['image'];
                } else {
                    $res['OrderItem'][0]['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                }
                $res1[] = $res;
            }
                
                $codata = $this->Order->find('count', array('conditions' => array('Order.uid' => $uid,'Order.order_status !=' =>0))); 
                if($res1){ 
                 $response['status'] = true;
                 $response['order'] = $res1; 
                 $response['count_order'] = $codata; 
                }else{
                 $response['status'] = false;
                 $response['order'] = '';    
                }
            } 
            echo json_encode($response);    
            exit;
          }
///////////////////angular api end////////////////////////////////////

    public function admin_login() { 
        Configure::write("debug", 0);
        $this->layout = "admin2";

        // echo AuthComponent::password('admin');

        if ($this->request->is('post')) {
            //echo $this->request->data['User']['server'];exit;
			 $this->Session->write('payfortpaymenton','website');   
            $sesid = $this->Session->id();
            if ($this->Auth->login()) {

                $this->User->id = $this->Auth->user('id');
                $this->User->saveField('logins', $this->Auth->user('logins') + 1);
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));
                $this->loadModel('Cart');
                $updatesess = $this->Session->id();
                $this->Cart->updateAll(array('Cart.sessionid' => "'$updatesess'"), array('Cart.sessionid' => $sesid));
                if ($this->Auth->user('role') == 'customer') {
                    return $this->redirect('http://' . $this->request->data['User']['server']);
                } elseif ($this->Auth->user('role') == 'admin') {
                    $uploadURL = Router::url('/') . 'app/webroot/upload';
                    $_SESSION['KCFINDER'] = array(
                        'disabled' => false,
                        'uploadURL' => $uploadURL,
                        'uploadDir' => ''
                    );

                    return $this->redirect(array(
                                'controller' => 'dashboards',
                                'action' => 'index',
                                'manager' => false,
                                'admin' => true
                    ));
                } elseif ($this->Auth->user('role') == 'rest_admin') {
                    $uploadURL = Router::url('/') . 'app/webroot/upload';
                    $_SESSION['KCFINDER'] = array(
                        'disabled' => false,
                        'uploadURL' => $uploadURL,
                        'uploadDir' => ''
                    );


                    return $this->redirect(array(
                                'controller' => 'dashboards',
                                'action' => 'index',
                                'manager' => false,
                                'admin' => true
                    ));
                } else {
                    $this->Session->setFlash('Login is incorrect', 'flash_error');
                }
            } else {
                $this->Session->setFlash('Login is incorrect', 'flash_error');
            }
        }
    }

    public function login() {
        if(!empty($this->Auth->user('id'))){
          return $this->redirect('myaccount');     
        }

        if ($this->request->is('post')) {
            $sesid = $this->Session->id();
        $hashpass = AuthComponent::password($this->request->data['User']['password']);    
       $users = $this->User->find('all', array('conditions' => array('User.username' =>$this->request->data['User']['username'])));
	
       if(empty($users)){
	 $this->Session->setFlash('User does not Exist', 'flash_error');
	 return $this->redirect(Router::fullbaseUrl() . $this->request->data['server']);  
                 
       }elseif(!empty($users[0]['User']['fb_id']) && $hashpass != $users[0]['User']['password']){
	$this->Session->setFlash('Your account created by facebook please forgot password', 'flash_error');
	return $this->redirect(Router::fullbaseUrl(). $this->request->data['server']); 
      
       }elseif($hashpass != $users[0]['User']['password']){ 
	$this->Session->setFlash('Wrong Password', 'flash_error');
	return $this->redirect(Router::fullbaseUrl() . $this->request->data['server']); 
       
       }else{      
       if ($this->Auth->login()) { 
                  $uid = $this->Auth->user('id');
                $this->User->id = $this->Auth->user('id');
                $this->User->saveField('logins', $this->Auth->user('logins') + 1);
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));
                $this->loadModel('Cart');
                $updatesess = $this->Session->id();  
                $this->Cart->updateAll(array('Cart.sessionid' => "'$updatesess'",'Cart.uid' => "'$uid'"), array('Cart.sessionid' => $sesid));
                if ($this->Auth->user('role') == 'customer') {
				$this->Session->setFlash('Login successfully', 'flash_success');
		       return $this->redirect(Router::fullbaseUrl(). $this->request->data['server']);	
                 
                } elseif ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'rest_admin') {
                    $uploadURL = Router::url('/') . 'app/webroot/upload';
                    $_SESSION['KCFINDER'] = array(
                        'disabled' => false,
                        'uploadURL' => $uploadURL,
                        'uploadDir' => ''
                    );
					
                     return $this->redirect(array(
                                'controller' => 'dashboards',
                                'action' => 'index',
                                'manager' => false,
                                'admin' => true
                    ));		
			
                } else {
						 $this->Session->setFlash('Login is incorrect', 'flash_error');
						return $this->redirect(Router::fullbaseUrl(). $this->request->data['server']); 
                 
                }
            } else {
         
                $this->Session->setFlash('Email id or Password  Wrong', 'flash_error');
				return $this->redirect(Router::fullbaseUrl(). $this->request->data['server']); 
                 
            }
            
        } 
        }  
    }

////////////////////////////////////////////////////////////

    public function logout() {
        $this->Session->setFlash('Good-Bye', 'flash_success');
        $_SESSION['KCEDITOR']['disabled'] = true;
        unset($_SESSION['KCEDITOR']);
         $this->Session->delete('payfortpaymenton'); 
		 $this->Session->delete('ordertype'); 
        return $this->redirect($this->Auth->logout());  
    }

    public function admin_logout() {
        $this->Session->setFlash('Good-Bye', 'flash_success');
		 $this->Session->delete('payfortpaymenton'); 
        $_SESSION['KCEDITOR']['disabled'] = true;
        unset($_SESSION['KCEDITOR']);
        $this->Auth->logout();
        return $this->redirect('/admin');
    }

////////////////////////////////////////////////////////////

    public function admin_index() {
        Configure::write("debug", 0);
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{ 

                 $users =  $this->User->find('all');

            $this->set(compact('users'));
        }
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {   
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            $this->User->id = $id;
            if (!$this->User->exists()) {
                throw new NotFoundException('Invalid user');
            }
            $this->set('user', $this->User->read(null, $id));

            // Multiple Addresses of a User
            $this->loadModel('Address');
            $this->set('addresses',$this->Address->find('all',array('conditions'=>array('Address.user_id'=>$id))));
        }
    }



    public function admin_add() {
//        if($this->Auth->user('role')!='admin'){
//            $this->render('/Pages/unauthorized');
//        }else{
            if ($this->request->is('post')) {
                if ($this->User->hasAny(array('User.username' => $this->request->data['User']['username']))) {
                    $this->Session->setFlash(__('Username already exist!!!', 'flash_error'));
                    return $this->redirect(array('action' => 'add'));
                }
                $this->User->create();
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash('The user has been saved', 'flash_success');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
                }
            }
//        }
    }

	public function add() {  
			Configure::write('debug', 0);
  
        if ($this->request->is('post')) {
         
            $this->request->data['User']['username'] = $this->request->data['User']['email'];
            $email = $this->request->data['User']['email'];
            $parts = explode('@', $email);
            $emailPart = $parts[0];
            $rand_no = rand(111111111,999999999);
            $password = $emailPart.$rand_no;
            $this->request->data['User']['password'] = $password;
            $encodepass  = base64_encode($password);
                    
            $this->request->data['User']['md_pass'] = $encodepass; 
            $this->request->data['User']['name'] = $emailPart;  

            if ($this->User->hasAny(array('User.username' => $this->request->data['User']['email']))) {  
           
			$this->Session->setFlash('Email_id already exist', 'flash_error');
                        return $this->redirect(Router::fullbaseUrl(). $this->request->data['server']); 
            } else {
                    $this->User->create();  
                    $this->request->data['User']['role'] = 'customer';
                    $this->request->data['User']['active'] = 1;
                    if ($this->User->save($this->request->data)) {
                        
                      $url = Router::url(array('controller' => 'Users', 'action' => 'changepassword'), true);
                    
                        
                        $ms = "<b>Hi ".$emailPart.",</b><br/>Welcome to The Button App 
                             <b>Your temporary password is: ".$password." "
                                . "</b> Please create a new password <a href=".$url.">here</a> <br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Registration Successful!!!')->
                         to($this->request->data['User']['email'])->send($ms);
                        
                         $this->request->data['User']['username'] = $this->request->data['User']['email']; 
                         $this->request->data['User']['password'] = $password;  
                    
                          $this->Auth->login(); 

                        $this->Session->setFlash('Registration Successfully Done.', 'flash_success');
			return $this->redirect(Router::fullbaseUrl() . $this->request->data['server']); 
    
                    } else { 
			$this->Session->setFlash('Sorry please try again', 'flash_error');
			return $this->redirect(Router::fullbaseUrl(). $this->request->data['server']); 
                  
                    }
              
            }
        } else {
	$this->Session->setFlash('Post Method Required', 'flash_error');
	return $this->redirect(Router::fullbaseUrl(). $this->request->data['server']); 
  
        }
     
    }
    
	
	
    
    ////////////////////////////////
    public function verifyEmail(){
        if($this->request->is('post')){
            $exist = $this->User->find("first",array('conditions'=>array(
                "AND"=>array(
                    'User.id'=>$this->request->data['user_id'],
                    'User.verification_code'=>$this->request->data['verification_code'],
                    'User.active'=>0
                )
            )));
            if($exist){
                //            print_r($this->request->data); exit;
				
		if($exist['User']['role']== 'rest_admin'){
				 $updated = $this->User->updateAll(array('User.verification_code'=>NULL),
                        array('User.id'=>$this->request->data['user_id'],'User.verification_code'=>$this->request->data['verification_code'],'User.active'=>0)
                        );
					  $response['msg']="Your account Verified Successfully Please wait for admin responce"; 			
					
				}else{
				
                $updated = $this->User->updateAll(array('User.active'=>1,'User.verification_code'=>NULL),
                        array('User.id'=>$this->request->data['user_id'],'User.verification_code'=>$this->request->data['verification_code'],'User.active'=>0)
                        );
                
                if($updated){
                    $user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->request->data['user_id'])));
                    $response['isSuccess']=true;
                        $pass = $user['User']['md_pass'];  
                     $decodepass = base64_decode($pass); 
                     $this->request->data['User']['username'] = $user['User']['username']; 
                     $this->request->data['User']['password'] = $decodepass;  
                    
                      $this->Auth->login(); 
                    $response['msg']="Your account Verified Successfully Welcome to Thoag"; 
                    
                }else{
                    $response['isSuccess']=false;
                    $response['msg']="Please verify account with valid verification code. Unable to verify";
                }
				
			}	
            }else{
                $response['isSuccess']=false;
                $response['msg']="Please verify account with valid verification code.";
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']="Only Post Method is allowed";
        }
        echo json_encode($response);
        exit;
    }

    
    ///////////////////////////////////

    public function forgetpwd() { 
        Configure::write("debug", 0);
         $this->layout = 'ajax';
        $this->User->recursive = -1;
        
        if (!empty($this->request->data)) {
            if (empty($this->request->data['username'])) {
                $response['isSuccess']=false;
                $response['msg']= "Please Provide your Email Address that you used while Registration.";
                
       
            } else {
                $username = $this->request->data['username'];
                $fu = $this->User->find('first', array('conditions' => array('User.username' => $username)));

                if ($fu['User']['email']) { 
                    if ($fu['User']['active'] == "1") {
                      
                        $key = Security::hash(CakeText::uuid(), 'sha512', true);
                        $hash = sha1($fu['User']['email'] . rand(0, 100));
                        $url = Router::url(array('controller' => 'Users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
                        $ms = '<p>Click the Link below to reset your password.</p><br /><a href="'.$url.'">'
                                . '<button type="button" style="background:none; border:none; height:35px; padding:0px; display:inline-block; padding:0px 15px; background-color:#CC0000; color:#fff;" border-radius:4px;>Reset Password</button></a>';
                        $fu['User']['tokenhash'] = $key;  
                        $this->User->id = $fu['User']['id'];
                        if ($this->User->saveField('tokenhash', $fu['User']['tokenhash'])) {
                            
     
                            
                            $l = new CakeEmail('smtp');     
                            $l->emailFormat('html')->template('forgot')->subject('Reset Your Password')
                                     ->viewVars(array('link' => $url)) 
                                    ->viewVars(array('user' => $fu)) 
                                    ->to($fu['User']['email'])->send();
             
                            
                            $this->set('smtp_errors', "none");
                             $response['isSuccess']= true;
                             $response['msg']= "Check Your Email to reset your password.";

                        } else {
                          
                              $response['isSuccess']= false;
                             $response['msg']= "Error Generating Reset link";
                        }
                    } else { 
                         $response['isSuccess']= false;
                         $response['msg']= "This Account is not Active yet. Check Your mail to activate it";
                       
                    }
                } else {
                    
                     $response['isSuccess']= false;
                      $response['msg']= "Email Address does not Exist.";
                   
                   
                }
            }
        }
        
           echo json_encode($response);
        exit;
    }

    public function reset($token = null) {
        configure::write('debug', 0);
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findBytokenhash($token);
            if ($u) {
                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {
                    if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
                        $this->Session->setFlash("Both the passwords are not matching...", 'flash_error');
                        return;
                    }
                    $this->User->data = $this->data;
                    $this->User->data['User']['email'] = $u['User']['email'];
                    $new_hash = sha1($u['User']['email'] . rand(0, 100)); //created token
                    $this->User->data['User']['tokenhash'] = $new_hash;
                    if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
                        if ($this->User->save($this->User->data)) {
                            $this->Session->setFlash('Password Has been Updated', 'flash_success');
                            $this->redirect(array('controller' => 'Products', 'action' => 'index'));
                        }
                    } else {
                        $this->set('errors', $this->User->invalidFields());
                    }
                }
            } else { 
                $this->Session->setFlash('Token Corrupted. Please Retry, the reset link 
                        <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none;
                        background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") 
                        repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;"
                        name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">works</a> only for once.', 'flash_error');
            }
        } else {
            $this->Session->setFlash('Pls try again...', 'flash_error');
            $this->redirect(array('controller' => 'pages', 'action' => 'login'));
        }
    } 

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        Configure::write("debug", 0);
        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }

        // get saved page permissions
        $this->loadModel('Userpermission');
        $AuthPermission = $this->Userpermission->find('first', array('conditions' => array('Userpermission.user_id' => $id)));
        if ($AuthPermission) {
            $authorized_pages = unserialize($AuthPermission['Userpermission']['view_pages']);
            $this->set('authorized_pages', $authorized_pages);
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $view_pages = serialize($this->request->data['Userpermission']['view_pages']);
            $dataprm = array('user_id' => $id, 'view_pages' => $view_pages);

            if ($this->User->save($this->request->data)) {
                $cnt = $this->Userpermission->find('count', array('conditions' => array('Userpermission.user_id' => $id)));
                if ($cnt < 1) {
                    $this->Userpermission->save($dataprm);
                } else {
                    $this->Userpermission->updateAll(
                            array('view_pages' => "'$view_pages'"), array('user_id' => $id)
                    );
                }
                $this->Session->setFlash('The user has been saved', 'flash_success');

                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }
    
    /*
     * Edit Profile
     */
    public function admin_myaccount() {
        Configure::write("debug", 0);
        $id=$this->Auth->User('id');
        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }

        // get saved page permissions
        

        if ($this->request->is('post') || $this->request->is('put')) {
            
            $image = $this->request->data['User']['image'];
            $uploadFolder = "profile_pic";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
               
                $full_image_path = $uploadPath . DS . $imageName;
              // $img = Router::url('/', true)."files/profile_pic/".$imageName;
                
                move_uploaded_file($image['tmp_name'], $full_image_path);  
                $this->request->data['User']['image']=$imageName;
            }else{
                $user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
                $this->request->data['User']['image']=$user['User']['image'];
            }

            if ($this->User->save($this->request->data)) {
                
                $this->Session->setFlash('The user has been saved', 'flash_success');

                return $this->redirect(array('controller'=>'orders','action' => 'myaccount'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
            }
        } else {
            $this->request->data=$this->User->find('first',array('conditions'=>array('User.id'=>$id)));
        }
    }

    public function edit() {
        $id = $this->Auth->user('id');
        $this->User->id = $this->Auth->user('id');
        if (!$this->User->exists($id)) {
            return $this->redirect(array('action' => 'myaccount'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $email = $this->Auth->user('email');
            $username = $this->Auth->user('username');
            if (($email == $this->request->data['User']['email']) && ($username == $this->request->data['User']['username'])) {
                 $this->request->data['User']['phone'] = $this->request->data['User']['phone'];  
                if ($this->User->save($this->request->data)) {
                   $this->Session->setFlash('Your profile has been Updated.', 'flash_success');  
                   
                    return $this->redirect(array('action' => 'myaccount'));
                } else {
                      $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
                  
                }
            } else if ($this->User->hasAny(array('User.email' => $this->request->data['User']['email']))) {
                $this->Session->setFlash('Email already exist!', 'flash_error'); 
               
                return $this->redirect(array('action' => 'edit'));
            } else if ($this->User->hasAny(array('User.username' => $this->request->data['User']['username']))) {
                $this->Session->setFlash('Username already exist!', 'flash_error');
                
                return $this->redirect(array('action' => 'edit'));
            } else {
                 $this->request->data['User']['phone'] = $this->request->data['User']['phone'];    
                if ($this->User->save($this->request->data)) {
                     $this->Session->setFlash('Your profile has been Updated.', 'flash_success');
                    
                    return $this->redirect(array('action' => 'myaccount'));
                } else {
                    $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
                
                }
            }
        } else {   
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $data = $this->request->data = $this->User->find('first', $options);
            $this->set('data', $data);
        } 
        
      
    }

////////////////////////////////////////////////////////////

    public function admin_password($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Password successfullu changed', 'flash_success');      
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');    
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if (!$this->request->is('post')) {
                throw new MethodNotAllowedException();
            }
            $this->User->id = $id;
            if (!$this->User->exists()) {
                throw new NotFoundException('Invalid user');
            }
            if ($this->User->delete()) {
                $this->Session->setFlash('User deleted', 'flash_success');
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash('User was not deleted', 'flash_error');
            return $this->redirect(array('action' => 'index'));
        }
    }
    /**
     * 
     * @param type $id
     */
    public function admin_activate($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            $this->User->id = $id;

            if ($this->User->exists()) {
                $x = $this->User->save(array(
                    'User' => array(
                        'active' => '1'
                    )
                ));
                $this->Session->setFlash(__("Activated successfully."));
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__("Unable to activate."));
                $this->redirect($this->referer());
            }
        }
    }

    /**
     * 
     * @param type $id
     */
    public function admin_deactivate($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            $this->User->id = $id;
            if ($this->User->exists()) {
                $x = $this->User->save(array(
                    'User' => array(
                        'active' => '0'
                    )
                ));
                $this->Session->setFlash(__("Deactivated successfully."));
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__("Unable to Deactivated."));
                $this->redirect($this->referer());
            }
        }
    }



    public function api_resendVerificationCode(){
        if($this->request->is('post')){
            $verification_code = rand(11111,99999);
//            $this->request->data['User']['verification_code'] = $verification_code;
            $this->User->id=$this->request->data['user_id'];
            $this->User->saveField('verification_code',$verification_code);
            $user = $this->User->find("first",array("conditions"=>array("User.id"=>$this->request->data['user_id'])));
            if($user){
                $ms = "Welcome to Thoag 
                             <b>Verfication Code is: ".$verification_code." "
                                . "</b><br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Resend Verification Code!!!')->
                                to($user['User']['email'])->send($ms);
                        $response['isSuccess'] = true;
                $response['msg'] = 'Verification code has been sent on Email. Please use that to activate your account';
                $response['user_id']=$this->request->data['user_id'];    
            }else{
                $response['isSuccess']=false;
                $response['msg'] = 'Sorry please try again';
            }
        }else{
            $response['isSuccess']=false;
            $response['msg'] = 'Post method required';
        }
        echo json_encode($response);
        exit;
    }
    public function api_verifyEmail(){
        if($this->request->is('post')){
            $exist = $this->User->find("first",array('conditions'=>array(
                "AND"=>array(
                    'User.id'=>$this->request->data['user_id'],
                    'User.verification_code'=>$this->request->data['verification_code'],
                    'User.active'=>0
                )
            )));
            if($exist){
                //            print_r($this->request->data); exit;
                $updated = $this->User->updateAll(array('User.active'=>1,'User.verification_code'=>NULL),
                        array('User.id'=>$this->request->data['user_id'],'User.verification_code'=>$this->request->data['verification_code'],'User.active'=>0)
                        );
                if($updated){
                    $user=$this->User->find('first',array('conditions'=>array('User.id'=>$this->request->data['user_id'])));
                     $this->loadModel('Cart');

                    $data_exist_withId = $this->Cart->find('all',array('conditions'=>array('AND'=>array(
                        'Cart.uid'=>$user['User']['id']
                    ))));
                    
                     $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$this->request->data['session_id'])
                        );
                    
                
                
                    if(isset($this->request->data['device_uuid'])){
                        $this->loadModel('Installation');
                        $exist = $this->Installation->find('first',array("conditions"=>array('Installation.device_uuid'=>$this->request->data["device_uuid"])));
                        if($exist){
                             $this->User->updateAll(
                                array('User.device_token'=>"'".$exist["Installation"]["device_token"]."'"),
                                array('User.id'=>$user['User']['id'])
                                );

                        }else{
                           // $response['device1']=$exist;
                        }
                    }
                    
                    if ($user['User']['image'] != '') {
                        if (!filter_var($user['User']['image'], FILTER_VALIDATE_URL) === false) {
                            $user['User']['image'] = $user['User']['image'];
                        } else {
                            $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                        }

                    } else {
                        $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                    }
                    
                    
                    $response['isSuccess']=true;
                    $response['msg']="Verified Successfully";
                    $response['data']=$user;
                }else{
                    $response['isSuccess']=false;
                    $response['msg']="Please verify account with valid verification code. Unable to verify";
                }
            }else{
                $response['isSuccess']=false;
                $response['msg']="Please verify account with valid verification code.";
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']="Only Post Method is allowed";
        }
        echo json_encode($response);
        exit;
    }



    public function api_forgetpwd() {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $username = $redata->User->username;
        $this->User->recursive = -1;
        if (empty($redata)) {
            $response['isSucess'] = 'false';
            $response['msg'] = 'Please Provide Your Username that You used to register with us';
        } else {
            $fu = $this->User->find('first', array('conditions' => array('User.username' => $username)));
            if ($fu['User']['email']) {
                if ($fu['User']['active'] == "1") {
                    $key = Security::hash(CakeText::uuid(), 'sha512', true);
                    $hash = sha1($fu['User']['email'] . rand(0, 100));
                    $url = Router::url(array('controller' => 'users', 'action' => 'api_resetpwd'), true) . '/' . $key . '#' . $hash;
                    $ms = "Welcome to Mobile
      <b><a href='" . $url . "' style='text-decoration:none'>Click here to reset your password.</a></b><br/>";
                    $fu['User']['tokenhash'] = $key;
                    $this->User->id = $fu['User']['id'];
                    if ($this->User->saveField('tokenhash', $fu['User']['tokenhash'])) {
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Reset Your Password')
                                ->to($fu['User']['email'])->send($ms);
                        $response['isSucess'] = 'true';
                        $response['msg'] = 'Check Your Email ID to reset your password';
                    } else {
                        $response['isSucess'] = 'false';
                        $response['msg'] = 'Error Generating Reset link';
                    }
                } else {
                    $response['isSucess'] = 'false';
                    $response['msg'] = 'This Account is still not Active .Check Your Email ID to activate it';
                }
            } else {
                $response['isSucess'] = 'false';
                $response['msg'] = 'Email ID does Not Exist';
            }
        }
        echo json_encode($response);
        exit;
    }

 

    public function api_resetpwd($token = null) {

        configure::write('debug', 0);
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findBytokenhash($token);
            if ($u) {

                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {

                    if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
                        $this->Session->setFlash("Both the passwords are not matching...", 'flash_success');
                        return;
                    }
                    $this->User->data = $this->data;
                    $this->User->data['User']['email'] = $u['User']['email'];
                    $new_hash = sha1($u['User']['email'] . rand(0, 100)); //created token
                    $this->User->data['User']['tokenhash'] = $new_hash;
                    if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
                        if ($this->User->save($this->User->data)) {
                            $this->Session->setFlash('Password Has been Updated', 'flash_success');
                           // $this->redirect(array('controller' => 'products', 'action' => 'index'));
                        }
                    } else {
                        $this->set('errors', $this->User->invalidFields());
                    }
                }
            } else {

                $this->Session->setFlash('Token Corrupted, Please Retry.the reset link 
                        <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none;
                        background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") 
                        repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;"
                        name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');
            }
        } else {
            $this->Session->setFlash('Pls try again...');
           // $this->redirect(array('controller' => 'pages', 'action' => 'login'));
        }
    }

    
    ////////////////////////////////////////////////////////////

    public function facebook_connect() {  
      configure::write('debug',0);	
        if ($this->request->is('post')) { 
            
            $user_profile = $this->request->data['myid'];
            $invitecode = $this->request->data['invitecode'];

             $imgurl ='https://graph.facebook.com/'.$user_profile["id"].'/picture?width=320&height=320' ; 
             
              $email = $user_profile['email'];
            $parts = explode('@', $email);
            $emailPart = $parts[0];
            $rand_no = rand(111111111,999999999);
            $password = $emailPart.$rand_no;
            $this->request->data['User']['password'] = $password;
	
            $this->request->data['User']['username'] = $user_profile['email'];
            $this->request->data['User']['name'] = $user_profile['name'];
            $this->request->data['User']['email'] = $user_profile['email'];
            $this->request->data['User']['fb_id'] = $user_profile['id'];
            $encodepass  = base64_encode($password); 
            $this->request->data['User']['md_pass'] = $encodepass;   
            
            $this->request->data['User']['image'] =  $imgurl; 
             // generate refferal code of a user 
            if(isset($invitecode)){ 
                $referral_code_exists = $this->User->find('first',array('conditions'=>
                    array(
                        'User.referral_code'=>$invitecode
                        )
                    ));
                $this->request->data['User']['used_referral_code'] = $invitecode;
                
            }else{  
                $this->request->data['User']['used_referral_code'] = '';  
              
            }
            
             if (!$this->User->hasAny(array(
                        'OR' => array('User.username' => $user_profile['email'], 'User.email' => $user_profile['email'])
                    ))) {
                 
                 if($this->request->data['User']['used_referral_code'] != '' && empty($referral_code_exists)){    
                    $response['status'] = false;
                    $response['msg'] = 'Invalid refferal code';
                }else{
                $this->User->create();
                $this->request->data['User']['role'] = 'customer';
                $this->request->data['User']['active'] = 1;
                if ($this->User->save($this->request->data)) {
                    $uid = $this->User->getLastInsertID();
                       
                    $user_referral_code =  substr($user_profile['email'],0,3).rtrim(strtr(base64_encode($uid), '+/', '-_'), '='); 
                    $this->User->id = $this->User->getLastInsertID();
                    $this->User->saveField('referral_code', $user_referral_code);     
                    
                         $url = Router::url(array('controller' => 'Users', 'action' => 'changepassword'), true);
                    
                        
                        $ms = "<b>Hi ".$user_profile['name'].",</b><br/>Welcome to The Button App 
                             <b>Your temporary password is: ".$password." "
                                . "</b> Please create a new password <a href=".$url.">here</a> <br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Registration Successful!!!')->
                         to($this->request->data['User']['email'])->send($ms);
                    
                    $user = $this->User->find('first', array('conditions' => array('email' => $user_profile['email'])));
                    $user_referral_code =  substr($user['User']['username'],0,3).rtrim(strtr(base64_encode($user['User']['id']), '+/', '-_'), '='); 
                    $this->User->id = $this->User->getLastInsertID();
                    $this->User->saveField('referral_code', $user_referral_code);
                    
               
                     if ($user['User']['id']) {
                    $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $password;
                    
                    //  $this->Auth->login();  
                     $response['status']= true;
					 $response['uid']= $user['User']['id'];
                     $response['msg']= "Login successfully ";
                 
                }
                    
                    
                } else {
               
                     $response['status']= false;
                     $response['msg']= "Sorry.Please try again";
                
                  
                }
                    }   
            } else {
                $user = $this->User->find('first', array('conditions' => array('email' => $user_profile['email'])));
                
                if($user['User']['fb_id'] != NULL){
                          if ($user['User']['id']) {
                              
                   $img = $imgurl;
                   $this->User->updateAll(array('User.image' => "'$img'"), array('User.email' => $user_profile['email']));
                              
                    $pass = $user['User']['md_pass'];
                     $decodepass = base64_decode($pass); 
                   $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $decodepass;
                    
                      //$this->Auth->login();  
                      $response['status']= true;
		      $response['uid']= $user['User']['id'];
                     $response['msg']= "Login";
                
                     }
                }else{
                     $response['msgs']= " null fb";
                      $fbid = $user_profile['id'];
                     //$this->User->saveField('fb_id', $user_profile['id']);
                    // $this->Session->setFlash('This email is already registered.', 'default', array('class' => 'msg_req'));
                     $img = $imgurl;
                     $this->User->updateAll(array('User.image' => "'$img'",'User.fb_id' => "$fbid"), array('User.email' => $user_profile['email']));  
                     $pass = $user['User']['md_pass'];
                     $decodepass = base64_decode($pass); 
               
                     $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $decodepass; 
                    
                      //$this->Auth->login(); 
                     $response['status']= true;
		     $response['uid']= $user['User']['id'];
                     $response['msg']= "Login";
                   
                }
                //$this->User->id = $user['User']['id'];
                // $this->User->saveField('image', $this->request->data['User']['image']);
                //$response['isSucess'] = 'true';
                //$response['data'] = $user;
            } 

        } else {
		
             $response['status']= false;
             $response['msg']= "Sorry. Please try again";
        }
        
        echo json_encode($response);
        exit;
    } 


 
     public function getrandom(){ 
         $random = $this->User->find('all', array(
                'order' => 'rand()'
                ));

         echo json_encode($random[0]['User']['name']);
         exit;
     }

}
 