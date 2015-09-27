BagLoginBundle full configuration description
==================================

``` yaml
# app/config/config.yml
bag_login:
  user_class:                           # Your User class full path
  email:
    from_address:                       # email address used as sender in emails
    from_display_name:                  # email name to display as sender in emails
    require_account_verification:       # true|false, if true, after a new registration the account will not be active, a link will be sent in the registration email, the user has to click on it in order to activate the account
    send_registration_email:            # true|false, if true, after a new registration the user is notified with an email
    send_account_activated_email:       # true|false, if true, after the activation of the account, an email is sent to the user
    send_password_changed_email:        # true|false, if true, after the user change his password, an email is sent to the user
    events:
      registration:
        format:                         # html|text, defines the email content format
        subject:                        # Subject to be used for the registration email
        view:                           # View defining the email content
      account_activation:
        format:                         # html|text, defines the email content format
        subject:                        # Subject to be used for the account activation email
        view:                           # View defining the email content
      request_new_password:
        format:                         # html|text, defines the email content format
        subject:                        # Subject to be used for the password change request email
        view:                           # View defining the email content
      password_changed:
        format:                         # html|text, defines the email content format
        subject:                        # Subject to be used for the password changed email
        view:                           # View defining the email content
  form:
    type:
      registration:                     # registration form type full path
  social_network:
    facebook:
      app_id:                           # Facebook's app ID
      secret:                           # Facebook's secret
  views:
    registration:                       # This view handles the registration form
    registration_completed:             # This view shows the succesfully registration message
    account_activated:                  # This view shows the account activated message
    login:                              # This view handles the login form
    activation_email_request:           # This view handles the activation email request form
    activation_email_request_completed: # This view shows the succesfully activation email sent
    request_new_password:               # This view handles the new password request form
    request_new_password_completed:     # This view shows the succesfully password reset
    change_password:                    # This view handles the password change
    change_password_completed:          # This view shows the succesfully changed password message
```

Here a fully example

``` yaml
# app/config/config.yml
bag_login:
  user_class:                           Project\CoreBundle\Entitiy\User
  email:
    from_address:                       no_reply@company.com
    from_display_name:                  Company Name Ltd.
    require_account_verification:       false
    send_registration_email:            true
    send_account_activated_email:       false
    send_password_changed_email:        true
    events:
      registration:
        format:                         html
        subject:                        Thank you for the registration at Company Name Ltd.
        view:                           ProjectCoreBundle:Email:registration_email.html.twig
      account_activation:
        format:                         html
        subject:                        Your account is now active
        view:                           ProjectCoreBundle:Email:account_activated.html.twig
      request_new_password:
        format:                         html
        subject:                        A new password has been requested
        view:                           ProjectCoreBundle:Email:request_new_password.html.twig
      password_changed:
        format:                         html
        subject:                        Your password has been changed
        view:                           ProjectCoreBundle:Email:password_changed.html.twig
  form:
    type:
      registration:                     Project\CoreBundle\Form\Type\RegistrationType
  social_network:
    facebook:
      app_id:                           FFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
      secret:                           XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
  views:
    registration:                       ProjectCoreBundle:Default:registration.html.twig
    registration_completed:             ProjectCoreBundle:Default:registration_completed.html.twig
    account_activated:                  ProjectCoreBundle:Default:account_activated.html.twig
    login:                              ProjectCoreBundle:Default:login.html.twig
    activation_email_request:           ProjectCoreBundle:Default:activation_email_request.html.twig
    activation_email_request_completed: ProjectCoreBundle:Default:activation_email_request_completed.html.twig
    request_new_password:               ProjectCoreBundle:Default:request_new_password.html.twig
    request_new_password_completed:     ProjectCoreBundle:Default:request_new_password_completed.html.twig
    change_password:                    ProjectCoreBundle:Default:change_password.html.twig
    change_password_completed:          ProjectCoreBundle:Default:change_password_completed.html.twig
```
