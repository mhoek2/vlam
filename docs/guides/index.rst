Quick-Guides
======

.. toctree::
   :maxdepth: 2

   dashboard-modules
   complete-case-actions
   sub-assignments
   user-meta-service
   entry-types
   
   
Introduction
============

One of the requirements of the application is to allow both beginner or more advanced developers to work on this project simultaneously.

To do that, OOP modularity has to be kept in mind.
Also, keep the codebase simple. 
And even keep some code that could be refactored and cleaned up to be smaller.

For example, for javascript, the ajax calls are repetitive jQuery code.
This could be unified in a single function. 
But keeping it separated allows for new developers quickly understand the core concepts