<?php 
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
// Lib Include 
require_once(DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/Psr/autoloader.php');
require_once(DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/myclabs/Enum.php');
require_once(DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/ZipStream/autoloader.php');
require_once(DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/ZipStream/ZipStream.php');
require_once(DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/PhpSpreadsheet/autoloader.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
// Lib Include


class Export extends \Opencart\System\Engine\Controller {
public function index(): void {		
		$this->load->language('extension/tmdmultivendor/vendor/export');
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', true));
		}
		// Default opencart table field list ///
		$defaultfild=array();
		$defaultfild[]='product_id';
		$defaultfild[]='model';
		$defaultfild[]='sku';
		$defaultfild[]='upc';
		$defaultfild[]='ean';
		$defaultfild[]='jan';
		$defaultfild[]='isbn';
		$defaultfild[]='mpn';
		$defaultfild[]='location';
		$defaultfild[]='quantity';
		$defaultfild[]='stock_status_id';
		$defaultfild[]='image';
		$defaultfild[]='manufacturer_id';
		$defaultfild[]='shipping';
		$defaultfild[]='price';
		$defaultfild[]='points';
		$defaultfild[]='tax_class_id';
		$defaultfild[]='date_available';
		$defaultfild[]='weight';
		$defaultfild[]='weight_class_id';
		$defaultfild[]='length';
		$defaultfild[]='width';
		$defaultfild[]='height';
		$defaultfild[]='length_class_id';
		$defaultfild[]='subtract';
		$defaultfild[]='minimum';
		$defaultfild[]='sort_order';
		$defaultfild[]='status';
		$defaultfild[]='date_added';
		$defaultfild[]='date_modified';
		$defaultfild[]='master_id';
		$defaultfild[]='variant';
		$defaultfild[]='override';
		
		// Default opencart table field list ///
		$this->document->setTitle($this->language->get('heading_title'));
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['button_export'] = $this->language->get('button_export');
		$data['button_exportoc'] = $this->language->get('button_exportoc');
		$data['entry_exportxls'] = $this->language->get('entry_exportxls');
		$data['entry_exportocxls'] = $this->language->get('entry_exportocxls');
		$data['entry_number'] = $this->language->get('entry_number');
		$data['help_number'] = $this->language->get('help_number');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_manufature'] = $this->language->get('entry_manufature');
		$data['entry_stores'] = $this->language->get('entry_stores');
		$data['entry_language'] = $this->language->get('entry_language');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_extrafiled'] = $this->language->get('entry_extrafiled');
		$data['entry_stock_status'] = $this->language->get('entry_stock_status');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_productname'] = $this->language->get('entry_productname');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_producturl'] = $this->language->get('entry_producturl');
		$data['entry_review'] = $this->language->get('entry_review');
		
		
		$data['text_all_manufacturer'] = $this->language->get('text_all_manufacturer');
		$data['text_all_category'] = $this->language->get('text_all_category');
		$data['text_all_status'] = $this->language->get('text_all_status');
		$data['text_all_language'] = $this->language->get('text_all_language');
		$data['text_all_stores'] = $this->language->get('text_all_stores');
		$data['text_all_stockstatus'] = $this->language->get('text_all_stockstatus');
		
		if (isset($this->request->get['number'])) {
			$data['number'] = $this->request->get['number'];
		} else {
			$data['number'] = '0';
		}
		
		
		
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		
		$vendor_id = $this->vendor->getId();
		$product_cont=$this->model_extension_tmdmultivendor_vendor_vendor->getTotalProducts($vendor_id);
		
		
		if (isset($this->request->get['end'])) {
			$data['end'] = $this->request->get['end'];
		}elseif (!empty($product_cont)) {
			$data['end'] = $product_cont;
			}
		else {
			$data['end'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];
		
			unset($this->session->data['warning']);
		} else {
			$data['error_warning'] = '';
		}
		
  		$data['breadcrumbs'] = [];

   		$data['breadcrumbs'][] = [
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard')
		];

   		$data['breadcrumbs'][] = [
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/tmdmultivendor/vendor/export')
   		];
		
		$data['restore'] = $this->url->link('extension/tmdmultivendor/vendor/export|export', 'language=' . $this->config->get('config_language'));
		
		$this->load->model('catalog/category');
		
		$data['categories'] = array();
			
		$data1 = array(
		);
		$results = $this->model_catalog_category->getCategories(0);
	
		foreach ($results as $result) {
		
		$data['categories'][] = array(
				'category_id' => $result['category_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['category_id'], $this->request->post['selected'])
				
			);
			
		}
		
		////////////// Custome filed //
		$query=$this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product");
		$data['cfiled']=array();
		foreach($query->rows as $row)
		{
			if(!in_array($row['Field'],$defaultfild))
			{
			$data['cfiled'][]=$row['Field'];
			}
		}
		
		
		
		////////////// Custome filed //
		/////////// Manufature
		$this->load->model('catalog/manufacturer');
		$data['product_manufacturers']= $this->model_catalog_manufacturer->getManufacturers();
		/////////// Manufature
		
		
		
		/////////// Stores
		$this->load->model('setting/store');
		$data['stores'] = $this->model_setting_store->getStores();
		/////////// Stores
		
		/////////// Stock status
		$this->load->model('extension/tmdmultivendor/localisation/stock_status');
		$data['stock_statuses'] = $this->model_extension_tmdmultivendor_localisation_stock_status->getStockStatuses();
		/////////// Stores
		
		/////////// Stock status
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		/////////// Stores
		
		
		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');
				
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/export', $data));
	}
	
	
	public function export() {
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', true));
		}
		$data=array();
		$start=$this->request->post['number'];
		$end2=$this->request->post['end'];
		$productreview=$this->request->post['productreview'];
		if(!empty($this->request->post['category']))
		{
		$category=true;
		$categoryvalue=$this->request->post['category'];
		}
		else
		{
		$category=false;
		}
		
		if(!empty($this->request->post['manufacturer_id']))
		{
			$manufacturer_id=$this->request->post['manufacturer_id'];
		}
		else
		{
			$manufacturer_id=false;
		}
		
		if(!empty($this->request->post['stock_status_id']))
		{
			$stock_status_id=$this->request->post['stock_status_id'];
		}
		else
		{
			$stock_status_id=false;
		}
		
		if(!empty($this->request->post['status']))
		{
			$status=$this->request->post['status'];
		}
		else
		{
			$status=false;
		}
		
		if(!empty($this->request->post['language_id']))
		{
			$language_id=$this->request->post['language_id'];
		}
		else
		{
			$language_id=(int)$this->config->get('config_language_id');
		}
		
		if(!empty($this->request->post['productimage']))
		{
			$productimage=$this->request->post['productimage'];
		}
		else
		{
			$productimage=0;
		}
		
		
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguage($language_id);
		$language_code=$languages['code'];
		
		
		
		if(!empty($this->request->post['productname']))
		{
			$productname=$this->request->post['productname'];
		}
		else
		{
			$productname=false;
		}
		
		if(!empty($this->request->post['model']))
		{
			$model=$this->request->post['model'];
		}
		else
		{
			$model=false;
		}
		
		if(!empty($this->request->post['price']))
		{
			$price=$this->request->post['price'];
		}
		else
		{
			$price=false;
		}
		if(!empty($this->request->post['vendor']))
		{
			$vendor=$this->request->post['vendor'];
		}
		else
		{
			$vendor=false;
		}
		if(!empty($this->request->post['price1']))
		{
			$price1=$this->request->post['price1'];
		}
		else
		{
			$price1=false;
		}
		if(!empty($this->request->post['quantity']))
		{
			$quantity=$this->request->post['quantity'];
		}
		else
		{
			$quantity=false;
		}
		
		if(!empty($this->request->post['store_id']))
		{
			$store_id=$this->request->post['store_id'];
		}
		else
		{
			$store_id=false;
		}
		$cfiled=array();
		if(isset($this->request->post['cfiled']))
		{
			$cfiled=$this->request->post['cfiled'];
		}
		$sql="SELECT * FROM `".DB_PREFIX."product` as p left join ".DB_PREFIX."product_description as pd on p.`product_id`= pd.`product_id` ";
		
		
		if($category)
			{
			$sql .=" left join ".DB_PREFIX."product_to_category as pc on pc.`product_id`= p.`product_id`   ";
			}
		if($store_id)
			{
			$sql .=" left join ".DB_PREFIX."product_to_store as pts on pts.product_id= p.product_id   ";
			}
		if($vendor)
			{
			$sql .=" left join ".DB_PREFIX."vendor_to_product as vtp on vtp.`product_id`= p.`product_id`   ";
		}
		
		$sql .=" where pd.language_id = '" . $language_id . "' ";
		
		if($category)
			{
			$sql .="  and  pc.category_id='".$categoryvalue."'";
			}
		
		if($manufacturer_id)
			{
			$sql .="  and  p.manufacturer_id='".$manufacturer_id."'";
			}
			
		if($stock_status_id)
			{
			$sql .="  and  p.stock_status_id='".$stock_status_id."'";
			}
			if($vendor)
			{
			$sql .="  and  vtp.vendor_id='".$vendor."'";
			}
			
		if($status)
			{
			if($status==2)
			{
			$status=0;
			}
			$sql .="  and  p.status='".$status."'";
			}
			
		if($status)
			{
			$sql .="  and  p.status='".$status."'";
			}
		if($productname)
			{
			$sql .="  and  pd.name like '".$productname."%'";
			}
		if($model)
			{
			$sql .="  and  p.model like '".$model."%'";
			}
		if($price)
			{
			$sql .="  and  p.price>='".$price."'";
			}
		if($price1)
			{
			$sql .="  and  p.price<='".$price1."'";
			}
		if($quantity)
			{
			$sql .="  and  p.quantity='".$quantity."'";
			}
		
		if($store_id)
			{
				$store_id1=$store_id;
			$sql .=" and pts.store_id='".$store_id."'";
			}

		if(isset($end2) && isset($start))
		{
			$sql .=" limit ".(int)$start.",".(int)$end2."";
			
		}
		
		
		$query=$this->db->query($sql);
		
		foreach($query->rows as $row){
		
		//////////////////////////// seo_keyword///
		$seo_keyword='';
		$sqlseo="SELECT * FROM " . DB_PREFIX . "seo_url WHERE `key` = 'product_id=" . (int)$row['product_id'] . "'";
		if(!empty($store_id1)){
			$sqlseo .=" and store_id = '" . (int)$store_id1 . "'";
		}
		else{ $sqlseo .=" and store_id = '0'"; }
		$sqlseo .=" and  language_id = '" . (int)$language_id . "' limit 0,1";
		$query1 = $this->db->query($sqlseo);
		if(isset($query1->row['keyword']))
		{
		$seo_keyword=$query1->row['keyword'];
		}
		///////////////////////////////seo_keyword///////
		
		////////////////////////////////manufacturer///////////
		$manufacturer='';
		$manufacturerid='';
		$query1 = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer  where manufacturer_id = '" . (int)$row['manufacturer_id'] . "'");
		if($query1->row)
		{
		$manufacturerid=$query1->row['manufacturer_id'];		
		$manufacturer=$query1->row['name'];		
		}
		////////////////////////////////manufacturer///////////
		
		///////////////////////////////////// Category ////////////
		$categories='';
		$categoriesid='';
		$sq11=$this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category where product_id='".$row['product_id']."'");
		if($sq11->rows)
		{
		foreach($sq11->rows as $category_id)
		{
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, c.parent_id, c.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c ON (cp.path_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (c.category_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . $language_id . "' AND cd2.language_id = '" . $language_id . "'";
		$sql .= " AND cd2.category_id = '" . $category_id['category_id'] . "'";
		$sql .= " GROUP BY cp.category_id ORDER BY name";
		$categoryqyery=$this->db->query($sql);
		if(isset($categoryqyery->row['name']))
		{
			$categories .=$categoryqyery->row['name'].';';
			$categoriesid .=$categoryqyery->row['category_id'].';';
		}
		}
		}
		///////////////////////////////////// Category ////////////
		
		///////////////////////////////////// Stores ////////////
		$stores='';
		$storeids='';
		$sq11=$this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store where product_id='".$row['product_id']."'");
		if($sq11->rows)
		{
		foreach($sq11->rows as $store_id)
        {
        if($store_id['store_id']==0)
        {
        $stores='default;';	
        $storeids .='0;';
        }

        $sq12=$this->db->query("SELECT * FROM " . DB_PREFIX . "store where store_id='".$store_id['store_id']."'");
        if($sq12->row)
        {
        $stores .=$sq12->row['name'].';';
        $storeids .=$store_id['store_id'].';';	
        }
        }
		}
		
		///////////////////////////////////// Stores ////////////
		
		
		///////////////////////////////////// images ////////////
		$images='';
		$sq11=$this->db->query("SELECT * FROM " . DB_PREFIX . "product_image where product_id='".$row['product_id']."'");
		if($sq11->rows)
		{
		foreach($sq11->rows as $image)
		{
			if(!empty($this->request->post['productimage']))
			{
				$images .=HTTP_CATALOG.'image/'.$image['image'].';';
			}
			else
			{
				$images .=$image['image'].';';
			}
		}
		}
		
		///////////////////////////////////// images ////////////
		
		///////////////////////////////////// Product Special ////////////
		$product_sp='';
		$sq11=$this->db->query("SELECT * FROM " . DB_PREFIX . "product_special where product_id='".$row['product_id']."' order by product_special_id DESC");
		if($sq11->rows)
		{
		foreach($sq11->rows as $sp)
		{
		$product_sp .=$sp['customer_group_id'].':'.$sp['date_start'].':'.$sp['date_end'].':'.$sp['price'].';';
		}
		}
		///////////////////////////////////// Product Special ////////////
		
		
		////////////////////////////////// Option Collection option:type
		$options='';
		$option_value_ids=array();
		$sq11=$this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po left join " . DB_PREFIX . "option_description od on od.option_id=po.option_id  left join `" . DB_PREFIX . "option` o on o.option_id=po.option_id  where po.product_id='".$row['product_id']."' group by od.option_id");
		if($sq11->rows)
		{
		foreach($sq11->rows as $option)
		{
		$option['name']=str_replace('-','/',$option['name']);	
		$options .=str_replace('&amp;','&',$option['name']).':'.$option['type'].';';
		$option_value_ids[]=array('option_id'=>$option['option_id'],'name'=>$option['name'],'type'=>$option['type'],'value'=>$option['value']);
		}
		}
		
		////////////////////////////////// Option Collection
		////////////////////////////////// Option value collections 
		///////////////option:value1-qty-Subtract Stock-Price-Points-Weight;
		$optionvalue='';
		foreach($option_value_ids as $option)
		{
		
		$sq11=$this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value po left join " . DB_PREFIX . "option_value_description od on od.option_value_id=po.option_value_id  left join " . DB_PREFIX . "option_value ov on ov.option_value_id=po.option_value_id  where po.product_id='".$row['product_id']."'  and po.option_id='".$option['option_id']."' group by po.option_value_id");
		if(isset($sq11->row['option_id'])){
		foreach($sq11->rows as $option_value)
		{
		$sq12=$this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po left join " . DB_PREFIX . "option_description od on od.option_id=po.option_id  left join `" . DB_PREFIX . "option` o on o.option_id=po.option_id  where po.product_id='".$row['product_id']."' and po.option_id='".$option_value['option_id']."'");
		if(isset($option_value['name'])){
		$option['name']=str_replace('-','/',$sq12->row['name']);		
		$option_value['name']=str_replace('-','/',$option_value['name']);	
		$optionvalue .=str_replace('&amp;','&',$option['name']).':'.str_replace('&amp;','&',$option_value['name']).'-'.$option_value['quantity'].'-'.$option_value['subtract'].'-'.round($option_value['price'],2).'-'.$option_value['points'].'-'.round($option_value['weight'],2).'-'.$option_value['sort_order'].';';
		}
		}
		}
		else
		{
			$optionvalue .=str_replace('&amp;','&',$option['name']).':'.str_replace('&amp;','&',$option['value']).';';
		}
		}
		////////////////////////////////// Option value collections
		
		////////////////////////////// Filter group name collection////////
		$filter_group='';
		$sq11=$this->db->query("SELECT * FROM " . DB_PREFIX . "product_filter po left join " . DB_PREFIX . "filter od on od.filter_id=po.filter_id left join " . DB_PREFIX . "filter_group_description fgd on fgd.filter_group_id=od.filter_group_id left join " . DB_PREFIX . "filter_group fg on fg.filter_group_id=od.filter_group_id where po.product_id='".$row['product_id']."' and fgd.language_id='".$language_id."'");
		if($sq11->rows)
		{
		foreach($sq11->rows as $filter_groups)
		{
			$filter_group .=$filter_groups['name'].':'.$filter_groups['sort_order'].';';
		}
		}
		////////////////////////////// Filter group name collection////////
		
		////////////////////////////// Filter group name collection////////
		$filter_name='';
		$sq11=$this->db->query("SELECT fgd.name as groupname,od.name as name,fgdn.sort_order FROM " . DB_PREFIX . "product_filter po left join " . DB_PREFIX . "filter_description od on od.filter_id=po.filter_id left join " . DB_PREFIX . "filter_group_description fgd on fgd.filter_group_id=od.filter_group_id left join " . DB_PREFIX . "filter fgdn on fgdn.filter_id=po.filter_id   where po.product_id='".$row['product_id']."' and fgd.language_id='".$language_id."' and od.language_id='".$language_id."'");
		if($sq11->rows)
		{
		foreach($sq11->rows as $filter_names)
		{
			$filter_name .=$filter_names['groupname'].'='.$filter_names['name'].':'.$filter_names['sort_order'].';';
		}
		}
		////////////////////////////// Filter group name collection////////
		
		////////////////////////////// Discount collection////////
		$discounts='';
		$sq11=$this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount where product_id='".$row['product_id']."'");
		if($sq11->rows)
		{
		foreach($sq11->rows as $discount)
		{
			$discounts .=$discount['customer_group_id'].':'.$discount['quantity'].':'.$discount['priority'].':'.$discount['price'].':'.$discount['date_start'].':'.$discount['date_end'].';';
		}
		}
		////////////////////////////// Discount collection////////
		
		
		////////////////////////////// att collection////////
		$atts='';
		$sq11=$this->db->query("SELECT agd.name as groupname,ag.sort_order as groupsort,ad.name as attname,a.sort_order as attsort,pa.text as text from  " . DB_PREFIX . "product_attribute pa   left join " . DB_PREFIX . "attribute a on a.attribute_id=pa.attribute_id  left join " . DB_PREFIX . "attribute_description ad on ad.attribute_id=pa.attribute_id left join " . DB_PREFIX . "attribute_group ag on ag.attribute_group_id=a.attribute_group_id  left join " . DB_PREFIX . "attribute_group_description agd on agd.attribute_group_id=ag.attribute_group_id  where pa.product_id='".$row['product_id']."' and ad.language_id='".$language_id."' and agd.language_id='".$language_id."'  and ad.language_id='".$language_id."'");
		if($sq11->rows)
		{
		foreach($sq11->rows as $att)
		{
			$atts .=$att['groupname'].':'.$att['groupsort'].'='.$att['attname'].'-'.$att['text'].'-'.$att['attsort'].';';
		}
		}
		////////////////////////////// att collection////////
		
		/////////////////////////////// Related product//////
		$related='';
		$relatedid='';
		$sq11=$this->db->query("SELECT pn.model as model,pn.product_id FROM " . DB_PREFIX . "product_related  pr  left join " . DB_PREFIX . "product pn on pn.product_id=pr.related_id where pr.product_id='".$row['product_id']."'");
		if($sq11->rows)
		{
		foreach($sq11->rows as $rp)
		{
		$relatedid .=$rp['product_id'].';';
		$related .=$rp['model'].';';
		}
		}
		
		////////////////////////Main Image
			$productimage=$row['image'];
			if(!empty($this->request->post['productimage']))
			{
				$productimage=HTTP_CATALOG.'image/'.$row['image'];
			}
		////////////////
		/////////////////////////////// Related product//////
		
		////////////////////// Product Review //////////////
		$reviews='';
		if(isset($productreview))
		{
			$sq11=$this->db->query("SELECT * FROM " . DB_PREFIX . "review  r   where product_id='".$row['product_id']."'");
			if($sq11->rows)
			{
				foreach($sq11->rows as $review)
				{
					
					$reviews .=$review['customer_id'].'::'.$review['author'].'::'.$review['text'].'::'.$review['rating'].'::'.$review['status'].'::'.$review['date_added'].'::'.$review['date_modified'].'|';
					
				}
			}
		}
		
		////////////////////// Product Review //////////////
		
		////////////////////// Product Download //////////////
		$downloadids='';
		if(isset($downloadids))
		{
			$sq11=$this->db->query("SELECT download_id	 FROM " . DB_PREFIX . "product_to_download   where product_id='".$row['product_id']."'");
			if($sq11->rows)
			{
				foreach($sq11->rows as $download)
				{
					
					$downloadids .=$download['download_id'].';';
					
				}
			}
		}
		
		
		$vendor_id=0;
		$vendor='';
		
		/// Check vendor information ////
		$sq11=$this->db->query("SELECT v.vendor_id,v.firstname,v.lastname FROM  " . DB_PREFIX . "vendor_to_product ptv left join  `" . DB_PREFIX . "vendor` v on v.vendor_id=ptv.vendor_id where ptv.product_id='".$row['product_id']."'");
			if(isset($sq11->rows))
			{
				foreach($sq11->rows as $vendorinfo)
				{
					
					$vendor_id=$vendorinfo['vendor_id'];
					$vendor=$vendorinfo['firstname'].' '.$vendorinfo['lastname'];
		
					
				}
			}
		/// Check vendor information ////
		
		////////////////////// Product Download //////////////
		
		$product= array( 
		'product_id'=>$row['product_id'],
		'language'=>$language_code,
		'stores'=>$stores,
		'storeids'=>$storeids,
		'model'=>$row['model'],
		'sku'=>$row['sku'],
		'upc'=>$row['upc'],
		'ean'=>$row['ean'],
		'jan'=>$row['jan'],
		'isbn'=>$row['isbn'],
		'mpn'=>$row['mpn'],
		'location'=>$row['location'],
		'name'=>$row['name'],
		'meta_tag_description'=>$row['meta_description'],
		'meta_tag_keywords'=>$row['meta_keyword'],
		'description'=>html_entity_decode($row['description']),
		'tag'=>$row['tag'],
		'price'=>$row['price'],
		'quantity'=>$row['quantity'],
		'minimum_quantity'=>$row['minimum'],
		'subtract_stock'=>$row['subtract'],
		'out_stockstat'=>$row['stock_status_id'],
		'require_shipping'=>$row['shipping'],
		'seo_keyword'=>$seo_keyword,
		'img_main'=>$productimage,
		'date_avail'=>$row['date_available'],
		'len_class'=>$row['length_class_id'],
		'length'=>$row['length'],
		'width'=>$row['width'],
		'height'=>$row['height'],
		'weight'=>$row['weight'],
		'weight_class'=>$row['weight_class_id'],
		'status'=>$row['status'],
		'sort_order'=>$row['sort_order'],
		'manufacturerid'=>$manufacturerid,
		'manufacturer'=>$manufacturer,
		'categoriesid'=>$categoriesid,
		'categories'=>$categories,
		'related'=>$related,
		'relatedid'=>$relatedid,
		'option'=>$options,
		'option_val'=>$optionvalue,
		'image1'=>$images,
		'product_sp'=>$product_sp,
		'tax_class'=>$row['tax_class_id'],
		'filter_group'=>$filter_group,
		'filter_name'=>$filter_name,
		'att'=>$atts,
		'discount'=>$discounts,
		'point'=>$row['points'],
		'meta_title'=>$row['meta_title'],
		'downloadid'=>$downloadids,
		'vendor_id'=>$vendor_id,
		'vendor'=>$vendor,
		'reviews'=>$reviews
		);
		
		
		
		$productextrainfo=array();
		if(isset($cfiled))
					  {
						  foreach($cfiled as $cfile)
						  {
							   $cfile=trim($cfile);
							   $productextrainfo[$cfile]=$row[$cfile];
						  }  
        $data[]=array_merge($product,$productextrainfo)	;             
		}
		else
		{
			$data[]=$product;
		}
		
		
		
		}

		$spreadsheet = new Spreadsheet();
		$sheet_numbers = 0;
			$sheet = $spreadsheet->getActiveSheet($sheet_numbers);
			$spreadsheet->setActiveSheetIndex($sheet_numbers);
		// Set properties
		
						$i=1;
					  $spreadsheet->getActiveSheet()->SetCellValue('A'.$i, 'Product ID');
					  $spreadsheet->getActiveSheet()->SetCellValue('B'.$i, 'Language');
					  $spreadsheet->getActiveSheet()->SetCellValue('C'.$i, 'Stores');
					  $spreadsheet->getActiveSheet()->SetCellValue('D'.$i, 'Stores id (0=Store;1=next if presemt) (1=2)');
					  $spreadsheet->getActiveSheet()->SetCellValue('E'.$i, 'Model');
                      $spreadsheet->getActiveSheet()->SetCellValue('F'.$i, 'SKU');
                      $spreadsheet->getActiveSheet()->SetCellValue('G'.$i, 'UPC');
                      $spreadsheet->getActiveSheet()->SetCellValue('H'.$i, 'EAN');
                      $spreadsheet->getActiveSheet()->SetCellValue('I'.$i, 'JAN');
                      $spreadsheet->getActiveSheet()->SetCellValue('J'.$i, 'ISBN');
                      $spreadsheet->getActiveSheet()->SetCellValue('K'.$i, 'MPN');
                      $spreadsheet->getActiveSheet()->SetCellValue('L'.$i, 'Location');
                      $spreadsheet->getActiveSheet()->SetCellValue('M'.$i, 'Product Name');
                      $spreadsheet->getActiveSheet()->SetCellValue('N'.$i, 'Meta Tag Description');
                      $spreadsheet->getActiveSheet()->SetCellValue('O'.$i, 'Meta Tag Keywords');
                      $spreadsheet->getActiveSheet()->SetCellValue('P'.$i, 'Description');
                      $spreadsheet->getActiveSheet()->SetCellValue('Q'.$i, 'Product Tags');
                      $spreadsheet->getActiveSheet()->SetCellValue('R'.$i, 'Price');
                      $spreadsheet->getActiveSheet()->SetCellValue('S'.$i, 'Quantity');
                      $spreadsheet->getActiveSheet()->SetCellValue('T'.$i, 'Minimum Quantity');
                      $spreadsheet->getActiveSheet()->SetCellValue('U'.$i, 'Subtract Stock  (1=YES 0= NO)');
                      $spreadsheet->getActiveSheet()->SetCellValue('V'.$i, 'Out Of Stock Status  (5=Out Of Stock , 8=Pre-Order , In Stock=7, 6=2 - 3 Days)');
                      $spreadsheet->getActiveSheet()->SetCellValue('W'.$i, 'Requires Shipping (1=YES 0= NO)');
                      $spreadsheet->getActiveSheet()->SetCellValue('X'.$i, 'SEO Keyword  (Must Unquie)');
                      $spreadsheet->getActiveSheet()->SetCellValue('Y'.$i, 'Image(Main image)');
                      $spreadsheet->getActiveSheet()->SetCellValue('Z'.$i, 'Date Available (Y-m-d)');
                      $spreadsheet->getActiveSheet()->SetCellValue('AA'.$i, 'Length Class (1=Centimeter, 3=Inch, 2=Millimeter)');
                      $spreadsheet->getActiveSheet()->SetCellValue('AB'.$i, 'Length');
                      $spreadsheet->getActiveSheet()->SetCellValue('AC'.$i, 'Width');
                      $spreadsheet->getActiveSheet()->SetCellValue('AD'.$i, 'height');
                      $spreadsheet->getActiveSheet()->SetCellValue('AE'.$i, 'Weight');
                      $spreadsheet->getActiveSheet()->SetCellValue('AF'.$i, 'Weight Class  (1=Kilogram,2=Gram,6=Ounce,Pound=5)');
                      $spreadsheet->getActiveSheet()->SetCellValue('AG'.$i, 'Status (1=Enabled, 0= Disabled)');
                      $spreadsheet->getActiveSheet()->SetCellValue('AH'.$i, 'Sort Order');
                      $spreadsheet->getActiveSheet()->SetCellValue('AI'.$i, 'Manufacturer ID');
                      $spreadsheet->getActiveSheet()->SetCellValue('AJ'.$i, 'Manufacturer');
                      $spreadsheet->getActiveSheet()->SetCellValue('AK'.$i, 'Categories id');
                      $spreadsheet->getActiveSheet()->SetCellValue('AL'.$i, 'Categories (category>subcategory; category1>subcategory1 )');
                     
                      $spreadsheet->getActiveSheet()->SetCellValue('AM'.$i, 'Related Product ID(productid,productid)');
                      $spreadsheet->getActiveSheet()->SetCellValue('AN'.$i, 'Related Product (model,model)');
                      $spreadsheet->getActiveSheet()->SetCellValue('AO'.$i, 'Option (name and type) size:select;color:radio');
                      $spreadsheet->getActiveSheet()->SetCellValue('AP'.$i, 'option:value1-qty-Subtract Stock-Price-Points-Weight;option:value1-qty-Subtract Stock-Price-Points-Weight');
                      $spreadsheet->getActiveSheet()->SetCellValue('AQ'.$i, '(image1;image2;image3)');
                      $spreadsheet->getActiveSheet()->SetCellValue('AR'.$i, 'Product Special price:(customer_group_id:start date:end date: special price )');
                      $spreadsheet->getActiveSheet()->SetCellValue('AS'.$i, 'Tax Class (None=0,Taxable Goods=9,Downloadable Products=10) Rest you can make and put that ID');
                      $spreadsheet->getActiveSheet()->SetCellValue('AT'.$i, 'Filter Group Name      (Group Name: Sort order;Group Name: Sort order)');
                      $spreadsheet->getActiveSheet()->SetCellValue('AU'.$i, 'Filter names (group name=name:sort order;group name=name:sort order)');
                      $spreadsheet->getActiveSheet()->SetCellValue('AV'.$i, 'Attributes (Attribute group name:sort order=atrribute name-value-sort order;Attribute group name:sort order=atrribute name-value-sort order;)');
                      $spreadsheet->getActiveSheet()->SetCellValue('AW'.$i, 'Discount (customer_group_id:qty:Priority:Price-Date Start-Date End;customer_group_id:qty:Priority:Price-Date Start-Date End;)');
                      $spreadsheet->getActiveSheet()->SetCellValue('AX'.$i, 'Reward Points');
                      $spreadsheet->getActiveSheet()->SetCellValue('AY'.$i, 'Meta Title');
					  $spreadsheet->getActiveSheet()->SetCellValue('AZ'.$i, 'Viewed');
                      $spreadsheet->getActiveSheet()->SetCellValue('BA'.$i, 'Download id');
					  $spreadsheet->getActiveSheet()->SetCellValue('BB'.$i, 'Reviews(Customer ID::author::text::ratting::status::date_added::date_modified|Customer ID::author::text::ratting::status::date_added::date_modified)');
					  $spreadsheet->getActiveSheet()->SetCellValue('BC'.$i, 'Vendor Id');
					  $spreadsheet->getActiveSheet()->SetCellValue('BD'.$i, 'Vendor Name');
                      
					  
					  $al='BE';
					  if(isset($cfiled))
					  {
						  foreach($cfiled as $cfile)
						  {
								 $cfile=trim($cfile);
							   $spreadsheet->getActiveSheet()->SetCellValue($al.$i, $cfile);
							   $al++;
                     
						  }
					  }
					  
					  $i=2;
					  

		 foreach($data as $product) {
						
                      $spreadsheet->getActiveSheet()->SetCellValue('A'.$i, $product['product_id']);
                      $spreadsheet->getActiveSheet()->SetCellValue('B'.$i, $product['language']);
                      $spreadsheet->getActiveSheet()->SetCellValue('C'.$i, $product['stores']);
                      $spreadsheet->getActiveSheet()->SetCellValue('D'.$i, $product['storeids']);
                      $spreadsheet->getActiveSheet()->SetCellValue('E'.$i, $product['model']);
                      $spreadsheet->getActiveSheet()->SetCellValue('F'.$i, $product['sku']);
                      $spreadsheet->getActiveSheet()->SetCellValue('G'.$i, $product['upc']);
                      $spreadsheet->getActiveSheet()->SetCellValue('H'.$i, $product['ean']);
                      $spreadsheet->getActiveSheet()->SetCellValue('I'.$i, $product['jan']);
                      $spreadsheet->getActiveSheet()->SetCellValue('J'.$i, $product['isbn']);
                      $spreadsheet->getActiveSheet()->SetCellValue('K'.$i, $product['mpn']);
                      $spreadsheet->getActiveSheet()->SetCellValue('L'.$i, $product['location']);
                      $spreadsheet->getActiveSheet()->SetCellValue('M'.$i, $product['name']);
                      $spreadsheet->getActiveSheet()->SetCellValue('N'.$i, $product['meta_tag_description']);
                      $spreadsheet->getActiveSheet()->SetCellValue('O'.$i, $product['meta_tag_keywords']);
                      $spreadsheet->getActiveSheet()->SetCellValue('P'.$i, $product['description']);
                      $spreadsheet->getActiveSheet()->SetCellValue('Q'.$i, $product['tag']);
                      $spreadsheet->getActiveSheet()->SetCellValue('R'.$i, $product['price']);
                      $spreadsheet->getActiveSheet()->SetCellValue('S'.$i, $product['quantity']);
                      $spreadsheet->getActiveSheet()->SetCellValue('T'.$i, $product['minimum_quantity']);
                      $spreadsheet->getActiveSheet()->SetCellValue('U'.$i, $product['subtract_stock']);
                      $spreadsheet->getActiveSheet()->SetCellValue('V'.$i, $product['out_stockstat']);
                      $spreadsheet->getActiveSheet()->SetCellValue('W'.$i, $product['require_shipping']);
                      $spreadsheet->getActiveSheet()->SetCellValue('X'.$i, $product['seo_keyword']);
                      $spreadsheet->getActiveSheet()->SetCellValue('Y'.$i, $product['img_main']);
                      $spreadsheet->getActiveSheet()->SetCellValue('Z'.$i, $product['date_avail']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AA'.$i, $product['len_class']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AB'.$i, $product['length']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AC'.$i, $product['width']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AD'.$i, $product['height']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AE'.$i, $product['weight']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AF'.$i, $product['weight_class']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AG'.$i, $product['status']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AH'.$i, $product['sort_order']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AI'.$i, $product['manufacturerid']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AJ'.$i, $product['manufacturer']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AK'.$i,$product['categoriesid']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AL'.$i,str_replace('&amp;','&', str_replace('&gt;','>',$product['categories'])));
                      $spreadsheet->getActiveSheet()->SetCellValue('AM'.$i, $product['relatedid']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AN'.$i, $product['related']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AO'.$i, $product['option']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AP'.$i, $product['option_val']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AQ'.$i, $product['image1']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AR'.$i, $product['product_sp']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AS'.$i, $product['tax_class']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AT'.$i, $product['filter_group']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AU'.$i, $product['filter_name']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AV'.$i, $product['att']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AW'.$i, $product['discount']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AX'.$i, $product['point']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AY'.$i, $product['meta_title']);
                      $spreadsheet->getActiveSheet()->SetCellValue('AZ'.$i, $product['downloadid']);
					  $spreadsheet->getActiveSheet()->SetCellValue('BA'.$i, $product['downloadid']);
					  $spreadsheet->getActiveSheet()->SetCellValue('BB'.$i, $product['reviews']);
                      $spreadsheet->getActiveSheet()->SetCellValue('BC'.$i, $product['vendor_id']);
                      $spreadsheet->getActiveSheet()->SetCellValue('BD'.$i, $product['vendor']);
                      
					   $al='BE';
					  if(isset($cfiled))
					  {
						  foreach($cfiled as $cfile)
						  {
							  $cfile=trim($cfile);
							   $spreadsheet->getActiveSheet()->SetCellValue($al.$i, $product[$cfile]);
							   $al++;
                     
						  }
					  }
					  $i++;
               }
			   
			   
			   	/* color setup */
				for($col = 'A'; $col != $al; $col++) {
			   $spreadsheet->getActiveSheet()->getColumnDimension($col)->setWidth(20);
			 	}
				
				$spreadsheet->getActiveSheet()->getColumnDimension('P','AR')->setWidth(50);
				$spreadsheet->getActiveSheet()->getColumnDimension('AQ')->setWidth(50);
				$spreadsheet->getActiveSheet()->getColumnDimension('AR')->setWidth(50);
				$spreadsheet->getActiveSheet()->getColumnDimension('BB')->setWidth(100);
				
				$spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
				
				$spreadsheet->getActiveSheet()
				->getStyle('A1:'.$al.'1')
				->getFill()
				->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				->getStartColor()
				->setARGB('FF4F81BD');
				
				$styleArray = array(
					'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => 'FFFFFF'),
					'size'  => 9,
					'name'  => 'Verdana'
				));
				
				$spreadsheet->getActiveSheet()->getStyle('A1:'.$al.'1')->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->setTitle('Product');
			
				/* color setup */  				
			$filename = 'Product.xls';
			$writer =new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
				 
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');
			$writer->save('php://output');
			//unlink($filename); 
	
	}
	
	
		public function cleanData(&$str) {
               $str = preg_replace("/\t/", "\\t", $str);
               $str = preg_replace("/\r?\n/", "\\n", $str);
               if(strstr($str, '"'))
               $str = '"' . str_replace('"', '""', $str) . '"';
       }
	   
}
?>