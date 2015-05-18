Social networks login
==================================

Social networks login configuration:

``` yaml
# app/config/config.yml
bag_login:
  ...
  social_network:
    facebook:
      app_id:                           # Facebook's app ID
      secret:                           # Facebook's secret
      fields:                           # fields to be fetched from Facebook profile, with corresponding User's object property to be filled
    twitter:
      consumer_key:                     # Twitter's consumer key
      consumer_secret:                  # Twitter's consumer secret
      fields:                           # fields to be fetched from Facebook profile, with corresponding User's object property to be filled
    google:
      client_id:                        # GooglePlus's client ID
      client_secret:                    # GooglePlus's client secret
      api_key:                          # GooglePlus's api key
      fields:                           # fields to be fetched from Facebook profile, with corresponding User's object property to be filled
```

# Facebook
Possible fields to be fetched from Facebook user profile:

- name
- lastName
- email
