Getting Started With TLHContactBundle
==================================


Installation
------------

1. Download TLHContactBundle using composer
2. Import TLHContactBundle routing file

Step 1: Download TLHContactBundle using composer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Require the bundle with composer:

.. code-block:: bash

    $ composer require friendsofsymfony/user-bundle "~2.0@dev"


Step 2: Import TLHContactBundle routing file
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

By importing the routing files you will have the contact page ready.


.. configuration-block::

    .. code-block:: yaml

        # app/config/routing.yml
        tlh_contact:
            resource: "@TLHContactBundle/Resources/config/routing.xml"

    .. code-block:: xml

            <!-- app/config/routing.xml -->
            <import resource="@TLHContactBundle/Resources/config/routing.xml"/>
