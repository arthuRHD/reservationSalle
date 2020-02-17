# reservationSalle
> a WebApp that provides a calendar and multiple forms to manage room reservations <br> 
> using LDAP protocol to authenticate your employees and a database to store reservation

## Install 
Once cloned on you local repository, you need to import `script_bdd_reset.sql` in your MariaDB/MySQL server
```sh
create database bddreserv;
use bddreserv;
source 'path/to/repository/script_bdd_reset.sql';
```

## Troubleshooting 

- Verify if the database is installed
- Verify the version of the dependencies
- Check error logs of your HTTP server
- Check if LDAP extension is installed on `phpinfo.php`
- Check if the LDAP connexion is correct

## Contact me 
[Arthur Richard](mailto:arthur.richard2299@gmail.com)