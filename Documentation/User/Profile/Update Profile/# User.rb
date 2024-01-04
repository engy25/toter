# User
## Profile

### Update Profile
Endpoint :/update-profile
Parameters :
fname: user's first name, nullable|string|between:3,40
image : users' image,mimes:jpeg,jpg,png,gif|nullable'
lname :users' last name, nullable|string|between:3,40
nickname user's nickname, nullable|string|between:3,40
dob: date of birth of the user, 'nullable|date|date_format:Y-m-d
email_address :users email address, nullable|email|max:40

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
 "result": "success",
    "message": "User Updated Successfully",
    "status": 200,
    "data": {
        "user": {
            "id": 9,
            "firstname": "Enjy Elsayad",
            "last_name": "lll88",
            "nickname": "55556",
            "dob": null,
            "is_active": true,
            "country_code": "+20",
            "image": "http://127.0.0.1:8000/storage/images/user/1700664843_wozk6sIbkQho.png",
            "phone": "963258717778",
            "flag": "http://127.0.0.1:8000/storage/images/countryFlag/cristina-glebova-fYqQBr0EzkA-unsplash.jpg",
            "email": "adin1554@gmail.com",
            "orders_make_This_month": 0,
            "duration_expired": "31 January",
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjcyYjc2Y2FkZTk3MGUzMTAzY2E0ZjY3NjJhZmQxYTU1NzZlY2NkMmYyNTU3MjdlZTYzNWMzNGIzODEzN2RhYjYxYzQ1NDQ2MmYzM2RmZjMiLCJpYXQiOjE3MDQzNjc4NzEuMjYyMDYzLCJuYmYiOjE3MDQzNjc4NzEuMjYyMDY0LCJleHAiOjE3MzU5OTAyNzEuMjU2OTY1LCJzdWIiOiI5Iiwic2NvcGVzIjpbXX0.BJBJSS4nx34AVLCdjmckqx8RTpxSPO2PT5Czo5G4qDOKF5Bv-EsW1GkHVT-ncdHk_xT3v1nCMYjrx-LmRiGGOQ"
        }
    }
}

in case of failed
    {
    "result": "failed",
    "message": null,
    "errors": {
        "fname": [
            "The fname must be between 3 and 40 characters."
        ]
    },
    "status": 422,
    "data": null
}

