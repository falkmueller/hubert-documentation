# Documentation

## What is Hubert?

Hubert is a php micro framework. It loads a configuration and
controls everything from request to response.

## How does it work?

Hubert is initialised by a single array that contains configuration, service containers and routes. When running _hubert()->core()->run()_ a route matching the request is selected, executed and its response is returned back to the browser. Thats the basic functionalit of Hubert. Furthermore Hubert of course can run bootstrap scripts, process MVC routes, render templates, save data and more. All these topics are covered by this documentation.
