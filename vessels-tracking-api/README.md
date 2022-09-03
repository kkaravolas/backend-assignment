# Vessel Positions API

## Overview
Vessel Positions is an API which supports the retrieval of maritime vehicles positions. 
Filtering options are available optionally. It is based on the Laravel PHP framework, and it uses an SQLite database for storing the ship positions.

## Prerequisites
In order to run this application, you need to have the following installed in your system:
- Docker installed in your local system **https://docs.docker.com/get-docker/** for running the local container instance
- POSTMAN for using the application

## Instructions
### How to boot the application
Firstly you need to clone this repository and open up a terminal in the application's folder.
The application is located in the ***vessels-tracking-api*** folder.

In order to boot the application, with docker daemon running in the background you need to run the following commands
```
cd vessels-tracking-api
docker-compose up --build
```

This will build the project as a container and run it on the local url 
```
http://localhost:8000
```

### How to use the application
In order to use the API you need to boot POSTMAN and import the included json collection (repository root directory) 
```
MarineTraffic.postman_collection.json
```

There you will find the **VesselPositions GET** request. 
In the **Params** tab, you can play with the optional filter parameters (mmsi, lat, lon etc.).

In the **Headers** tab, you can select one of the supported Content-Type headers. 
The selected request content-type header, will also be the content-type of the response. 
You need to select only one per call.

## Requests logging
All incoming requests, are logged in the file /storage/logs/laravel.log inside the docker container image.

In order to access this log:
- Open a terminal and type ```docker ps```
- From the displayed list of containers, grab the container id of the *vessels-tracking-api_main* image
- Run ```docker exec -it <container_id> /bin/sh``` where <container_id> is replaced with the real container id
- A new terminal opens that runs inside the container. There you type ```tail -f storage/logs/laravel.log``` in order to view in real time the log entries.

### API Swagger Documentation
You can access the API documentation, by visiting
```
http://localhost:8000/api/documentation
```

### How to run the included PHPUnit tests
In order to run the tests that are shipped with the application, you need to open a terminal in the folder where you have cloned the repository, and run
```
vendor/bin/phpunit 
```
The tests are located in the file
```
Feature/VesselPositionsApiTest.php
```
The basic assertions of the tests are:
- Check the response from the endpoint and assert a 200 response code
- Check that the response content-type matches the request content-type
- Test the case where the user requests a non supported content-type and assert the response code (406)
