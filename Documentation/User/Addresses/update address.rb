# User
## Address

### Store address

Endpoint :/update-address/the id of the address you wanna update
Method : Post
Body :
'title' => 'nullable|in:المنزل ,عمل,امي,غير',
'building' => 'nullable|min:3,max:200',
'street' => 'nullable|min:3,max:200',
'apartment' => 'nullable|min:3,max:200',
'phone' => 'nullable|regex:/^[^0]\d{8,19}$/|numeric|unique:users,phone',
'country_code' => 'nullable|exists:countries,country_code',
'default' => 'nullable|in:1,0',
'lat' => 'nullable|numeric',
'lng' => 'nullable|numeric',
'instructions' => 'nullable|min:3,max:200',
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



 in case of success
 Status :200 ok
 {
    "result": "success",
    "message": "Data Saved Successfully",
    "status": 200,
    "data": {
        "Addresses": [
            {
                "id": 8,
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
        ]
    }
}
