<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\StoreEntityCreator\Console\Command;

use Element119\StoreEntityCreator\Model\StoreViewCreator;
use Exception;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Console\Cli;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateStoreView extends Command
{
    private const INPUT_ARGUMENT_STORE_ID = 'store_id';
    private const INPUT_OPTION_DISABLED = 'disabled';
    private const INPUT_OPTION_SORT_ORDER = 'sort-order';

    private StoreViewCreator $storeViewCreator;
    private StoreManagerInterface $storeManager;

    public function __construct(
        StoreViewCreator $storeViewCreator,
        StoreManagerInterface $storeManager = null,
        ?string $name = null
    ) {
        parent::__construct($name);

        $this->storeViewCreator = $storeViewCreator;
        $this->storeManager = $storeManager ?: ObjectManager::getInstance()->get(StoreManagerInterface::class);
    }

    protected function configure()
    {
        $this->setName('app:store-view:create')
            ->setDescription('Create a new store view.')
            ->addArgument(
                StoreViewCreator::STORE_VIEW_CODE,
                InputArgument::REQUIRED,
                'New store view code.'
            )->addArgument(
                StoreViewCreator::STORE_VIEW_NAME,
                InputArgument::REQUIRED,
                'New store view name.'
            )->addArgument(
                self::INPUT_ARGUMENT_STORE_ID,
                InputArgument::REQUIRED,
                'ID of the store to add the new store view to.'
            )->addOption(
                self::INPUT_OPTION_DISABLED,
                null,
                InputOption::VALUE_NONE,
                'Disable the new store view.'
            )->addOption(
                self::INPUT_OPTION_SORT_ORDER,
                null,
                InputOption::VALUE_REQUIRED,
                'New store view sort order.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $storeViewData = [
            StoreViewCreator::STORE_VIEW_NAME => $input->getArgument(StoreViewCreator::STORE_VIEW_NAME),
            StoreViewCreator::STORE_VIEW_CODE => $input->getArgument(StoreViewCreator::STORE_VIEW_CODE),
            StoreViewCreator::STORE_VIEW_STORE_ID => $input->getArgument(self::INPUT_ARGUMENT_STORE_ID),
            StoreViewCreator::STORE_VIEW_SORT_ORDER => $input->getOption(self::INPUT_OPTION_SORT_ORDER),
            StoreViewCreator::STORE_VIEW_STATUS => !$input->getOption(self::INPUT_OPTION_DISABLED),
            StoreViewCreator::STORE_VIEW_WEBSITE_ID => $this->getWebsiteId(
                (int)$input->getArgument(self::INPUT_ARGUMENT_STORE_ID)
            ),
        ];

        try {
            $this->storeViewCreator->create($storeViewData);
        } catch (Exception $e) {
            $output->writeln('Failed to create new store view:');
            $output->writeln($e->getMessage());

            return CLI::RETURN_FAILURE;
        }

        $output->writeln('Store view created.');

        return Cli::RETURN_SUCCESS;
    }

    private function getWebsiteId(int $storeId): int
    {
        return (int)$this->storeManager->getGroup($storeId)->getWebsiteId();
    }
}
