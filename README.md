# willowbabyshop software

2.2.5.1	25/01/2022
Bug Fixed: htaccess: Force using https error
==========================
	# Force using https
	RewriteCond %{HTTPS} off
	RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

	# SEO URL Settings
	# If your opencart installation does not run on the main web folder make sure you folder it does run in ie. / becomes /shop/
	RewriteBase /willowbabyshop/
	RewriteRule ^sitemap.xml$ index.php?route=feed/google_sitemap [L]
	RewriteRule ^googlebase.xml$ index.php?route=feed/google_base [L]
	RewriteRule ^system/download/(.*) index.php?route=error/not_found [L]
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_URI} !.*\.(ico|gif|jpg|jpeg|png|js|css)
	RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]
==========================
Bug Fixed: Blog: Description not well formatted.
Bug Fixed: Menu: Custom menu appear without access.
Modify: Blog: Meta title is generated from blog title + suffix ' | willowbabyshop'.
Bug Fixed: Blog: Disabled user can be selected as creator.
Bug Fixed: Blog: Pagination.
Bug Fixed: Config SSL not set on store_id = 0.

2.2.5.0 21/01/2021
Modul: Marketing > Data Collection: Promo BCA 65.
Modul: Payment > Payment Link
Bug Fixed: Manufacturer List: Manufacturer with 0 product not shown.
Bug Fixed: Product List: Layout tabel jika produk kosong.
Layout: Step by step Checkout ditata rata kiri.

2.2.4.0	13/01/2021
Modul: Total > Shipping: Raja Ongkir (Starter)
Bug Fixed: Order Info > Set Invoice No
Order Info > Update Order History: Validate Invoice No must be set before order complete.
Bug Fixed: Manufacturer List.
Bug Fixed: Pavblog > summernote insert image does not manage by filemanager.
Bug Fixed: Filemanager: common.js not catch newly created a.thumbnail element.

2.2.3.2	15/12/2021
Library: Add PHPMailer library
Bug Fixed: Reset password not working
Customer Activity: Handle activity about google login and register
Product List: Add field date modified, apply permanently extended product list
Product > Delete: Termasuk menghapus file gambar dan cache.
Menu: Dynamic Menu.
Modification: VQMod to Permanent Mod
Contact: Remove BBM and LINE
Bug fixed: Search, Special, Highlight, and Manufacturer Info Layout
Total > Reward: Enhance reward point
Category, Manufacturer: Add Id and Product Total Field

2.2.3.1	08/12/2021
Checkout: Login & Register by Google
Extension > Module: Pengaturan Login dan Credential
Checkout > Login: Penerapan Google OAuth
Checkout > Register: Penerapan Google OAuth

2.2.3.0
New Modul: Login by Google
Checkout: Handling jika customer belum ada no HP
Checkout > Confirm Order: Penataan layout Order Confirmation

2.2.2.1
Mass New Product: Modify Model getImage
Footer:	Marketplace list
Bug Fixed: Welcome > Reward Point
Bug Fixed: Repair image placeholder

2.2.2.0	22/11/2021
New Modul: Information > Info Page (Marketplace List)
Vqmod: Permanently applied some vqmod xml

2.2.1.3	20/11/2021
Setting: By pass IP Check for auto update API

2.2.1.2	15/11/2021
Bug Fixed: Mass new product > repair product description conversion
Layout Fixed: Catalog > Product Detail

2.2.1.1	13/11/2021
Modul: Mass new product > Auto generate SEO URL | Product > Model & SKU Validation
Bug Fixed: Product > Product List Table

2.2.1.0	9/11/2021
Modul: Mass new product upload by excel.

2.2.0.7	6/11/2021
Bug Fixed: Nav bar at smaller screen keep visible

2.2.0.6	5/11/2021
Modul: Megamenu > Align Left

2.2.0.5	3/11/2021
Modul: Welcome greeting

2.2.0.4	23/10/2021
Bug Fixed: Handling error API key (Catalog Side)

2.2.0.3	7/10/2021
Bug Fixed: Handling error API key (Catalog Side)
Modul: Product List by API (Catalog Side)

2.2.0.2	29/9/2021
Modul: Price and Stock mass update by API (Catalog Side)

2.2.0.1
File Structure: Clean file structure.