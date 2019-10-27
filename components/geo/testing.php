<?php include 'head.php'?>

<div class="inputs">
     <gmap-autocomplete
        @place_changed="changeCenter">
      </gmap-autocomplete>
     <input  type="text" v-model="range" placeholder="range in miles" >

<select v-model="selected">
  <option disabled value="">Please select one</option>
  <option v-for="option in options" v-bind:value="option.value">
    {{ option.text }}
  </option>
</select>
  <!-- {{rateOP}} -->
  <!-- {{by}} -->

<select v-model="rateOP" @change="onCha">
  <option disabled value="">Please select one</option>
  <option v-for="option in rp" v-bind:value="option.value">
    {{ option.text }}
  </option>
</select>

<select  v-if="rateOP !== 'notrated' " v-model="by">
<option disabled value="">Please select one</option>
  <option v-for="option in ob" v-bind:value="option.value">
    {{ option.text }}
  </option>
</select>

<!-- <span>Selected: {{ selected }}</span> -->
     <input  type="text" v-model="query" placeholder="your query" >
      <button class="btn btn-primary" @click="usePlace">Search</button><br>
      <p> Note: you must fulfill all the inputs & select option .your query is optional</p>
</div>



<div class="container-fluid">

  <div class="row">
    <div class="col-md-2 list">

        <!-- <h2>Results</h2> -->
        <hr>
        <div  v-if="selected === 'regular' ">
        <ol>
        <li v-for="(mark,index) in markers" @click="navigate(mark,index)">
          <!-- <h1>Vue is awesome!</h1> -->
         <span>item_name: {{ mark.res.item_name }} </span><br>
         <span> distance: {{ mark.res.Dist }}</span>
         <span> rating: {{mark.res.total}}</span>

        </li>
        </ol>
        </div>

        <div  v-if="selected === 'offer' ">
        <ol>
        <li v-for="(mark,index) in markers" @click="navigate(mark,index)">
          <!-- <h1>Vue is awesome!</h1> -->
         <span>item_name: {{ mark.res.item_name }} </span><br>
         <span> distance: {{ mark.res.Dist }}</span>
         <span> rating: {{mark.res.total}}</span>

        </li>
        </ol>
        </div>
        <div  v-if="selected === 'restaurant' ">
        <ol>
        <li v-for="(mark,index) in markers" @click="navigate(mark,index)">
          <!-- <h1>Vue is awesome!</h1> -->
          <span>restaurant name: {{ mark.res.restaurant_name }} </span><br>
         <span> distance: {{ mark.res.Dist }}</span>
         <span> rating: {{mark.res.total}}</span>

        </li>
        </ol>
        </div>

    </div>

<div class="col-md-7">

<gmap-map :center="changingCenter" :zoom="changingZoom" class="map-container">
 <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false" id="window">



   <ul v-if="selected === 'restaurant'"class="">
    <img :src="infoContent.image" alt="image" id="winImage">
      <li>
       name: {{infoContent.restaurant_name}}
      </li>
      <li>
        avg environment : {{infoContent.env}}
      </li>

      <li>
        avg service : {{infoContent.service}}
      </li>
      <li>
        avg rating : {{infoContent.total}}
      </li>
      <li>
        total raters : {{infoContent.raters}}
      </li>
      <li>
        <a :href ="'restaurant.php?res_id='+infoContent.r_id">check</a>
      </li>
    </ul>
    <ul v-if="selected === 'regular' || selected === 'offer' "class="">
    <img :src="infoContent.i_img" alt="image" id="winImage">
      <li>
       name: {{infoContent.item_name}}
      </li>
      <li>
        price : {{infoContent.price}}
      </li>

      <li>
        avg taste : {{infoContent.taste}}
      </li>
      <li>
        total raters : {{infoContent.I_raters}}
      </li>
      <li>
        avg comparative price : {{infoContent.com_price}}
      </li>
      <li>
        avg rating : {{infoContent.total}}
      </li>

      <li>
        <a :href ="'item.php?item_id='+infoContent.item_id+'&&res_id='+infoContent.r_id">check</a>
      </li>
    </ul>

    <!-- v-link="'people/edit/' + item.id" -->
    <!-- <a href='index.php/{{infoContent.unique_id}}' title="">check</a> -->

    <!-- <a v-link="{ path: 'people/edit/', params: { userId:infoContent.unique_id  }}">check</a> -->
 </gmap-info-window>


