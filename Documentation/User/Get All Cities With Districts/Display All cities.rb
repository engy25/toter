# User
## Display All cities

### Display All Cities

Endpoint :/get-cities  --> display the cities and its districts
Method : Get
Body :

----------
Authorization

BarearToken :
no

 Response




 in case of success
 Status :200 ok
 {
    "result": "success",
    "message": "Data Retreived Successfully",
    "status": 200,
    "data": {
        "Cities": [
            {
                "id": 6,
                "name": "Baghdad",
                "districts": [
                    {
                        "id": 23,
                        "name": "districts"
                    },
                    {
                        "id": 26,
                        "name": "eeeeeeeeeeeeee"
                    }
                ]
            },
            {
                "id": 7,
                "name": "Mosul",
                "districts": [
                    {
                        "id": 9,
                        "name": "echimyids"
                    },
                    {
                        "id": 18,
                        "name": "Fayounsssengssss"
                    },
                    {
                        "id": 28,
                        "name": "sssssssssssssssedetr"
                    }
                ]
            },
            {
                "id": 8,
                "name": "Basra",
                "districts": [
                    {
                        "id": 24,
                        "name": "District233"
                    },
                    {
                        "id": 25,
                        "name": "Fayoun"
                    }
                ]
            },
            {
                "id": 10,
                "name": "Erbil",
                "districts": [
                    {
                        "id": 19,
                        "name": "districts6"
                    },
                    {
                        "id": 20,
                        "name": "eeeeeeeeeeesmsm"
                    }
                ]
            },
            {
                "id": 11,
                "name": "Najaf",
                "districts": [
                    {
                        "id": 13,
                        "name": "District3ee255"
                    },
                    {
                        "id": 27,
                        "name": "Fayoun33333ensdsd"
                    }
                ]
            },
            {
                "id": 12,
                "name": "Karbala",
                "districts": [
                    {
                        "id": 8,
                        "name": "District225"
                    }
                ]
            }
        ]
    }
}

------------------------------------------------------

# User
## Display All cities

### Display All Cities

Endpoint :/get-cities/1 --> display the cities of the store  and its districts and delivery fees of the district
 1->the Id of the store
Method : Get
Body :

----------
Authorization

BarearToken :
no

 Response




 in case of success
 Status :200 ok
 {
  "result": "success",
  "message": "Data Retreived Successfully",
  "status": 200,
  "data": {
      "Cities": [
          {
              "id": 7,
              "name": "Mosul",
              "districts": [
                  {
                      "id": 9,
                      "name": "echimyids",
                      "delivery_charge": 12
                  },
                  {
                      "id": 18,
                      "name": "Fayounsssengssss",
                      "delivery_charge": null
                  },
                  {
                      "id": 28,
                      "name": "sssssssssssssssedetr",
                      "delivery_charge": null
                  }
              ]
          },
          {
              "id": 12,
              "name": "Karbala",
              "districts": [
                  {
                      "id": 8,
                      "name": "District225",
                      "delivery_charge": 12
                  }
              ]
          }
      ]
  }
}

failed store id not exist
status:404 not found
{
    "result": "failed",
    "message": "store Not Found",
    "status": 404,
    "data": null
}

if there is not have cities

  {
    "result": "success",
    "message": "Data Retreived Successfully",
    "status": 200,
    "data": {
        "Cities": []
    }
}
