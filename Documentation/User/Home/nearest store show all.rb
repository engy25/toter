# User
## Home

###  2: Display the Nearest Store When You Press In Show All

Endpoint :/nearest-store
Headers :
Accept: application/json
Accept-Language: en or ar
lat: the latituted of the user
lng: the longtude of the user

Parameters :
----------
Authorization --------------(not required)

BarearToken :
token of the user

 Response this response have pagination  and the icon dislay this offer_icon  from here|
                                                                                       |
                                                                                       ------------------|
Status 200 OK                                                                                            |
{
  "result": "success",
  "message": "Data Retreived Successfully",
  "status": 200,
  "data": {
      "store": {
          "data": [
              {
                  "id": 1,
                  "name": "Dream Land Restaurant",
                  "image": "https://elwadah.easyoneclick.com/storage/images/stores/360_F_324739203_keeq8udvv0P2h1MLYJ0GLSlTBagoXS48.jpg",
                  "price": 0,
                  "currency": "dollar",
                  "delivery_time": "43 m",
                  "reviews_count": 2,
                  "rating": 4.5,
                  "favourite": 0,
                  "offer_name": "5% off on 5 orders and free delivery",
                  "offer_discount": "5%",
                  "status": "close",
                  "working_hours": "9:00 AM - 12:00 AM"
              },
              {
                  "id": 4,
                  "name": "shop  flower",
                  "image": "https://elwadah.easyoneclick.com/storage/images/stores/1703608065_aOFSsIXzpuq8.jpg",
                  "price": 0,
                  "currency": "dollar",
                  "delivery_time": "555555 m",
                  "reviews_count": 0,
                  "rating": 0,
                  "favourite": 0,
                  "offer_name": "",
                  "offer_discount": "0%",
                  "status": "close",
                  "working_hours": "6:00 AM - 12:00 PM"
              },
              {
                  "id": 2,
                  "name": "Cleaning Store",
                  "image": "https://elwadah.easyoneclick.com/storage/images/stores/download.jpg",
                  "price": 0,
                  "currency": "dollar",
                  "delivery_time": "43 m",
                  "reviews_count": 1,
                  "rating": 4,
                  "favourite": 0,
                  "offer_name": "",
                  "offer_discount": "0%",
                  "status": "close",
                  "working_hours": "9:00 AM - 12:00 AM"
              },
              {
                  "id": 3,
                  "name": "Toters Fresh",
                  "image": "https://elwadah.easyoneclick.com/storage/images/stores/1703032898_MgefBU7aSZGW.jpg",
                  "price": 0,
                  "currency": "dollar",
                  "delivery_time": "43 m",
                  "reviews_count": 1,
                  "rating": 5,
                  "favourite": 0,
                  "offer_name": "5% off on 5 orders",
                  "offer_discount": "6%",
                  "status": "close",
                  "working_hours": "9:00 AM - 12:00 AM"
              }
          ],
          "links": {
              "first": "https://elwadah.easyoneclick.com/api/nearest-store?page=1",
              "last": "https://elwadah.easyoneclick.com/api/nearest-store?page=1",
              "prev": null,
              "next": null
          },
          "meta": {
              "current_page": 1,
              "from": 1,
              "last_page": 1,
              "links": [
                  {
                      "url": null,
                      "label": "&laquo; Previous",
                      "active": false
                  },
                  {
                      "url": "https://elwadah.easyoneclick.com/api/nearest-store?page=1",
                      "label": "1",
                      "active": true
                  },
                  {
                      "url": null,
                      "label": "Next &raquo;",
                      "active": false
                  }
              ],
              "path": "https://elwadah.easyoneclick.com/api/nearest-store",
              "per_page": 15,
              "to": 4,
              "total": 4
          }
      }
  }
}
