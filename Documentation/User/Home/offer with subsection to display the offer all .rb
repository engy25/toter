# User
## Home

###  2: Display the Offer When You Press In Show All

Endpoint :/index-offer-type?subsection_name=the name of the subsection you must get it from home page
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
  {                                                                                                      |
     "result": "success",                                                                                |
    "message": "Data Retreived Successfully",                                                            |
    "status": 200,
    "data": {                                                                                            |
        "Pizza - 5% off on 5 orders and free delivery": {                                                |
            "data": [                                                                                    |
                {                                                                                       |
                    "offer_id": 1,                                                                      |
                    "offer_icon": "https://elwadah.easyoneclick.com/storage/images/subSections/13.svg", |
                    "offer_title": "Unlock 5% Off On 5 Food Orders and free delivery",
                    "offer_name": "5% off on 5 orders and free delivery",
                    "offer_description": "Save Up to IQD 7000 on every order from foods",
                    "offer_discount_percentage": 5,
                    "offer_required_points": 1555555,
                    "tier": "Green Tier",
                    "sub_section": "Pizza",
                    "store_id": 1,
                    "store_name": "Dream Land Restaurant",
                    "store_image": "https://elwadah.easyoneclick.com/storage/images/stores/360_F_324739203_keeq8udvv0P2h1MLYJ0GLSlTBagoXS48.jpg",
                    "price": "0.00",
                    "currency": null,
                    "reviews_count": 2,
                    "delivery_time": "43",
                    "rating": 4.5,
                    "favourite": 0
                },
                {
                    "offer_id": 3,
                    "offer_icon": "https://elwadah.easyoneclick.com/storage/images/subSections/13.svg",
                    "offer_title": "5 % discount",
                    "offer_name": "5 % discount on all orders",
                    "offer_description": "5 % discount",
                    "offer_discount_percentage": 4,
                    "offer_required_points": 5,
                    "tier": "Golden Tier",
                    "sub_section": "Pizza",
                    "store_id": 2,
                    "store_name": "Cleaning Store",
                    "store_image": "https://elwadah.easyoneclick.com/storage/images/stores/download.jpg",
                    "price": "0.00",
                    "currency": null,
                    "reviews_count": 1,
                    "delivery_time": "43",
                    "rating": 4,
                    "favourite": 0
                }
            ],
            "links": {
                "first": "https://elwadah.easyoneclick.com/api/index-offer-type?page=1",
                "last": "https://elwadah.easyoneclick.com/api/index-offer-type?page=1",
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
                        "url": "https://elwadah.easyoneclick.com/api/index-offer-type?page=1",
                        "label": "1",
                        "active": true
                    },
                    {
                        "url": null,
                        "label": "Next &raquo;",
                        "active": false
                    }
                ],
                "path": "https://elwadah.easyoneclick.com/api/index-offer-type",
                "per_page": 15,
                "to": 2,
                "total": 2
            }
        }
    }
}
