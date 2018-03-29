<div class = "row">
	<div class = "col l2">
		<h4 class = "center-align blue-text">Task Bar</h4>
		<ul class = "collection">
			<li class = "collection-item grey lighten-4"><a class = "modal-trigger" href="#modal2" title = "Add a shelter">Add a User</a></li>
			<li class = "collection-item grey lighten-4"><a class = "modal-trigger" href="#modal3" title = "Add a plugin">Add a Plugin</a></li>
		</ul>
	</div>
	<div class = "col l10">
		<?php if (isset($data['message'])){ echo $data['message']; } ?>
		<h4 class = "center-align blue-text">Users</h4>
		<table class = "bordered highlight">
			<thead>
				<tr>
					<td>Name</td>
					<td>Email</td>
					<td>Delete User</td>
				</tr>
			</thead>
			<?php if (isset($data['users'])) {?>
				<?php foreach ($data['users'] as $user) {?>
					<tr>
						<td><?php echo $user['user_name'];?></td>
						<td><?php echo $user['email'];?></td>
						<td>
							<form action = "" method = "POST"><input type = "hidden" name = "user-id" value = "<?php echo $user['user_id'];?>">
            					<button class = "btn" name = "delete-user" id = "delete-user"><i class = "material-icons left">delete</i></button>
            				</form>
            			</td>
					</tr>
				<?php }?>
			<?php } ?>
		</table>
		<br>
		<h4 class = "center-align blue-text">Plugins</h4>
		<table class = "bordered highlight">
			<thead>
				<tr>
					<td>Plugin Name</td>
					<td>Activate</td>
					<td>Delete Plugin</td>
				</tr>
			</thead>
			<?php if (isset($data['plugins'])) {?>
				<?php foreach ($data['plugins'] as $plugin) {?>
					<tr>
						<td><?php echo $plugin['plugin_name'];?></td>
						<td>
							<div class="switch">
							    <label>
							      Off
							      <input type="checkbox" class = "toggle_plugin" value = "<?php echo $plugin['plugin_id'];?>" <?php if ($plugin['active'] == 1){echo "checked";}?>>
							      <span class="lever"></span>
							      On
							    </label>
						  	</div>  
						</td>
						<td>
							<form action = "" method = "POST"><input type = "hidden" name = "plugin-id" value = "<?php echo $plugin['plugin_id'];?>">
            					<button class = "btn" name = "delete-plugin" id = "delete-plugin"><i class = "material-icons left">delete</i></button>
            				</form>
            			</td>
					</tr>
				<?php }?>
			<?php } ?>
		</table>
	</div>
</div>    
<div id="modal2" class="modal">
    <div class="modal-content">
        <h4 style = "text-align: center;">Input a New User</h4>
        <form action = "" method = "POST">
          <div class="">
            <div class="row">
              <div class="input-field col s12">
                <input id="user_name" type="text" class="validate" name = "user_name">
                <label for="user_name">User Name</label>
              </div>
              <div class="input-field col s12">
                <input id="user_email" type="email" class="validate" name = "user_email">
                <label for="user_email">User Email</label>
              </div>
            </div>
          </div>
          <button class = "btn-floating" title = "Add a user" name = "submit_user"><i class="material-icons">add</i></button>
        </form>
      </div>
    </div>      
   <div id="modal3" class="modal">
    <div class="modal-content">
        <h4 style = "text-align: center;">Upload a Plugin</h4>
        <form action = "" method = "POST" enctype="multipart/form-data">
          <div class="">
            <div class="row">
              <div class=" input-field col s12">
                <input id="plugin_name" type="text" class="validate" name = "plugin_name">
                <label for="plugin_name">Plugin Name</label>
              </div>
              <div class="file-field input-field col s12">
                <div class="file-field input-field">
			      <div class="btn">
			        <span>Plugin File</span>
			        <input type="file" name = "extension">
			      </div>
			      <div class="file-path-wrapper">
			        <input class="file-path validate" type="text">
			      </div>
			    </div>
              </div>
            </div>
          </div>
          <button class = "btn-floating" title = "Add a plugin" name = "submit_plugin"><i class="material-icons">add</i></button>
        </form>
      </div>
    </div>          
    <script type="text/javascript">
    	var updater = new XMLHttpRequest();
    	var toggleable = document.getElementsByClassName("toggle_plugin");
        for (var i = 0; i < toggleable.length; i++) {
          toggleable[i].addEventListener("click", function(){
            var element_id = this.value;
            var check_val = 0;
            if (this.checked) {
            	check_val = 1;
            }
            /* Update table row */
            updater.open("POST", "?m=/plugin-toggle", true);
            updater.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            updater.send("id="+element_id+"&checked="+check_val);
          });
        }
    </script>