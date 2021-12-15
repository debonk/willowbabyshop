<?php
class ModelSettingSetting extends Model {
	public function getSetting($code, $store_id = 0) {
		$setting_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "'");

		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$setting_data[$result['key']] = $result['value'];
			} else {
				$setting_data[$result['key']] = json_decode($result['value'], true);
			}
		}

		return $setting_data;
	}

	public function editSetting($code, $data, $store_id = 0) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "'");

		foreach ($data as $key => $value) {
			if (substr($key, 0, strlen($code)) == $code) {
				// RJ - 20160115 - Start
				if (($this->db->escape($key) == 'config_url') || ($this->db->escape($key) == 'config_ssl')){
				
					# Terminate URL correctly
					if (substr($value,strlen($value)-1,1) != '/') {
						$value = $value . '/';
					}																
	
					# Force protocol to secure if secure has been selected
					if ($data['config_secure'] == '1') {
						$value = $this->replaceProtocol($value, 'https://');
					}
				 
					# update local variables and update store table
					$data[$key] = $value;
					$this->UpdateStore((int)$store_id,$data);
				}
				// RJ - 20160115 - End

				if (!is_array($value)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value, true)) . "', serialized = '1'");
				}
			}
		}
	}

	public function deleteSetting($code, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "'");
	}
	
	public function getSettingValue($key, $store_id = 0) {
		$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `key` = '" . $this->db->escape($key) . "'");

		if ($query->num_rows) {
			return $query->row['value'];
		} else {
			return null;	
		}
	}
	
	public function editSettingValue($code = '', $key = '', $value = '', $store_id = 0) {
		if (!is_array($value)) {
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($value) . "', serialized = '0'  WHERE `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape(json_encode($value)) . "', serialized = '1' WHERE `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
		}
	}
             
	function removeProtocol($URL) {  // RJ-20141213 - Remove protocols from URL
		$newURL = $URL;
		$offset = strpos($URL,'://');
		if ($offset){
			$newURL = substr($URL,$offset + 3);
		}
		$newURL = str_replace('www.', '', $newURL);
		$newURL = str_replace('//', '/', $newURL);	// Make sure no double slashes are in url (at end))
		return $newURL;
   }

   function replaceProtocol($URL, $protocol) {  // RJ-20141213 - add secure protocol to URL
	   	$newURL = $this->removeProtocol($URL);                        	  
	   	$newURL = $protocol . $newURL;
	   	if (substr($newURL,-1,1) != '/') {
	   		$newURL .= '/';
	   	}
	   	return $newURL;
   }
        
	function UpdateStore($store_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "store SET name = '" . $this->db->escape($data['config_name']) . "', `url` = '" . $this->db->escape($data['config_url']) . "', `ssl` = '" . $this->db->escape($data['config_ssl']) . "' WHERE store_id = '" . (int)$store_id . "'");

		$this->cache->delete('store');
	}
}
