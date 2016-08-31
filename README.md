astridCMS
=======

A Symfony project created on July 26, 2016, 1:21 pm.

##Introduction

astridCMS is a mini-CMS bundle that allows users to create static html pages. All the pages can be found on /page/page-title.

## Set up

### Initial requirements

Before you install this bundle, make sure you have the following in your composer.json "required" :
```
        "egeloen/ckeditor-bundle": "^4.0",
        "stof/doctrine-extensions-bundle": "^1.2.2",
        "friendsofsymfony/user-bundle": "dev-master",
        "symfony/assetic-bundle": "^2.7.1",
        "leafo/scssphp": "~0.6",
        "patchwork/jsqueeze": "~1.0"
```
Add the following to your `app/config/config.yml` :
```
stof_doctrine_extensions:
    orm:
        default:
            sluggable: true

fos_user:
    db_driver:     orm                       
    firewall_name: main                      
    user_class:    OC\UserBundle\Entity\User 

assetic:
  debug:          '%kernel.debug%'
  use_controller: '%kernel.debug%'
```

On your command line, don't forget to type : `composer update`
And in the kernel :
```
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
```


Then be sure to set up the following bundles appropriately : 
        - FOSUserBundle,
        - Assetic,
        - CKEditor
You can find the setup cookbooks for these bundles on https://symfony.com/

Download the bundle, add it to your symfony projet, then add the following to the kernel :
            `new (name of the file)\CoreBundle\OCCoreBundle(),`

Set up the appropriate routes in `routing.yml`:
```
oc_core:
    resource: "@OCCoreBundle/Resources/config/routing.yml"
    prefix:   /
```

Finally, in the command line, insert the following:
`doctrine:schema:update --force`
`php bin/console assets:install --symlink`


Once these steps have been carried out, you can change your security.yml file to make sure that your admin area is protected.
It should contain the following:

```
# app/config/security.yml

security:
  encoders:
        Symfony\Component\Security\Core\User\User: plaintext
        OC\UserBundle\Entity\User: sha512

  role_hierarchy:
    ROLE_ADMIN:       ROLE_USER
    ROLE_SUPER_ADMIN: [ROLE_USER, ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]

  providers:
    in_memory:
      memory:
        users:
          user:  { password: userpass, roles: [ 'ROLE_USER' ] }
          admin: { password: adminpass, roles: [ 'ROLE_ADMIN' ] }
    main:
      id: fos_user.user_provider.username

  firewalls:
    main_login:

      pattern:   ^/login$
      anonymous: true
    main:
      pattern:      ^/
      anonymous:    ~
      provider:     main
      form_login:
        login_path: fos_user_security_login
        check_path: fos_user_security_check
      logout:
        path:       fos_user_security_logout
        target:     /
      remember_me:
        secret:     %secret%

  access_control:
    - { path: ^/page, roles: IS_AUTHENTICATED_ANONYMOUSLY, requires_channel: http }
    - { path: ^/$, roles: IS_AUTHENTICATED_ANONYMOUSLY, requires_channel: http }

```
## Settings

The settings for this CMS are found in the `config.yml` file in resources.
To activate versionning, set the versionning parameter to `true`, or to `false` if you want it deactivated.
If you want default access to be activated, set it to `true` and specify the default access value. If you don't want it, just set the default access to `false`.
