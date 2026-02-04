<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Current Location on Map</title>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
    
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../img/p11.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* --- Header --- */
        header {
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .nav-bar ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .nav-bar ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 16px;
            transition: 0.3s;
        }

        .nav-bar ul li a:hover, .nav-bar ul li a.active {
            color: #004AAD;
        }

        .hamburger {
            display: none;
            cursor: pointer;
        }

        .hamburger .line {
            width: 25px;
            height: 3px;
            background: #333;
            margin: 5px;
        }

        /* --- Main Content --- */
        #contain {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }

        h3 {
            color: #004AAD;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Map Styling */
        #map-container {
            width: 100%;
            height: 400px;
            margin: 0 auto 25px auto;
            border-radius: 15px;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            z-index: 1;
        }

        /* Location Info Styling */
        .info-box {
            background: #f4f6f8;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            border-left: 5px solid #004AAD;
            text-align: left;
            font-size: 16px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .info-box i {
            font-size: 20px;
            color: #004AAD;
            width: 25px;
            text-align: center;
        }

        /* Hidden/Unused IP section styling if enabled */
        #ip, #version, #country {
            font-weight: 600;
            color: #004AAD;
        }

        /* Mobile Responsiveness */
        @media screen and (max-width: 768px) {
            header { padding: 15px 20px; }
            .hamburger { display: block; }

            .nav-bar {
                position: absolute;
                top: 60px;
                left: 0;
                right: 0;
                background: white;
                display: none;
                flex-direction: column;
                padding: 20px;
                text-align: center;
            }
            .nav-bar.active { display: flex; }
            .nav-bar ul { flex-direction: column; gap: 15px; }

            #map-container {
                height: 300px;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">SAVE <b style="color: #004AAD;">Plate</b></div>
        <div class="hamburger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <nav class="nav-bar">
            <ul>
                <li><a href="delivery.php">Home</a></li>
                <li><a href="#" class="active">Map</a></li>
                <li><a href="deliverymyord.php">My Orders</a></li>
            </ul>
        </nav>
    </header>

    <div id="contain">
        <div class="glass-card">
            <h3><i class="fa fa-map-location-dot"></i> Your Current Location</h3>
            
            <div id="map-container"></div>
            
            <div class="info-box">
                <i class="fa fa-city"></i>
                <span id="city-name">Locating city...</span>
            </div>
            
            <div class="info-box">
                <i class="fa fa-map-pin"></i>
                <span id="address">Fetching detailed address...</span>
            </div>

            <div style="display:none">
                <p>Your IP address : <span id="ip"></span></p>
                <span id="version"></span>
                <span id="country"></span>
            </div>
        </div>
    </div>

    <script>
        const hamburger = document.querySelector(".hamburger");
        hamburger.onclick = function() {
            const navBar = document.querySelector(".nav-bar");
            navBar.classList.toggle("active");
        }
    </script>

    <script>
      // Initialize the map and user's location marker
      function initMap() {
        // Retrieve the map container element
        var mapContainer = document.getElementById("map-container");
        
        // Create a new map centered on the user's location
        navigator.geolocation.getCurrentPosition(function(position) {
          var userLocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          
          var map = L.map(mapContainer).setView(userLocation, 15);
          
          // Add the OpenStreetMap tile layer to the map
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 18,
            tileSize: 512,
            zoomOffset: -1
          }).addTo(map);
          
          // Add a marker at the user's location
          var marker = L.marker(userLocation).addTo(map);
          marker.bindPopup("<b>You are here!</b>").openPopup();
          
          // Retrieve the city name using OpenStreetMap API
          var url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=" + userLocation.lat + "&lon=" + userLocation.lng;
            
          fetch(url)
            .then(function (response) {
              return response.json();
            })
            .then(function (data) {
              // Display the city name on the web page
              var cityName = data.address.city || data.address.town || "Unknown City";
              var cityNameElement = document.getElementById("city-name");
              cityNameElement.innerHTML = "You are in " + cityName;
            });
              
            // Use reverse geocoding to get the user's address
            fetch(url)
            .then(response => response.json())
            .then(data => {
              document.getElementById("address").innerHTML = `You are at ${data.display_name}`;
            });

        }, function() {
          // Handle errors when retrieving the user's location
          alert("Error: The Geolocation service failed. Please allow location access.");
        });
      }

      function getVisitorLocation() {
          // make API request to ipinfo.io to retrieve location data
          fetch("https://ipapi.co/json/")
            .then(response => response.json())
            .then(data => {
              var country = data.country;
              var region = data.region;
              var city = data.city;
              var postalCode = data.postal;
              var ip = data.ip;
              var version=data.version;
              
              document.getElementById("country").innerHTML = country; 
              document.getElementById("ip").innerHTML = ip;
              document.getElementById("version").innerHTML = version;
            })
            .catch(error => {
              console.log("Error retrieving location data: " + error);
            });
        }

        // call function to get visitor's location information
        getVisitorLocation();
    </script>
    
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"></script>
</body>
</html>