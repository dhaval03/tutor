<?php
namespace Opencart\Catalog\Model\Extension\Tmdmultivendor\Vendor;
class Manufacturer extends \Opencart\System\Engine\Model {
	public function addManufacturer($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$manufacturer_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}

		if (isset($data['manufacturer_store'])) {
			foreach ($data['manufacturer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		// SEO URL
		
		if (isset($data['manufacturer_seo_url'])) {
			foreach ($data['manufacturer_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET `store_id` = '" . (int)$store_id . "', `language_id` = '" . (int)$language_id . "', `key` = 'manufacturer_id', `value` = '" . (int)$manufacturer_id . "', `keyword` = '" . $this->db->escape($keyword) . "'");
				}
			}
		}

		
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_to_manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "vendor_to_manufacturer SET manufacturer_id = '" . (int)$manufacturer_id . "', vendor_id = '" .(int)$this->vendor->getId() . "'");

		
		$this->cache->delete('manufacturer');

		return $manufacturer_id;
	}

	public function editManufacturer($manufacturer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		if (isset($data['manufacturer_store'])) {
			foreach ($data['manufacturer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_to_manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "vendor_to_manufacturer SET manufacturer_id = '" . (int)$manufacturer_id . "', vendor_id = '" . (int)$this->vendor->getId() . "'");


		

        $this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'manufacturer_id' AND `value` = '" . (int)$manufacturer_id . "'");
		
			if (isset($data['manufacturer_seo_url'])) {
			foreach ($data['manufacturer_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET `store_id` = '" . (int)$store_id . "', `language_id` = '" . (int)$language_id . "', `key` = 'manufacturer_id', `value` = '" . (int)$manufacturer_id . "', `keyword` = '" . $this->db->escape($keyword) . "'");
				}
			}
		}
		
		$this->cache->delete('manufacturer');
	}

	public function deleteManufacturer($manufacturer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_to_manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'manufacturer_id' AND `value` = '" . (int)$manufacturer_id . "'");

		$this->cache->delete('manufacturer');
	}

	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row;
	}

	public function getManufacturers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "vendor_to_manufacturer vm ON (m.manufacturer_id = vm.manufacturer_id) where vm.vendor_id<>0";
		
		if(isset($data['vendor_id'])){
			$sql .= " and vm.vendor_id='".(int)$data['vendor_id']."'";
		}
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND m.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'm.name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY m.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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

	public function getManufacturerStores($manufacturer_id) {
		$manufacturer_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		foreach ($query->rows as $result) {
			$manufacturer_store_data[] = $result['store_id'];
		}

		return $manufacturer_store_data;
	}


	public function getManufacturerSeoUrls(int $manufacturer_id): array {
		$manufacturer_seo_url_data = [];

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'manufacturer_id' AND `value` = '" . (int)$manufacturer_id . "'");

		foreach ($query->rows as $result) {
			$manufacturer_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $manufacturer_seo_url_data;
	}
	
	public function getTotalManufacturers($data) {
	
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "vendor_to_manufacturer vm ON (m.manufacturer_id = vm.manufacturer_id) where vm.vendor_id<>0";
		if(isset($data['vendor_id'])){
			$sql .= " and vm.vendor_id='".(int)$data['vendor_id']."'";
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
}
