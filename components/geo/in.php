<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<body>
  <div id="root">
    <h1>Autocomplete Example (#164)</h1>
    <label>
      AutoComplete
      <gmap-autocomplete
        @place_changed="setPlace">
      </gmap-autocomplete>
      <button @click="usePlace">Add</button>
    </label>
    <br/>

    <Gmap-Map :center="changingCenter" :zoom="changingZoom" class="map-container">
      <Gmap-Marker v-for="(marker, index) in markers"
        :key="index"
        :position="marker.position"
        :clickable="true"
        :draggable="true"
        ></Gmap-Marker>
      <Gmap-Marker
        v-if="this.center"
        label="&#x2605;"
        @click="mark"
        :position="{
          lat: this.center.lat,
          lng: this.center.lng,
        }"
        ></Gmap-Marker>
    </Gmap-Map>
    <ul>
      <li v-for="(item, index) in markers">
 {{ index }} - {{ item.position }}
  </li>
    </ul>



  </div>

  <script src="lib/vue.js"></script>
  <script src="lib/axios.js"></script>
  <script src="lib/googleMap.js"></script>
  <script src="lib/lodash.js"></script>


<script>
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAE6lL8yeY_7T4ifK-pEWhkKE7UNn4Zvw4',
    libraries: 'places'
  },
});
document.addEventListener('DOMContentLoaded', function() {
  Vue.component('google-map', VueGoogleMaps.Map);
  Vue.component('google-marker', VueGoogleMaps.Marker);
  new Vue({
    el: '#root',
    data: {
      markers: [],
      place: null,
      api:[],
      center:null
    },
    methods: {
      setDescription(description) {
        this.description = description;
      },
      setPlace(place) {
        this.place = place
        // console.log(this.place.geometry.location.lat());
      },
      usePlace() {
        // if (this.place) {
        //   console.log(place);
        //   this.markers.push({
        //     position: {
        //       lat: this.place.geometry.location.lat(),
        //       lng: this.place.geometry.location.lng(),
        //     }
        //   })
             if (this.place) {
          console.log(this.place);
          this.center=null;
          this.center={
              lat: this.place.geometry.location.lat(),
              lng: this.place.geometry.location.lng(),
          }
          console.log(this.center);

  // fetch("http://localhost/zahid_api/components/geo/geodata.php",{lat: this.place.geometry.location.lat(),
  //    lng: this.place.geometry.location.lng()}

  // )
  //       .then(response => response.json())
  //       .then((data) => {
  //         this.markers = data.data;
  //         console.log(this.markers)
  //       })

          // this.place = null;
        // }
        }
      },
      mark(){
        console.log("clicked");
      }

    }
  });
});
</script>

</body>
</body>
</html>


