import requests
payload = {'state': 'success'}
r = requests.post("http://localhost:8080/Raspi_receive.php", data=payload)
print(r.text)