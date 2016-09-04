The username Form Type
======================

TLHContactBundle provides a default form type.

    If you don't use this form type in your app, you can disable it to remove
    the service from the container:

    .. code-block:: yaml

        # app/config/config.yml
        fos_user:
            use_username_form_type: false
