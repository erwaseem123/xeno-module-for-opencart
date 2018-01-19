<?php

class ModelThirdpartyxeno extends Model {

    public function send_data_to_xeno($order_info){

        if($this->config->get('xeno_status')){

            $data                   = array();
            $customer_data          = array(); 
            $xeno_apikey            = $this->config->get('xeno_apikey');
            $xeno_baseurl           = $this->config->get('xeno_baseurl');
            $url                    = $xeno_baseurl."/orders/add?api_key=IrAtTrbkh0vHZctOVP56";//.$xeno_apikey;



            $data['number']         = $order_info['telephone'];
            $data['name']           = $order_info['firstname'].' '.$order_info['lastname'];
            $data['amount']         = round($order_info['total']);
            $data['bill_number']    = '#'.trim($order_info['order_id']);
            $data['order_date']     = date("d/m/Y", strtotime($order_info['date_added']));
            $data['order_time']     = date("H:i:s", strtotime($order_info['date_added']));
            $data['discount']       = 0;
            $data['channel']        = 'Outlet';
            $data['store_id']        = 1;
            //$data['admin_id']        = 9;//optional field
            $data['product']        = [];
            $order_products = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_info['order_id'] . "'");
            foreach ($order_products->rows as $product) {
                $data['product'][] = [
                    //'product_id'        => $product['product_id'],
                    'product_name'      => $product['name'],
                    'product_amount'    => round($product['price']),
                    'product_discount'  => 0,
                    'product_quantity'  => $product['quantity'],
                ];
            }
            $customer_data['customer_details'][] = $data;

            $final_data = ['customer_data' => $customer_data];
          
           
            $data_for_xeno = array(
              CURLOPT_PORT              => "1222",
              CURLOPT_URL               => $url,
              CURLOPT_RETURNTRANSFER    => true,
              CURLOPT_ENCODING          => "",
              CURLOPT_MAXREDIRS         => 10,
              CURLOPT_TIMEOUT           => 30,
              CURLOPT_HTTP_VERSION      => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST     => "POST",
              CURLOPT_POSTFIELDS        => json_encode($final_data),
              CURLOPT_HTTPHEADER        => array(
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 58894307-184d-d41c-5b8e-7a6719e2d35c"
              ),
            );


            $curl = curl_init();
            curl_setopt_array($curl, $data_for_xeno);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }

/*
            $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "1222",
  CURLOPT_URL => "http://xenodev.net:1222/api/xeno/external/orders/add?api_key=IrAtTrbkh0vHZctOVP56",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"customer_data\":{\"customer_details\":[{\"number\":\"9899413447\",\"name\":\"Ayushmaan Kapoor\",\"amount\":\"2500\",\"bill_number\":\"H1234\",\"order_date\":\"24-07-2016\",\"order_time\":\"13:20:20\",\"discount\":\"0\",\"channel\":\"Outlet\",\"store_id\":\"1\",\"admin_id\":\"123\",\"product\":[{\"product_name\":\"Subzrangni Pulao\",\"product_amount\":\"500\",\"product_discount\":\"100\",\"product_quantity\":\"2\"}]}]}}",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 58894307-184d-d41c-5b8e-7a6719e2d35c"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
*/





              echo "<pre>";
           // print_r( $xeno_response);
            die;
            
        }

    }

}

?>

