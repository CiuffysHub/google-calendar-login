# Calendar Login Demo

This is a very simple demonstration of how to get your users to log-in to your website and manage their Google Calendar.
In order to do this, we need to get a refresh token for every user, by asking their permission to log-in.

## Requirements

You are first required to create a Google API Application and to give it Google Calendar permissions and an allowed redirect url to the "google-login.php" page that you have to upload on your domain.

## Explanation

- Upload your google-login.php page: this is a php page that will display the tokens once you get redirected to it. Make sure to fill all the redacted fields.
- Use the following link (fill redacted): https://accounts.google.com/o/oauth2/auth?scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcalendar&redirect_uri=https://www.[yourdomain].it/google-login.php&response_type=code&client_id=[APP_CLIENT_ID]&access_type=offline&prompt=consent

Congratulations, you now have permanent access to Google Calendar from your web app! Try the following pages to start managing the google account:

https://www.[yourdomain].it/add_event.php?title=YourTitle
https://www.[yourdomain].it/upcoming.php
