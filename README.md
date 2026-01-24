# VLAM Training
[![build](https://github.com/mhoek2/vlam/actions/workflows/docs.yml/badge.svg)](https://github.com/mhoek2/vlam/actions/workflows/docs.yml)

## CodeIgniter 4
CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

## CodeIgniter 4 Shield Authentication
Shield is the official authentication and authorization framework for CodeIgniter 4. \
Shield provides two primary methods Session-based and Access Token authentication out of the box.

It also provides HMAC SHA256 Token and JSON Web Token authentication. [official site](https://shield.codeigniter.com/)

# :o: Getting-Started
Private repo, to get started:
1. Navigate to the ```gh-pages``` branch 
2. download the zip and extract
3. open index.html locally.

# Devlogs:

## Devlog 001 - week 06
Setup framework, implement front and admin controller and view separation. \
Little work has been done on the design aspect, main focus lies in setting up core features.
Example: Authentication, users roles and permissions, front and backend separation.

Mockup of creating assignments with entries has been implemented:

https://github.com/user-attachments/assets/0ccd585c-d110-45f1-8e9c-39a3aca2bdde

## Devlog 002 - week 07-09
- Parts of the front-end design have been implemented more.
- Support for modular wysiwyg editors using a service. (CKEditor, Summernote are implemented)
- Large parts of the core database infrastructure has been implemented for assignments and entries in comination with trainings, including cascaded foreign relations for ON DELETE.
That helps for a cleaner codebase. 
- Assignments are now cloned for each training in the database.
This ensures no edits can be done during a training. and prevents corrupted refences in the database. (eg. removed assignments or entries in the future wont affect a live or completed training)
- Assignments can have cases, with its own entries. 
- A option is added for handle tailored assignments, meaning a custom 'Controller' can be selected.
This will either be the 'post' page, after an assignment is saved. or when no entries are present, a dedicated assignment CAN be built.
(eg: The assignment where cards can be selected for other users, or the post assignment page where a supposed 'AI' is used to process the selected answers.)
- Large parts of code have been unified and cleaned up.

https://github.com/user-attachments/assets/28bf56af-63be-42d5-a7f9-4b29f385eba0

## Devlog 003 - week 10-12
- Style training manager in the admin panel.
- Some graphics of the figma front-end design have been implemented. (sidebar background and logo)
- Implement CSRF security tokens to all front and admin forms.
- Added javacript eventHandler to track and synchronize CSRF token across multipel tabs using localStorage.
- Added user manager for back-end "Create, Change password, Remove". 
    - <em>```(SSO is a future feature request. So, keep time spent on build-in user manager to minimum. )```</em>
- Create dashboard module system, making easier adn cleaner to extend. (OOP)
- Create a service and database structure for 'User Meta', allowing to store per-user data.
- Create helper functions. ( csrf, user, dashboard modules)
- Implement [phpDocumentor](https://phpdoc.org/) using composer, with CI workflow for auto-generation and upload to 'gh-pages' branch
- Begin adding php docstrings for documentation, and adding Guide (.rst) structure.
- Update Font Awesome version from 6.0.0 to 6.7.2
- Implement schedule management per training, in preparation for a Agenda dashboard module
- Add ability to store actual 'multi-choice' questions. (more then one answer)
- Add entry/question type grouping system
- Some general cleanup, refactoring, security type checks and bits and bobs.

https://github.com/user-attachments/assets/c965076f-2da3-48aa-b187-af8999dd34ae

## Devlog 004 - week 14-15
- Extend CI workflow with auto-generated docs reports using PHPStan (php), Schemaspy(sql), ESLint (javascript), Stylelint (css)
- Improve docs guide
- Add metrics for assignment and case to admin panel ( count entries/questions and cases )
- Define ESLint and Stylelint code conventions/format
- Add InlinePHP filter for ESLint and Stylelint
- Some general cleanup, refactoring

![image](https://github.com/user-attachments/assets/d3ca855f-e227-48c1-98a9-6180e7d418eb)



https://github.com/user-attachments/assets/71bc435d-2095-4756-809a-f4e6d362fca7


# Helpful SQL Queries:

### List Foreign Relations:
```sql
SELECT 
    TABLE_NAME, 
    COLUMN_NAME, 
    CONSTRAINT_NAME, 
    REFERENCED_TABLE_NAME, 
    REFERENCED_COLUMN_NAME
FROM 
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE 
    REFERENCED_TABLE_NAME IS NOT NULL 
    AND TABLE_SCHEMA = 'hklab69_vlam';
```
