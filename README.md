[![Latest Stable Version](https://poser.pugx.org/mslwk/module-repository-searchresult-builder/v/stable)](https://packagist.org/packages/mslwk/module-repository-searchresult-builder)
[![License](https://poser.pugx.org/mslwk/module-repository-searchresult-builder/license)](https://packagist.org/packages/mslwk/module-repository-searchresult-builder)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maciejslawik/repository-searchresult-builder-magento2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/maciejslawik/repository-searchresult-builder-magento2/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/maciejslawik/repository-searchresult-builder-magento2/badges/build.png?b=master)](https://scrutinizer-ci.com/g/maciejslawik/repository-searchresult-builder-magento2/build-status/master)

# Magento 2 Repository SearchResult Builder module #

The extension provides a simple trait for easy search result building.
See the test double for reference.

### Installation ###

##### Via Composer #####

To install the extension using Composer use the 
following commands:

```bash
 composer require mslwk/module-repository-searchresult-builder
 php bin/magento module:enable MSlwk_RepositorySearchResultBuilder
 php bin/magento setup:upgrade
 ```
 
##### From GitHub #####
 
You can download the extension directly from GitHub and 
put it inside `` app/code/MSlwk/RepositorySearchResultBuilder `` directory. Then run the
following commands:

```bash
 php bin/magento module:enable MSlwk_RepositorySearchResultBuilder
 php bin/magento setup:upgrade
 ```