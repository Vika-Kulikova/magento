<?php

    namespace Viktoria\CustomerOrder\Block;

    class Order extends \Magento\Framework\View\Element\Template
    {
        public function sayHello()
        {
            return __('Hello World');
        }
    }