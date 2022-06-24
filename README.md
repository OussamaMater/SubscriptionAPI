# Subscription REST API

A simple subscription RESTful API with in which users can subscribe to a single/multiple websites and recieve emails whenever a post is published.

This API goal is to demonstrate the following Laravel concepts:
- Structuring routes.
- Events & Listeners.
- Queues.
- Commands.
- Handling calls and formatting responses.

## Install

    git clone https://github.com/OussamaMater/SubscriptionAPI.git
    cd SubscriptionAPI
    composer install --ignore-platform-reqs
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan db:seed


## Run the app

    php artisan serve

# Endpoints

The REST API to the example app is described below.

## Create a Website

### Request

`POST /api/v1/websites`

    curl --request POST \
    --url http://127.0.0.1:8000/api/v1/websites \
    --header 'Accept: application/json' \
    --header 'Content-Type: multipart/form-data' \
    --form name=something

### Response

    {
    "status": "created",
    "message": "website was created."
    }

## Create a Client

### Request

`POST /api/v1/clients`

    curl --request POST \
    --url http://127.0.0.1:8000/api/v1/clients \
    --header 'Accept: application/json' \
    --header 'Content-Type: multipart/form-data' \
    --form email=email@email.com \
    --form password=password \
    --form name=something
### Response

    {
    "status": "created",
    "error": "client was created."
    }

## Login a Client

### Request

`POST /api/v1/clients/login`

    curl --request POST \
    --url http://127.0.0.1:8000/api/v1/clients/login \
    --header 'Accept: application/json' \
    --header 'Content-Type: multipart/form-data' \
    --form email=email@email.com \
    --form password=password
### Response

    {
    "status": "success",
    "message": "2|eZaccuhspPrJTwK2iCB2xNj0Dj9qL3FH3rGoZLlD"
    }

## Logout a Client

### Request

`POST /api/v1/clients/logout`

    curl --request POST \
    --url http://127.0.0.1:8000/api/v1/clients/logout \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer 1|rWtxn3D5ERH3c7zU2Ai17fmJ9pWjhOwupB2b18Fw' \
    --header 'Content-Type: multipart/form-data' \
### Response

    {
    "status": "success",
    "message": "2|eZaccuhspPrJTwK2iCB2xNj0Dj9qL3FH3rGoZLlD"
    }

## Create a Website Post

### Request

`POST /api/v1/posts`

    curl --request POST \
    --url http://127.0.0.1:8000/api/v1/posts \
    --header 'Accept: application/json' \
    --header 'Content-Type: multipart/form-data' \
    --form 'title=a title' \
    --form 'description=some text' \
    --form website=10
### Response

    {
    "status": "success",
    "message": "user logged out."
    }

## Subscribe to a Website

### Request

`POST /api/v1/clients/subscribe`

    curl --request POST \
    --url http://127.0.0.1:8000/api/v1/clients/subscribe \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer 1|rWtxn3D5ERH3c7zU2Ai17fmJ9pWjhOwupB2b18Fw' \
    --header 'Content-Type: multipart/form-data' \
    --form user=1 \
    --form website=10
### Response

    {
    "status": "created",
    "error": "client subscribed to website."
    }