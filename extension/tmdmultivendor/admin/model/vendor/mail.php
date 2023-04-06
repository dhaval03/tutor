<?php
namespace Opencart\Admin\Model\Extension\Tmdmultivendor\Vendor;
class Mail extends \Opencart\System\Engine\Model {
	public function addMail(array $data): int {
		$this->db->query("INSERT INTO " . DB_PREFIX . "vendor_mail set
		sellertype='".$this->db->escape($data['sellertype'])."',
		status='".(int)$data['status']."',
		date_added=now()");
		
		$mail_id = $this->db->getLastId();
		
			foreach ($data['seller_mail'] as $language_id => $value) {
				$this->db->query("INSERT INTO " .DB_PREFIX . "vendor_mail_language SET 
				mail_id ='" . (int)$mail_id . "',
				language_id ='" . (int)$language_id . "',
				subject='".$this->db->escape($value['subject'])."',
				name='".$this->db->escape($value['name'])."',
				message='".$this->db->escape($value['message'])."'
				"); 
			}
		
		$this->cache->delete('mail');

		return $mail_id;
	}

	public function editMail(int $mail_id, array $data): void {
		
		$this->db->query("UPDATE " . DB_PREFIX . "vendor_mail set 
		sellertype='".$this->db->escape($data['sellertype'])."',
		status='".(int)$data['status']."',
		date_modified=now()
		where mail_id='".(int)$mail_id."'");
	
		$this->db->query("delete from " . DB_PREFIX . "vendor_mail_language where  mail_id ='" . (int)$mail_id."'");
		/* 04-03-2019 in update remove isset query */
		
		foreach ($data['seller_mail'] as $language_id => $value) {
				$this->db->query("INSERT INTO " .DB_PREFIX . "vendor_mail_language SET 
				mail_id ='" . (int)$mail_id . "',
				language_id ='" . (int)$language_id . "',
				subject='".$this->db->escape($value['subject'])."',
				name='".$this->db->escape($value['name'])."',
				message='".$this->db->escape($value['message'])."'
				"); 
			}
		$this->cache->delete('mail');
	}
	
	public function deleteMail(int $mail_id): void {
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_mail where mail_id='".(int)$mail_id."'");
		$this->cache->delete('mail');
	}
	public function getMail(int $mail_id): array {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_mail where mail_id='".(int)$mail_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public  function getMailInfo($sellertype){
		$query=$this->db->query("select * from " . DB_PREFIX . "vendor_mail vm LEFT JOIN " . DB_PREFIX . "vendor_mail_language vml on(vm.mail_id=vml.mail_id) where vm.sellertype='" .$sellertype."'and vml.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
		
	}

	public function getMails(array $data=[]):array {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_mail vm left join " . DB_PREFIX . "vendor_mail_language vml ON (vm.mail_id = vml.mail_id) where vml.language_id = '" . (int)$this->config->get('config_language_id') . "' and vm.mail_id<>0";
				
		$sort_data = array(
			'vml.name',
			'vm.mail_id'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY vm.mail_id";
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

	public function getTotalMail(): int {

		$query = $this->db->query("SELECT COUNT(*) AS `total` FROM `" . DB_PREFIX . "vendor_mail`");

		return (int)$query->row['total'];
	}
	
	public function getMailLanguage(int $mail_id): array {
		$mail_data = array();
		/* 04-03-2019 in update query */
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."vendor_mail_language WHERE  mail_id = '" . (int)$mail_id . "'");
		foreach ($query->rows as $result) {
			$mail_data[$result['language_id']] = array(
				'name'		    => $result['name'],
				'message'		=> $result['message'],
				'subject'		=> $result['subject']
			);	
	 	}
		return $mail_data;
	}
	
}
