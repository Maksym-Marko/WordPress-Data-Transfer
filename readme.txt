WordPress Data Transfer.

Data transfer from one WordPress website to another. 
The goal is to move data from a very old website, clean up spam, revisions, and extra stuff.
The problem is that the new website already has data and you shouldn't destroy it.

Export:
You should to determine what data you want to move to the new website and get rid of the excess.

Import:
- You should run each stage separately to decrease server loading.
- Users and usermeta table should be imported manually (in case the wp_users table on the new website is empty). 
- Pay attention about wp prefix.
- If wp prefixes on the websites are the same = no problem!