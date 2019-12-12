CHANGELOG for 1.2.x
===================

BC change
---------

The minimim version specified in composer.json is now PHP 5.6. It was 5.5 until now.

Changelog
---------

* The controller is extending AbstractController instead of Controller
* Services are now injected into the controller constructor
* Model\ContactInterface has been created, it is clearer than using the Model\Contact
* Documentation has been slightly updated
