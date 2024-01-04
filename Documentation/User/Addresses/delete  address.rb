# User
## Address

### Delete address

Endpoint :/delete-address/the id of the address you wanna update
Method : Post
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



 in case of success and this user doesno have any addresses
  {
    "result": "success",
    "message": "Address Deleted Successfully",
    "status": 200,
    "data": {
        "Addresses": []
    }
}

in case of success and this user have many address
  {
    "result": "success",
    "message": "Address Deleted Successfully",
    "status": 200,
    "data": {
        "Addresses": [
            {
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
            },
            {
                "id": 10,
                "user_id": 107,
                "name": "asdf",
                "title": "امي",
                "building": "yyyy",
                "street": "eeeeeee",
                "apartment": "eeeeeeeee",
                "phone": "102365975256",
                "default": 0,
                "country_code": 20,
                "lat": 23699.3333,
                "lng": 23699.3333,
                "instructions": "ehhehhe"
            }
        ]
    }
}

in case of id not found
 Status: 422Unprocessable Content

  {
    "result": "failed",
    "message": "Address Not Found",
    "status": 422,
    "data": null
}
