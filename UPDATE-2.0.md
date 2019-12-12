UPGRADE for 2.0
===============

BC change
---------

* The minimim version specified in composer.json is now PHP 5.6. It was 5.5 until now.
* Drop support for Symfony 2.8 as FrameworkBundle 2.8 does not contain the AbstractController. Plus Symfony 2.8 is not
maintained since November 2019.

Changelog
---------

* The controller is extending AbstractController instead of Controller
* Services are now injected into the controller constructor
* Model\ContactInterface has been created, it is clearer than using the Model\Contact
* Twig is now injected instead of EngineInterface from symfony/templating
* Documentation has been slightly updated
