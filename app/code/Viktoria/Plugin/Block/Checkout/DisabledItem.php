<?php
    /**
     * Created by PhpStorm.
     * User: dmytro
     * Date: 17.12.18
     * Time: 22:24
     */

    namespace Viktoria\Plugin\Block\Checkout;


    class DisabledItem
    {
        public function aroundProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, \Closure $proceed, $jsLayout)
        {
            $ret = $proceed($jsLayout);
            //delete postcode
            unset($ret['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['postcode']);
            //delete country_id
            unset($ret['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['country_id']);
            //delete region_id
            unset($ret['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['region_id']);

            return $ret;
        }
    }