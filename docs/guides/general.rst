General
=======

First things first
------------------

One of the requirements of the application is to allow both beginner or more advanced developers to work on this project simultaneously.

To achieve this, **OOP modularity** must be maintained while keeping the codebase simple and approachable.

In some cases, code that could be optimized or refactored is intentionally left as is to enhance readability for newcomers. 

For example, in JavaScript, the AJAX calls currently use repetitive jQuery code. While these could be merged into a single function, keeping them separate helps new developers quickly grasp core concepts without added complexity.


The Pitch
---------

The platforms end-goal is to extend the printed hand-book for the **"VLAM Training"**, requiring the end-user
to make assignments with multiple-choice questions or the occasional user text input. Further there a case stories, with their own set of questions.

Certain assignments or cases require the platform to parse and store the answers. This to be displayed elsewhere on the platform, eg: The dashboard.

Very special cases require custom tailored assignments isolated from default question like behaivior.

Database structure
------------------

Handling questions with predefined answers comes with challenges.  

For example, if an admin deletes a question or answer, what happens to stored user-data.

especially over time? This can lead to **unreferenced database indexes** across multiple tables, potentially causing missing user information.  

If you've checked the database structure, you may have noticed duplicated tables: 

.. tip::

	+-----------------------------+--------------------------------------+
	| **General Tables**          | **Training Tables**                  |
	+-----------------------------+--------------------------------------+
	| assignments                 | training_assignments                 |
	+-----------------------------+--------------------------------------+
	| assignment_entry            | training_assignment_entry            |
	+-----------------------------+--------------------------------------+
	| assignment_entry_properties | training_assignment_entry_properties |
	+-----------------------------+--------------------------------------+
	| assignment_result           | training_assignment_results          |
	+-----------------------------+--------------------------------------+
	| cases                       | training_cases                       |
	+-----------------------------+--------------------------------------+
	| case_entry                  | training_case_entry                  |
	+-----------------------------+--------------------------------------+
	| case_entry_properties       | training_case_entry_properties       |
	+-----------------------------+--------------------------------------+
	| case_result                 | training_case_result                 |
	+-----------------------------+--------------------------------------+


**Why Two Sets of Tables?**  

- **General Tables** → Used by admins/moderators to modify training in real-time. Changes are immediately reflected on the front-end, allowing them to interact as if they were trainees
- **Training Tables** → Created when a training session starts. These are **cloned** from General Tables and exist per training session, ensuring no interference with other sessions and isolation from future changes. 

**The Trade-Off**  

When there are typo's or missing assignments/cases in a training session, these **cannot** be modified after the fact. Similar to a regular printed hand-book. 

In special cases, there’s an option to **forcefully reset a training session**, but this will erase all saved user data for that training session.


Special Assigment or Case
-------------------------

As mentioned in the pitch, certain assignments or cases might require the platform to do something with the selected user input.
Or have a custom assigment with no questions, but other user interactions.

.. note::

	**Example Scenarios**

	- Parse answers and display them in a list on the dashboard.
	- Parse answers with AI .. (future plans)
	- Custom assignment with its own **Controller and View** isolated from default behaivior
	- Custom Post assignment page

To allow for such flexibility, **Sub Assignments** and **Complete Case Actions** has been implemented.

These are basicly Controllers but in a dedicated sub-folder, the admin is presented a *optional list to choose out of.

.. note::
	**There is a set of helpers to**

	- Save/find user meta. 
	- Get the user results for an assignment or case

For more detailed information, please refer to the Quick-Guides sub-pages.

