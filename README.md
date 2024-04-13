# Financial Dashboard

## Description

The Financial Dashboard is a web application that retrieves and displays financial data from an open API. Users can view real-time stock prices, market trends, and other relevant financial information in a clean and intuitive interface.

## Why?

Accessing and analyzing financial data can be a daunting task for many individuals, especially those who are not familiar with the complexities of the financial markets. This project aims to simplify the process by providing a user-friendly dashboard that consolidates and presents the most important financial information in an easy-to-understand format.

## Prerequisites

- A server with Docker and Docker Compose installed

- A domain name pointing to the server's IP address

## Quick Start

1\. Clone the repository:

```

git clone <project-git-repo-url>

```

2\. Set up your `.env` file:

   - Set up your RapidAPI credentials:

     ```

     RAPIDAPI_KEY=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

     RAPIDAPI_HOST=<your-host-file-here>

     ```

   - Add your mailer credentials so that the project can send emails.

3\. Build the Docker images:

```

docker-compose build

```

4\. Start the Docker containers:

```

docker-compose up -d

```

The `-d` flag runs the containers in detached mode.

5\. Set up Laravel:

   - Enter the Laravel container:

     ```

     docker exec -it <container-name> /bin/bash

     ```

     Replace `<container-name>` with the name of your Laravel container.

   - Install the dependencies:

     ```

     composer install

     npm install

     ```

   - Run the Laravel Mix build:

     ```

     npm run prod

     ```

6\. Verify the deployment:

   Visit your domain name in a web browser to verify that your Laravel project has been successfully deployed. The project currently points to the `8080` port, but you can update this if needed.

   ```

   http://localhost:8080

   ```
   
