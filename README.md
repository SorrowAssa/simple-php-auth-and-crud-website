# Simple PHP auth and CRUD website

Hi, here is just a try to put my knowledges in PHP as a simple website.
No CSS, the goal was only to create forms that could be called in ajax.  
This website works with mysql to store the data.

I'm more a .Net developper and there are maybe wrong ways to do in this site, but maybe it will help someone one day !

### 2 parts

- Authentication : you can register/login, form is posted with ajax. If succeeded, user is logged.
- CRUD : a page where you can create *events*. You are redirected on the list view, and when click on an action, a modal is shown, calling a partial page (create, edit,...).
Forms don't have a real control, that was not the aim of the solution (edit only by creator, minimum fields length...)

### Install

There are 2 files that need to be initialized: 
- *demo/create_demo_dp.php* : line 5, set your mysql user with db creation rigths.
- *includes/config.php* : line 4, set your local base url, **http://localhost:8080/** by default. Used in header.php to determine path to js (yeah, I was lazy). Line 8, mysql user again.

The db is created when you visit the *index.php* (if can't connect to db) or *create_demo_dp.php*.

### Security

CSRF: I put a csrf token on forms. Not sure it's the good way through, I'm not an expert :/  
XSS: Prepared queries with UTF-8 should be ok.  
For all data displayed from db, htmlentities() to avoid html or js modifications.
