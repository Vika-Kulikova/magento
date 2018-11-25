<?php

namespace Viktoria\Customer\Helper;

use \Magento\Framework\App\Helper\Context;
use \Magento\Store\Model\StoreManagerInterface;
use \Magento\Framework\App\State;
use \Magento\Customer\Model\CustomerFactory;
use \Symfony\Component\Console\Input\Input;

class Customer extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     *
     */
    const KEY_FIRSTNAME = 'customer-firstname';
    const KEY_LASTNAME = 'customer-lastname';
    const KEY_EMAIL = 'customer-email';
    const KEY_PASSWORD = 'customer-password';
    const KEY_WEBSITE = 'website';
    const KEY_SENDEMAIL = 'send-email';

    /**
     * @var $storeManager
     */
    protected $storeManager;
    /**
     * @var $state
     */
    protected $state;
    /**
     * @var $customerFactory
     */
    protected $customerFactory;

    /**
     * @var $data
     */
    protected $data;

    /**
     * @var $customerId
     */
    protected $customerId;

    /**
     * Customer constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param State $state
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        State $state,
        CustomerFactory $customerFactory
    ) {
        $this->storeManager = $storeManager;
        $this->state = $state;
        $this->customerFactory = $customerFactory;

        parent::__construct($context);
    }

    /**
     * @param Input $input
     * @return $this
     */
    public function setData(Input $input)
    {
        $this->data = $input;
        return $this;
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $this->state->setAreaCode('frontend');

        $customer = $this->customerFactory->create();
        $customer
            ->setWebsiteId($this->data->getOption(self::KEY_WEBSITE))
            ->setEmail($this->data->getOption(self::KEY_EMAIL))
            ->setFirstname($this->data->getOption(self::KEY_FIRSTNAME))
            ->setLastname($this->data->getOption(self::KEY_LASTNAME))
            ->setPassword($this->data->getOption(self::KEY_PASSWORD));
        $customer->save();

        $this->customerId = $customer->getId();

        if($this->data->getOption(self::KEY_SENDEMAIL)) {
            $customer->sendNewAccountEmail();
        }
    }

    public function getCustomerId()
    {
        return (int)$this->customerId;
    }
}
