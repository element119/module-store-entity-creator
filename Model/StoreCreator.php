<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\StoreEntityCreator\Model;

use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Store\Api\Data\GroupInterfaceFactory as StoreInterfaceFactory;
use Magento\Store\Model\ResourceModel\Group as StoreResourceModel;
use Magento\Store\Model\Group as Store;

class StoreCreator
{
    public const STORE_CODE = 'code';
    public const STORE_DEFAULT_STORE_ID = 'default_store_id';
    public const STORE_NAME = 'name';
    public const STORE_ROOT_CATEGORY_ID = 'root_category_id';
    public const STORE_WEBSITE_ID = 'website_id';

    private StoreInterfaceFactory $storeFactory;
    private StoreResourceModel $storeResourceModel;

    public function __construct(
        StoreInterfaceFactory $storeFactory,
        StoreResourceModel $storeResourceModel
    ) {
        $this->storeFactory = $storeFactory;
        $this->storeResourceModel = $storeResourceModel;
    }

    /**
     * @param array $data
     * @return Store
     * @throws Exception
     * @throws AlreadyExistsException
     */
    public function create(array $data): Store
    {
        /** @var Store $store */
        $store = $this->storeFactory->create();

        $store->setData($data);
        $this->storeResourceModel->save($store);

        return $store;
    }
}
