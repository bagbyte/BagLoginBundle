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
