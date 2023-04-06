<?php
namespace Opencart\Admin\Model\Extension\Tmdmultivendor\Vendor;
class Store extends \Opencart\System\Engine\Model {
	public function addStore(array $data): int {
		$this->db->query("INSERT INTO " . DB_PREFIX . "vendor_store set vendor_id='".(int)$data['vendor_id']."',country_id='".(int)$data['country_id']."',zone_id='".(int)$data['zone_id']."',logo='".$data['logo']."',store_about='".$this->db->escape($data['store_about'])."',banner='".$data['banner']."',email='".$this->db->escape($data['email'])."',address='".$this->db->escape($data['address'])."',phone='".$this->db->escape($data['phone'])."',city='".$this->db->escape($data['city'])."',postcode='".$this->db->escape($data['postcode'])."',bank_detail='".$this->db->escape($data['bank_detail'])."',tax_number='".$this->db->escape($data['tax_number'])."',shipping_charge='".$this->db->escape($data['shipping_charge'])."',commission='".$this->db->escape($data['commission'])."',date_added=now()");
		
		$vs_id = $this->db->getLastId();
		
		if (isset($data['store_description'])) {
			foreach ($data['store_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " .DB_PREFIX . "vendor_store_description SET vs_id ='" . (int)$vs_id . "',language_id = '" . (int)$language_id ."',name='".$this->db->escape($value['name'])."',description='".$this->db->escape($value['description'])."',meta_description='".$this->db->escape($value['meta_description'])."',meta_keyword='".$this->db->escape($value['meta_keyword'])."',shipping_policy='".$this->db->escape($value['shipping_policy'])."',return_policy='".$this->db->escape($value['return_policy'])."'"); 
			}
		}
		$this->cache->delete('store');

		return $vs_id;
		
	}

	public function editProduct(int $vs_id, array $data): void {
		$this->db->query("UPDATE " . DB_PREFIX . "vendor_store set vendor_id='".(int)$data['vendor_id']."',country_id='".(int)$data['country_id']."',zone_id='".(int)$data['zone_id']."',store_about='".$this->db->escape($data['store_about'])."',logo='".$data['logo']."',banner='".$data['banner']."',email='".$this->db->escape($data['email'])."',address='".$this->db->escape($data['address'])."',phone='".$this->db->escape($data['phone'])."',city='".$this->db->escape($data['city'])."',postcode='".$this->db->escape($data['postcode'])."',bank_detail='".$this->db->escape($data['bank_detail'])."',tax_number='".$this->db->escape($data['tax_number'])."',shipping_charge='".$this->db->escape($data['shipping_charge'])."',commission='".$this->db->escape($data['commission'])."',date_modified=now() where vs_id='".(int)$vs_id."'");
		
		$this->db->query("delete from " . DB_PREFIX . "vendor_store_description where  vs_id ='" . (int)$vs_id."'");
		if (isset($data['store_description'])) {
			foreach ($data['store_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " .DB_PREFIX . "vendor_store_description SET vs_id ='" . (int)$vs_id . "',language_id = '" . (int)$language_id ."',name='".$this->db->escape($value['name'])."',description='".$this->db->escape($value['description'])."',meta_description='".$this->db->escape($value['meta_description'])."',meta_keyword='".$this->db->escape($value['meta_keyword'])."',shipping_policy='".$this->db->escape($value['shipping_policy'])."',return_policy='".$this->db->escape($value['return_policy'])."'"); 
			}
		}
		$this->cache->delete('store');
	}
	
	
	public function deleteStore(int $vs_id): void {
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_store where vs_id='".(int)$vs_id."'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_store_description where vs_id='".(int)$vs_id."'");

		$this->cache->delete('store');
	}

	public function getStore($vs_id) {
		$sql="select * from " . DB_PREFIX . "vendor_store where vs_id='".(int)$vs_id."'";
		$query=$this->db->query($sql);
		return $query->row;
	}
	
	public function getVendorStoreDescriptions($vs_id) {
		$store_descriptio_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."vendor_store_description WHERE vs_id = '" . (int)$vs_id . "'");
		foreach ($query->rows as $result) {
			$store_descriptio_data[$result['language_id']] = array(
				'name'=> $result['name'],
				'meta_keyword'=> $result['meta_keyword'],
				'description'=> $result['description'],
				'meta_description'=> $result['meta_description'],
				'shipping_policy'=> $result['shipping_policy'],
				'return_policy'=> $result['return_policy'],
			);
	 	}
		return $store_descriptio_data;
	}
	

	public function getStores(array $data = []): array {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_store vs LEFT JOIN " . DB_PREFIX . "vendor_store_description vsd ON (vs.vs_id = vsd.vs_id) WHERE vsd.language_id = '" . (int)$this->config->get('config_language_id') . "' and vs.vs_id<>0";

		
		$sort_data = array(
			'vsd.name'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY vsd.name";
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

	public function getTotalStore($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "vendor_store vs LEFT JOIN " . DB_PREFIX . "vendor_store_description vsd ON (vs.vs_id = vsd.vs_id) WHERE vsd.language_id = '" . (int)$this->config->get('config_language_id') . "' and vs.vs_id<>0";
		if(isset($data['vendor_id'])){
			$sql .= " and vendor_id='".(int)$data['vendor_id']."'";
		}
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
}
