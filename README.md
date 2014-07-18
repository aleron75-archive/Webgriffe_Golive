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
Active Checkers found: 17
Checking current Magento installation... done!
Errors: 0
Warnings: 13
Passed: 4

Detailed result
array(17) {
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
}
```

Checkers are declared and activated through the config.xml file.

Some of them can be used to check different configuration values simply
by duplicating them and changing some parameter values.

Each Checker returns one of the following exit code:

* error
* warning
* none

The shell script exits with an error code if and only if there is at least
one Checker which gives an error.

Checker's exit code severity can be configured. They come with default severity
exit codes based on personal experience but feel free to change them based on
your needs.

Golive is developed "the Magento way" so it's fully extensible.

This project is at its early stages and is still under development; shell script
is raw and still has to be beautified and more Checkers have to be developed.

In other words: any feedback or help is extremely appreciated.

Extension developed and tested on [Magento CE v 1.8.1.0](http://www.magentocommerce.com/download)

This extension is published under the [Open Software License (OSL 3.0)](http://opensource.org/licenses/OSL-3.0).