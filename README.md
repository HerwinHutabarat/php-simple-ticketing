# PHP-SIMPLE-TICKETING
#### A simple app to manage ticket using php native

This i a simple native php api services for ticket management, such as generated ticket, show the ticket, and update status of ticket . Specially on ticket generator service is PHP CLI command executable via Command Prompt or Terminal only.

#### Requirements
- PHP > v7.4
- MySQL > v5.5

#### Features

- Generate Ticket
- Check Ticket
- Update Ticket

#### How to use
Make sure your system already install all requirements, then clone this repository into your project folder. After you finish, open it using your favorite IDE. \
\
Before start running the app, make sure that MySQL Service running in your system.
Then go to the file named **dump.sql** in this project folder, copy the query and paste into your SQL Editor like ([Navicat](https://www.navicat.com), [DBeaver](https://dbeaver.io), etc) then execute.

Now here we are
Run this command in your Command Prompt or Terminal

```bash
php generate_ticket.php 2 100
```
The command above will generate ticket code with **_event_id_** 2 as much as 100.

Finally start the app
```bash
php -S localhost:8000
```

All api service specifications are contained in the ticketing.json file.