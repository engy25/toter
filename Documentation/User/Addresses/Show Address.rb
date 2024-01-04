# User
## Address

### Display Specific Address

Endpoint :/address/the id of the address you wanna see it
Method : Get
Body :

----------
Authorization

BarearToken :
token of the user

 Response

in case of not authentication

    {
        "result": "failed",
        "message": "Pleaze Login First",
        "status": 401,
        "data": null
    }

in case of the id not found
    {
    "result": "failed",
    "message": "Address Not Found",
    "status": 422,
    "data": null
}

 in case of success
 Status :200 ok
 {
    "result": "success",
    "message": "Data Retreived Successfully",
    "status": 200,
    "data": {
        "Addresses": {
            "id": 11,
            "user_id": 107,
            "name": "asdf",
            "title": "امي",
            "building": "yyyy",
            "street": "eeeeeee",
            "apartment": "eeeeeeeee",
            "phone": "102365975256",
            "default": 1,
            "country_code": 20,
            "lat": 23699.3333,
            "lng": 23699.3333,
            "instructions": "ehhehhe"
        }
    }
}
