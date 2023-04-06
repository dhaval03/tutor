<?php
namespace Opencart\Catalog\Model\Extension\Tmdmultivendor\Vendor;
class SeoUrl extends \Opencart\System\Engine\Model {
	public function addSeoUrl($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET store_id = '" . (int)$data['store_id'] . "', language_id = '" . (int)$data['language_id'] . "', query = '" . $this->db->escape($data['query']) . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
	}

	public function editSeoUrl(int $seo_url_id, array $data): void {
		$this->db->query("UPDATE `" . DB_PREFIX . "seo_url` SET `store_id` = '" . (int)$data['store_id'] . "', `language_id` = '" . (int)$data['language_id'] . "', `key` = '" . $this->db->escape((string)$data['key']) . "', `value` = '" . $this->db->escape((string)$data['value']) . "', `keyword` = '" . $this->db->escape((string)$data['keyword']) . "', `sort_order` = '" . (int)$data['sort_order'] . "' WHERE `seo_url_id` = '" . (int)$seo_url_id . "'");
	}

	public function deleteSeoUrl($seo_url_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE seo_url_id = '" . (int)$seo_url_id . "'");
	}
	
	public function getSeoUrl($seo_url_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE seo_url_id = '" . (int)$seo_url_id . "'");

		return $query->row;
	}

	public function getSeoUrls($value): array {
		$product_seo_url_data = [];

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'route' AND `value` = '".$this->db->escape($value)."'");

		foreach ($query->rows as $result) {
			$product_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $product_seo_url_data;
	}
	
	public function saveSeoUrls($data,$value): void {
		$query = $this->db->query("delete FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'route' AND `value` = '".$this->db->escape($value)."'");
	
		foreach ($data[$data['urlformat']] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					
					$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET `store_id` = '" . (int)$store_id . "', `language_id` = '" . (int)$language_id . "', `key` = 'route', `value` = '" . $this->db->escape($value) . "', `keyword` = '" . $this->db->escape($keyword) . "',sort_order='-1'");
				}
			}
		
	}

	public function getTotalSeoUrls($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "seo_url`";
		
		$implode = array();

		if (!empty($data['filter_query'])) {
			$implode[] = "query LIKE '" . $this->db->escape($data['filter_query']) . "'";
		}
		
		if (!empty($data['filter_keyword'])) {
			$implode[] = "keyword LIKE '" . $this->db->escape($data['filter_keyword']) . "'";
		}
		
		if (!empty($data['filter_store_id']) && $data['filter_store_id'] !== '') {
			$implode[] = "store_id = '" . (int)$data['filter_store_id'] . "'";
		}
				
		if (!empty($data['filter_language_id']) && $data['filter_language_id'] !== '') {
			$implode[] = "language_id = '" . (int)$data['filter_language_id'] . "'";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}		
		
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getSeoUrlsByKeyword($keyword) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE keyword = '" . $this->db->escape($keyword) . "'");

		return $query->rows;
	}	
	
	public function getSeoUrlsByQuery($keyword) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE keyword = '" . $this->db->escape($keyword) . "'");

		return $query->rows;
	}	
}