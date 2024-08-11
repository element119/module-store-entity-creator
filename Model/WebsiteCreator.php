<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\StoreEntityCreator\Model;

use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Store\Api\Data\WebsiteInterfaceFactory;
use Magento\Store\Model\ResourceModel\Website as WebsiteResourceModel;
use Magento\Store\Model\Website;

class WebsiteCreator
{
    public const WEBSITE_CODE = 'code';
    public const WEBSITE_DEFAULT_STORE = 'default_group_id';
    public const WEBSITE_IS_DEFAULT = 'is_default';
    public const WEBSITE_NAME = 'name';
    public const WEBSITE_SORT_ORDER = 'sort_order';

    private WebsiteInterfaceFactory $websiteFactory;
    private WebsiteResourceModel $websiteResourceModel;

    public function __construct(
        WebsiteInterfaceFactory $websiteFactory,
        WebsiteResourceModel $websiteResourceModel
    ) {
        $this->websiteFactory = $websiteFactory;
        $this->websiteResourceModel = $websiteResourceModel;
    }

    /**
     * @param array $data
     * @return Website
     * @throws Exception
     * @throws AlreadyExistsException
     */
    public function create(array $data): Website
    {
        /** @var Website $website */
        $website = $this->websiteFactory->create();

        $website->setData($data);
        $this->websiteResourceModel->save($website);

        return $website;
    }
}
