# Docker

This "hello world" app is set up to use [docker](http://docker.com) to deploy the application.
This means you can get started on building a fuel application quickly, and without having to install php7.

To get started you'll need to install docker on your machine. Instructions on this can be found on the
offical docker documentation.

First you need to build the docker container, the first time you do this it will take a while to run,
after the first run subsequent builds are faster.

```bash
docker build -t myapp .
```

Once the container is built you simply need to run it with:

```bash
docker run -d -p 127.0.0.1:5000:80 --name myfuelapp myapp 
```

The app is now running and can be accessed via `http://127.0.0.1:5000`.

To kill the app use `docker kill myfuelapp`.

Advanced docker usage is outside the scope of this quick introduction, but plenty of information can be
found by searching for it.

