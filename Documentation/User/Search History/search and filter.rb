# User
## Seach History

### Seach History

Endpoint :/filter
Headers :
Accept: application/json
Accept-Language: en or ar


Parameters :
'keyword' => 'nullable|string', put the keyword that you want to search by it like the name or the description of the item

'min_price' => 'nullable|integer', you must put with it max_price
'max_price' => 'nullable:min_price|integer', you may put max price without min price if you want max with min the user get the price between max and min
'rate' => 'nullable', you put the rate for ex : 4 the user get all the items that average rating is <=4
'subsection_id' => 'nullable|,', the sub_section id you may search with it you display all the subsections then you search by id
'tag_id'=> 'nullable', the tag id you may search with it you display all the tags of the stores then you search by id

'type' => 'nullable|string'
Authorization --------------(not required if you put BarearToken and you put keyword  i store your keyword in DataBase)

BarearToken :
token of the user

 Response

in case of success
  {
    "result": "success",
    "message": "Data Retreived Successfully",
    "status": 200,
    "data": {
        "items": {
            "data": [
                {
                    "id": 1,
                    "name": "Pizza mushroom",
                    "image": "http://127.0.0.1:8000/storage/images/items/360_F_18669964_Txz4BS0OErzj9v9DHM3N51d8yFVa85dR.jpg",
                    "price": 110,
                    "currency": "دولار",
                    "delivery_time": "43 m",
                    "reviews_count": 3,
                    "rating": 3.7,
                    "favourite": 1,
                    "popuar": null
                },
                {
                    "id": 17,
                    "name": "Engy",
                    "image": "http://127.0.0.1:8000/storage/images/items/1703703551_e8NLERFnNwyT.jpg",
                    "price": 5.05,
                    "currency": "دولار",
                    "delivery_time": "43 m",
                    "reviews_count": 0,
                    "rating": 0,
                    "favourite": 0,
                    "popuar": null
                },
                {
                    "id": 16,
                    "name": "sokassssssssssss33",
                    "image": "http://127.0.0.1:8000/storage/images/items/1703635133_9THBJYTmyCxy.jpg",
                    "price": 1320,
                    "currency": "دولار",
                    "delivery_time": "43 m",
                    "reviews_count": 0,
                    "rating": 0,
                    "favourite": 0,
                    "popuar": null
                },
                {
                    "id": 15,
                    "name": "sokassssssssssss33",
                    "image": "http://127.0.0.1:8000/storage/images/items/1703635086_YQ908Rn5rtSc.jpg",
                    "price": 1320,
                    "currency": "دولار",
                    "delivery_time": "43 m",
                    "reviews_count": 0,
                    "rating": 0,
                    "favourite": 0,
                    "popuar": null
                },
                {
                    "id": 14,
                    "name": "sokassssssssssss33",
                    "image": "http://127.0.0.1:8000/storage/images/items/1703634832_iyQ0dE9aioBN.jpg",
                    "price": 1320,
                    "currency": "دولار",
                    "delivery_time": "43 m",
                    "reviews_count": 0,
                    "rating": 0,
                    "favourite": 0,
                    "popuar": null
                },
                {
                    "id": 13,
                    "name": "sokassssssssssss33",
                    "image": "http://127.0.0.1:8000/storage/images/items/1703634705_b4Jm2eZDFPdw.jpg",
                    "price": 1320,
                    "currency": "دولار",
                    "delivery_time": "43 m",
                    "reviews_count": 0,
                    "rating": 0,
                    "favourite": 0,
                    "popuar": null
                },
                {
                    "id": 12,
                    "name": "sokassssssssssss33",
                    "image": "http://127.0.0.1:8000/storage/images/items/1703633313_U39DQYuemJo3.jpg",
                    "price": 1320,
                    "currency": "دولار",
                    "delivery_time": "43 m",
                    "reviews_count": 0,
                    "rating": 0,
                    "favourite": 0,
                    "popuar": null
                },
                {
                    "id": 11,
                    "name": "sokassererer",
                    "image": "http://127.0.0.1:8000/storage/images/items/1703632914_tHDL85MhsZTs.jpg",
                    "price": 1320,
                    "currency": "دولار",
                    "delivery_time": "43 m",
                    "reviews_count": 0,
                    "rating": 0,
                    "favourite": 0,
                    "popuar": null
                },
                {
                    "id": 2,
                    "name": "Poly Service",
                    "image": "http://127.0.0.1:8000/storage/images/items/istockphoto-1031043754-612x612.jpg",
                    "price": 10,
                    "currency": "دولار",
                    "delivery_time": "43 m",
                    "reviews_count": 0,
                    "rating": 0,
                    "favourite": 0,
                    "popuar": null
                },
                {
                    "id": 3,
                    "name": "Pizza mushroom",
                    "image": "http://127.0.0.1:8000/storage/images/items/360_F_18669964_Txz4BS0OErzj9v9DHM3N51d8yFVa85dR.jpg",
                    "price": 10,
                    "currency": "دولار",
                    "delivery_time": "43 m",
                    "reviews_count": 0,
                    "rating": 0,
                    "favourite": 0,
                    "popuar": null
                }
            ],
            "links": {
                "first": "http://127.0.0.1:8000/api/filter?page=1",
                "last": "http://127.0.0.1:8000/api/filter?page=2",
                "prev": null,
                "next": "http://127.0.0.1:8000/api/filter?page=2"
            },
            "meta": {
                "current_page": 1,
                "from": 1,
                "last_page": 2,
                "links": [
                    {
                        "url": null,
                        "label": "&laquo; Previous",
                        "active": false
                    },
                    {
                        "url": "http://127.0.0.1:8000/api/filter?page=1",
                        "label": "1",
                        "active": true
                    },
                    {
                        "url": "http://127.0.0.1:8000/api/filter?page=2",
                        "label": "2",
                        "active": false
                    },
                    {
                        "url": "http://127.0.0.1:8000/api/filter?page=2",
                        "label": "Next &raquo;",
                        "active": false
                    }
                ],
                "path": "http://127.0.0.1:8000/api/filter",
                "per_page": 10,
                "to": 10,
                "total": 15
            }
        }
    }
}
