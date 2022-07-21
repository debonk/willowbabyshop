# willowbabyshop software
Modify: Extend expiration time

3.1.2	21/07/2022
Catalog > Tools: Add Log Feature.
	Set DIR_LOG to system/logs in config
Catalog > Tools: Create looping process for big data import.
Bug Fixed: Catalog > Product List: Error variant name set to '?'

3.1.1	18/07/2022
System > Error: Get route when logging error
System > db: Trim $value before escape 
Bug Fixed: Catalog > Product Form: Error php in script
Bug Fixed: Api > Product: Minor Bugs

3.1.0	14/07/2022
Modify: Change base of Special/Discount to model instead of product_id
	Api > Product
	Checkout > Cart
	Common > Cart
	APP > Product
	Product List
	Product Form

	Table: product_special
		ALTER TABLE `oc_product_special` ADD `model` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `product_id`;
		ALTER TABLE `oc_product_special` ADD INDEX( `model`);
	Table: product_discount
		ALTER TABLE `oc_product_discount` ADD `model` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `product_id`;
		ALTER TABLE `oc_product_discount` ADD INDEX( `model`);

3.0.8
Bug Fixed: Product > Highlight: array_multisort(): Array sizes are inconsistent
Bug Fixed: PHP Notice:  Undefined variable: model in /home/willowba/public_html/willowmgr12/view/template/catalog/product_form.tpl

3.0.7_b	08/07/2022
Catalog > Option: Sort option value by sort_order and name
Bug Fixed: Error on charset "UTF-8;"

3.0.7	04/07/2022
Filemanager: Add image from external url
Catalog > Tools: Repair import image from external url
Catalog > Product List: Image will show variant image first, then main image

3.0.6	30/06/2022
Api > Product: Add getSpecial/Discount API request.
Bug Fixed: Catalog > Product List: Special/Discount price not shown when event in last day.

3.0.5	23/06/2022
Modify: Catalog > Tools: Add variant image field
Modify: Manufacturer, Category: Auto generate SEO Url
Bug Fixed: Manufacturer form: Add/Edit doesn't follow filter url

3.0.4	16/06/2022
Modul: Api > Product: Campaign API - Set promo through API
Modify: Catalog > Product Form: Set default image when add new variant
Refactoring: Cleaning VQMod, Remove VQMod Folder

3.0.3	06/06/2022
Modify: Catalog > Product List: Add Product in Promo filter
Bug Fixed: APP > Product: Select variant not refresh image/model/price/special

3.0.2	04/06/2022
Bug Fixed: Catalog > Product Form: Variant value id saved as object instead of array
Bug Fixed: Catalog > Product List: Manufacturer & Category filter keep showing --- All Data ---

3.0.1	03/06/2022
Modify: Catalog > Manufacturer: Add filter feature
Modify: Report > Product Purchased: Add filter and sort features
Bug Fixed: Themecontrol > Product: error special and discount

3.0.0	30/05/2022
Modify: File Manager: Regenerate new filename to avoid error when Upload image contain special character

3.0.0.5_Developed
Modul: Multiple Option >>
	- Catalog > Tool
	- Api > Product
	- Report > Product
	- APP > common/home

3.0.0.4_Developing
	- APP > Product > Comparison
	- APP > Product > Wishlist
	- APP > Product > Search
	- APP > Product > Category
	- APP > Product > Manufacturer
	- APP > Product > Special
	- APP > Product > Highlight
	- APP > Module > Featured
	- APP > Module > Special
	- APP > Module > Latest
	- APP > Module > Bestseller

