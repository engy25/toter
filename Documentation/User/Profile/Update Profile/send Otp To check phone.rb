# User
## Profile

### Update Phone   1: Send Otp To check phone
details
to update the phone firstly you must put your phone and country_code then we send to you msg containnig otp this have 2 stages the first stage
Endpoint :/send-otp-to-check-phone
Parameters :
phone => ,your phone,required|numeric|unique
country_code =>,your country code, required

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
            "The phone has already been taken."
        ]
    },
    "status": 422,
    "data": null
}


 in case of success
 Status :200 ok
 {
    "result": "success",
    "message": "Pleaze Complete Your Updated Stages",
    "status": 200,
    "data": {
        "user": {
            "id": 9,
            "phone": "963258717555",
            "otp": 1111,
            "country_code": "+20"
        }
    }
}
}


