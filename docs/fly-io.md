# Fly.io Deployment

[Fly.io](https://fly.io/) is a platform for deploying and running applications globally.  It's a great choice for this app because it's easy to use and free for small projects.

## Setting up the Fly machine.

* Run `fly launch`. 
* I chose not to setup a databse or redis.
* I downgraded to the smallest machine size.

## Setting up the Database

### Supabase
I used [Supabase](https://supabase.com/) for this app. It's free and easy to use.  
They also give a UI for looking at the data in the database. 

Start by creating a postgresql DB with Supabase and copy the URL

Create a new DB in Supabase.

Copy the connection URI from the DB settings. The URL for this page looks like:
```
https://supabase.com/dashboard/project/[YOUR-ROJECT]/settings/database
```

Make sure to choose "Mode: session" instead of "Mode: transaction".  The URI will look something like this:
```
postgresql://postgres.[YOUR-PROJECT]:[YOUR-PASSWORD]@aws-0-ca-central-1.pooler.supabase.com:5432/postgres
```
 
In Fly, set the secret environment variable `DB_URL` to the connection URI and add `\?sslmode=disable` to the end of the URL.  For example:

```bash
fly secrets set DB_URL=postgresql://postgres.eldspfnfvoyjggkrsfch:STRATIFY-gumshoe-upgrowth@aws-0-ca-central-1.pooler.supabase.com:5432/postgres\?sslmode=disable
```

## Migrating the Database via Fly console
```
fly ssh console -C "php /var/www/html/artisan migrate --force"
```
