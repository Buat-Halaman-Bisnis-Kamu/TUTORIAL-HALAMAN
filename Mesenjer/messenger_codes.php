curl -X POST -H "Content-Type: application/json" -d '{
  "type": "standard",
  "data": {
    "ref":"billboard-ad"
  },
  "image_size": 1000
}' "https://graph.facebook.com/v2.6/me/messenger_codes?access_token=<ACCESS_TOKEN>"
