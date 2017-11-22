Advanced Routing configuration
==============================

By default, the routing file ``@TLHContactBundle/Resources/config/routing.xml`` imports
all the routing configuration block and enables all the routes.
In the case you want to enable or disable the different available routes, you can
modify the path after the imported routing file or manually defining the whole 
routing system.

### Format: yaml
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    tlh_contact_form:
        path: /contact
        defaults: { _controller: TLHContactBundle:Contact:form }
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

## Example

For example, you want the route to be **/contacto** in Spanish.

### Format: yaml
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    tlh_contact_form:
        path: /contacto
        defaults: { _controller: TLHContactBundle:Contact:form }
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
