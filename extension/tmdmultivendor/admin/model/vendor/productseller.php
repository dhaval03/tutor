<?php
namespace Opencart\Admin\Model\Extension\Tmdmultivendor\Vendor;
class productseller extends \Opencart\System\Engine\Model {
	
	public function saveProductSeller($product_id,$data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_to_product WHERE product_id = '" . (int)$product_id . "'");
			
		$this->db->query("INSERT INTO " . DB_PREFIX . "vendor_to_product SET product_id = '" . (int)$product_id . "', vendor_id = '" . $data['vendor_id'] . "'");
	}
	
	public function getnewProductid() {
		$product = $this->db->query("SELECT auto_increment FROM INFORMATION_SCHEMA.TABLES where table_name ='" . DB_PREFIX . "product' and TABLE_SCHEMA = '".DB_DATABASE."'");
		return $product->row['auto_increment'];
	}
	
	
}