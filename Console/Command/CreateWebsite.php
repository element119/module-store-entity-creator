<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\StoreEntityCreator\Console\Command;

use Element119\StoreEntityCreator\Model\WebsiteCreator;
use Exception;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateWebsite extends Command
{
    private const INPUT_OPTION_DEFAULT_STORE_ID = 'default-store-id';
    private const INPUT_OPTION_IS_DEFAULT = 'is-default';
    private const INPUT_OPTION_SORT_ORDER = 'sort-order';

    private WebsiteCreator $websiteCreator;

    public function __construct(
        WebsiteCreator $websiteCreator,
        ?string $name = null
    ) {
        parent::__construct($name);

        $this->websiteCreator = $websiteCreator;
    }

    protected function configure()
    {
        $this->setName('app:website:create')
            ->setDescription('Create a new website.')
            ->addArgument(
                WebsiteCreator::WEBSITE_CODE,
                InputArgument::REQUIRED,
                'New website code.'
            )->addArgument(
                WebsiteCreator::WEBSITE_NAME,
                InputArgument::REQUIRED,
                'New website name.'
            )->addOption(
                self::INPUT_OPTION_DEFAULT_STORE_ID,
                null,
                InputOption::VALUE_REQUIRED,
                'Default store ID for new website.'
            )->addOption(
                self::INPUT_OPTION_SORT_ORDER,
                null,
                InputOption::VALUE_REQUIRED,
                'New website sort order.'
            )->addOption(
                self::INPUT_OPTION_IS_DEFAULT,
                null,
                InputOption::VALUE_NONE,
                'Sets the new website as the default website.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $websiteData = [
            WebsiteCreator::WEBSITE_NAME => $input->getArgument(WebsiteCreator::WEBSITE_NAME),
            WebsiteCreator::WEBSITE_CODE => $input->getArgument(WebsiteCreator::WEBSITE_CODE),
            WebsiteCreator::WEBSITE_DEFAULT_STORE => $input->getOption(self::INPUT_OPTION_DEFAULT_STORE_ID),
            WebsiteCreator::WEBSITE_IS_DEFAULT => $input->getOption(self::INPUT_OPTION_IS_DEFAULT),
            WebsiteCreator::WEBSITE_SORT_ORDER => $input->getOption(self::INPUT_OPTION_SORT_ORDER) ?? 0,
        ];

        try {
            $this->websiteCreator->create($websiteData);
        } catch (Exception $e) {
            $output->writeln('Failed to create new website:');
            $output->writeln($e->getMessage());

            return CLI::RETURN_FAILURE;
        }

        $output->writeln('Website created.');

        return Cli::RETURN_SUCCESS;
    }
}
