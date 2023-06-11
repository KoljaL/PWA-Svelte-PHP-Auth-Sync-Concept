# PSPASC

https://github.com/KoljaL/PWA-Svelte-PHP-Auth-Sync-Concept

This is a proof-of-concept!

> The idea is to have a simple, offline-first, PWA that can be used to manage a notes ans tasks.   
> The backend will be a simple PHP script that will handle the database and the API.   
> The frontend will be a simple PWA that will be able to work offline and sync with the backend when online.

## Features

### Frontend
- The frontend will be a simple PWA that will be able to work offline and sync with the backend when online.
- To work offline, the app will use a IndexedDB database to store the data.
- There will be multiple indexes for the data, so that the app can search the data.
- - `created`, `updated`, `deleted` - for syncing with the backend
- - `tags`, `type`, `state` - for searching
- The app will use a service worker to cache the app shell and the data.

### Backend
- For every user, the app will create a new folder with a SQLite database, a JSON-config file and a folder for file uplaods.
- The server authenticates the user and sends a session ID as an HttpOnly response cookie.
- The database on the server will be a mirror of the IndexedDB database on the client.
- - So it is basically a Key-Value store, where the key is the `id` of the object and the value is the JSON string of the object.

## To proof
- Is the Auth flow secure enough?
- Is the IndexedDB database fast enough?
- Is a SQLite database as a Key-Value store fast enough?


## Stack
## Frontend
- SvelteKit with static-adapter

## Backend
- PHP 
- SQLite with JSON1 extension

## Links
- https://stackoverflow.com/questions/42824415/single-page-application-with-httponly-cookie-based-authentication-and-session-ma
- https://stackoverflow.com/questions/53313536/image-storage-when-offline-in-pwa
- https://www.delphitools.info/2021/06/17/sqlite-as-a-no-sql-database/
- https://www.beekeeperstudio.io/blog/sqlite-json-with-text
- 

## Code snippets


```php
function JSONTOInsertSQL($table,$obj){
    $keys   = implode('`,`', array_map('addslashes', array_keys($obj)));
    $values = implode("','", array_map('addslashes', array_values($obj)));
    return "INSERT INTO `$table` (`$keys`) VALUES ('$values')";
}
```

 