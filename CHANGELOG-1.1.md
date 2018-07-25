CHANGELOG for 1.1.x
===================

This changelog references the relevant changes (bug and security fixes) done
in the 1.1 version.

- deprecation : Entity/Contact has been deprecated. Model/Contact should be used instead.
- refactor : both sending methods have been moved from the main Controller to Services/Messager
- refactor : calling new_Instance on the Switch_Message is deprecated. It has been fixed.
