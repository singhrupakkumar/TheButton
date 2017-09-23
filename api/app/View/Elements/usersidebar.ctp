<div class="col-md-2"> 
        <!-- @TODO: Unify these two menus. -->
        <div class="hidden-xs hidden-sm" id="user-nav">
          <div class="panel panel-default">
          
            <div class="panel-heading">
              <h3>Account </h3>
            </div>
            <div>
              <div class="list-group"> 
                  <a class="active list-group-item" href="/users/profile">Account Info</a> 
                  <a class="list-group-item" href="/users/reminders">Reminders</a>
                  <a class="list-group-item" href="/inbox"> Inbox </a>
                  <a class="list-group-item" href="/users/credits">Wallet</a>
                  <a class="list-group-item" href="/users/share_and_earn">Share &amp; Earn</a>
                  <a class="list-group-item" href="<?php echo $this->webroot.'users/logout'; ?>">Sign Out</a> </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3>Purchases</h3>
            </div>
            <div>
              <div class="list-group"> <a class="list-group-item" href="/invoices"> <span class="badge">1</span> My Orders </a> </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3>Help &amp; Support</h3>
            </div>
            <div>
              <div class="list-group"> <a class="list-group-item" href="/support/new">Contact Us</a> <a class="list-group-item" href="/topics">FAQs</a> </div>
            </div>
          </div>
        </div>
        <div class="panel-group visible-xs visible-sm" id="responsive-user-nav">
          <div class="panel panel-default">
            <div class="panel-heading"> <a data-parent="#responsive-user-nav" data-toggle="collapse" href="#list-group-account"> <span class="right5">Account</span> <span class="fa fa-caret-right"></span> <span class="fa fa-caret-down" style="display: none"></span> </a> </div>
            <div class="panel-collapse collapse" id="list-group-account">
              <div class="list-group">
                  <a class="active list-group-item" href="/users/profile">Account Info</a>
                  <a class="list-group-item" href="/users/reminders">Reminders</a> 
                  <a class="list-group-item" href="/inbox"> Inbox </a> <a class="list-group-item" href="/users/credits">Wallet</a>
                  <a class="list-group-item" href="/users/share_and_earn">Share &amp; Earn</a>
                  <a class="list-group-item" href="<?php echo $this->webroot.'users/logout'; ?>">Sign Out</a> </div>  
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading"> <a data-parent="#responsive-user-nav" data-toggle="collapse" href="#list-group-purchases"> <span class="right5">Purchases</span> <span class="fa fa-caret-right"></span> <span class="fa fa-caret-down" style="display: none;"></span> </a> </div>
            <div class="panel-collapse collapse" id="list-group-purchases">
              <div class="list-group"> <a class="list-group-item" href="/invoices"> <span class="badge">1</span> My Orders </a> </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading"> <a data-parent="#responsive-user-nav" data-toggle="collapse" href="#list-group-support"> <span class="right5">Help &amp; Support</span> <span class="fa fa-caret-right"></span> <span class="fa fa-caret-down" style="display: none;"></span> </a> </div>
            <div class="panel-collapse collapse" id="list-group-support">
              <div class="list-group"> <a class="list-group-item" href="/support/new">Contact Us</a> <a class="list-group-item" href="/topics">FAQs</a> </div>
            </div>
          </div>
        </div>
      </div>