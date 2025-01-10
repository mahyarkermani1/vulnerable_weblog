
# introduction

[Yashar Shahinzadeh](https://voorivex.academy/class/), a security expert and web penetration testing specialist, Bug Hunter, provides online training in the field of bug hunting and web application penetration testing.
In the owasp zero course, a prerequisite is taught in designing a weblog with html, css and php.
This repository is a simple weblog with html, css, javascript and php that was taught in the prerequisites section of the owasp zero course.

All source codes are personalized by me and written and designed in the face of various challenges.
The following are some of the features of this website:

- login
- Registration
- Edit profile
- Add post
- See other posts
- Add a profile picture
- forgot password
- admin panel


## How to use this repository

> [!WARNING]
> The codes in this repository are designed and written in html, css, javascript and php. This source code has various vulnerabilities including **xss**, **injections**, **open redirect** and **other vulnerabilities**. So **do not** test and execute it in a real environment.

The purpose of this repository is to understand how a blog/website works with the html, css, javascript and php language.

The functions in this repository are described in a simple and understandable way so that users can study the source codes and understand how they work. You can run the codes by cloning the repository and run a web-server like apache.

**Linux Commands**

    # clone and move project files
    git clone https://github.com/mahyarkermani1/vulnerable_weblog.git
    cd vulnerable_weblog
    mv * /var/www/html

    # run the apache web-server
    sudo systemctl start apache2

> [!IMPORTANT]
> The database (db) folder contains parameters to set the database values ​​(name, username and other parameters in the database). You need to edit and configure the database folder according to your requirements to be able to run this source code.

The purpose of providing this source code is that all the code in this section is designed and written in simple and understandable language, and users can understand how websites work with html, css, javascript and php by studying the files in each directory, changing and modeling them.
