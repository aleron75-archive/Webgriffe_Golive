Webgriffe_Golive
================

Introduction
------------

Golive extension can be helpful either before a site launch or in continuous
integration environment to ensure that changes to Magento settings don't
compromise the site.

Installation
------------

You can install this extension in several ways:

**Download**

Download the full package, copy the content of the ```src``` directory
in your magento base directory; pay attention not to overwrite
the ```app``` and  ```shell``` folder, only merge their contents into existing
directories;

** Modman **

To install modman Module Manager: https://github.com/colinmollenhour/modman

After having installed modman on your system, you can clone this module on your
Magento base directory by typing the following command:

```
$ modman init
$ modman clone git@github.com:aleron75/Webgriffe_Golive.git
```

** Composer **

Add the dependency to your ```composer.json```:

```
{
  ...
  "require-dev": {
    ...
    "aleron75/webgriffe_tph-pro": "dev-master",
    ...
  },
  "repositories": [
    ...
    {
      "type": "vcs",
      "url":  "git@github.com:aleron75/Webgriffe_Golive.git"
    },
    ...
  ],
  ...
}


```

Then run the following command:

```
$ composer update aleron75/webgriffe_golive
```

** Common tasks **

After installation:

* if you have cache enabled, disable or refresh it;
* if you have compilation enabled, disable or recompile it.

Usage
------------

The extension is a collection of so called 'Checkers', small classes whose
single responsibility is that of checking whether your Magento installation
has some default settings which should be updated before going live.

For example it checks whether you have changed the HTML Head Default Title or
Description or if you have updated the theme favicon.

Checkers can be run through an easy-to-use shell script:

```
$ php shell/golive.php --domain www.yourdomain.com
```

The output is something like:

```
Webgriffe Go Live 0.1.0
Active Checkers found: 73
Checking current Magento installation... done!

|  ID | Checked                                         | Result  |
| --- | ----------------------------------------------- | ------- |
|   1 | Unsecure Base URL                               | passed  |
|   2 | Secure Base URL                                 | passed  |
|   3 | Root Favicon                                    | warning |
|   4 | Theme Favicon                                   | warning |
|   5 | HTML Head Default Title                         | warning |
|   6 | HTML Head Default Description                   | warning |
|   7 | HTML Head Default Keywords                      | warning |
|   8 | HTML Head Default Robots                        | passed  |
|   9 | HTML Head Demo Notice                           | passed  |
|  10 | Header Logo Image Alternate Text                | error   |
|  11 | Header Welcome Text                             | warning |
|  12 | Footer Copyright                                | error   |
|  13 | Image Placeholder                               | warning |
|  14 | Small Image Placeholder                         | warning |
|  15 | Thumbnail Placeholder                           | warning |
|  16 | Store Information Contact Address               | warning |
|  17 | Store Information Country                       | warning |
|  18 | Store Information VAT Number                    | warning |
|  19 | Store Information Name                          | warning |
|  20 | Store Information Phone                         | warning |
|  21 | Cookie Lifetime                                 | passed  |
|  22 | Theme Logo                                      | warning |
|  23 | Theme Email Logo                                | warning |
|  24 | Theme Print Logo                                | warning |
|  25 | Store Email General Sender Name                 | warning |
|  26 | Store Email General Sender Address              | error   |
|  27 | Store Email Sales Representative Sender Name    | warning |
|  28 | Store Email Sales Representative Sender Address | error   |
|  29 | Store Email Customer Support Sender Name        | warning |
|  30 | Store Email Customer Support Sender Address     | error   |
|  31 | Store Email Custom Email 1 Sender Name          | warning |
|  32 | Store Email Custom Email 1 Sender Address       | error   |
|  33 | Store Email Custom Email 2 Sender Name          | warning |
|  34 | Store Email Custom Email 2 Sender Address       | error   |
|  35 | Shipping Tax Class                              | warning |
|  36 | Default Destination Country for Tax Calculation | warning |
|  37 | Shipping Origin Country                         | warning |
|  38 | Shipping Origin Region/State                    | warning |
|  39 | Shipping Origin ZIP/Postal Code                 | warning |
|  40 | Test Orders                                     | passed  |
|  41 | Test Invoices                                   | passed  |
|  42 | Test Shipments                                  | passed  |
|  43 | Test Credimemos                                 | passed  |
|  44 | Test Payments                                   | passed  |
|  45 | Test Transactions                               | passed  |
|  46 | Test Customers                                  | warning |
|  47 | Test Customer Addresses                         | warning |
|  48 | Catalog Product Attribute Index                 | passed  |
|  49 | Catalog Product Price Index                     | passed  |
|  50 | Catalog URL Index                               | passed  |
|  51 | Catalog Product Flat Index                      | passed  |
|  52 | Catalog Category Flat Index                     | passed  |
|  53 | Catalog Category Product Index                  | passed  |
|  54 | Catalog Search Fulltext Index                   | passed  |
|  55 | Catalog Inventory Stock Index                   | passed  |
|  56 | Tag Summary Index                               | passed  |
|  57 | Block Html Cache                                | warning |
|  58 | Collections Cache                               | warning |
|  59 | Config Cache                                    | warning |
|  60 | Config API Cache                                | warning |
|  61 | EAV Cache                                       | warning |
|  62 | Layout Cache                                    | warning |
|  63 | Translate Cache                                 | warning |
|  64 | Google Analytics Activated                      | warning |
|  65 | Google Analytics Account Number                 | skipped |
|  66 | Sitemap                                         | warning |
|  67 | Log Cleaning                                    | warning |
|  68 | Error Email Recipient                           | warning |
|  69 | Email Communications                            | passed  |
|  70 | Log Enabled                                     | warning |
|  71 | Profiler Enabled                                | passed  |
|  72 | Template Path Hints                             | passed  |
|  73 | Translate Inline Frontend                       | passed  |
| ----------------------------------------------------- | ------- |
|                                                Errors | 7       |
|                                              Warnings | 41      |
|                                                Passed | 24      |
|                                               Skipped | 1       |
| ----------------------------------------------------- | ------- |
```

Checkers are declared and activated through the config.xml file.

New checks can be added by simply copying a checker configuration node in the
config.xml file and changing what is need to be changed.

Others require a Checker Class to be written; it usually takes only a few lines
of code. Take a look at existing ones to learn how to write your own.

Each Checker returns one of the following exit code:

* __error__: the check failed and severity was set to error
* __warning__: the check failed and severity was set to warning
* __none__: the check passed
* __skip__: the check couldn't be applied (for example: Google Analytics Account Number check is skipped if GA is not activated)

The shell script exit code corresponds to the number of errors found.

Checker's exit code severity can be configured. They come with default severity
exit codes based on personal experience but feel free to change them based on
your needs.

Golive is developed "the Magento way" so it's fully extensible.

This project is at its early stages and is still under development; shell script
is raw and still has to be beautified and more Checkers have to be developed.

In other words: any feedback or help is extremely appreciated.

Extension developed and tested on [Magento CE v 1.8.1.0](http://www.magentocommerce.com/download)

This extension is published under the [Open Software License (OSL 3.0)](http://opensource.org/licenses/OSL-3.0).