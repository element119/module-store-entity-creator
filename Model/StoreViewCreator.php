<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\StoreEntityCreator\Model;

use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Store\Api\Data\StoreInterfaceFactory as StoreViewInterfaceFactory;
use Magento\Store\Model\ResourceModel\Store as StoreViewResourceModel;
use Magento\Store\Model\Store as StoreView;

class StoreViewCreator
{
    public const STORE_VIEW_CODE = 'code';
    public const STORE_VIEW_NAME = 'name';
    public const STORE_VIEW_SORT_ORDER = 'sort_order';
    public const STORE_VIEW_STATUS = 'is_active';
    public const STORE_VIEW_STORE_ID = 'group_id';
    public const STORE_VIEW_WEBSITE_ID = 'website_id';

    private StoreViewInterfaceFactory $storeViewFactory;
    private StoreViewResourceModel $storeViewResourceModel;

    public function __construct(
        StoreViewInterfaceFactory $storeViewFactory,
        StoreViewResourceModel $storeViewResourceModel
    ) {
        $this->storeViewFactory = $storeViewFactory;
        $this->storeViewResourceModel = $storeViewResourceModel;
    }

    /**
     * @param array $data
     * @return StoreView
     * @throws Exception
     * @throws AlreadyExistsException
     */
    public function create(array $data): StoreView
    {
        /** @var StoreView $storeView */
        $storeView = $this->storeViewFactory->create();

        $storeView->setData($data);
        $this->storeViewResourceModel->save($storeView);

        return $storeView;
    }
}
