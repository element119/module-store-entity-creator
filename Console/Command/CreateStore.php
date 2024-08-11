<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\StoreEntityCreator\Console\Command;

use Element119\StoreEntityCreator\Model\StoreCreator;
use Exception;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateStore extends Command
{
    private const INPUT_OPTION_DEFAULT_STORE_VIEW_ID = 'default-store-view-id';

    private StoreCreator $storeCreator;

    public function __construct(
        StoreCreator $storeCreator,
        ?string $name = null
    ) {
        parent::__construct($name);

        $this->storeCreator = $storeCreator;
    }

    protected function configure()
    {
        $this->setName('app:store:create')
            ->setDescription('Create a new store.')
            ->addArgument(
                StoreCreator::STORE_CODE,
                InputArgument::REQUIRED,
                'New store code.'
            )->addArgument(
                StoreCreator::STORE_NAME,
                InputArgument::REQUIRED,
                'New store name.'
            )->addArgument(
                StoreCreator::STORE_WEBSITE_ID,
                InputArgument::REQUIRED,
                'ID of the website to add the new store to.'
            )->addArgument(
                StoreCreator::STORE_ROOT_CATEGORY_ID,
                InputArgument::REQUIRED,
                'New store root category ID.'
            )->addOption(
                self::INPUT_OPTION_DEFAULT_STORE_VIEW_ID,
                null,
                InputOption::VALUE_REQUIRED,
                'Default store view ID for new store.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $storeData = [
            StoreCreator::STORE_NAME => $input->getArgument(StoreCreator::STORE_NAME),
            StoreCreator::STORE_CODE => $input->getArgument(StoreCreator::STORE_CODE),
            StoreCreator::STORE_WEBSITE_ID => $input->getArgument(StoreCreator::STORE_WEBSITE_ID),
            StoreCreator::STORE_ROOT_CATEGORY_ID => $input->getArgument(StoreCreator::STORE_ROOT_CATEGORY_ID),
            StoreCreator::STORE_DEFAULT_STORE_ID => $input->getOption(self::INPUT_OPTION_DEFAULT_STORE_VIEW_ID),
        ];

        try {
            $this->storeCreator->create($storeData);
        } catch (Exception $e) {
            $output->writeln($e->getMessage());

            return CLI::RETURN_FAILURE;
        }

        return Cli::RETURN_SUCCESS;
    }
}
