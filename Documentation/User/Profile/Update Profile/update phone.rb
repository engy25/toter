# User
## Profile

### Update Phone   2: update phone
details
after you put the phone that u wants to update you receive an otp you must confirm it in this stage
Endpoint :/update-phone
Parameters :
phone => ,your phone,required|numeric|unique
country_code =>,your country code, required
otp: 111 انا مثبته الرقم دا لحد ما نستخدم الخدمه اللي بفلوس
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


  in case of failed validation
    status :4 22Unprocessable Content

    {
      "result": "failed",
      "message": null,
      "errors": {
          "phone": [
              "the phone must be at leat 9 number and the most 20 numbers"
          ]
      },
      "status": 422,
      "data": null
  }


in case of falied otp or phone
  {
    "result": "failed",
    "message": "Otp Is Not Correct",
    "status": 422,
    "data": null
}

 in case of success
 Status :200 ok
 {
  "result": "success",
  "message": "User Updated Successfully",
  "status": 200,
  "data": {
      "user": {
          "phone": "963258717555",
          "country_code": "+20",
          "flag": "http://127.0.0.1:8000/storage/images/countryFlag/cristina-glebova-fYqQBr0EzkA-unsplash.jpg"
      }
  }
}


