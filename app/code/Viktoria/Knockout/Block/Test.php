<?php

    namespace Viktoria\Knockout\Block;


    class Test extends \Magento\Framework\View\Element\Template
    {
        /**
         * @var array|\Magento\Checkout\Block\Checkout\LayoutProcessorInterface[]
         */
        private $layoutProcessors;

        /**
         * Test constructor.
         * @param \Magento\Framework\View\Element\Template\Context $context
         * @param array $layoutProcessors
         * @param array $data
         */
        public function __construct(
            \Magento\Framework\View\Element\Template\Context $context,
            array $layoutProcessors = [],
            array $data = []
    ) {
            parent::__construct($context, $data);
            $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
            $this->layoutProcessors = $layoutProcessors;
        }

        /**
         * @return \Magento\Framework\Phrase
         */
        public function sayHello()
        {
            return __('Hello World');
        }

        /**
         * @return string
         */
        public function getJsLayout()
        {
            foreach ($this->layoutProcessors as $processor) {
                $this->jsLayout = $processor->process($this->jsLayout);
            }
            return \Zend_Json::encode($this->jsLayout);
        }
    }
