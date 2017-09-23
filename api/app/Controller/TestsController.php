<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property Customer $Customer Description
 * @property Combination $Combination Description
 * @property PhpExcel $PhpExcel Description
 */
class TestsController extends AppController {

    public $components = array('Paginator', 'Session', 'PhpExcel');
    public $helpers = array('PhpExcel');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('index', 'mail', 'genpass', 'updatereviewkey', 'createThali',
            'renderThali', 'update_profiles','dowloadexcel','dowloadexcelbyid'));
    }

    public function index() {
        $indexInfo['description'] = "App User Registration(post method)(2-d array) ";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/users/registration";
        $indexInfo['parameters'] = '<b>data[User][username] - </b>Username<br>
		<b>data[User][email] - </b> User email<br>
                <b>data[User][name] - </b>Name<br>  
		<b>data[User][password] - </b>Password<br>
                <!--b>data[User][image] - </b>Image<br-->
                <b>data[User][phone] - </b>Contact-No<br>
		<!--b>data[User][device_token] - </b>device token<br-->
                <!--b>data[User][latitude] - </b>Latitude<br-->
                <!--b>data[User][longitude] - </b>Longitude<br-->';
        $indexarr[] = $indexInfo;


        $indexInfo['description'] = "App User Login(post method)(2-d array) ";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/users/login";
        $indexInfo['parameters'] = '<b>data[User][username] - </b>Username<br>
		<b>data[User][password] - </b>Password<br
		<b>data[User][device_token] - </b>device token<br>';
        $indexarr[] = $indexInfo;


        $indexInfo['description'] = "App User Update(post method)(2-d array) ";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/users/editprofile/(user_id)";
        $indexInfo['parameters'] = '<b>data[User][username] - </b>Username<br>
		<b>data[User][email] - </b> User email<br>
                <b>data[User][name] - </b>Name<br>
		<b>data[User][password] - </b>Password<br>
                <b>data[User][image] - </b>Image<br>
                <b>data[User][phone] - </b>Contact-No<br>';
        $indexarr[] = $indexInfo;

        $indexInfo['description'] = "App Single User Record";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/users/user/(user_id)";
        $indexInfo['parameters'] = '';
        $indexarr[] = $indexInfo;

        $indexInfo['description'] = "App All User Record";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/users/alluser";
        $indexInfo['parameters'] = '';
        $indexarr[] = $indexInfo;

        $indexInfo['description'] = "App User Forget Password(post method)(2-d array) ";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/users/forgetpwd";
        $indexInfo['parameters'] = '<b>data[User][email] - </b> User email<br>';
        $indexarr[] = $indexInfo;


        $indexInfo['description'] = "App User Logout";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/users/logout";
        $indexInfo['parameters'] = '';
        $indexarr[] = $indexInfo;

        $indexInfo['description'] = "App Get Restaurant list ";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/restaurants/restaurantslist";
        $indexInfo['parameters'] = '
                 <b>Restaurant[latitude] - </b> 0<br>
                   <b>Restaurant[longitude] - </b> 0<br>';
        $indexarr[] = $indexInfo;

        $indexInfo['description'] = "App Get Restaurant list by address ";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/api/restaurants/restaurantslistbyadd";
		
 
   $indexInfo['parameters'] = '<b>address: - </b> 0<br>';
        $indexarr[] = $indexInfo;

      /*   $indexInfo['description'] = "App View All Post ";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/posts";
        $indexInfo['parameters'] = '';
        $indexarr[] = $indexInfo; */
       
   	   $indexInfo['description'] = "App Order History ";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/shop/orderHistory";
       
		$indexInfo['parameters'] = ' <b>[User] [id] </b> 0<br>';
        $indexarr[] = $indexInfo;

		$indexInfo['description'] = "Display Cart ";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/shop/displaycart";

        $indexInfo['parameters'] = '<b>[User] [id] </b> uid <br>
		  <b>[User] [SnId] </b> sid <br>';
        $indexarr[] = $indexInfo;
		
		$indexInfo['description'] = "Remove Cart items ";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/shop/removeitems";
		  
        $indexInfo['parameters'] = '<b>[Cart] [id] </b> id <br>';
        $indexarr[] = $indexInfo;
		
		$indexInfo['description'] = "Get Restaurant menu ";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/restaurants/getresmenu";
		  
        $indexInfo['parameters'] = '<b>[Restaurant] [id] </b> id <br>';
        $indexarr[] = $indexInfo;
		
		$indexInfo['description'] = "CheckOut";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/restaurants/getresmenu";
		  
        $indexInfo['parameters'] = '<b>[User] [id] </b> id <br>
		  <b>[User] [snid] </b> snid <br>
		  <b>[products] [prod] </b> cart <br>
		  <b>[address] [billing] </b> billing_addr <br>
		  <b>[address] [shipping] </b> shipping_addr <br>
		  <b>[payment] [mode] </b>  <br>
		  <b>[payment] [total] </b> shipping_addr <br>';
        $indexarr[] = $indexInfo;
		
		$indexInfo['description'] = "TableReservation";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/shop/tablesucess";
		 
        $indexInfo['parameters'] = ' <b>[Table] [rid] </b> restaurant id <br>
		  <b>[Table] [fname] </b> firstname <br>
		  <b>[Table] [lname] </b> lastname <br>
		  <b>[Table] [number] </b> Table Number <br>
		  <b>[Table] [date.] </b> Date. <br>
		  <b>[Table] [time] </b> Time.   <br>
		  <b>[Table] [email] </b> Email id <br>';
        $indexarr[] = $indexInfo;
		
		$indexInfo['description'] = "TableReservation";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/shop/tablesucess";
		
        $indexInfo['parameters'] = '  <b>[Table] [rid] </b> restaurant id <br>
		  <b>[Table] [fname] </b> firstname <br>
		  <b>[Table] [lname] </b> lastname <br>
		  <b>[Table] [number] </b> Table Number <br>
		  <b>[Table] [date.] </b> Date. <br>
		  <b>[Table] [time] </b> Time.   <br>
		  <b>[Table] [email] </b> Email id <br>';
        $indexarr[] = $indexInfo;
		
		$indexInfo['description'] = "App User Post Review";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/shop/review";
		  
        $indexInfo['parameters'] = '<b>[Review] [uid] </b> user id <br>
		  <b>[Review] [text] </b> text <br>
		  <b>[Review] [name] </b> name <br>
		  <b>[Review] [email] </b> emailid <br>
		  <b>[Review] [food_quality] </b> food_quality <br>
		  <b>[Review] [price] </b> Price   <br>
		  <b>[Review] [punctuality] </b> punctuality <br>
		  <b>[Review] [courtesy] </b> courtesy <br>';
        $indexarr[] = $indexInfo;
		
		$indexInfo['description'] = "Add to Cart";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/shop/cart";
		  
		$indexInfo['parameters'] = '<b>[Product] [id] </b> Product id <br>
		  <b>[User] [id] </b> User id <br>
		  <b>[Quantity] [qty] </b> Quantity <br>
		  <b>[SnId] [sid] </b> SessionId <br>';
        $indexarr[] = $indexInfo;
			
			
		$indexInfo['description'] = "Add Remove Cart Items";
        $indexInfo['url'] = FULL_BASE_URL . $this->webroot . "api/shop/addremovecart";
		 
		  
		$indexInfo['parameters'] = ' <b>[Cart] [id] </b> Cart id <br>';
        $indexarr[] = $indexInfo;
			
			
        $this->set('IndexDetail', $indexarr);
    }

    public function mail() {
        $this->loadModel('Order');
        $x = $this->Order->find("all", array(
            "conditions" => array(
                //"Order.id" => 169,
                "Order.sku" => "I5KP9X7Q"
            ),
            "contain" => array("Address", "Combination", "Combination.Vendor")
        ));
        App::uses("CakeEmail", "Network/Email");
        $fm = new CakeEmail('smtp');
        $viewVars = array(
            'id_o' => $x[0]['Order']['sku'],
            'name' => $x[0]['Address']['f_name'] . " " . $x[0]['Address']['l_name'],
            'mob' => $x[0]['Address']['phone_number'],
            'address' => $x[0]['Address']['address'],
            'orders' => $x
        );
        $fm->to("pickmeals@gmail.com")
                ->cc("himan.verma@live.com")
                ->viewVars($viewVars)
                ->from("no-reply@pickmeals.com", "PickMeals.com")
                ->replyTo("support@pickmeals.com", "PickMeals.com")
                ->subject("New Order on PickMeals.com (ID :" . $x[0]['Order']['sku'] . ")")
                ->template("referal")
                ->emailFormat('html');
        try {
            $x = $fm->send();
        } catch (SocketException $e) {
            debug($e);
        }
        exit;
    }

    public function genpass() {
        //debug(AuthComponent::user());
        //exit;

        $this->loadModel('Customer');
        $x = $this->Customer->find('all', array('recursive' => -1));
        foreach ($x as $v) {
            $this->Customer->updateAll(array(
                //'Customer.password' => "'".Security::hash($v['Customer']['id'].$v['Customer']['email'])."'"
                'Customer.password' => "'" . AuthComponent::password('pickm') . "'"
                    ), array(
                'Customer.id' => $v['Customer']['id']
            ));
        }
        exit;
    }

    public function updatereviewkey() {
        //combination_reviewkey	
        $this->loadModel('Combination');
        $x = $this->Combination->find("all");
        foreach ($x as $v) {
            $this->Combination->updateAll(array(
                'Combination.reviewkey' => "'" . $v['Combination']['vendor_id'] . "_" . $v['Combination']['display_name'] . "'"
                    ), array(
                'Combination.id' => $v['Combination']['id']
            ));
        }
        exit;
    }

    public function createThali($dishArray = array(), $w = 140, $h = 0) {
        Configure::write('debug', 2);

        ini_set("max_execution_time", -1);

        $thali = new Imagick("tmpl/img/thali.png");
        $mask_1 = new Imagick("tmpl/img/thali-mask1.png");
        $mask_2 = new Imagick("tmpl/img/thali-mask2.png");
        $mask_3 = new Imagick("tmpl/img/thali-mask3.png");
        $mask_4 = new Imagick("tmpl/img/thali-mask4.png");
        $mask_5 = new Imagick("tmpl/img/thali-mask5.png");


        if (!is_array($dishArray)) {
            return false;
        }

        $mask_cnt = 0;

        foreach ($dishArray as $dish) {
            if ($mask_cnt > 4) {   // Mask Locking (Modify if masks will be increased or decreased)
                break;
            }
            $dish = new Imagick($dish);
            if ($mask_cnt + 1 == 5) {
                $dish = new Imagick("tmpl/dishes/rice.jpg"); // Fixed Rice for Mask No. 1
            }

            $dish->scaleimage($thali->getimagewidth(), $thali->getimageheight()); // Set As per bowl image

            $dish->compositeimage(new Imagick("tmpl/img/thali-mask" . ($mask_cnt + 1) . ".png"), \Imagick::COMPOSITE_COPYOPACITY, 0, 0, Imagick::CHANNEL_ALPHA);
            $dish->mergeimagelayers(Imagick::LAYERMETHOD_COALESCE);

            $thali->compositeimage($dish, \Imagick::COMPOSITE_ATOP, 0, 0, Imagick::CHANNEL_ALPHA);
            $thali->mergeimagelayers(Imagick::LAYERMETHOD_COALESCE);

            $mask_cnt++;
        }




        $thali->setimageformat("jpg");
        $thali->setImageFileName($url = "files/thali_images/" . $this->randomString(6) . "-Thali.jpg");
//    $thali->setinterlacescheme(\Imagick::INTERLACE_PNG);
        $thali->scaleimage($w, $h);
        $thali->writeimage();
        $thali->destroy();
        return $url;
    }

    public function renderThali() {
        $dishes = array(
            "tmpl/dishes/bhindi-fried.jpg",
            "tmpl/dishes/dal-makhani.jpg",
            "tmpl/dishes/paneer-do-pyaza.jpg",
            "tmpl/dishes/paneer.jpg",
        );

        $this->loadModel("Combination");
        $x = $this->Combination->find("all");
        App::uses("HtmlHelper", "View/Helper");
        $html = new HtmlHelper(new View());
        foreach ($x as $v) {
            shuffle($dishes);

            $this->Combination->updateAll(array(
                "Combination.image" => "'" . $html->url("/" . $this->createThali($dishes, 150), true) . "'"
                    ), array(
                "Combination.id" => $v['Combination']['id']
            ));
        }







//        shuffle($dishes);
//        echo '<img src="/'.$this->createThali($dishes, 150).'" align="left" />';
//        
//        shuffle($dishes);
//        echo '<img src="/'.$this->createThali($dishes, 150).'" align="left" />';
//        
//        shuffle($dishes);
//        echo '<img src="/'.$this->createThali($dishes, 150).'" align="left" />';
//        
//        shuffle($dishes);
//        echo '<img src="/'.$this->createThali($dishes, 150).'" align="left" />';
//        
//        shuffle($dishes);
//        echo '<img src="/'.$this->createThali($dishes, 150).'" align="left" />';
//        
//        shuffle($dishes);
//        echo '<img src="/'.$this->createThali($dishes, 150).'" align="left" />';
//        
//        exit;
    }

    public function size() {
                        $email = new CakeEmail();
                        $email->from('restaurants@test.com')
                                //->cc(Configure::read('Settings.ADMIN_EMAIL'))
                                ->cc('ashutosh@avainfotech.com')
                                ->to('ashutosh@avainfotech.com')
                                ->subject('Shop Order')
                                ->template('order')
                                ->emailFormat('html')
                                ->viewVars(array('shop' => "sdsss"))
                                ->send('html');
        exit;
    }

    public function getxorder() {
        ini_set('memory_limit', '-1');
        Configure::write('debug', 0);
        require '../Vendor/PhpExcel/PHPExcel.php';
        define( 'PCLZIP_TEMPORARY_DIR', '../tmp/' );
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        $this->loadModel('Order');
        $x = $this->Order->find("all",array(
           "contain" =>  array(
               "Address",
               "Combination",
               "Combination.Vendor",
               "Customer"
           ),
           "order" => "Order.id DESC"
        ));
//        debug($x);
//        exit;
        // create new empty worksheet and set default font
        $this->PhpExcel->createWorksheet()
                ->setDefaultFont('Calibri', 12);
        $this->PhpExcel->getSheet()->setTitle("Orders");
        
// define table cells
        $table = array(
            array('label' => __('Used Discount'), 'filter' => true),
            array('label' => __('Vendor Name'), 'filter' => true),
            array('label' => __('Combination (Dish)'), 'filter' => true),
            array('label' => __('Essentials'), 'filter' => true),
            array('label' => __('Price')),
            array('label' => __('Paid Amount')),
            array('label' => __('Quantity')),
            array('label' => __('Customer ID'), 'filter' => true),
            array('label' => __('Customer Name'), 'filter' => true),
            array('label' => __('Contact No.'), 'width' => 20, 'wrap' => true),
            array('label' => __('Payment Method')),
            array('label' => __('Order @'), 'filter' => true),
            array('label' => __('ID'), 'filter' => true),
            array('label' => __('ORDER_ID'), 'filter' => true),
            array('label' => __('Delivery Address'), 'width' => 40, 'wrap' => true),
            
        );

// add heading with different font and bold text
        $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
        
// add data
        foreach ($x as $d) {
            $this->PhpExcel->addTableRow(array(
                $d['Order']['discount_amount'] == 0 ? "NO":"YES",
                @$d['Combination']['Vendor']['name'],
                $d['Order']['recipe_names'],
                $d['Order']['essentials'],
                $d['Combination']['price'],
                ($d['Order']['discount_amount']>=$d['Combination']['price']) ? 0.00 : abs($d['Order']['discount_amount'] - $d['Combination']['price']) ,
                $d['Order']['qty'],
                $d['Order']['customer_id'],
                $d['Address']['f_name']." ".$d['Address']['l_name'],
                $d['Address']['phone_number'],
                $d['Order']['paid_via'],
                date("d-m-Y h:i A",$d['Order']['timestamp']),
                $d['Order']['id'],
                $d['Order']['sku'],
                $d['Address']['address'],
            ));
        }

// close table and output
        $file = $this->PhpExcel->addTableFooter();
        
        $this->PhpExcel->addSheet("Customers");
        
        $table = array(
            array('label' => __('id'), 'filter' => true),
            array('label' => __('Promo Code')),
            array('label' => __('Name'), 'filter' => true),
            array('label' => __('Mobile No.'), 'width' => 50, 'wrap' => true),
            array('label' => __('Registered On'), 'filter' => true),
            array('label' => __('Cash Promo')),
            array('label' => __('Total Orders'))
        );
        $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
        
        $cstDate = array();
        $this->loadModel('Customer');
        $cst = $this->Customer->find('all');
        foreach ($cst as $d) {
            $c = $this->Order->find("count",array(
                "conditions" => array(
                    "Order.customer_id" => $d['Customer']['id']
                )
            ));
            
            $cstDate[@date("d-m-Y",$d['Customer']['registered_on'])][] = $d;
            $this->PhpExcel->addTableRow(array(
                $d['Customer']['id'],
                $d['Customer']['my_promo_code'],
                $d['Customer']['name'],
                $d['Customer']['mobile_number'],
                @date("d-m-Y h:i A",$d['Customer']['registered_on']),
                "Rs. ".$d['Customer']['cash_by_promo'],
                $c
            ));
        }
        $this->PhpExcel->addTableFooter();
        
        
        $odr3 = array();
        $chartData = array();
        foreach($x as $v3){
            $d3 = date("d-m-Y",$v3['Order']['timestamp']);
            $odr3[$d3][] = $v3;
        }
        foreach($odr3 as $kv3 => $cv3){
           $chartData[$kv3]['total'] = count($cv3);
           $repeated = 0;
           $newCount = 0;
           $couponCount = 0;
           foreach($cv3 as $ev3){
               
               $tmp = $this->Order->find("count",array(
                   "conditions" => array(
                       "Order.customer_id" => $ev3['Order']['customer_id']
                   )
               ));
               if($ev3['Order']['discount_amount'] != NULL && $ev3['Order']['discount_amount'] > 0){
                   $couponCount++;
               }
               if(@date("d-m-Y",$ev3['Customer']['registered_on']) == @date("d-m-Y",$ev3['Order']['timestamp'])){
                   $newCount++;
               }
               if($tmp > 1)
                   $repeated++;
           }
           $chartData[$kv3]['repeated'] = $repeated;
           $chartData[$kv3]['newreg'] = isset($cstDate[$kv3])? count($cstDate[$kv3]): 0;
           $chartData[$kv3]['Coupon'] = $couponCount;
           $chartData[$kv3]['new'] = $newCount;
        }
        //echo json_encode($chartData);
        //exit;
        
        $this->PhpExcel->addSheet("Chart 1");
        
        $table = array(
            array('label' => __('Date'), 'filter' => true),
            array('label' => __('Total Orders')),
            array('label' => __('Repeated')),
            array('label' => __('New Registered Customers')),
            array('label' => __('New Orders')),
            array('label' => __('Coupon'), 'filter' => true)
        );
        $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
        $this->loadModel('Customer');
        $cst = $this->Customer->find('all');
        foreach ($chartData as $eK => $eD) {
            
            $this->PhpExcel->addTableRow(array(
                $eK,
                $eD['total'],
                $eD['repeated'],
                $eD['newreg'],
                $eD['new'],
                $eD['Coupon'],
            ));
        }
        $this->PhpExcel->addTableFooter();
        $this->PhpExcel->output();
        exit;
    }
    
    

    public function updatep(){
        $this->loadModel('Customer');
        $this->loadModel('Address');
        $cst = $this->Customer->find("all",array(
           "conditions" => array(
               "Customer.name" => array(""," ")
           ),
            "contain" => false
        ));
        foreach($cst as $c){
            $add = $this->Address->find("first",array(
                "conditions" => array(
                    "Address.customer_id" => $c['Customer']['id']
                ),
                "order" => "Address.id DESC",
                "contain" => false
            ));
            $this->Customer->updateAll(array(
                "Customer.name" => "'".  ucwords($add['Address']['f_name']." ".$add['Address']['l_name'])."'",
            ), array(
                "Customer.id" => $c['Customer']['id']
            ));
        }
        exit;
        
    }
    
    public function mailtest(){
        print_r($this->Session->read('Shop'));
        exit;
//        App::uses('CakeEmail', 'Network/Email');
//        $Email = new CakeEmail('smtp');
//        $Email->from(array('rajdeep@crystalbiltech.com' => 'My Site'));
//        $Email->to('ashutosh@avainfotech.com');
//        $Email->subject('About');
//        $Email->send('My message');
        
    }
    public function dowloadexcel(){  
        ini_set('memory_limit', '-1');
        Configure::write('debug', 2);
        if($this->Session->read('orderexcel')){
          $date= $this->Session->read('orderexcel.date');
          $date1= $this->Session->read('orderexcel.date1');      
        }else {
            $date= "2016-01-01";
            $date1= date('Y-m-d');
        }         
        require '../Vendor/PHPExcel.php';
        define('PCLZIP_TEMPORARY_DIR', '../tmp/');
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);      
         $this->loadModel('Restaurant');
         $this->loadModel('Order');
         $this->loadModel('TableReservation');
         $resdata = $this->Restaurant->find('all');
            $alldata = [];
            foreach ($resdata as $key => $rd) {
         
                $rd['Restaurant']['id'];
                 $alldata['Order'][$key]['commission_del'] = $rd['Restaurant']['commission_del'];
                $alldata['Order'][$key]['commission_qr'] = $rd['Restaurant']['commission_qr'];
                $alldata['Order'][$key]['commission_tr'] = $rd['Restaurant']['commission_tr'];
                $alldata['Order'][$key]['commission_pick'] = $rd['Restaurant']['commission_pick'];
       
                //$alldata['Order'][$key]['name']
                $alldata['Order'][$key]['name'] = $rd['Restaurant']['name'];
                $alldata['Order'][$key]['id'] = $rd['Restaurant']['id'];
                
                
                 $data = $this->Order->find('all', array('conditions' => array('AND'=>array('Order.restaurant_id' => $rd['Restaurant']['id'],'Order.created  BETWEEN ? and ?'=>array($date,$date1)))));
                $alldata['Order'][$key]['table_reservation'] = $this->TableReservation->find('count', array('conditions' => array('AND'=>array('TableReservation.res_id' => $rd['Restaurant']['id'],'TableReservation.created  BETWEEN ? and ?'=>array($date,$date1)))));
                $alldata['Order'][$key]['allorders'] = $alldata['Order'][$key]['table_reservation'] + $this->Order->find('count', array('conditions' => array('AND'=>array('Order.restaurant_id' => $rd['Restaurant']['id'],'Order.created  BETWEEN ? and ?'=>array($date,$date1)))));
                $cnt = count($data);
                $dl = 0;
                $pk = 0;
                $qrc = 0;
                $tble = 0;
                $delivery_total=0;
                $pickup_total=0;
                $qr_total=0;
                for ($i = 0; $i < $cnt; $i++) {

                    if ($data[$i]['Order']['delivery_status'] == 0) {
                        $dl++;
                        $delivery_total+=$data[$i]['Order']['total'];
                    } else if ($data[$i]['Order']['delivery_status'] == 1) {
                        $pk++;
                         $pickup_total+=$data[$i]['Order']['total'];
                    } else if ($data[$i]['Order']['delivery_status'] == 2) {
                        $qrc++;
                        $qr_total+=$data[$i]['Order']['total'];
                    }
                }
                $tresrv=$this->TableReservation->find('all', array('conditions' => array('AND'=>array('TableReservation.res_id' => $rd['Restaurant']['id'],'TableReservation.created  BETWEEN ? and ?'=>array($date,$date1)))));
                $tr_total=0;
                foreach($tresrv as $trd){
                    $tr_total+=$trd['TableReservation']['total'];
                }
                $alldata['Order'][$key]['delivery'] = $dl;
                $alldata['Order'][$key]['pickup'] = $pk;
                $alldata['Order'][$key]['qrcode'] = $qrc;
                $alldata['Order'][$key]['dtotal'] = $delivery_total;
                $alldata['Order'][$key]['ptotal'] = $pickup_total;
                $alldata['Order'][$key]['qrtotal'] = $qr_total;  
                $alldata['Order'][$key]['trtotal'] = $tr_total;  
            }
           
        $this->PhpExcel->createWorksheet()
                ->setDefaultFont('Calibri', 12);
        $this->PhpExcel->getSheet()->setTitle("Orders");
        $table = array(
             array('label' => __('Restaurant Name'), 'filter' => true),
            array('label' => __('Total Delivery Orders'), 'filter' => true),
            array('label' => __('Total Pickup Orders'), 'filter' => true),
            array('label' => __('Total Qrcode Orders'), 'filter' => true),
             array('label' => __('Total Table reservation'), 'filter' => true),
            array('label' => __('All orders'), 'filter' => true),
            array('label' => __('Total Delivery amount'), 'filter' => true),
            array('label' => __('Total Pickup amount'), 'filter' => true),
            array('label' => __('Total Qrcode amount'), 'filter' => true),
            array('label' => __('Total Table Reservation amount'), 'filter' => true),
            array('label' => __('Total Delivery commission'), 'filter' => true),
            array('label' => __('Total Pickup commission'), 'filter' => true),
            array('label' => __('Total Qrcode commission'), 'filter' => true),
             array('label' => __('Total table reservation commission'), 'filter' => true),
                           
        );
        $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));       
        foreach ($alldata['Order'] as $d) {
            $this->PhpExcel->addTableRow(array(
                $d['name'],    
                $d['delivery'],
                $d['pickup'],
                $d['qrcode'],
                $d['table_reservation'],
                $d['allorders'],
                $d['dtotal'],
                $d['ptotal'],
                $d['qrtotal'],
                $d['trtotal'],
               ($d['dtotal']*$d['commission_del'])/100,
               ($d['ptotal']*$d['commission_pick'])/100,
               ($d['qrtotal']*$d['commission_qr'])/100,
               ($d['trtotal']*$d['commission_tr'])/100,
               
            ));
        }
        $file = $this->PhpExcel->addTableFooter();        
        $this->PhpExcel->output();
        exit;
    }
     public function dowloadexcelbyid($id=NULL){  
        ini_set('memory_limit', '-1');
        Configure::write('debug', 2);
        if($this->Session->read('orderexcel')){
          $date= $this->Session->read('orderexcel.date');
          $date1= $this->Session->read('orderexcel.date1');      
        }else {
            $date= "2016-01-01";
            $date1= date('Y-m-d');
        }         
        require '../Vendor/PHPExcel.php';
        define('PCLZIP_TEMPORARY_DIR', '../tmp/');
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);      
         $this->loadModel('Restaurant');
         $this->loadModel('Order');
         $this->loadModel('TableReservation');
         $resdata = $this->Restaurant->find('all',array('conditions'=>array('Restaurant.id'=>$id)));
            $alldata = [];
            foreach ($resdata as $key => $rd) {
         
                $rd['Restaurant']['id'];
                 $alldata['Order'][$key]['commission_del'] = $rd['Restaurant']['commission_del'];
                $alldata['Order'][$key]['commission_qr'] = $rd['Restaurant']['commission_qr'];
                $alldata['Order'][$key]['commission_tr'] = $rd['Restaurant']['commission_tr'];
                $alldata['Order'][$key]['commission_pick'] = $rd['Restaurant']['commission_pick'];
       
                //$alldata['Order'][$key]['name']
                $alldata['Order'][$key]['name'] = $rd['Restaurant']['name'];
                $alldata['Order'][$key]['id'] = $rd['Restaurant']['id'];
                
                
                 $data = $this->Order->find('all', array('conditions' => array('AND'=>array('Order.restaurant_id' => $rd['Restaurant']['id'],'Order.created  BETWEEN ? and ?'=>array($date,$date1)))));
                $alldata['Order'][$key]['table_reservation'] = $this->TableReservation->find('count', array('conditions' => array('AND'=>array('TableReservation.res_id' => $rd['Restaurant']['id'],'TableReservation.created  BETWEEN ? and ?'=>array($date,$date1)))));
                $alldata['Order'][$key]['allorders'] = $alldata['Order'][$key]['table_reservation'] + $this->Order->find('count', array('conditions' => array('AND'=>array('Order.restaurant_id' => $rd['Restaurant']['id'],'Order.created  BETWEEN ? and ?'=>array($date,$date1)))));
                $cnt = count($data);
                $dl = 0;
                $pk = 0;
                $qrc = 0;
                $tble = 0;
                $delivery_total=0;
                $pickup_total=0;
                $qr_total=0;
                for ($i = 0; $i < $cnt; $i++) {

                    if ($data[$i]['Order']['delivery_status'] == 0) {
                        $dl++;
                        $delivery_total+=$data[$i]['Order']['total'];
                    } else if ($data[$i]['Order']['delivery_status'] == 1) {
                        $pk++;
                         $pickup_total+=$data[$i]['Order']['total'];
                    } else if ($data[$i]['Order']['delivery_status'] == 2) {
                        $qrc++;
                        $qr_total+=$data[$i]['Order']['total'];
                    }
                }
                $tresrv=$this->TableReservation->find('all', array('conditions' => array('AND'=>array('TableReservation.res_id' => $rd['Restaurant']['id'],'TableReservation.created  BETWEEN ? and ?'=>array($date,$date1)))));
                $tr_total=0;
                foreach($tresrv as $trd){
                    $tr_total+=$trd['TableReservation']['total'];
                }
                $alldata['Order'][$key]['delivery'] = $dl;
                $alldata['Order'][$key]['pickup'] = $pk;
                $alldata['Order'][$key]['qrcode'] = $qrc;
                $alldata['Order'][$key]['dtotal'] = $delivery_total;
                $alldata['Order'][$key]['ptotal'] = $pickup_total;
                $alldata['Order'][$key]['qrtotal'] = $qr_total;  
                $alldata['Order'][$key]['trtotal'] = $tr_total;  
            }
           
        $this->PhpExcel->createWorksheet()
                ->setDefaultFont('Calibri', 12);
        $this->PhpExcel->getSheet()->setTitle("Orders");
        $table = array(
             array('label' => __('Restaurant Name'), 'filter' => true),
            array('label' => __('Total Delivery Orders'), 'filter' => true),
            array('label' => __('Total Pickup Orders'), 'filter' => true),
            array('label' => __('Total Qrcode Orders'), 'filter' => true),
             array('label' => __('Total Table reservation'), 'filter' => true),
            array('label' => __('All orders'), 'filter' => true),
            array('label' => __('Total Delivery amount'), 'filter' => true),
            array('label' => __('Total Pickup amount'), 'filter' => true),
            array('label' => __('Total Qrcode amount'), 'filter' => true),
            array('label' => __('Total Table Reservation amount'), 'filter' => true),
            array('label' => __('Total Delivery commission'), 'filter' => true),
            array('label' => __('Total Pickup commission'), 'filter' => true),
            array('label' => __('Total Qrcode commission'), 'filter' => true),
             array('label' => __('Total table reservation commission'), 'filter' => true),
                           
        );
        $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));       
        foreach ($alldata['Order'] as $d) {
            $this->PhpExcel->addTableRow(array(
                $d['name'],    
                $d['delivery'],
                $d['pickup'],
                $d['qrcode'],
                $d['table_reservation'],
                $d['allorders'],
                $d['dtotal'],
                $d['ptotal'],
                $d['qrtotal'],
                $d['trtotal'],
               ($d['dtotal']*$d['commission_del'])/100,
               ($d['ptotal']*$d['commission_pick'])/100,
               ($d['qrtotal']*$d['commission_qr'])/100,
               ($d['trtotal']*$d['commission_tr'])/100,
               
            ));
        }
        $file = $this->PhpExcel->addTableFooter();        
        $this->PhpExcel->output();
        exit;
    }
   
}