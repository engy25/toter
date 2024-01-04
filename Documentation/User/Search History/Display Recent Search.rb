# User
## Seach History

### Display Recent Search

Endpoint :/recent-search
Headers :
Accept: application/json
Accept-Language: en or ar


Parameters :
----
Authorization --------------( required )

BarearToken :
token of the user

 Response

in case of success
  {
    "result": "success",
    "message": "Data Retreived Successfully",
    "status": 200,
    "data": {
        "search": {
            "data": [
                {
                    "id": 10,
                    "keyword": "Pizza mushroom",
                    "user_id": 9
                },
                {
                    "id": 9,
                    "keyword": "Pizza M",
                    "user_id": 9
                },
                {
                    "id": 8,
                    "keyword": "Pizza",
                    "user_id": 9
                }
            ]
        }
    }
}
