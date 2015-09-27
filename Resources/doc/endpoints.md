# BagLoginBundle Endpoints references

# Registration

## Registration form
Registration page

#### Route
- Name: bag_login_web_register
- URL: /web/register

### Dispatched event
- [BagLoginEvents::REGISTRATION_START](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)
- [BagLoginEvents::REGISTRATION_ERROR](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)
- [BagLoginEvents::REGISTRATION_END](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)

### View
- Default: BagLoginBundle:Registration:registration.twig
- Override by: bag_login.view.registration

## Registration completed
This page is shown after the registration form has been submitted and the process is ended succesfully

#### Route
- Name: bag_login_web_registration_completed
- URL: /web/registration/done

### View
- Default: BagLoginBundle:Registration:registration_completed.twig
- Override by: bag_login.view.registration_completed

# Activation
If the bag_login.email.require_account_verification configuration is set to true, after the registration 
a link will be sent to the user's email used during the registration with a confirmation link,
the activation process takes care of handling this link. 

## Activation
Handle the link sent in the registration email. If the token sent is correct it redirects to bag_login_web_account_activation_completed.

#### Route
- Name: bag_login_web_account_activation
- URL: /web/activate/account/{token}

### Dispatched event
- [BagLoginEvents::ACCOUNT_ACTIVATED](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)

## Activation completed
This page is shown if the activation complets succesfully.

#### Route
- Name: bag_login_web_registration_completed
- URL: /web/account/activated

### View
- Default: BagLoginBundle:Registration:account_activated.twig
- Override by: bag_login.view.account_activated

# Activation email request
If the activation email doesn't reach the user, he can request a resent of the same.

## Activation email request form
Activation email request page

#### Route
- Name: bag_login_web_request_activation_email
- URL: /web/request/activation/email

### Dispatched event
- [BagLoginEvents::ACTIVATION_EMAIL_REQUEST_START](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)
- [BagLoginEvents::ACTIVATION_EMAIL_REQUEST_ERROR](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)
- [BagLoginEvents::ACTIVATION_EMAIL_REQUEST_END](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)

### View
- Default: BagLoginBundle:Registration:activation_email_request.twig
- Override by: bag_login.view.activation_email_request

## Activation email request completed
This page is shown after the activation email request form has been submitted and the process is ended succesfully

#### Route
- Name: bag_login_web_request_activation_email_completed
- URL: /web/activation/email/sent

### View
- Default: BagLoginBundle:Registration:activation_email_request_completed.twig
- Override by: bag_login.view.activation_email_request_completed

# Password change
If the user lost his password he can request to reset it, in order to do that he has to fill the 
password change form, an email will be sent to his email account used during the registration process 
with a link which will allow him to change it

## Password reset form
Password reset page

#### Route
- Name: bag_login_web_password_reset
- URL: /web/request/new/password

### Dispatched event
- [BagLoginEvents::PASSWORD_REQUEST_START](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)
- [BagLoginEvents::PASSWORD_REQUEST_ERROR](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)
- [BagLoginEvents::PASSWORD_REQUEST_END](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)

### View
- Default: BagLoginBundle:Password:request_new_password.twig
- Override by: bag_login.view.request_new_password

## Password reset completed
This page is shown after the password reset form has been submitted and the process is ended succesfully

#### Route
- Name: bag_login_web_password_reset_done
- URL: /web/request/new/password/completed

### View
- Default: BagLoginBundle:Password:request_new_password_completed.twig
- Override by: bag_login.view.request_new_password_completed

## Password change form
Password change page

#### Route
- Name: bag_login_web_change_password
- URL: /web/change/password/{token}

### Dispatched event
- [BagLoginEvents::PASSWORD_SET_START](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)
- [BagLoginEvents::PASSWORD_SET_ERROR](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)
- [BagLoginEvents::PASSWORD_SET_END](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)

### View
- Default: BagLoginBundle:Password:change_password.twig
- Override by: bag_login.view.change_password

## Password changed
This page is shown after the password change form has been submitted and the process is ended succesfully

#### Route
- Name: bag_login_web_password_reset_done
- URL: /web/request/new/password/completed

### View
- Default: BagLoginBundle:Password:change_password_completed.twig
- Override by: bag_login.view.change_password_completed

# Login

# Login form
Login page

#### Route
- Name: bag_login_web_login
- URL: /web/login

### Dispatched event
- [BagLoginEvents::LOGIN_START](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)

### View
- Default: BagLoginBundle:Login:login.twig
- Override by: bag_login.view.login
