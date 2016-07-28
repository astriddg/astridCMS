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

On your command line, don't forget to type : `composer update`
And in the kernel :
```
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new OC\UserBundle\OCUserBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
```
Download the bundle, add it to your symfony projet, then add the following to the kernel :
            `new (name of the file)\CoreBundle\OCCoreBundle(),`
            
Add the following to your `app/config/config.yml` :
```
`stof_doctrine_extensions:
    orm:
        default:
            sluggable: true

fos_user:
    db_driver:     orm                       
    firewall_name: main                      
    user_class:    OC\UserBundle\Entity\User 

assetic:
  debug:          '%kernel.debug%'
  use_controller: '%kernel.debug%'`
```

Finally, in the command line, insert the following:
`doctrine:schema:update --force`
`php bin/console assets:install --symlink`
