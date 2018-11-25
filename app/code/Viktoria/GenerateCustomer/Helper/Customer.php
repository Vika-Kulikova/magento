<?php

    namespace Viktoria\GenerateCustomer\Helper;

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
        const KEY_QUANTITY = 'generate-customers-quantity';
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
         * @var array
         */
        protected $firstname = ['Olivia', 'Oliver', 'Amelia', 'Harry', 'Isla', 'Jack', 'Emily', 'George', 'Ava',
            'Noah', 'Lily', 'Charlie', 'Mia', 'Jacob', 'Sophia', 'Alfie', 'Isabella', 'Freddie', 'Grace'];

        /**
         * @var array
         */
        protected $lastname = ['Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson',
            'Moore', 'Taylor', 'Anderson', 'Thomas', 'Jackson', 'White', 'Harris', 'Martin', 'Thompson', 'Garcia', 'Martinez'];

        /**
         * @var array
         */
        protected $email = ['@ukr.net', '@gmail.com', '@yahoo.com', '@outlook.com', '@zillum.com', '@icloud.com', '@mail.com'];


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
        )
        {
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

        private function generateCustomer($firstnameArr, $lastnameArr, $emailArr)
        {
            $customers = [];
            $num = $this->data->getOption(self::KEY_QUANTITY);

            for ($i = 0; $i < $num; $i++) {
                $firstname = $firstnameArr[mt_rand(0, count($firstnameArr)-1)];
                $lastname = $lastnameArr[mt_rand(0, count($lastnameArr)-1)];
                $email = $firstname . '_' . $lastname . $emailArr[mt_rand(0, count($emailArr)-1)];
                array_push($customers, $firstname, $lastname, $email);
            }

        }


        /**
         * @throws \Magento\Framework\Exception\LocalizedException
         */
        public function execute()
        {
            $this->state->setAreaCode('frontend');

for ($i = 0; $i < $num; $i++)
{
    $customer = $this->customerFactory->create();
    $customer

        ->setWebsiteId($this->data->getOption(self::KEY_WEBSITE))
        ->setEmail($this->data->getOption(self::KEY_EMAIL))
        ->setFirstname($this->data->getOption(self::KEY_FIRSTNAME))
        ->setLastname($this->data->getOption(self::KEY_LASTNAME))
        ->setPassword($this->data->getOption(self::KEY_PASSWORD));
    $customer->save();

    $this->customerId = $customer->getId();

    if ($this->data->getOption(self::KEY_SENDEMAIL)) {
        $customer->sendNewAccountEmail();
    }
    
}

        }

        public function getCustomerId()
        {
            return (int)$this->customerId;
        }
    }
