# BagLoginBundle API reference

## Login / Register with Social Networks

#### Route
- Name: bag_login_api_social
- URL: /api/login/``{network}``
- Method: POST

``{network}`` = [facebook|twitter|google]

### Input parameter
* *client_id*
* *client_secret*

### Returned codes
* 200: Operation succeeds
* 400: Operation fails

### Output 

## New account registration

### Dispatched event
- [BagLoginEvents::USER_REGISTER](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)

#### Route
- Name: bag_login_api_register
- URL: /api/register
- Method: POST

### Input parameter

* Object defined in **bag_login.form.type.registration** (default [RegistrationType](https://github.com/bagbyte/BagLoginBundle/blob/master/Form/Type/RegistrationType.php))

### Returned codes

* 200: Operation succeeds
* 400: The data sent are not correct or some required data is missing
* 409: The email is already registered

## Request activation email

### Dispatched event
- [BagLoginEvents::USER_REQUEST_CONFIRMATION_EMAIL](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)

#### Route
- Name: bag_login_api_request_activation_email
- URL: /api/request/activation/email
- Method: POST

### Input parameter
* [EmailType](https://github.com/bagbyte/BagLoginBundle/blob/master/Form/Type/EmailType.php) object

### Returned codes
* 200: Operation succeeds
* 400: The data sent are not correct or some required data is missing
* 412: The email doesn't match any user

## Request new password

### Dispatched event
- [BagLoginEvents::USER_REQUEST_NEW_PASSWORD](https://github.com/bagbyte/BagLoginBundle/blob/master/BagLoginEvents.php)

#### Route
- Name: bag_login_api_password_reset
- URL: /api/request/new/password
- Method: POST

### Input parameter
* [EmailType](https://github.com/bagbyte/BagLoginBundle/blob/master/Form/Type/EmailType.php) object

### Returned codes
* 200: Operation succeeds
* 400: The data sent are not correct or some required data is missing
* 409: The password reset has been already requested
* 412: The email doesn't match any user
