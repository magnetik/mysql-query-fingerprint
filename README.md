#Mysql Query Fingerprint PHP generator

Generate a "fingerprint" of a MySQL query.

The fingerprint of `SELECT foo FROM bar WHERE foo='bar'` is the sale as `SELECT foo FROM bar WHERE foo='foo'`. Same thing for IN or UNION commands.

##Licence
This project is under GPL V3: http://www.gnu.org/licenses/gpl.html