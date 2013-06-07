      <div class="row-fluid">
        <div class="span4">
          <div class="row-fluid">
            <div class="span6">
              <div class="profile-image" style="border: 1px solid #ccc; width: 100%;">
                <img src="" />
              </div>
            </div>
            <div class="span6">
              <div class="profile-data">
                <h4 style="margin: 0;"><?php echo $user->getFirstName(); ?> <?php $user->getLastName(); ?></h4>
                <p>Chicago, IL</p>
                <p><i class="icon-pencil"></i> <a href="#" onclick="profile.edit()">Edit Profile</a></p>
              </div>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span12">
              <div class="profile-recent-activity" style="border: 1px solid #ccc; width: 100%; min-height: 400px;">
                <h4>Recent Activity</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="span8">
          <div class="chitchat">
            <ul style="margin: 0; list-style-type: none; padding: 5px;">
              <li style="display: inline-block; width: 15%; vertical-align: top; margin-right: 5px;">
                <div style="height: 40px; width: 100%; border: 1px solid #ccc;"></div>
              </li>
              <li style="display: inline-block; width: 75%; position: relative; border-bottom: 1px solid #ccc;">
                <strong>Local Business Name</strong><br />Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                <div style="position: absolute; top: 0px; right: 5px; color: #666;">12:45 pm</div>
              </li>
              <li>
                <ul style="margin-left: 15%; list-style-type: none; border-bottom: 1px solid #ccc; padding: 5px;">
                  <li style="display: inline-block; width: 17%; vertical-align: top; margin-right: 5px;">
                    <div style="height: 40px; width: 100%; border: 1px solid #ccc;"></div>
                  </li>
                  <li style="display: inline-block; width: 72%;"><strong>Local Business Name</strong><br />Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                </ul>
              </li>
            </ul>
            <ul style="margin: 0; list-style-type: none; border-bottom: 1px solid #ccc; padding: 5px;">
              <li style="display: inline-block; width: 15%; vertical-align: top; margin-right: 5px;">
                <div style="height: 40px; width: 100%; border: 1px solid #ccc;"></div>
              </li>
              <li style="display: inline-block; width: 75%;"><strong>Local Business Name</strong><br />Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
            </ul>
          </div>
        </div>
      </div>