<gmap-marker v-for="(marker, index) in markers"
        :key="index"
        :position="marker.position"
        :clickable="true"
         @click="toggleInfoWindow(marker,index)"
        >
</gmap-marker>


 </gmap-map>
    </div>

    <div class="col-md-2">

   </div>
</div>
</div>

</div>


<!-- <h2>{{range}}</h2>
    <span>Selected: {{ selected }}</span>
    <span>query: {{ query }}</span>
 <br>
 <br/> -->

    <!-- <button @click="changeZoom">Change Zoom</button> -->
 <!-- ------------------------Autocomplete ends-----------------///////-->


 <!-- ------------------------------Gmap & infowindow------------------------------------ -->





<!-- ------------------------------------Gmap ends---------------------------------------------- -->


<!-- -------------------------------------div ends-------------------- -->






<script>
  	 Vue.use(VueGoogleMaps, {
      load: {
        key: 'AIzaSyAE6lL8yeY_7T4ifK-pEWhkKE7UNn4Zvw4',
        libraries: 'places'
      }
    });
document.addEventListener('DOMContentLoaded', function() {
  Vue.component('google-map', VueGoogleMaps.Map);
  Vue.component('google-marker', VueGoogleMaps.Marker);
      new Vue({
        el: '#test2',
        data: {

	      range:'',
        query:'',
        selected:'',
        rateOP:'',
        by:'',
        options: [
      { text: 'regular items', value: 'regular' },
      { text: 'offers', value: 'offer' },
      { text: 'restaurant', value: 'restaurant' }
    ],
    rp: [
      { text: 'rated', value: 'rated' },
      { text: 'not rated', value: 'notrated' }
    ],
    ob: [
      { text: 'distance', value: 'distance' },
      { text: 'ratings', value: 'ratings' }
    ],
	      infoContent: [],
	      infoWindowPos: null,
	      infoWinOpen: false,
	      currentMidx: null,
	      //optional: offset infowindow so it visually sits nicely on top of our marker
	      infoOptions: {
	        pixelOffset: {
	          width: 0,
	          height: -35
	        }
	      },
	      markers:[],
	      changingZoom: 12,
	      changingCenter: {lat: 1.38, lng: 103.8},
        },

        methods: {
          changeCenter(place) {
            this.changingCenter = {
              lat: place.geometry.location.lat(),
              lng: place.geometry.location.lng()
            };
          },
          onCha(){
            console.log(this.rateOP);
            if (this.rateOP=='notrated') {
               this.by='distance';
            }
            if (this.rateOP=='rated') {
               this.by=null;
            }
            console.log(this.by);
          },

          changeZoom() {
            this.changingZoom = Math.floor(5 + Math.random() * 10);
          },

          setPlace(){

          },

          navigate:function(mark,index){
          	this.changingCenter = mark.position;
              // alert(mark.res.restaurant_name);
              this.toggleInfoWindow(mark,index);
          },

          toggleInfoWindow: function(marker, idx) {
            this.infoWindowPos = marker.position;
            this.infoContent = marker.res;
            console.log(this.infoContent);
            //check if its the same marker that was selected if yes toggle
            if (this.currentMidx == idx) {
              this.infoWinOpen = !this.infoWinOpen;
            }
            //if different marker set infowindow to open and reset current marker index
            else {
              this.infoWinOpen = true;
              this.currentMidx = idx;
            }
          },

          usePlace(){
        //     range:'',
        // query:'',
        // selected:'',
        // rateOP:'',
        // by:'',
        // alert(this.range);
// if (range) {
//   alert("yes");
// }
// else{
//  alert("no yes");
// }

         fetch('http://localhost/zahid_api/components/geo/geodata.php?lat='+this.changingCenter.lat+'&&lng='+this.changingCenter.lng+'&&range='+this.range+'&&selected='+this.selected+'&&query='+this.query+'&&orderby='+this.by+'&&rateOP='+this.rateOP)
		    .then(response => response.json())
		    .then((data) => {
		      this.markers = data.data;
          console.log(this.markers);
          console.log(this.range);
          console.log(this.changingCenter.lat);
		      console.log(this.changingCenter.lng);
		    })

		      this.place = null;
          }
        }
      });
  })

  </script>
</body>
</html>