BagLoginBundle full configuration description
==================================

``` yml
# app/config/config.yml
  bag_login:
    user_class:                           # Your User class full path
    email:
      from_address:                       # email address used as sender in emails
      from_display_name:                  # email name to display as sender in emails
      send_registration_email:            # true|false, if true, after a new registration the user is notified with an email
      require_account_verification:       # true|false, if true, after a new registration the account will not be active, a link will be sent in the registration email, the user has to click on it in order to activate the account
      send_activation_email:              # true|false, if true, after the activation of the account, an email is sent to the user
      events:
        registration:
          subject:                        # Subject to be used for the registration email
          view:                           # View defining the email content
        account_activation:
          subject:                        # Subject to be used for the account activation email
          view:                           # View defining the email content
    form:
      type:
        registration:                     # registration form type full path
    social_network:
      facebook:
        appId:                            # Facebook's appId
        secret:                           # Facebook's secret
      twitter:
        appId:                            # Twitter's appId
        secret:                           # Twitter's secret
      google:
        appId:                            # GooglePlus's appId
        secret:                           # GooglePlus's secret
    views:
      page_not_found:                     # Page not found view
      error:                              # This view shows an error message
      activation_email_request:           # This view handles the activation email request form
      activation_email_request_completed: # This view shows the succesfully activation email sent
      registration:                       # This view handles the registration form
      registration_completed:             # This view shows the succesfully registration message
      account_activated:                  # This view shows the account activated message
      login:                              # This view handles the login form
      logout:                             # This view shows the succesfully logout message
      request_new_password:               # This view handles the new password request form
      request_new_password_completed:     # This view shows the succesfully password reset
      change_password:                    # This view handles the password change
      change_password_completed:          # This view shows the succesfully changed password message
```

Here a fully example

``` yml
# app/config/config.yml
  bag_login:
    user_class:                           Project\CoreBundle\Entitiy\User
    email:
      from_address:                       no_reply@company.com
      from_display_name:                  Company Name Ltd.
      send_registration_email:            true
      require_account_verification:       false
      send_activation_email:              false
      events:
        registration:
          subject:                        Thank you for the registration at Company Name Ltd.
          view:                           ProjectCoreBundle:Email:registration_email.html.twig
        account_activation:
          subject:                        Your account is now active
          view:                           ProjectCoreBundle:Email:account_activated.html.twig
    form:
      type:
        registration:                     Project\CoreBundle\Form\Type\RegistrationType
    social_network:
      facebook:
        appId:                            FFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
        secret:                           XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
      twitter:
        appId:                            TTTTTTTTTTTTTTTTTTTTTTTTTTTTTT
        secret:                           YYYYYYYYYYYYYYYYYYYYYYYYYYYYYY
      google:
        appId:                            GGGGGGGGGGGGGGGGGGGGGGGGGGGGGG
        secret:                           ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    views:
      page_not_found:                     ProjectCoreBundle:Default:page_not_found.html.twig
      error:                              ProjectCoreBundle:Default:error.html.twig
      activation_email_request:           ProjectCoreBundle:Default:activation_email_request.html.twig
      activation_email_request_completed: ProjectCoreBundle:Default:activation_email_request_completed.html.twig
      registration:                       ProjectCoreBundle:Default:registration.html.twig
      registration_completed:             ProjectCoreBundle:Default:registration_completed.html.twig
      account_activated:                  ProjectCoreBundle:Default:account_activated.html.twig
      login:                              ProjectCoreBundle:Default:login.html.twig
      logout:                             ProjectCoreBundle:Default:logout.html.twig
      request_new_password:               ProjectCoreBundle:Default:request_new_password.html.twig
      request_new_password_completed:     ProjectCoreBundle:Default:request_new_password_completed.html.twig
      change_password:                    ProjectCoreBundle:Default:change_password.html.twig
      change_password_completed:          ProjectCoreBundle:Default:change_password_completed.html.twig
```
