Penndot-Traffic-Cameras-API
===========================

Get Cameras By roadid
* Endpoint: /getCamerasByRoadId.php
* Parameters: roadid - One of (i476,i676,i76,i95,nonhighway), format - (xml or json)
* Sample output:

```
{
  cameras:[
    {
      camera:{
        id:"0",
        lng:"-75.348917",
        lat:"39.8758",
        name:"I-476 McDade on Ramp",
        road:"Interstate 476",
        road_id:"i476",
        url:"http://www.dot35.state.pa.us/public/Districts/District6/WebCams/D6Cam122.jpg"
      }
    }
  ]
}
```

Get Cameras By Lat Lng
* Endpoint: /getCamerasByLatLng.php
* Parameters: lat - Latitude, lng - Longitude, radius - (in miles, default 10mi), count - (default 20) format - (xml or json)
* Sample output:

```
{
  cameras:[
    {
      camera:{
        id:"0",
        lng:"-75.348917",
        lat:"39.8758",
        name:"I-476 McDade on Ramp",
        road:"Interstate 476",
        road_id:"i476",
        url:"http://www.dot35.state.pa.us/public/Districts/District6/WebCams/D6Cam122.jpg",
        distance:"0.12342132"
      }
    }
  ]
}
```
