# User
## Home

### Home  2:  Home

Endpoint :/home
Headers :
Accept: application/json
Accept-Language: en or ar
lat: the latituted of the user
lng: the longtude of the user

Parameters :
----------
Authorization --------------(not required)

BarearToken :
token of the user

 Response

in case of the user not  auth:
  {
    "result": "success",
    "message": "Data Retreived Successfully",
    "status": 200,
    "data": {
        "home": {
            "Offers": [
                {
                    "id": 2,
                    "image": "https://elwadah.easyoneclick.com/storage/images/offers/offer.jpeg",
                    "name": "5% off on 5 orders",
                    "title": "Unlock 5% Off On 5 Food Orders",
                    "description": "Save Up to IQD 7000 on every order from foods",
                    "discount_percentage": 6,
                    "required_points": 5,
                    "tier": "Green Tier",
                    "sub_section": "Fresh toters",
                    "store": "Toters Fresh",
                    "from_date": "2023-11-01",
                    "to_date": "2024-11-22"
                },
                {
                    "id": 1,
                    "image": "https://elwadah.easyoneclick.com/storage/images/offers/offer.jpeg",
                    "name": "5% off on 5 orders and free delivery",
                    "title": "Unlock 5% Off On 5 Food Orders and free delivery",
                    "description": "Save Up to IQD 7000 on every order from foods",
                    "discount_percentage": 5,
                    "required_points": 1555555,
                    "tier": "Green Tier",
                    "sub_section": "Pizza",
                    "store": "Dream Land Restaurant",
                    "from_date": "2023-11-22",
                    "to_date": "2024-11-22"
                }
            ],
            "sections": [
                {
                    "id": 2,
                    "name": "Fresh toters",
                    "description": "Groceries your way.",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/food.svg"
                },
                {
                    "id": 5,
                    "name": "Flowers",
                    "description": "Freshly Picked flowers for all",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/new.svg"
                },
                {
                    "id": 6,
                    "name": "Add Funds",
                    "description": "Top up your wallets for quick.",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/flowers.svg"
                },
                {
                    "id": 10,
                    "name": "Cleaning",
                    "description": "Still back and enjoy the scrub!",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/market.svg"
                },
                {
                    "id": 15,
                    "name": "Butler",
                    "description": "We deliver all orders provided they are sufficient.",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/laundry.svg"
                },
                {
                    "id": 16,
                    "name": "Rewards",
                    "description": "Redeem your points with free meals and offers",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/butler.svg"
                },
                {
                    "id": 17,
                    "name": "Food",
                    "description": "All the best restaurants near you.",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/rewards.svg"
                }
            ],
            "sub_sections": [
                {
                    "id": 24,
                    "name": "Pizza",
                    "description": null,
                    "image": "https://elwadah.easyoneclick.com/storage/images/subSections/13.svg"
                }
            ],
            "Fresh toters _ 5% off on 5 orders": [
                {
                    "offer_id": 2,
                    "offer_icon": "https://elwadah.easyoneclick.com/storage/images/subSections/1.png",
                    "offer_title": "Unlock 5% Off On 5 Food Orders",
                    "offer_name": "5% off on 5 orders",
                    "offer_description": "Save Up to IQD 7000 on every order from foods",
                    "offer_discount_percentage": 6,
                    "offer_required_points": 5,
                    "tier": "Green Tier",
                    "sub_section": "Fresh toters",
                    "store_id": 3,
                    "store_name": "Toters Fresh",
                    "store_image": "https://elwadah.easyoneclick.com/storage/images/stores/1703032898_MgefBU7aSZGW.jpg",
                    "price": "0.00",
                    "currency": null,
                    "reviews_count": 1,
                    "delivery_time": "43",
                    "rating": 5,
                    "favourite": 0
                }
            ],
            "Pizza _ 5% off on 5 orders and free delivery": [
                {
                    "offer_id": 3,
                    "offer_icon": "https://elwadah.easyoneclick.com/storage/images/subSections/13.svg",
                    "offer_title": "5 % discount",
                    "offer_name": "5 % discount on all orders",
                    "offer_description": "5 % discount",
                    "offer_discount_percentage": 4,
                    "offer_required_points": 5,
                    "tier": "Golden Tier",
                    "sub_section": "Pizza",
                    "store_id": 2,
                    "store_name": "Cleaning Store",
                    "store_image": "https://elwadah.easyoneclick.com/storage/images/stores/download.jpg",
                    "price": "0.00",
                    "currency": null,
                    "reviews_count": 1,
                    "delivery_time": "43",
                    "rating": 4,
                    "favourite": 0
                },
                {
                    "offer_id": 1,
                    "offer_icon": "https://elwadah.easyoneclick.com/storage/images/subSections/13.svg",
                    "offer_title": "Unlock 5% Off On 5 Food Orders and free delivery",
                    "offer_name": "5% off on 5 orders and free delivery",
                    "offer_description": "Save Up to IQD 7000 on every order from foods",
                    "offer_discount_percentage": 5,
                    "offer_required_points": 1555555,
                    "tier": "Green Tier",
                    "sub_section": "Pizza",
                    "store_id": 1,
                    "store_name": "Dream Land Restaurant",
                    "store_image": "https://elwadah.easyoneclick.com/storage/images/stores/360_F_324739203_keeq8udvv0P2h1MLYJ0GLSlTBagoXS48.jpg",
                    "price": "0.00",
                    "currency": null,
                    "reviews_count": 2,
                    "delivery_time": "43",
                    "rating": 4.5,
                    "favourite": 0
                }
            ],
            "nearest_stores": [
                {
                    "id": 1,
                    "name": "Dream Land Restaurant",
                    "image": "https://elwadah.easyoneclick.com/storage/images/stores/360_F_324739203_keeq8udvv0P2h1MLYJ0GLSlTBagoXS48.jpg",
                    "price": 0,
                    "currency": "dollar",
                    "delivery_time": "43 m",
                    "reviews_count": 2,
                    "rating": 4.5,
                    "favourite": 0,
                    "offer_name": "5% off on 5 orders and free delivery",
                    "offer_discount": "5%",
                    "status": "close",
                    "working_hours": "9:00 AM - 12:00 AM"
                },
                {
                    "id": 4,
                    "name": "shop  flower",
                    "image": "https://elwadah.easyoneclick.com/storage/images/stores/1703608065_aOFSsIXzpuq8.jpg",
                    "price": 0,
                    "currency": "dollar",
                    "delivery_time": "555555 m",
                    "reviews_count": 0,
                    "rating": 0,
                    "favourite": 0,
                    "offer_name": "",
                    "offer_discount": "0%",
                    "status": "close",
                    "working_hours": "6:00 AM - 12:00 PM"
                },
                {
                    "id": 2,
                    "name": "Cleaning Store",
                    "image": "https://elwadah.easyoneclick.com/storage/images/stores/download.jpg",
                    "price": 0,
                    "currency": "dollar",
                    "delivery_time": "43 m",
                    "reviews_count": 1,
                    "rating": 4,
                    "favourite": 0,
                    "offer_name": "",
                    "offer_discount": "0%",
                    "status": "close",
                    "working_hours": "9:00 AM - 12:00 AM"
                },
                {
                    "id": 3,
                    "name": "Toters Fresh",
                    "image": "https://elwadah.easyoneclick.com/storage/images/stores/1703032898_MgefBU7aSZGW.jpg",
                    "price": 0,
                    "currency": "dollar",
                    "delivery_time": "43 m",
                    "reviews_count": 1,
                    "rating": 5,
                    "favourite": 0,
                    "offer_name": "5% off on 5 orders",
                    "offer_discount": "6%",
                    "status": "close",
                    "working_hours": "9:00 AM - 12:00 AM"
                }
            ]
        }
    }
}

