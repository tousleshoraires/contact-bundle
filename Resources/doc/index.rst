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

    $ composer require tousleshoraires/contact-bundle "dev-master"


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

Next Steps
~~~~~~~~~~

Now that you have completed the basic installation and configuration of the
TLHContactBundle, you are ready to learn about more advanced features and usages
of the bundle.

The following documents are available:

.. toctree::
    :maxdepth: 1

    routing
