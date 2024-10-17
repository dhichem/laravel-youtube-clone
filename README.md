## Project Overview

This project is a **YouTube clone** built with **Laravel** and **Vue.js**, offering a complete video-sharing platform with advanced features.

## Key Features

- **Seeders / Factories**: The database is populated using **seeders** and **factories**, enabling quick testing of video uploads, users, and comments.

- **Middleware / Auth**: The application employs **middleware** and **auth** for secure user authentication and route protection, ensuring only authenticated users can access specific features like video uploads.

- **Request Validation**: All incoming **requests** are validated efficiently, ensuring data integrity when users upload videos or update their profiles.

- **Tailwind CSS**: For styling, the project uses **Tailwind CSS**, providing a responsive and modern design out-of-the-box.

- **Vue.js Integration**: The frontend is built with **Vue.js**, enhancing user experience with dynamic components such as video players, real-time comments, and more.

- **Route Model Binding**: Simplifies controller logic by using **route model binding** to inject models directly into routes, like videos and users.

- **Accessors / Mutators**: Leverages **accessors** and **mutators** for data manipulation, ensuring video titles and descriptions are properly formatted before being saved.

- **pbmedia/laravel-ffmpeg**: Video processing is handled using **pbmedia/laravel-ffmpeg** to manipulate video files and generate **thumbnails** for each upload.

- **Jobs / Queues**: Video formatting and processing are offloaded to **jobs** and **queues**, improving performance and allowing background processing.

- **HLS (HTTP Live Streaming)**: Supports **HLS** for adaptive bitrate streaming, delivering high-quality video playback across all devices.

- **VideoJS Player**: Utilizes **VideoJS** for video playback, offering a customizable and reliable player for all browsers.

This YouTube clone project is designed to be scalable and extendable, making it an ideal foundation for any video-driven platform.
