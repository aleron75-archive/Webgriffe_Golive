Webgriffe_Golive
================

Golive extension can be helpful either before a site launch or in continuous
integration environment to ensure that changes to Magento settings don't
compromise the site.

The extension is a collection of so called 'Checkers', small classes whose
single responsibility is that of checking whether your Magento installation
has some default settings which should be updated before going live.

For example it checks whether you have changed the HTML Head Default Title or
Description or if you have updated the theme favicon.

Checkers can be run through an easy-to-use shell script:

```
$ php shell/golive.php --domain www.yourdomain.com
```

At the moment the output is something ugly like:

```
Active Checkers found: 51
Checking current Magento installation... done!
Errors: 0
Warnings: 31
Passed: 19
Skipped: 1

Detailed result
array(51) {
  ["config_general_web_unsecure_base_url"] => string(6) "passed"
  ["config_general_web_secure_base_url"] => string(6) "passed"
  ["design_root_favicon"] => string(7) "warning"
  ["design_theme_favicon"] => string(7) "warning"
  ["html_head_default_title"] => string(7) "warning"
  ["html_head_default_description"] => string(7) "warning"
  ["html_head_default_keywords"] => string(7) "warning"
  ["html_head_default_robots"] => string(6) "passed"
  ["html_head_demo_notice"] => string(6) "passed"
  ["design_image_placeholder"] => string(7) "warning"
  ["design_smallimage_placeholder"] => string(7) "warning"
  ["design_thumbnail_placeholder"] => string(7) "warning"
  ["store_info_address"] => string(7) "warning"
  ["store_info_country"] => string(7) "warning"
  ["store_info_vatnumber"] => string(7) "warning"
  ["store_info_name"] => string(7) "warning"
  ["store_info_phone"] => string(7) "warning"
  ["design_theme_logo"] => string(7) "warning"
  ["design_theme_logoemail"] => string(7) "warning"
  ["design_theme_logoprint"] => string(7) "warning"
  ["shipping_tax_class"] => string(7) "warning"
  ["tax_calculation_destination_country"] => string(7) "warning"
  ["shipping_origin_country"] => string(7) "warning"
  ["shipping_origin_regionstate"] => string(7) "warning"
  ["shipping_origin_postcode"] => string(7) "warning"
  ["empty_order_collection"] => string(6) "passed"
  ["empty_invoice_collection"] => string(6) "passed"
  ["empty_shipment_collection"] => string(6) "passed"
  ["empty_creditmemo_collection"] => string(6) "passed"
  ["empty_payment_collection"] => string(6) "passed"
  ["empty_transaction_collection"] => string(6) "passed"
  ["empty_customer_collection"] => string(7) "warning"
  ["empty_customeraddress_collection"] => string(7) "warning"
  ["indexstatus_catalog_product_attribute"] => string(6) "passed"
  ["indexstatus_catalog_product_price"] => string(6) "passed"
  ["indexstatus_catalog_url"] => string(6) "passed"
  ["indexstatus_catalog_product_flat"] => string(6) "passed"
  ["indexstatus_catalog_category_flat"] => string(6) "passed"
  ["indexstatus_catalog_category_product"] => string(6) "passed"
  ["indexstatus_catalogsearch_fulltext"] => string(6) "passed"
  ["indexstatus_cataloginventory_stock"] => string(6) "passed"
  ["indexstatus_tag_summary"] => string(6) "passed"
  ["cache_enabled_block_html"] => string(7) "warning"
  ["cache_enabled_collections"] => string(7) "warning"
  ["cache_enabled_config"] => string(7) "warning"
  ["cache_enabled_config_api"] => string(7) "warning"
  ["cache_enabled_eav"] => string(7) "warning"
  ["cache_enabled_layout"] => string(7) "warning"
  ["cache_enabled_translate"] => string(7) "warning"
  ["google_analytics_activated"] => string(7) "warning"
  ["google_analytics_accountnumber"] => string(7) "skipped"
}
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