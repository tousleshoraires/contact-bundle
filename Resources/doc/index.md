Getting Started With TLHContactBundle
==================================

## Installation

1. Download TLHContactBundle using composer
2. Import TLHContactBundle routing file

## Step 1: Download TLHContactBundle using composer

Require the bundle with composer:
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $ composer require tousleshoraires/contact-bundle "dev-master"
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

## Step 2: Register the Bundle into the AppKernel
```
<?php
 // app/AppKernel.php
 
 public function registerBundles()
 {
     $bundles = array(
         // ...
         new TLH\ContactBundle\TLHContactBundle(),
         // ...
     );
 }
```

## Step 3: Import TLHContactBundle routing file

By importing the routing files you will have the contact page ready.

### format: yaml
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        # app/config/routing.yml
        tlh_contact:
            resource: "@TLHContactBundle/Resources/config/routing.xml"
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

### format: xml
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        <!-- app/config/routing.xml -->
        <import resource="@TLHContactBundle/Resources/config/routing.xml"/>
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

## Step 4: Configuration

The bundle can be configured with a custom FormType, a specific Entity or the basic sender information.

### Complete configuration
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
tlh_contact:
    class: MyContactEntity
    form: MyContactType
    recipient_address: "address@domain.tld"
    confirmation: 
        enabled: true
        from_email:
            address: sender@domain.tld
            sender_name: Name
    information: 
        enabled: true
        from_email:
            address: sender@domain.tld
            sender_name: Name
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


## Next Steps

Now that you have completed the basic installation and configuration of the
TLHContactBundle, you are ready to learn about more advanced features and usages
of the bundle.
- routing
- templating

The following documents are available:
...
