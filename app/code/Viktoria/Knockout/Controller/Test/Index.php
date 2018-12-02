<?php

    namespace Viktoria\Knockout\Controller\Test;

    class Index extends \Magento\Framework\App\Action\Action
    {
//        protected $_pageFactory;
        protected $resultPageFactory;

        public function __construct(
            \Magento\Framework\App\Action\Context $context,
//            \Magento\Framework\View\Result\PageFactory $pageFactory)
            \Magento\Framework\View\Result\PageFactory $resultPageFactory)
        {
//            $this->_pageFactory = $pageFactory;
            $this->resultPageFactory = $resultPageFactory;
            return parent::__construct($context);
        }

        public function execute()
        {
//            echo "Hello World";
//            exit;
            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        }
    }
