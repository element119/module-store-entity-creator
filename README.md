<h1 align="center">element119 | Store Entity Creator</h1>

## 📝 Features
✔️ Create store entities (websites, stores, and store views) using the Magento CLI

✔️ Theme agnostic

✔️ Built in accordance with Magento best practises

✔️ Seamless integration with Magento

✔️ Built with developers and extensibility in mind to make customisations as easy as possible

✔️ Installable via Composer

<br/>

## 🔌 Installation
Run the following command to *install* this module:
```bash
composer require element119/module-store-entity-creator
php bin/magento setup:upgrade
```

<br/>

## ⏫ Updating
Run the following command to *update* this module:
```bash
composer update element119/module-store-entity-creator
php bin/magento setup:upgrade
```

<br/>

## ❌ Uninstallation
Run the following command to *uninstall* this module:
```bash
composer remove element119/module-store-entity-creator
php bin/magento setup:upgrade
```

<br/>

## 📚 User Guide
### Website Creation - `app:website:create`
```
Description:
  Create a new website.

Usage:
  app:website:create [options] [--] <code> <name>

Arguments:
  code                                     New website code.
  name                                     New website name.

Options:
      --default-store-id=DEFAULT-STORE-ID  Default store ID for new website.
      --sort-order=SORT-ORDER              New website sort order.
      --is-default                         Sets the new website as the default website.
  -h, --help                               Display help for the given command. When no command is given display help for the list command
  -q, --quiet                              Do not output any message
  -V, --version                            Display this application version
      --ansi|--no-ansi                     Force (or disable --no-ansi) ANSI output
  -n, --no-interaction                     Do not ask any interactive question
  -v|vv|vvv, --verbose                     Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```

### Store Creation - `app:store:create`
```
Description:
  Create a new store.

Usage:
  app:store:create [options] [--] <code> <name> <website_id> <root_category_id>

Arguments:
  code                                               New store code.
  name                                               New store name.
  website_id                                         ID of the website to add the new store to.
  root_category_id                                   New store root category ID.

Options:
      --default-store-view-id=DEFAULT-STORE-VIEW-ID  Default store view ID for new store.
  -h, --help                                         Display help for the given command. When no command is given display help for the list command
  -q, --quiet                                        Do not output any message
  -V, --version                                      Display this application version
      --ansi|--no-ansi                               Force (or disable --no-ansi) ANSI output
  -n, --no-interaction                               Do not ask any interactive question
  -v|vv|vvv, --verbose                               Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```

### Store View Creation - `app:store-view:create`
```
Description:
  Create a new store view.

Usage:
  app:store-view:create [options] [--] <code> <name> <store_id>

Arguments:
  code                         New store view code.
  name                         New store view name.
  store_id                     ID of the store to add the new store view to.

Options:
      --disabled               Disable the new store view.
      --sort-order=SORT-ORDER  New store view sort order.
  -h, --help                   Display help for the given command. When no command is given display help for the list command
  -q, --quiet                  Do not output any message
  -V, --version                Display this application version
      --ansi|--no-ansi         Force (or disable --no-ansi) ANSI output
  -n, --no-interaction         Do not ask any interactive question
  -v|vv|vvv, --verbose         Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```
