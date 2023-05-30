<?php

/**
 * tutor.php
 *
 * tutor management
 *
 * @author     Opencart-api.com
 * @copyright  2017
 * @license    License.txt
 * @version    2.0
 * @link       https://opencart-api.com/product/shopping-cart-rest-api/
 * @documentations https://opencart-api.com/opencart-rest-api-documentations/
 */
namespace Opencart\Catalog\Controller\Extension\RestApi\Rest;
require_once(DIR_SYSTEM . 'engine/restcontroller.php');

class Tutor extends \RestController
{

    private $error = array();

    public function tutor()
    {
		$this->checkPlugin();
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
			    $this->getVendor($this->request->get['id']);
			} else {
				$this->listvendor();
			}
        }else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }
	
	
	public function getVendor()
	{
		$json = array('success' => true);
		$this->load->model('extension/tmdmultivendor/vendor/vendor');

        $vendor = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($this->request->get['id']);
        if(!empty($vendor)) {
            $this->json["data"] = $vendor;
        } else {
            $this->json['success'] = false;
        }

        $this->sendResponse($json);
	}
	
    public function listvendor()
    {
		 $this->load->model('extension/tmdmultivendor/vendor/vendor');

        $vendor = $this->model_extension_tmdmultivendor_vendor_vendor->getVendors();
        $data['vendor'] = array_values($vendor);

        if (!empty($data['vendor'])) {

            $this->json["data"] = $data;
        }

        if($this->includeMeta) {

            $data = $this->json['data'];

            if(isset($this->json['data']['vendor'])) {
                $intercomsData = $this->json['data']['vendor'];
            } else {
                $intercomsData = array();
            }
            $this->response->addHeader('X-Total-Count: ' . count($intercomsData));
            $this->response->addHeader('X-Pagination-Limit: '.count($intercomsData));
            $this->response->addHeader('X-Pagination-Page: 1');        
        }
	}
}