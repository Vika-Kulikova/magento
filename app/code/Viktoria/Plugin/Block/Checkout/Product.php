<?php
    /**
     * Created by PhpStorm.
     * User: dmytro
     * Date: 17.12.18
     * Time: 21:55
     */

    namespace Viktoria\Plugin\Block\Checkout;


    class Product
    {
        public function afterGetName(\Magento\Catalog\Model\Product $subject, $result) {
            return "Apple ".$result; // Adding Apple in product name
        }
    }