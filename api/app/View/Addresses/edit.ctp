<div class="con_main pass_gap share_form">
  <div class="container">
    <div class="edit">
      <h2>
        <figure class="form-logo">
          <img src="<?php echo $this->webroot."home/";?>images/thoag-logo.png" alt="" >
        </figure>
      </h2>
      <div class="col-sm-9 col-center">
        <div class="edit_box">     

           <?php echo $this->Form->create('Address', array('id' => 'usereditform','class' => 'jquery-validation')); ?>
					<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title'); 
                echo $this->Form->input('name');
				
				$phone = substr($address['Address']['phone'],5);
				$recipent_mobile = substr($address['Address']['recipent_mobile'],5);

				?>
				<div class="input tel"><label for="AddressPhone" class="active">Phone</label><input name="data[Address][phone]" maxlength="9" value="<?php if(isset($address['Address']['phone'])){ echo $phone; } ?>" id="AddressPhone" type="tel">
				</div>	
				
				<div class="input tel"><label for="AddressRecipentMobile" class="active">Recipent Mobile</label><input name="data[Address][recipent_mobile]" maxlength="9" value="<?php if(isset($address['Address']['phone'])){ echo $recipent_mobile; } ?>" id="AddressRecipentMobile" type="tel"></div>
				<div class="map-locator">
		      <div class="padd-map">   
          <?php echo $this->Form->input('address'); ?>
		 
		      <input id="aalat"  type="hidden">
				  <input id="aalong" type="hidden">
				  <a class="btn btn-primary" id='getlatlongadd' style="" ><img src="<?php echo $this->webroot; ?>img/location.png"></a>
          </div>
			 </div>
			 <div class="map_outer">
				<div id="mapaddress" style="position: absolute; right:-600px;top:0; width:500px;height:300px"></div>
			</div>
                <a href="<?php echo $this->webroot."users/edit" ?>" class="btn btn-danger">Cancel</a>            
<?php echo $this->Form->end(__('Submit')); ?>
         
		<?php echo $this->Form->end(); ?> 
         
 </div> 
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    

    
   
 jQuery.noConflict()(function ($) {   
    
jQuery(document).ready(function() {
	
	jQuery('.map_outer').hide();	
	
	
	
    jQuery("#getlatlongadd").click(function(){
        console.log('clicked')
		jQuery('.map_outer').show();	
        jQuery.post("http://rajdeep.crystalbiltech.com/thoag/eng/restaurants/LatLongFromAddress",
        {
            address: jQuery("#AddressAddress").val()
        },
        function(data, status){
			console.log(data)
            console.log("Data: " + data + "\nStatus: " + status);
            if(status=='success'){
                var res = JSON.parse(data);
                displayMap(res.latitude,res.longitude)
            }
            
        });
    });
	
	    function displayMap(latitude,longitude){
        console.log('display mapaddress')
       // $('#RestaurantLatitude').val(latitude)
       // $('#RestaurantLongitude').val(longitude)
        var myCenter = new google.maps.LatLng(latitude,longitude);
        var mapCanvas = document.getElementById("mapaddress");
        var mapOptions = {center: myCenter, zoom: 15};
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var marker = new google.maps.Marker({position:myCenter,draggable: true});
        marker.setMap(map);
        
        google.maps.event.addListener(marker, 'dragend', function(evt){
            //console.log('dragged')
			//console.log(evt)
			//console.log(marker)
            $('#aalat').val(evt.latLng.lat())
            $('#aalong').val(evt.latLng.lng())
			GetAddress(evt.latLng.lat(),evt.latLng.lng());
            //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        });
    }
	
	
	 function GetAddress(lat,lng) {
            //var lat = parseFloat(document.getElementById("aalat").value);
           // var lng = parseFloat(document.getElementById("aalong").value);
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                       // alert("Location: " + results[1].formatted_address);
					jQuery("#AddressAddress").val(results[1].formatted_address);
						//console.log(results[1].formatted_address)
                    }
                }
            });
        }
	
	
	
	
   
          var editaddressform = jQuery("#usereditform").validate({   
	errorClass: "my-error-class",
   	validClass: "my-valid-class", 
        rules: {
              "data[Address][title]" : { 
                required: true 
                  } 
                 ,"data[Address][phone]": {  
                 number:true,
                minlength: 9,
                maxlength: 9,
                zeronot:true   
                  },
				"data[Address][recipent_mobile]": {  
                 number:true,
                minlength: 9,
                maxlength: 9,
                zeronot:true
                  }
        },
        messages: {
          
          "data[Address][title]": {     
                    required: "Please enter valid title name", 
                },
             "data[Address][phone]": {  
                    required: "Please enter valid number(10 digits)",  
                },
				"data[Address][recipent_mobile]": {    
                    required: "Please enter valid number(10 digits)",  
                }
        }
    });



    $('#editform').on('submit', function () {
    if(editaddressform.form()){ 
     
    } else {  
        return false;  
    }
});



	});
        }); 
  
</script>   
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQrWZPh0mrrL54_UKhBI2_y8cnegeex1o&libraries=places&callback=initAutocomplete"
        async defer></script>                 