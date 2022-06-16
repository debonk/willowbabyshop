# API Documentation

LOGIN
	Method: POST

	Url: http://www.willowbabyshop.com/index.php?route=api/login

	Body: 'key' = $key

	Response:
		{
			"success": "Success: API session successfully started!",
			"token": "b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz"
		}

================================

PRODUCT INFO
	Method: GET

	Url: http://www.willowbabyshop.com/index.php?route=api/product&token={{API token}}&model={{model}}
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

	Url: http://www.willowbabyshop.com/index.php?route=api/product/list&token={{API token}}&status={{status}}
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

	Url: http://www.willowbabyshop.com/index.php?route=api/product/updates&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Body: 'data' = [["model","price","quantity","status"],["06.02.00910",81000,1,1],["06.02.00909",8100,9,1],["05.03.01326",2499000,0,0]]
	(Multiple array diencode ke bentuk JSON)

	Response:
		{
			"success": "Success: You have modified your product!"
		}

================================

CAMPAIGN: ADD SPECIAL (MASS) > Untuk membuat single promo/harga diskon/harga coret
	Method: POST

	Url: http://www.willowbabyshop.com/index.php?route=api/product/addSpecials&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Body: 'data' = [["model","price","special_price","date_start","date_end"],["06.02.00910",81900,75000,"2022-06-15","2022-07-15"],["06.02.00910",81900,73710,"2022-06-15","2022-07-15"],["05.03.01326",2499900,2249910,"2022-06-15","2022-07-15"]]
	(Multiple array diencode ke bentuk JSON)

	Response:
		{
			"success": "Success: Your request has been processed!",
			"failed_data": [
				"06.02.00910: Skipped as main product special price has been set."
			]
		}

================================

CAMPAIGN: DELETE SPECIAL (MASS) > Untuk menghapus single promo/harga diskon/harga coret
	Method: POST

	Url: http://www.willowbabyshop.com/index.php?route=api/product/deleteSpecials&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Body: 'data' = ["model","06.02.00910","06.02.00909","05.03.01326"]
	(Single array diencode ke bentuk JSON)

	Response:
		{
			"success": "Success: Your request has been processed!",
		}

================================

CAMPAIGN: ADD DISCOUNT (MASS) > Untuk membuat promo berdasarkan quantity/harga grosir
	Method: POST

	Url: http://www.willowbabyshop.com/index.php?route=api/product/addDiscounts&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Body: 'data' = [["model","quantity","price","special_price","date_start","date_end"],["06.02.00910",2,81900,75000,"2022-06-15","2022-07-15"],["06.02.00909",3,81900,73710,"2022-06-15","2022-07-15"],["05.03.01326",2,2499900,2249910,"2022-06-15","2022-07-15"]]
	(Multiple array diencode ke bentuk JSON)

	Response:
		{
			"success": "Success: Your request has been processed!",
			"failed_data": [
				"06.02.00910: Skipped as main product discount price has been set."
			]
		}

================================

CAMPAIGN: DELETE DISCOUNT (MASS) > Untuk menghapus promo berdasarkan quantity/harga grosir
	Method: POST

	Url: http://www.willowbabyshop.com/index.php?route=api/product/deleteDiscounts&token={{API token}}
	{{API token}}: b7IM7fgNrwqGdNjHsrxko2KVXDvZaBdz (token yang diperoleh saat login)

	Body: 'data' = ["model","06.02.00910","06.02.00909","05.03.01326"]
	(Single array diencode ke bentuk JSON)

	Response:
		{
			"success": "Success: Your request has been processed!",
		}

================================
