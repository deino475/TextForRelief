    <div id="modal1" class="modal">
      <div class="modal-content">
        <h4 style = "text-align: center;">Input a New Shelter</h4>
        <form action = "" method = "POST">
          <div class="">
            <div class="row">
              <div class="input-field col s12">
                <input id="shelter_name" type="text" class="validate" name = "shelter_name">
                <label for="shelter_name">Name of the Shelter</label>
              </div>
              <div class="input-field col s12">
                <input id="street_name" type="text" class="validate" name = "street_name">
                <label for="street_name">Street</label>
              </div>
              <div class="input-field col s6">
                <input id="city_name" type="text" class="validate" name = "city_name">
                <label for="city_name">City</label>
              </div>
              <div class="input-field col s6">
                <input id = "state_name" type = "text" name = "state_name">
                <label for="state_name">State</label>
              </div>
              <div class="input-field col s6">
                <input id = "zip_code" type = "text" class = "validate" name = "zip_code">
                <label for = "zip_code">Zip Code</label>
              </div>
              <div class="input-field col s6">
                <input id = "active_shelter" type = "text" class = "validate" name = "active_shelter">
                <label for="active_shelter">Active Shelter?</label>
              </div>
              <div class="input-field col s6">
                <input id = "latitude" type = "text" class = "validate" name = "latitude">
                <label for = "latitude">Latitude</label>
              </div>
              <div class="input-field col s6">
                <input id = "longitude" type = "text" class = "validate" name = "longitude">
                <label for="longitude">Longitude</label>
              </div>
            </div>
          </div>
          <button class = "btn-floating" title = "Add a shelter" name = "submit"><i class="material-icons">add</i></button>
        </form>
      </div>
    </div>        