# Spin City
## A fullstack project representing an online physical music vendor.
### Built with HTML5, CSS, Bootstrap, PHP, and MySQL.

This website represents a fictional online physical music vendor named Spin City. This website allows a user to browse and inspect a multitude of records of which are available in vinyl and/or CD.
The user is also available to create an account, but that doesn't do much to change their experience as of now.

The largest efforts were put into the employee experience. Each employee has an account they can login to, where they can:
- Add a new record with information regarding its name, artist, year of release, album cover, genre, price, etc.
- Edit an existing records information.
- Delete a record from the database.

On top of the employees, there exists administrators. Admins have all the abilities of an employee on top of being able to:
- Add a new employee with information regarding their first name, last name, account name, password, etc.
- Delete an existing employee

All account passwords are passed through a hashing algorithm, and the website uses prepared MySQL statements as well as filtering to prevent injections.
