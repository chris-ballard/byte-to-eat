# Byte to Eat

A basic example of how Generative AI can be used to power features in PHP applications, using the OpenAI API.

The app is built using Symfony and Bootstrap, and is based on the [Symfony Docker](https://github.com/dunglas/symfony-docker) skeleton.
It uses the [openai-php client](https://github.com/openai-php/client) to talk to OpenAI.

## Getting Started

### Prerequisites

1. [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. An [OpenAI](https://platform.openai.com/) developer account

### Running The App

1. Copy the `.env` file to `.env.local` and enter your API credentials
2. Run `docker compose up -d` to pull the image and start the container
3. Open https://localhost and [accept the auto-generated TLS certificate](https://stackoverflow.com/questions/7580508/getting-chrome-to-accept-self-signed-localhost-certificate/15076602#15076602)
4. Start ordering some food!*

*this is not a real restaurant and any food is subsequently received it is purely coincidental

## How To Use

Byte to Eat is a fictional (!) restaurant where you are waited on by an AI assistant.
The app presents you with a form with options for your starter, main course, and dessert. 
However, rather than manually clicking and selecting your choices (because who has time for that??),
instead you type your request into the order field and the assistant will fill in the form for you.

Because the intention is that the form is automatically filled, the select fields in the form are disabled. But since
this means that you're unable to see the options, the menu is printed for you underneath the form.

### Placing an order

1. Enter your request in the "What would you like to order?" field, e.g.
```
I'd like the calamari, cheese burger, and ice cream, please! 
```
2. Click the "Ask Order Assistant" button and your choices will be automatically populated
3. Your choices can be subsequently changed by submitting further requests to the Order Assistant
4. Messages from the assistant will be displayed above the form each time a request is submitted
5. Once you're happy with your selection, click the "Place Order" button - reset the conversation thread so you can start a new order from scratch
