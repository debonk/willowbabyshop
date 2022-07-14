# API Documentation

LOGIN
	Method: POST

	Url: https://www.willowbabyshop.com/index.php?route=api/login

	Body: 'key' = $key

	Response:
		{
			"success": "Success: API session successfully started!",
			"token": "b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz"
		}

================================

PRODUCT INFO
	Method: GET

	Url: https://www.willowbabyshop.com/index.php?route=api/product&token={{API token}}&model={{model}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)
	{{model}}: 06.02.00910 (kode barang/SKU)

	Response:
		{
			"product": {
				"product_id": "3507",
				"name": "360 DO BRUSH FOR BABY",
				"model": "06.02.00910",
				"quantity": "2",
				"price": "Rp. 81,000",
				"status": "1"
			}
		}
	
================================

PRODUCT LIST (Model/Kode Barang)
	Method: GET

	Url: https://www.willowbabyshop.com/index.php?route=api/product/list&token={{API token}}&status={{status}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)
	{{status}}: (kosong) | 1 | 0 | all (Untuk status produk aktif/tidak aktif)

	Response:
		{
			"products": [
				"02.01.00028",
				"02.01.01167",
				"02.01.00130",
				...
				"13.01.04321"
			],
			"success": "Success: Showing 8751 records."
		}
================================

PRODUCTS UPDATE (MASS)
	Method: POST

	Url: https://www.willowbabyshop.com/index.php?route=api/product/updates&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Body: 'data' = [["model","price","quantity","status"],["06.02.00910",81000,1,1],["06.02.00909",8100,9,1],["05.03.01326",2499000,0,0]]
	(Multiple array diencode ke bentuk JSON)

	Response:
		{
			"success": "Success: You have modified your product!"
		}

================================

CAMPAIGN: GET SPECIAL (MASS) > Untuk menarik data produk yang aktif promo/harga diskon/harga coret
	Method: GET

	Url: https://www.willowbabyshop.com/index.php?route=api/product/specials&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Response:
{
    "products": [
        {
            "model": "01.02.00779",
            "price": "99000.00",
            "special": 49500,
            "date_start": "2022-02-19",
            "date_end": "2022-12-31"
        },
        {
            "model": "05.03.01326",
            "price": "2499900.00",
            "special": 2249910,
            "date_start": "2022-06-15",
            "date_end": "2022-07-15"
        }
    ],
    "success": "Success: Showing 2 records."
}
================================

CAMPAIGN: ADD SPECIAL (MASS) > Untuk membuat single promo/harga diskon/harga coret
	Method: POST

	Url: https://www.willowbabyshop.com/index.php?route=api/product/addSpecials&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Body: 'data' = [["model","price","special_price","date_start","date_end"],["06.02.00910",81900,75000,"2022-06-15","2022-07-15"],["06.02.00910",81900,73710,"2022-06-15","2022-07-15"],["05.03.01326",2499900,2249910,"2022-06-15","2022-07-15"]]
	(Multiple array diencode ke bentuk JSON)

	Response:
		{
			"success": "Success: Your request has been processed!",
			"summary": "3 success, 0 failed"
		}

================================

CAMPAIGN: DELETE SPECIAL (MASS) > Untuk menghapus single promo/harga diskon/harga coret
	Method: POST

	Url: https://www.willowbabyshop.com/index.php?route=api/product/deleteSpecials&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Body: 'data' = ["model","06.02.00910","06.02.00909","05.03.01326"]
	(Single array diencode ke bentuk JSON)

	Response:
		{
			"success": "Success: Your request has been processed!",
			"summary": "1 success, 2 failed",
			"failed_data": [
				"06.02.00910: Skipped as there is no special price active.",
				"05.03.01326: Skipped as there is no special price active."
			]
		}

================================

CAMPAIGN: GET DISCOUNT (MASS) > Untuk menarik data produk yang aktif harga grosir
	Method: GET

	Url: https://www.willowbabyshop.com/index.php?route=api/product/discounts&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Response:
{
    "products": [
        {
            "model": "06.02.00909",
            "quantity": "3",
            "price": "81900.00",
            "discount": 73710,
            "date_start": "2022-06-15",
            "date_end": "2022-07-15"
        }
    ],
    "success": "Success: Showing 1 records."
}
================================

CAMPAIGN: ADD DISCOUNT (MASS) > Untuk membuat promo berdasarkan quantity/harga grosir
	Method: POST

	Url: https://www.willowbabyshop.com/index.php?route=api/product/addDiscounts&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Body: 'data' = [["model","quantity","price","discount_price","date_start","date_end"],["06.02.00910",2,81900,75000,"2022-06-15","2022-07-15"],["06.02.00909",3,81900,73710,"2022-06-15","2022-07-15"],["05.03.01326",2,2499900,2249910,"2022-06-15","2022-07-15"]]
	(Multiple array diencode ke bentuk JSON)

	Response:
		{
			"success": "Success: Your request has been processed!",
			"summary": "3 success, 1 failed",
			"failed_data": [
				"06.02.00909: Skipped as discount price has been set."
			]
		}

================================

CAMPAIGN: DELETE DISCOUNT (MASS) > Untuk menghapus promo berdasarkan quantity/harga grosir
	Method: POST

	Url: https://www.willowbabyshop.com/index.php?route=api/product/deleteDiscounts&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Body: 'data' = ["model","06.02.00910","06.02.00909","05.03.01326"]
	(Single array diencode ke bentuk JSON)

	Response:
		{
			"success": "Success: Your request has been processed!",
			"summary": "3 success, 0 failed"
		}
================================
