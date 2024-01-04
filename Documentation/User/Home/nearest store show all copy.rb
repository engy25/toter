# User
## Home

###  2: Display the stores of specific subsection In Show All when the user press on specific subsection

Endpoint :/subsection-store/ the id of the subsection
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

 Response 
                                                                                       |
                                                                                       ------------------|
Status 200 OK                                                                                            |
{
    "result": "success",
    "message": "Data Retreived Successfully",
    "status": 200,
    "data": {
        "stores": {
            "data": [
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
                "first": "https://elwadah.easyoneclick.com/api/subsection-store/1?page=1",
                "last": "https://elwadah.easyoneclick.com/api/subsection-store/1?page=1",
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
                        "url": "https://elwadah.easyoneclick.com/api/subsection-store/1?page=1",
                        "label": "1",
                        "active": true
                    },
                    {
                        "url": null,
                        "label": "Next &raquo;",
                        "active": false
                    }
                ],
                "path": "https://elwadah.easyoneclick.com/api/subsection-store/1",
                "per_page": 10,
                "to": 1,
                "total": 1
            }
        }
    }
}