2.3.0.3_Developing
	- Sale > Order
	- APP > order
		Table: product_option_value: add index to model and product_id
	- APP > Common > Cart
	- APP > Checkout > Cart
		Table: cart: Modified
			Add model
			ALTER TABLE `oc_cart` ADD INDEX( `model`);
	- APP > product > product
	- Catalog > Product Form > Multiple Option: Variant Tab (REBUILD)
	- Removing VQMod
	- Catalog > Product List > Delete
	- Catalog > Product List > Copy
	- Catalog > Product List > Filter
	- Catalog > Product List > Autocomplete
	- Catalog > Product Form > Special
		Table: product_special: change discount structure to disc_1 (%), disc_2 (%), disc_3(fixed)
			ALTER TABLE `oc_product_special` ADD `discount_percent_1` TINYINT(3) NOT NULL DEFAULT '0' AFTER `priority`, ADD `discount_percent_2` TINYINT(3) NOT NULL DEFAULT '0' AFTER `discount_percent_1`
			ALTER TABLE `oc_product_special` CHANGE `price` `discount_fixed` INT(11) NOT NULL DEFAULT '0';
	- Catalog > Product Form > Discount
		Table: product_discount: change discount structure to disc_1 (%), disc_2 (%), disc_3(fixed)
			ALTER TABLE `oc_product_discount` ADD `discount_percent_1` TINYINT(3) NOT NULL DEFAULT '0' AFTER `priority`, ADD `discount_percent_2` TINYINT(3) NOT NULL DEFAULT '0' AFTER `discount_percent_1`;
			ALTER TABLE `oc_product_discount` CHANGE `price` `discount_fixed` INT(11) NOT NULL DEFAULT '0';
	- Catalog > Product List
		Table: product: remove model, price, quantity, points, weight, weight_class_id (rename first)
			ALTER TABLE `oc_product` CHANGE `model` `model_del` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `quantity` `quantity_del` INT(4) NOT NULL DEFAULT '0', CHANGE `price` `price_del` DECIMAL(15,2) NOT NULL DEFAULT '0.00', CHANGE `points` `points_del` INT(8) NOT NULL DEFAULT '0', CHANGE `weight` `weight_del` DECIMAL(15,2) NOT NULL DEFAULT '0.00', CHANGE `weight_class_id` `weight_class_id_del` INT(11) NOT NULL DEFAULT '0';
	- Catalog > Option: Remove Multiple Selection on Option Type
	- Catalog > Product Form > Multiple Option: Option Tab
	- Catalog > Product Form > Multiple Option: Variant Tab
	- Catalog > Product Form > Multiple Option: UX by javascript untuk new data
		Table: product_option_value: modified
	- Catalog > Option: Add Multiple Selection on Option Type

==================================
2.2.6.9	14/05/2022
Modify: Special, Discount, Coupon, Cart: Tanggal pada date_start dan date_end masih berlaku
Modify: Catalog > Product: Set date_available to now when copy product

2.2.6.8	27/04/2022
Bug Fixed: Catalog > Product: Autocomplete tidak berfungsi

2.2.6.7 26/04/2022
MODIFY: Product: Seo Url auto replace with correct format

2.2.6.6
Bug Fixed: Mylivechat setting not show correct value

2.2.6.5 02/04/2022
Modul: My Live Chat
Modul: Google Recaptcha v3
	Applied to Contact, Register, Product/product
Bug Fixed: HP Warning:  A non-numeric value encountered in 'product_carousel'
Bug Fixed: Google Analytics

2.2.6.4	21/03/2022
Bug Fixed: PHP Notice:  A non well formed numeric value encountered in (part 2)

2.2.6.4	21/03/2022
Modul: Connect with Google Analytic
Bug Fixed: Google Analytic feed not saved properly
Modify Modul: Header: Simplified Notification
Modify Layout: FRONT > Product > Product: hide text if no reviews, option button on different screen;
Bug Fixed: Product images set multiple times
Bug Fixed: PHP Notice:  A non well formed numeric value encountered in (part 1)

2.2.6.3	12/03/2022
Modify Modul: FRONT > Product > Product: Set Out of Stock if product have option, but option total qty = 0;
Modify Modul: Mass new product: Add product option image to parent product, check url availability.
Bug Fixed: Sku on variant: mass new product upload.
Bug Fixed: Product: Copy Product then Delete Product remove main product's image too.
Bug Fixed: Free Shipping: Always applied even not in the list.

2.2.6.2	05/03/2022
Modify Modul: Header > Welcome: Add "login and sign in with google" if not logged in.

2.2.6.1	04/03/2022
Blog Latest Module: add feature to disabled image
Modify Table: Reduce price decimal format to 15,2
Bug fixed: Menu > Geo Zones unlisted in menu
Layout: Header: Smaller logo

2.2.6.0 26/02/2022
Modul: Add model/sku on variant (option)
----------------------
	Applied to admin > catalog > product
	Applied to front > product
	Applied to front > cart
	Applied to front > checkout
	Applied to front > order history
	Applied to admin > sale > order > info
	Applied to admin > sale > order > order invoice
	Applied to admin > sale > order > order shipping
	Applied to admin > sale > order > add/edit
	Applied to admin > report > product purchased
	Applied to api > product > mass product update
	Applied to admin > product > mass new product upload
========================
Bug Fixed: Order > Dispatch Note: Error non numeric weight
Modify: Product List: include product option in filter model
Bug Fixed: Marketing > Collection: Export data tidak berfungsi

2.2.5.3	15/02/2022
Layout: Modify product_tab_widget
Layout: Modify product name trim
Layout: Modify product_block on special, bestseller
Layout: Modify product_block on category, manufacturer, search

Modify: Shipping > Extended Free Shipping: Add Free Shipping limit
Layout: Blog
Bug Fixed: Catalog > Tool: Regex for url_alias 
Bug Fixed: Total > Free Shipping 
Bug Fixed: Manufacturer Auto Complete

2.2.5.2	26/01/2022
Modul: Total > Shipping: Raja Ongkir (Pro)

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