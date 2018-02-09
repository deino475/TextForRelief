    <table class = "bordered highlight">
      <thead>
        <tr>
          <th>Name of the Organization</th>
          <th>Street Name</th>
          <th>City</th>
          <th>State</th>
          <th>Zip Code</th>
          <th>Available</th>
          <th>Latitude</th>
          <th>Longitude</th>
        </tr>
      </thead>
      <tbody id = "shelter-table">
      </tbody>
    </table>
    <script type="text/javascript">
      var xhttp = new XMLHttpRequest();
      var updater = new XMLHttpRequest();

      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var data_to_add = JSON.parse(this.responseText);
          var table_area = document.getElementById('shelter-table');
          for (var i = 0; i < data_to_add.length; i++) {
            table_area.innerHTML += '<tr> \
            <td><div contenteditable = "true" class = "changeable" id = "' + data_to_add[i]['shelter_id']+':name">' + data_to_add[i]['shelter_name'] + '</div></td> \
            <td><div contenteditable = "true" class = "changeable" id = "' + data_to_add[i]['shelter_id']+':street">' + data_to_add[i]['street_name'] + '</div></td> \
            <td><div contenteditable = "true" class = "changeable" id = "' + data_to_add[i]['shelter_id']+':city">' + data_to_add[i]['city_name'] + '</div></td> \
            <td><div contenteditable = "true" class = "changeable" id = "' + data_to_add[i]['shelter_id']+':state">' + data_to_add[i]['state_name'] + '</div></td> \
            <td><div contenteditable = "true" class = "changeable" id = "' + data_to_add[i]['shelter_id']+':zip">' + data_to_add[i]['zip_code'] + '</div></td> \
            <td><div contenteditable = "true" class = "changeable" id = "' + data_to_add[i]['shelter_id']+':available">' + data_to_add[i]['available'] + '</div></td> \
            <td><div contenteditable = "true" class = "changeable" id = "' + data_to_add[i]['shelter_id']+':lat">' + data_to_add[i]['lat'] + '</div></td> \
            <td><div contenteditable = "true" class = "changeable" id = "' + data_to_add[i]['shelter_id']+':lng">' + data_to_add[i]['lng'] + '</div></td> \
            </tr>';
          }
        }
        var editables = document.getElementsByClassName("changeable");
        for (var i = 0; i < editables.length; i++) {
          editables[i].addEventListener("blur", function(){
            var element_id = this.id;
            var my_id = element_id.split(":")[0];

            /* Get row contents */
            var name_contents = document.getElementById(my_id + ":name").innerHTML;
            var street_contents = document.getElementById(my_id + ":street").innerHTML;
            var city_contents = document.getElementById(my_id + ":city").innerHTML;
            var state_contents = document.getElementById(my_id + ":state").innerHTML;
            var zip_contents = document.getElementById(my_id + ":zip").innerHTML;
            var available_contents = document.getElementById(my_id + ":available").innerHTML;
            var lat_contents = document.getElementById(my_id + ":lat").innerHTML;
            var lng_contents = document.getElementById(my_id + ":lng").innerHTML;

            /* Update table row */
            updater.open("POST", "?m=/send", true);
            updater.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            updater.send("shelter_id="+my_id+"&shelter_name="+name_contents+"&street_name="+street_contents+"&city_name="+city_contents+"&state_name="+state_contents+"&zip_code="+zip_contents+"&available="+available_contents+"&lat="+lat_contents+"&lng="+lng_contents);
          });
        }
      };
      xhttp.open("GET", "?m=/get/json", true);
      xhttp.send(); 
    </script>