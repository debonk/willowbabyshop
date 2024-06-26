<?php
class ModelCatalogProduct extends Model
{
	public function addProduct($data)
	{
		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', user_id = '" . (int)$this->user->getId() . "', date_added = NOW()");

		$product_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int)$product_id . "'");
		}

		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "' AND language_id = '" . (int)$language_id . "'");

						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

		# Product Variant
		$option_ids = isset($data['product_variant']['option']) ? array_column($data['product_variant']['option'], 'option_id') : [];

		foreach ($data['product_variant']['variant'] as $variant) {
			$option_value_ids = isset($variant['option_value_id']) ? array_values($variant['option_value_id']) : [];

			$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_id = '" . (int)$product_id . "', option_id = '" . $this->db->escape(json_encode($option_ids)) . "', option_value_id = '" . $this->db->escape(json_encode($option_value_ids)) . "', model = '" . $this->db->escape($variant['model']) . "', image = '" . $this->db->escape($variant['image']) . "', quantity = '" . (int)$variant['quantity'] . "', price = '" . (float)$variant['price'] . "', points = '" . (int)$variant['points'] . "', weight = '" . (float)$variant['weight'] . "', weight_class_id = '" . (int)$variant['weight_class_id'] . "'");
		}

		# Product Option
		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] != 'select' && $product_option['type'] != 'radio' && $product_option['type'] != 'checkbox' && $product_option['type'] != 'image') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
				}
			}
		}

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', model = '" . $this->db->escape($product_discount['model']) . "', discount_percent_1 = '" . (int)$product_discount['discount_percent_1'] . "', discount_percent_2 = '" . (int)$product_discount['discount_percent_2'] . "', discount_fixed = '" . (int)$product_discount['discount_fixed'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', model = '" . $this->db->escape($product_special['model']) . "', discount_percent_1 = '" . (int)$product_special['discount_percent_1'] . "', discount_percent_2 = '" . (int)$product_special['discount_percent_2'] . "', discount_fixed = '" . (int)$product_special['discount_fixed'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}

		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($product_image['image']) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
				if ((int)$product_reward['points'] > 0) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$product_reward['points'] . "'");
				}
			}
		}

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$data['keyword'] = $data['keyword'] ? $data['keyword'] : $data['product_description'][$this->config->get('config_language_id')]['name'] . '-' . token(3);

		$data['keyword'] = preg_replace('/[\'\"*?+&\s-]+/', '-', utf8_strtolower($data['keyword']));

		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");

		if (isset($data['product_recurrings'])) {
			foreach ($data['product_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_recurring` SET `product_id` = " . (int)$product_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('product');

		return $product_id;
	}

	public function editProduct($product_id, $data)
	{
		$this->db->query("UPDATE " . DB_PREFIX . "product SET sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', user_id = '" . (int)$this->user->getId() . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int)$product_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");

		if (!empty($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

		# Product Variant
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");

		$option_ids = isset($data['product_variant']['option']) ? array_column($data['product_variant']['option'], 'option_id') : [];

		foreach ($data['product_variant']['variant'] as $variant) {
			$option_value_ids = isset($variant['option_value_id']) ? array_values($variant['option_value_id']) : [];

			$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_id = '" . (int)$product_id . "', option_id = '" . $this->db->escape(json_encode($option_ids)) . "', option_value_id = '" . $this->db->escape(json_encode($option_value_ids)) . "', model = '" . $this->db->escape($variant['model']) . "', image = '" . $this->db->escape($variant['image']) . "', quantity = '" . (int)$variant['quantity'] . "', price = '" . (float)$variant['price'] . "', points = '" . (int)$variant['points'] . "', weight = '" . (float)$variant['weight'] . "', weight_class_id = '" . (int)$variant['weight_class_id'] . "'");
		}

		# Product Option
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] != 'select' && $product_option['type'] != 'radio' && $product_option['type'] != 'checkbox' && $product_option['type'] != 'image') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', model = '" . $this->db->escape($product_discount['model']) . "', discount_percent_1 = '" . (int)$product_discount['discount_percent_1'] . "', discount_percent_2 = '" . (int)$product_discount['discount_percent_2'] . "', discount_fixed = '" . (int)$product_discount['discount_fixed'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', model = '" . $this->db->escape($product_special['model']) . "', discount_percent_1 = '" . (int)$product_special['discount_percent_1'] . "', discount_percent_2 = '" . (int)$product_special['discount_percent_2'] . "', discount_fixed = '" . (int)$product_special['discount_fixed'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($product_image['image']) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $value) {
				if ((int)$value['points'] > 0) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");

		$data['keyword'] = $data['keyword'] ? $data['keyword'] : $data['product_description'][$this->config->get('config_language_id')]['name'] . '-' . token(3);
		$data['keyword'] = preg_replace('/[\'\"*?+&\s-]+/', '-', utf8_strtolower($data['keyword']));

		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");

		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_recurring` WHERE product_id = " . (int)$product_id);

		if (isset($data['product_recurring'])) {
			foreach ($data['product_recurring'] as $product_recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_recurring` SET `product_id` = " . (int)$product_id . ", customer_group_id = " . (int)$product_recurring['customer_group_id'] . ", `recurring_id` = " . (int)$product_recurring['recurring_id']);
			}
		}

		$this->cache->delete('product');
	}

	public function copyProduct($product_id)
	{
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p WHERE p.product_id = '" . (int)$product_id . "'");

		if ($query->num_rows) {
			$data = $query->row;

			$token = token(3);

			$data['sku'] = '';
			$data['upc'] = '';
			$data['date_available'] = date('Y-m-d');
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			$extension = '.' . pathinfo($data['image'], PATHINFO_EXTENSION);
			$new_image = str_replace($extension, '-' . $token . $extension, $data['image']);

			copy(DIR_IMAGE . $data['image'], DIR_IMAGE . $new_image);

			$data['image'] = $new_image;

			$data['product_attribute'] = $this->getProductAttributes($product_id);
			$data['product_description'] = $this->getProductDescriptions($product_id);
			$data['product_discount'] = $this->getProductDiscounts($product_id);
			$data['product_filter'] = $this->getProductFilters($product_id);
			$data['product_image'] = $this->getProductImages($product_id);

			foreach ($data['product_image'] as $idx => $product_image) {
				$extension = '.' . pathinfo($product_image['image'], PATHINFO_EXTENSION);
				$new_image = str_replace($extension, '-' . $token . $extension, $product_image['image']);

				copy(DIR_IMAGE . $product_image['image'], DIR_IMAGE . $new_image);

				$data['product_image'][$idx]['image'] = $new_image;
			}

			$data['product_option'] = $this->getProductOptions($product_id);
			$data['product_variant'] = $this->getProductVariants($product_id);

			if ($data['product_variant']) {
				foreach ($data['product_variant']['variant'] as $key => $variant) {
					$data['product_variant']['variant'][$key]['model'] .= '-' . $token;

					$extension = '.' . pathinfo($variant['image'], PATHINFO_EXTENSION);
					$new_image = str_replace($extension, '-' . $token . $extension, $variant['image']);

					copy(DIR_IMAGE . $variant['image'], DIR_IMAGE . $new_image);

					$data['product_variant']['variant'][$key]['image'] = $new_image;
				}
			}

			$data['product_related'] = $this->getProductRelated($product_id);
			$data['product_reward'] = $this->getProductRewards($product_id);
			$data['product_special'] = $this->getProductSpecials($product_id);
			$data['product_category'] = $this->getProductCategories($product_id);
			$data['product_download'] = $this->getProductDownloads($product_id);
			$data['product_layout'] = $this->getProductLayouts($product_id);
			$data['product_store'] = $this->getProductStores($product_id);
			$data['product_recurrings'] = $this->getRecurrings($product_id);

			$this->addProduct($data);
		}
	}

	public function deleteProduct($product_id)
	{
		$product_info = $this->getProduct($product_id);

		$product_images = $this->getProductImages($product_id);

		$images = array_column($product_images, 'image');
		$images[] = $product_info['image'];

		$product_variant = $this->getProductVariants($product_id);

		$images = array_merge($images, array_column($product_variant['variant'], 'image'));

		foreach ($images as $image) {
			if (!empty($image)) {
				$extension = pathinfo(DIR_IMAGE . $image, PATHINFO_EXTENSION);

				$cache_files = str_replace('.' . $extension, '*', DIR_IMAGE . 'cache/' . $image);

				foreach (glob($cache_files) as $file) {
					if (file_exists($file)) {
						unlink($file);
					}
				}

				if (file_exists(DIR_IMAGE . $image)) {
					unlink(DIR_IMAGE . $image);
				}
			}
		}

		clearstatcache();

		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_recurring WHERE product_id = " . (int)$product_id);
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_product WHERE product_id = '" . (int)$product_id . "'");

		$this->cache->delete('product');
	}

	public function getProduct($product_id)
	{
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getProductBySku($sku)
	{
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product WHERE sku = '" . $this->db->escape($sku) . "'");

		return $query->row;
	}

	public function getProductByModel($model)
	{
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = pov.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pov.model = '" . $this->db->escape($model) . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		$product_data = $query->row;

		if ($query->num_rows) {
			$keyword_query = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_data['product_id'] . "'");

			if ($keyword_query->num_rows) {
				$product_data['keyword'] = $keyword_query->row['keyword'];
			} else {
				$product_data['keyword'] = '';
			}
		}

		return $product_data;
	}

	public function getProducts($data = array())
	{
		$sql = "SELECT p.*, pd.*, pov.*, p.image AS main_image, pov.image AS variant_image,  p2c.category_id, m.name AS manufacturer_name, u.username FROM oc_product p LEFT JOIN `oc_product_option_value` pov ON (pov.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "user u ON (p.user_id = u.user_id) ";

		$filter_data = [];
		$join_data = [];

		if (!empty($data['filter_name'])) {
			$filter_data[] = "pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$filter_data[] = "pov.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$filter_data[] = "pov.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$filter_data[] = "pov.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_product_id']) && !is_null($data['filter_product_id'])) {
			$filter_data[] = "p.product_id = '" . (int)$data['filter_product_id'] . "'";
		}

		if (!empty($data['filter_tag'])) {
			$filter_data[] = "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
		}

		if (!empty($data['filter_username'])) {
			$filter_data[] = "u.username LIKE '%" . $this->db->escape($data['filter_username']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$filter_data[] = "p.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_manufacturer']) && !is_null($data['filter_manufacturer'])) {
			$filter_data[] = "p.manufacturer_id = '" . (int)$data['filter_manufacturer'] . "'";
		}

		if (isset($data['filter_special'])) {
			if ($data['filter_special'] == 'special') {
				$join_data[] = "LEFT JOIN `oc_product_special` ps ON (ps.product_id = p.product_id)";

				$filter_data[] = "ps.product_special_id IS NOT NULL";
			} elseif ($data['filter_special'] == 'discount') {
				$join_data[] = "LEFT JOIN `oc_product_discount` pd2 ON (pd2.product_id = p.product_id)";

				$filter_data[] = "pd2.product_discount_id IS NOT NULL";
			}
		}

		if (isset($data['filter_category'])) {
			if (!empty($data['filter_category'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();

					$implode_data[] = "category_id = '" . (int)$data['filter_category'] . "'";

					$this->load->model('catalog/category');

					$categories = $this->model_catalog_category->getCategories($data['filter_category']);

					foreach ($categories as $category) {
						$implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
					}

					$filter_data[] = "(" . implode(' OR ', $implode_data) . ")";
				} else {
					$filter_data[] = "p2c.category_id = '" . (int)$data['filter_category'] . "'";
				}
			} else {
				$filter_data[] = "p2c.category_id IS NULL";
			}
		}

		$sql .= implode(' ', $join_data);

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if ($filter_data) {
			$sql .= " AND " . implode(' AND ', $filter_data);
		}

		$sql .= " GROUP BY pov.product_option_value_id";

		$sort_data = array(
			'pd.name',
			'pov.model',
			'pov.price',
			'p.product_id',
			'pd.tag',
			'manufacturer_name',
			'p2c.category_id',
			'pov.quantity',
			'p.date_modified',
			'p.status',
			'u.username',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		$sql .= ", pov.product_option_value_id ASC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getProductsByCategoryId($category_id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getProductsAutoComplete($data = [])
	{
		$sql = "SELECT pov.model, pov.price, p.product_id, pd.name FROM `oc_product_option_value` pov LEFT JOIN oc_product p ON (pov.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_model'])) {
			$sql .= " AND pov.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";

			$sql .= " GROUP BY p.product_id";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " ORDER BY pov.model ASC";
		} else {
			$sql .= " ORDER BY pd.name ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getProductDescriptions($product_id)
	{
		$product_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $product_description_data;
	}

	public function getProductCategories($product_id)
	{
		$product_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}

	public function getProductFilters($product_id)
	{
		$product_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_filter_data[] = $result['filter_id'];
		}

		return $product_filter_data;
	}

	public function getProductAttributes($product_id)
	{
		$product_attribute_data = array();

		$product_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' GROUP BY attribute_id");

		foreach ($product_attribute_query->rows as $product_attribute) {
			$product_attribute_description_data = array();

			$product_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

			foreach ($product_attribute_description_query->rows as $product_attribute_description) {
				$product_attribute_description_data[$product_attribute_description['language_id']] = array('text' => $product_attribute_description['text']);
			}

			$product_attribute_data[] = array(
				'attribute_id'                  => $product_attribute['attribute_id'],
				'product_attribute_description' => $product_attribute_description_data
			);
		}

		return $product_attribute_data;
	}

	public function getProductVariantName($option_value_ids)
	{
		$variant_name = [];
		$option_values_id = implode(', ', $option_value_ids);

		$variant_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value_description WHERE option_value_id IN (" . $this->db->escape($option_values_id) . ") AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		$variants_value = array_combine(array_column($variant_value_query->rows, 'option_value_id'), $variant_value_query->rows);

		foreach ($option_value_ids as $id) {
			$variant_name[] = $variants_value[$id]['name'];
		}

		return implode(', ', $variant_name);
	}

	public function getProductVariantsModel($product_id)
	{
		$product_variants_model_data = [];

		$product_variants_query = $this->db->query("SELECT model FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "' ORDER BY model ASC");

		foreach ($product_variants_query->rows as $product_variants_value) {
			$product_variants_model_data[] = $product_variants_value['model'];
		}

		return $product_variants_model_data;
	}

	public function getProductVariants($product_id)
	{
		$product_variants_data = [];
		$variants_data = [];
		$options_data = [];

		$product_variants_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "' ORDER BY product_option_value_id ASC");

		foreach ($product_variants_query->rows as $product_variants_value) {
			$variants_data[] = array(
				'product_option_value_id'	=> $product_variants_value['product_option_value_id'],
				'option_value_id'			=> json_decode($product_variants_value['option_value_id']),
				'model'          			=> $product_variants_value['model'],
				'image'          			=> $product_variants_value['image'],
				'quantity'       			=> $product_variants_value['quantity'],
				'price'          			=> $product_variants_value['price'],
				'points'         			=> $product_variants_value['points'],
				'weight'         			=> $product_variants_value['weight'],
				'weight_class_id'			=> $product_variants_value['weight_class_id']
			);
		}

		$option_ids = json_decode($product_variants_query->row['option_id']);

		if (is_array($option_ids) && $option_ids) {
			$this->load->model('catalog/option');

			$option_value_ids = array_column($variants_data, 'option_value_id');

			$options_data = array_map(function ($option_id, $idx) use ($option_value_ids) {
				$option_info = $this->model_catalog_option->getOption($option_id);

				if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
					$option_info['option_value'] = $this->model_catalog_option->getOptionValues($option_id, array_unique(array_column($option_value_ids, $idx)));

					return $option_info;
				} else {
					return;
				}
			}, $option_ids, array_keys($option_ids));
		}

		$product_variants_data = array(
			'option'	=> $options_data,
			'variant'	=> $variants_data
		);

		return $product_variants_data;
	}

	public function addProductVariant($product_id, $data)
	{
		$option_ids = isset($data['option']) ? array_column($data['option'], 'option_id') : [];

		foreach ($data['variant'] as $variant) {
			$option_value_ids = isset($variant['option_value_id']) ? $variant['option_value_id'] : [];

			$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_id = '" . (int)$product_id . "', option_id = '" . $this->db->escape(json_encode($option_ids)) . "', option_value_id = '" . $this->db->escape(json_encode($option_value_ids)) . "', model = '" . $this->db->escape($variant['model']) . "', image = '" . $this->db->escape($variant['image']) . "', quantity = '" . (int)$variant['quantity'] . "', price = '" . (float)$variant['price'] . "', points = '" . (int)$variant['points'] . "', weight = '" . (float)$variant['weight'] . "', weight_class_id = '" . (int)$variant['weight_class_id'] . "'");
		}
	}

	public function getProductOption($product_id, $option_id)
	{
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$option_id . "'");

		return $query->row;
	}

	public function getProductOptions($product_id)
	{
		$product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $product_option_query->rows;
	}

	public function getProductVariantByModel($model)
	{
		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "product_option_value WHERE model = '" . $this->db->escape($model) . "'";

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getProductImages($product_id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getProductDiscounts($product_id, $model = '')
	{
		$sql = "SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'";

		if (!empty($model)) {
			$sql .= " AND model = '" . $this->db->escape($model) . "'";
		}

		$sql .= " ORDER BY date_end DESC, quantity ASC, priority ASC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getProductSpecials($product_id, $model = '')
	{
		$sql = "SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'";

		if (!empty($model)) {
			$sql .= " AND model = '" . $this->db->escape($model) . "'";
		}

		$sql .= " ORDER BY date_end DESC, priority ASC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getProductRewards($product_id)
	{
		$product_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $product_reward_data;
	}

	public function getProductDownloads($product_id)
	{
		$product_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_download_data[] = $result['download_id'];
		}

		return $product_download_data;
	}

	public function getProductStores($product_id)
	{
		$product_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_store_data[] = $result['store_id'];
		}

		return $product_store_data;
	}

	public function getProductLayouts($product_id)
	{
		$product_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $product_layout_data;
	}

	public function getProductRelated($product_id)
	{
		$product_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}

		return $product_related_data;
	}

	public function getRecurrings($product_id)
	{
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_recurring` WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}

	public function getTotalProducts($data = [])
	{
		$sql = "SELECT COUNT(DISTINCT pov.product_option_value_id) AS total FROM oc_product p LEFT JOIN `oc_product_option_value` pov ON (pov.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) LEFT JOIN " . DB_PREFIX . "user u ON (p.user_id = u.user_id) ";

		$filter_data = [];
		$join_data = [];

		if (!empty($data['filter_name'])) {
			$filter_data[] = "pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$filter_data[] = "pov.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$filter_data[] = "pov.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$filter_data[] = "pov.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_product_id']) && !is_null($data['filter_product_id'])) {
			$filter_data[] = "p.product_id = '" . (int)$data['filter_product_id'] . "'";
		}

		if (!empty($data['filter_tag'])) {
			$filter_data[] = "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
		}

		if (!empty($data['filter_username'])) {
			$filter_data[] = "u.username LIKE '%" . $this->db->escape($data['filter_username']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$filter_data[] = "p.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_manufacturer']) && !is_null($data['filter_manufacturer'])) {
			$filter_data[] = "p.manufacturer_id = '" . (int)$data['filter_manufacturer'] . "'";
		}

		if (isset($data['filter_special'])) {
			if ($data['filter_special'] == 'special') {
				$join_data[] = "LEFT JOIN `oc_product_special` ps ON (ps.product_id = p.product_id)";

				$filter_data[] = "ps.product_special_id IS NOT NULL";
			} elseif ($data['filter_special'] == 'discount') {
				$join_data[] = "LEFT JOIN `oc_product_discount` pd2 ON (pd2.product_id = p.product_id)";

				$filter_data[] = "pd2.product_discount_id IS NOT NULL";
			}
		}

		if (isset($data['filter_category'])) {
			if (!empty($data['filter_category'])) {
				$filter_data[] = "p2c.category_id = '" . (int)$data['filter_category'] . "'";
			} else {
				$filter_data[] = "p2c.category_id IS NULL";
			}
		}

		$sql .= implode(' ', $join_data);

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if ($filter_data) {
			$sql .= " AND " . implode(' AND ', $filter_data);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalProductsByTaxClassId($tax_class_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByStockStatusId($stock_status_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByWeightClassId($weight_class_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByLengthClassId($length_class_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByDownloadId($download_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByManufacturerId($manufacturer_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByAttributeId($attribute_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByOptionId($option_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByProfileId($recurring_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_recurring WHERE recurring_id = '" . (int)$recurring_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByLayoutId($layout_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}

	public function checkProductModel($model, $product_id)
	{
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option_value WHERE model = '" . $this->db->escape($model) . "' AND product_id != '" . (int)$product_id . "'";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}
