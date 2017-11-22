Advanced Templating configuration
==============================

By default, the template file ``@TLHContactBundle/Resources/view/Contact/form.html.twig`` extends
a template called ``@TLHContactBundle/Resources/view/layout.html.twig``.

In the case you want to override one of those, you can create your own template into the 
``app/Resources/view/TLHContactBundle/`` directory.

### Replacing layout.html.twig
The {% block %} used is the following:
```
{% block tlh_contact_content %}
{% endblock tlh_contact_content %}
```

### List of default templates
- @TLHContactBundle/Resources/view/layout.html.twig
- @TLHContactBundle/Resources/view/Contact/form.html.twig
- @TLHContactBundle/Resources/view/Contact/email.txt.twig
- @TLHContactBundle/Resources/view/Contact/emailing_information.txt.twig
