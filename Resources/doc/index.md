Getting Started With BagLoginBundle
==================================

## Prerequisites

This version of the bundle requires Symfony 2.1+. If you are using Symfony
2.0.x, please use the 1.2.x releases of the bundle.

The BagLoginBundle is build on top of following bundles:

 - [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle)
 - [FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle)
 - [FOSOAuthServerBundle](https://github.com/FriendsOfSymfony/FOSOAuthServerBundle)
 - [HWIOAuthBundle](https://github.com/hwi/HWIOAuthBundle)

Following links can be useful to:
 - [Integrating FOSOAuthServerBundle with FOSUserBundle](http://blog.tankist.de/blog/2013/07/16/oauth2-explained-part-1-principles-and-terminology/)
 - [Integrating HWIOAuthBundle with FOSUserBundle](https://gist.github.com/danvbe/4476697)

## Installation

Installation is a quick (I promise!) 7 step process:

1. Download BagLoginBundle using composer
2. Enable the Bundle
3. Configure the BagLoginBundle
4. Import BagLoginBundle routing files

### Step 1: Download BagLoginBundle using composer

Add BagLoginBundle by running the command:

``` bash
$ php composer.phar require bagbyte/login-bundle "dev-master"
```

Composer will install the bundle to your project's `vendor/bagbyte` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

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

### Step 3: Configure the BagLoginBundle

In order for Symfony's security component to use the BagLoginBundle, you must
tell it to do so in the `security.yml` file. The `security.yml` file is where the
basic security configuration for your application is contained.

Below is a minimal example of the configuration necessary to use the BagLoginBundle
in your application:

``` yaml
# app/config/config.yml
  bag_login:
    user_class:                           Project\CoreBundle\Entitiy\User # Your User class full path
    email:
      from_address:                       no_reply@company.com            # email address used as sender in emails
      from_display_name:                  Company Name Ltd.               # email name to display as sender in emails
      send_registration_email:            true                            # true|false, if true, after a new registration the user is notified with an email
      require_account_verification:       false                           # true|false, if true, after a new registration the account will not be active, a link will be sent in the registration email, the user has to click on it in order to activate the account
      send_activation_email:              true                            # true|false, if true, after the activation of the account, an email is sent to the user
      send_password_changed_email:        false                           # true|false, if true, after the user change his password, an email is sent to the user
    form:
      type:
        registration:                     Project\CoreBundle\Form\Type\RegistrationType  # registration form type full path
```

**Note:**

> The full configuration is described here: [config.md](https://github.com/bagbyte/BagLoginBundle/blob/master/Resources/doc/config.md)

### Step 4: Import BagLoginBundle routing files

Now that you have activated and configured the bundle, all that is left to do is
import the BagLoginBundle routing files.

By importing the routing files you will have ready made pages for things such as
logging in, registration, etc.

In YAML:

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

- [Overriding Templates](overriding_templates.md)
- [Hooking into the controllers](controller_events.md)
- [Overriding Controllers](overriding_controllers.md)
- [Overriding Forms](overriding_forms.md)
- [Using the UserManager](user_manager.md)
- [Command Line Tools](command_line_tools.md)
- [Logging by username or email](logging_by_username_or_email.md)
- [Transforming a username to a user in forms](form_type.md)
- [Emails](emails.md)
- [Using the groups](groups.md)
- [More about the Doctrine implementations](doctrine.md)
- [Supplemental Documentation](supplemental.md)
- [Replacing the canonicalizer](canonicalizer.md)
- [Using a custom storage layer](custom_storage_layer.md)
- [Configuration Reference](configuration_reference.md)
- [Adding invitations to registration](adding_invitation_registration.md)
- [Advanced routing configuration](routing.md)
