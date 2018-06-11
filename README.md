# IFTTT Tube Notification Script

Sends a notification to IFTTT containing the tube status for selected lines.

This requires the php file running on your own server.

### Set-up

- Add a random string as a key into the key.ini file.
  This string can be as long as you like (as long as IFTTT can fit it into a POST request).
- You will probably want to delete the #!/usr/bin/php line at the top for most servers.
- On IFTTT, "If webhook, then send push notification".
- We then call our script from IFTTT using "If time, then call webhook".
  We put the same key from the ini file into the POST body.
- Change the `$lines` and `$url` variables in the script to your choosing.
  `$url` is the url from IFTTT webhooks.
  `$lines` has to be an id on tfl's api, which for all tube lines is the lowercase name of the line, e.g. `central`.
  London overground is `london-overground`.

### Testing

```
curl -d "key" -X POST url
```
This will send the notification to IFTTT.
