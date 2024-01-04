# User
## Home

###  2: Display the offer detaild of specif offer

Endpoint :/offer?offer_id= the id of the offer
Headers :
Accept: application/json
Accept-Language: en or ar
lat: the latituted of the user
lng: the longtude of the user

Parameters :
offer_id : the if of the offer
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
        "offer": {
            "id": 1,
            "image": "https://elwadah.easyoneclick.com/storage/images/offers/offer.jpeg",
            "name": "5% off on 5 orders and free delivery",
            "title": "Unlock 5% Off On 5 Food Orders and free delivery",
            "description": "Save Up to IQD 7000 on every order from foods",
            "discount_percentage": 5,
            "required_points": 1555555,
            "tier": "Green Tier",
            "sub_section": "Pizza",
            "store": "Dream Land Restaurant",
            "from_date": "2023-11-22",
            "to_date": "2024-11-22"
        }
    }
}
