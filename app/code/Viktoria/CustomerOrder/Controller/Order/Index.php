<?php
    /**
     * Created by PhpStorm.
     * User: dmytro
     * Date: 05.12.18
     * Time: 19:56
     */

    namespace Viktoria\CustomerOrder\Controller\Order;


    class Index extends \Magento\Framework\App\Action\Action
    {
        protected $pageFactory;

        public function __construct(
            \Magento\Framework\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $pageFactory)
        {
            $this->pageFactory = $pageFactory;
            return parent::__construct($context);
        }

        public function execute()
        {
            return $this->pageFactory->create();
        }
    }
