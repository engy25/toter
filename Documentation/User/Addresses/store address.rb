# User
## Address

### Store address

Endpoint :/address
Method : Post
Body :
'title' => 'required|in:المنزل ,عمل,امي,غير',
'building' => 'required|min:3,max:200',
'street' => 'required|min:3,max:200',
'apartment' => 'required|min:3,max:200',
'phone' => 'required|regex:/^[^0]\d{8,19}$/|numeric|unique:users,phone',
'country_code' => 'required|exists:countries,country_code',
'default' => 'required|in:1,0', هل العنوان دا انت عايز تخليه ديفولت ولا لا ولو دا اول مره تكريت عنوان انا هخليه ديفولت اوتوماتيك
'lat' => 'required|numeric',
'lng' => 'required|numeric',
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
