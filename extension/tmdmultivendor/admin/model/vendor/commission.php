<?php
namespace Opencart\Admin\Model\Extension\Tmdmultivendor\Vendor;
class Commission extends \Opencart\System\Engine\Model {
	public function addCommission(array $data): int {
		$this->db->query("INSERT INTO " . DB_PREFIX . "vendor_commission set
			category_id='".(int)$data['category_id']."',
			fixed='".(int)$data['fixed']."',
			percentage='".(int)$data['percentage']."',
			date_added=now()");
		$commission_id = $this->db->getLastId();

		$this->cache->delete('commission');

		return $commission_id;
	}

	public function editCommission(int $commission_id, array $data): void {
		$this->db->query("UPDATE " . DB_PREFIX . "vendor_commission set 
			category_id='".(int)$data['category_id']."',
			fixed='".(int)$data['fixed']."',
			percentage='".(int)$data['percentage']."',
			date_modified=now()
			where commission_id='".(int)$commission_id."'");
		
		$this->cache->delete('commission');
	}
	
	public function deleteCommission(int $commission_id): void {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "vendor_commission` WHERE `commission_id` = '" . (int)$commission_id . "'");
		$this->cache->delete('commission');

	}

	public function getCommission(int $commission_id): array {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_commission where commission_id='".(int)$commission_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getCommissions(array $data = []): array {
		
		$sql = "SELECT c.`commission_id`, cd.`name`, c.`percentage`, c.`fixed`, c.`date_added`, c.`date_modified` FROM `" . DB_PREFIX . "vendor_commission` c LEFT JOIN `" . DB_PREFIX . "category_description` cd ON (c.`category_id` = cd.`category_id`) WHERE cd.`language_id` = '" . (int)$this->config->get('config_language_id') . "'";

		
		if (isset($data['filter_id'])){
		 	$sql .=" and commission_id like '".$this->db->escape($data['filter_id'])."%'";
		}

		if (!empty($data['filter_category'])) {
			$sql .= " AND cd.`name` LIKE '" . $this->db->escape((string)$data['filter_category'] . '%') . "'";
		}
		
		$sort_data = array(
			'cd.name',
			'c.percentage',
			'c.commission_id',
			'c.fixed',
			'cd.category_id'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY c.commission_id";
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

	// public function getTotalCommission(int $commission_id): array {
		public function getTotalCommission(array $data = []): int {
		$sql = "SELECT COUNT(*) AS `total` FROM `" . DB_PREFIX . "vendor_commission` c LEFT JOIN `" . DB_PREFIX . "category_description` cd ON (c.`category_id` = cd.`category_id`) WHERE cd.`language_id` = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_id'])){
		 	$sql .=" and commission_id like '".$this->db->escape($data['filter_id'])."%'";
		}

		if (!empty($data['filter_category'])) {
			$sql .= " AND cd.`name` LIKE '" . $this->db->escape((string)$data['filter_category'] . '%') . "'";
		}

		$query = $this->db->query($sql);

		return (int)$query->row['total'];
	}
}
