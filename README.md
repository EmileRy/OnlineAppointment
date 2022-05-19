# OnlineAppointment

### Members
- Martha Higuera Pastor
- Emile Rey
- Timothé Didier Robert Nicole

### Description
OnlineAppointment is a web-app that allows patients to book online medical appointments. They will be able to look for a doctor in a specific speciality and then book an appointment depending on his/her availability.
Then, patients will have access to this list of their future appointments and they'll be able to manage them (edit, cancel...).

Doctors will be able to look manage their availability and their online booked appointments.

### How to install?

#### Requirements

* PHP server (version 8 or higher)
* MySQL server

#### Step 1: Setup files

Clone this repository into your PHP server main directory.

#### Step 2: Database

Create a database (into your MySQL server) dedicated to this app. Then import one of the `empty_db.sql` file to automatically create the tables.

#### Step 3: Configuration

Edit the `config.php` file to use the correct SQL credentials, so the app will be able to connect to the database you created during the previous step.

#### Step 4: Envoy!

The app should now work fine, you can navigate to your PHP server main URL to use it and create your own account. Note that it is an experimental app so there is no email verification.