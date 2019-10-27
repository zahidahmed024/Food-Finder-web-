<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
<ul id="example-2">
  <button> get</button>
  <li v-for="(item, index) in items">
     {{ item.lon }}
  </li>
   <!-- {{parentMessage}} -->
</ul>

  <script src="lib/axios.js" type="text/javascript"></script>
	<script src="lib/vue.js" type="text/javascript"></script>
	<script type="text/javascript">



    var example2 = new Vue({
  el: '#example-2',
  data: {
    parentMessage: 'Parent',
    items: [],
  },

  mounted() {
      fetch(" http://localhost/zahid_api/components/getItems.php?token=5bfb9b00d5bdd")
        .then(response => response.json())
        .then((data) => {
          this.items = data.items;
        })
    }
})
		// axios.get('http://localhost/zahid_api/components/geo/geodata.php', {
  //               params:{
  //                 lat: '23.7104',
  //                 lon: '90.40744',

  //             }
  //         })
  //             .then(function (response) {
  //               console.log(response.data.data);
  //               console.log(response.data.data[0].position);

  //           for (var i = 0; i < response.data.data.length; i++) {
  //              console.log(response.data.data[i].position);
  //               }
  //             })
  //             .catch(function (error) {
  //               console.log(error);
  //             });
  // fetch('http://localhost/zahid_api/components/geo/geodata.php').then(response => response.json()).then(data => console.log(data.data[0]));
  // fetch('http://zahid8164.000webhostapp.com/zahid_api/components/getItems.php')
  //   .then((response) => response.json())
  //   .then((responseJson) => {
  //     // Alert.alert(responseJson);

  //       console.log(responseJson.items);
  //       // this.setState({
  //       //   markers: responseJson.items,
  //       // })

  //   })
// response => console.log(response)
	</script>
</body>
</html>