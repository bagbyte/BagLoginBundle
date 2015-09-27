Getting Started With BagLoginBundle
==================================

## Prerequisites

This version of the bundle requires Symfony 2.1+.

The BagLoginBundle is build on top of following bundles:

 - [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle)
 - [FOSOAuthServerBundle](https://github.com/FriendsOfSymfony/FOSOAuthServerBundle)
 - [HWIOAuthBundle](https://github.com/hwi/HWIOAuthBundle)

Following links can be useful to:
 - [Integrating FOSOAuthServerBundle with FOSUserBundle](http://blog.tankist.de/blog/2013/07/16/oauth2-explained-part-1-principles-and-terminology/)
 - [Integrating HWIOAuthBundle with FOSUserBundle](https://gist.github.com/danvbe/4476697)

## Installation

Installation is a quick (I promise!) 7 step process:

1. Install BagLoginBundle using composer
2. Configure the bundle in prerequisites
3. Enable the Bundle
4. Configure the BagLoginBundle
5. Import BagLoginBundle routing files

### Step 1: Install BagLoginBundle using composer

Add BagLoginBundle by running the command:

``` bash
$ php composer.phar require bagbyte/login-bundle "dev-master"
```

Composer will install the bundle to your project's `vendor/bagbyte` directory.

### Step 2: Configure the bundle in prerequisites

Before to go on with the BagLoginBundle configuration makes sure to have properly configured the bundles in the prerequisites section.

### Step 3: Enable the bundle

Enable the bundle in the AppKernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Bag\LoginBundle\BagLoginBundle(),
    );
}
```

### Step 4: Configure the BagLoginBundle

Update the app/config/config.yml file adding the following lines:

``` yaml
# app/config/config.yml
...

  bag_login:
    email:
      from_address:         no_reply@company.com    # email address used as sender in emails
      from_display_name:    Company Name Ltd.       # email name to display as sender in emails
```

**Note:**

> The full configuration is described here: [config.md](https://github.com/bagbyte/BagLoginBundle/blob/master/Resources/doc/config.md)

### Step 5: Import BagLoginBundle routing files

Now that you have activated and configured the bundle, all that is left to do is
import the BagLoginBundle routing files.
Add the following line to your app/config/routing.yml file.

``` yaml
# app/config/routing.yml
bag_login:
    resource: "@BagLoginBundle/Resources/config/routing.yml"
```

**Note:**

> In order to use the built-in email functionality (confirmation of the account,
> resetting of the password), you must activate and configure the SwiftmailerBundle.

### Next Steps

Now that you have completed the basic installation and configuration of the
BagLoginBundle, you are ready to learn about more advanced features and usages
of the bundle.

The following documents are available:

- [Social Networks Login](social_login.md)
- [Overriding Templates](overriding_templates.md)
- [Overriding Forms](overriding_forms.md)
- [Emails](emails.md)
