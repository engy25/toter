# User
## Seach History

### Delete specific keyword in search

Endpoint :/recent-searches/destroy/the id of the keyword
Method:Post
Headers :
Accept: application/json
Accept-Language: en or ar


Parameters :
----
Authorization --------------( required )

BarearToken :
token of the user

 Response

in case id not found
  {
    "result": "failed",
    "message": "Not Found",
    "status": 404,
    "data": null
}
in case of success
  {
    "result": "success",
    "message": "Data Deleted Successfully",
    "status": 200,
    "data": null
}