in case of the user auth

  {
    "result": "success",
    "message": "Data Retreived Successfully",
    "status": 200,
    "data": {
        "home": {
            "tier": { الفئه الخضراء
                "id": 1,
                "image": "https://elwadah.easyoneclick.com/storage/images/tiers/tier1.jpeg",
                "name": "Green Tier",
                "description": "Use your reward points to enjoy a huge range of benefits, such as exclusive offers, discounts, and free meals",
                "orders_make_This_month": 0,  ---- عدد الاوردرات للي اليوزر عملها الشهر دا
                "text": "There are 10 additional orders remaining to upgrade to the golden tier until January 31",
                "points": 0 عدد النقاط التي يمتلكها اليوزر
            },
            "Offers": [   // Offers created recently
                {
                    "id": 2,
                    "image": "https://elwadah.easyoneclick.com/storage/images/offers/offer.jpeg",
                    "name": "5% off on 5 orders",
                    "title": "Unlock 5% Off On 5 Food Orders",
                    "description": "Save Up to IQD 7000 on every order from foods",
                    "discount_percentage": 6,
                    "required_points": 5,
                    "tier": "Green Tier",
                    "sub_section": "Fresh toters",
                    "store": "Toters Fresh",
                    "from_date": "2023-11-01",
                    "to_date": "2024-11-22"
                },
                {
                    "id": 1,
                    "image": "https://elwadah.easyoneclick.com/storage/images/offers/offer.jpeg",
                    "name": "5% off on 5 orders and free delivery",
                    "title": "Unlock 5% Off On 5 Food Orders and free delivery",
                    "description": "Save Up to IQD 7000 on every order from foods",
                    "discount_percentage": 5,
                    "required_points": 1555555,
                    "tier": "Green Tier",
                    "sub_section": "Pizza",
                    "store": "Dream Land Restaurant",
                    "from_date": "2023-11-22",
                    "to_date": "2024-11-22"
                }
            ],
            "sections": [// Sections  that have surrounded stores
                {
                    "id": 2,
                    "name": "Fresh toters",
                    "description": "Groceries your way.",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/food.svg"
                },
                {
                    "id": 5,
                    "name": "Flowers",
                    "description": "Freshly Picked flowers for all",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/new.svg"
                },
                {
                    "id": 6,
                    "name": "Add Funds",
                    "description": "Top up your wallets for quick.",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/flowers.svg"
                },
                {
                    "id": 10,
                    "name": "Cleaning",
                    "description": "Still back and enjoy the scrub!",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/market.svg"
                },
                {
                    "id": 15,
                    "name": "Butler",
                    "description": "We deliver all orders provided they are sufficient.",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/laundry.svg"
                },
                {
                    "id": 16,
                    "name": "Rewards",
                    "description": "Redeem your points with free meals and offers",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/butler.svg"
                },
                {
                    "id": 17,
                    "name": "Food",
                    "description": "All the best restaurants near you.",
                    "image": "https://elwadah.easyoneclick.com/storage/images/sections/rewards.svg"
                }
            ],
            "sub_sections": [
                {
                    "id": 24,
                    "name": "Pizza",
                    "description": null,
                    "image": "https://elwadah.easyoneclick.com/storage/images/subSections/13.svg"
                }
            ],
            "Fresh toters _ 5% off on 5 orders": [  // Offers in sections that are in the surrounded area and the icon from the first  offer_icon
                {
                    "offer_id": 2,
                    "offer_icon": "https://elwadah.easyoneclick.com/storage/images/subSections/1.png",
                    "offer_title": "Unlock 5% Off On 5 Food Orders",
                    "offer_name": "5% off on 5 orders",
                    "offer_description": "Save Up to IQD 7000 on every order from foods",
                    "offer_discount_percentage": 6,
                    "offer_required_points": 5,
                    "tier": "Green Tier",
                    "sub_section": "Fresh toters",
                    "store_id": 3,
                    "store_name": "Toters Fresh",
                    "store_image": "https://elwadah.easyoneclick.com/storage/images/stores/1703032898_MgefBU7aSZGW.jpg",
                    "price": "0.00",
                    "currency": null,
                    "reviews_count": 1,
                    "delivery_time": "43",
                    "rating": 5,
                    "favourite": 0
                }
            ],
            Pizza is the name that must pass to display in show all
            "Pizza _ 5% off on 5 orders and free delivery": [  // Offers in sections that are in the surrounded area
                {
                    "offer_id": 3,
                    "offer_icon": "https://elwadah.easyoneclick.com/storage/images/subSections/13.svg",
                    "offer_title": "5 % discount",
                    "offer_name": "5 % discount on all orders",
                    "offer_description": "5 % discount",
                    "offer_discount_percentage": 4,
                    "offer_required_points": 5,
                    "tier": "Golden Tier",
                    "sub_section": "Pizza",
                    "store_id": 2,
                    "store_name": "Cleaning Store",
                    "store_image": "https://elwadah.easyoneclick.com/storage/images/stores/download.jpg",
                    "price": "0.00",
                    "currency": null,
                    "reviews_count": 1,
                    "delivery_time": "43",
                    "rating": 4,
                    "favourite": 0
                },
                {
                    "offer_id": 1,
                    "offer_icon": "https://elwadah.easyoneclick.com/storage/images/subSections/13.svg",
                    "offer_title": "Unlock 5% Off On 5 Food Orders and free delivery",
                    "offer_name": "5% off on 5 orders and free delivery",
                    "offer_description": "Save Up to IQD 7000 on every order from foods",
                    "offer_discount_percentage": 5,
                    "offer_required_points": 1555555,
                    "tier": "Green Tier",
                    "sub_section": "Pizza",
                    "store_id": 1,
                    "store_name": "Dream Land Restaurant",
                    "store_image": "https://elwadah.easyoneclick.com/storage/images/stores/360_F_324739203_keeq8udvv0P2h1MLYJ0GLSlTBagoXS48.jpg",
                    "price": "0.00",
                    "currency": null,
                    "reviews_count": 2,
                    "delivery_time": "43",
                    "rating": 4.5,
                    "favourite": 0
                }
            ],
            the stores that neare from you
            "nearest_stores": [
                {
                    "id": 1,
                    "name": "Dream Land Restaurant",
                    "image": "https://elwadah.easyoneclick.com/storage/images/stores/360_F_324739203_keeq8udvv0P2h1MLYJ0GLSlTBagoXS48.jpg",
                    "price": 0,
                    "currency": "dollar",
                    "delivery_time": "43 m",
                    "reviews_count": 2,
                    "rating": 4.5,
                    "favourite": 0,
                    "offer_name": "5% off on 5 orders and free delivery",
                    "offer_discount": "5%",
                    "status": "close",
                    "working_hours": "9:00 AM - 12:00 AM"
                },
                {
                    "id": 4,
                    "name": "shop  flower",
                    "image": "https://elwadah.easyoneclick.com/storage/images/stores/1703608065_aOFSsIXzpuq8.jpg",
                    "price": 0,
                    "currency": "dollar",
                    "delivery_time": "555555 m",
                    "reviews_count": 0,
                    "rating": 0,
                    "favourite": 0,
                    "offer_name": "",
                    "offer_discount": "0%",
                    "status": "close",
                    "working_hours": "6:00 AM - 12:00 PM"
                },
                {
                    "id": 2,
                    "name": "Cleaning Store",
                    "image": "https://elwadah.easyoneclick.com/storage/images/stores/download.jpg",
                    "price": 0,
                    "currency": "dollar",
                    "delivery_time": "43 m",
                    "reviews_count": 1,
                    "rating": 4,
                    "favourite": 0,
                    "offer_name": "",
                    "offer_discount": "0%",
                    "status": "close",
                    "working_hours": "9:00 AM - 12:00 AM"
                },
                {
                    "id": 3,
                    "name": "Toters Fresh",
                    "image": "https://elwadah.easyoneclick.com/storage/images/stores/1703032898_MgefBU7aSZGW.jpg",
                    "price": 0,
                    "currency": "dollar",
                    "delivery_time": "43 m",
                    "reviews_count": 1,
                    "rating": 5,
                    "favourite": 0,
                    "offer_name": "5% off on 5 orders",
                    "offer_discount": "6%",
                    "status": "close",
                    "working_hours": "9:00 AM - 12:00 AM"
                }
            ]
        }
    }
}
