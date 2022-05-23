import requests

url = "https://api.orange.com/oauth/v3/token"

payload='grant_type=client_credentials'
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Authorization': 'Basic TW5WUHJ6d1V6M3JJOUdoeTlNYmU5Y0pwbWoydXRaU2Y6bDNhdkFSNWpMcVJHbmp6ag==',
  'Accept': 'application/json'
}

response = requests.request("POST", url, headers=headers, data=payload)

print(response.text)