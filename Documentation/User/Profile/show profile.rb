# User
## Profile

### Show Profile  2: Show Profile

Endpoint :/show-profile
Parameters :
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
  "message": "Data Retreived Successfully",
  "status": 200,
  "data": {
      "user": {
          "id": 107,
          "firstname": "asdf",
          "last_name": null,
          "nickname": null,
          "dob": null,
          "is_active": true,
          "country_code": "+20",
          "image": "https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y",
          "phone": "5987654234433",
          "flag": "https://elwadah.easyoneclick.com/storage/images/countryFlag/cristina-glebova-fYqQBr0EzkA-unsplash.jpg",
          "email": "go4go53@gmail.com",
          "orders_make_This_month": 0,
          "duration_expired": "31 January",
          "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiZWIxNzBiMTFlZGU0NzJkYmEzNjU3M2I4MjRhMTFlMjIxZWY1ODQ5ZDU2NjZlZTY3M2U1ZjQ1NjM0MWZjMmM2Y2M4Yzg2OGFjOTBkNWI0YjkiLCJpYXQiOjE3MDQzNzE5MjIuNjUzMzA4LCJuYmYiOjE3MDQzNzE5MjIuNjUzMzExLCJleHAiOjE3MzU5OTQzMjIuNjI2NTMzLCJzdWIiOiIxMDciLCJzY29wZXMiOltdfQ.EEom3K3CoP9aqRZdne_u-JBxvcLc3ZdeZZnwQ4IT-0i2qDTN7aVNk2eGHuQoySwS1y-yTHeOWyDObcZYNXU1uss9aeOqRPmCcUYV8CIcTlR5d4uOp60LUTL7nbEIVLz3jI7ejh-zCEc-nzqo1srKsJoZHq5-0NHjr21shdXltl2bcQIVvKLOW9GT0sTedH8goCSBdAuVlQ17NvEqqMONppsGkpyX96SnVhx9d_VPrTmifdXVER31lYazNgEYaI4FoMh0hRCNvBfaeOI2Cu0i4MVTaCZdxkWBj99xGK_8u2Vd3oAc4wdwbybBusQe76xf751oZyz_f4NQIYwN3mJiQQ"
      }
  }
}


