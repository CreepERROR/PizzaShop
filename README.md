# PizzaShop

Docketu : 

http://docketu.iutnc.univ-lorraine.fr:18250/ : adminer
http://docketu.iutnc.univ-lorraine.fr:18251/ : catalogue
http://docketu.iutnc.univ-lorraine.fr:18252/ : commande

## Curl des routes gateway :

## Produits :
curl --location 'http://localhost:3080/produits' \
--header 'Origin: *' \
--data ''

## Un produit par numéro :
curl --location 'http://localhost:3080/produit/1' \
--header 'Origin: *' \
--data ''

## Produits d’une catégorie :
curl --location 'http://localhost:3080/categories/7/produits' \
--header 'Origin: *' \
--data ''

## Affichage UNE commande :
curl --location 'http://localhost:3080/commandes/112e7ee1-3e8d-37d6-89cf-be3318ad6368' \
--header 'Origin: *' \
--data ''

## SIGNIN ds le shop :
curl --location --request POST 'http://localhost:3080/signin' \
--header 'Origin: *' \
--header 'Authorization: Basic QWxpeFBlcnJvdDpBbGl4UGVycm90' \
--data ''

## CreateCommand :
curl --location 'http://localhost:2080/createCommand' \
--header 'Origin: *' \
--header 'Content-Type: text/plain' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvIiwic3ViIjoicGl6emEtc2hvcC5kYiIsImF1ZCI6InBpenphc2hvcGNvbXBvbmVudHMtYXBpLnBpenphLWF1dGgtMSIsImlhdCI6MTcwNDgwOTA4NywiZXhwIjoxNzA0ODEyNjg3LCJ1c2VybmFtZSI6IkFsaXhQZXJyb3QifQ.s4afTZJQ42j5ifRYigOsMr3GrRpx8zPjiOnivOvqQDY' \
--data-raw '{
"refresh_token": "ac590b521c41d3d4dd0c901b040d1b6317817b693a7b830b5f1d1e010e411a9a",
"mail_client": "testtest@gmal.com", "type_livraison": 2,
"items": [
{
"numero": 1,
"taille": 1,
"quantite": 3
}
] }'


curl --location --request GET 'http://localhost:3080/api/users/validate' \
--header 'Content-Type: text/plain' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvIiwic3ViIjoicGl6emEtc2hvcC5kYiIsImF1ZCI6InBpenphc2hvcGNvbXBvbmVudHMtYXBpLnBpenphLWF1dGgtMSIsImlhdCI6MTY5OTk1NzY5MCwiZXhwIjoxNjk5OTYxMjkwLCJ1c2VybmFtZSI6IkFsaXhQZXJyb3QifQ.98whuYU_nOJm9-JRsQPl8kKV3UL1T0f4KUvSUcuswVw' \
--data '{
"refresh_token": "ac590b521c41d3d4dd0c901b040d1b6317817b693a7b830b5f1d1e010e411a9a"
}'


curl --request POST \
  --url http://localhost:3080/api/users/signin \
  --header 'Authorization: Basic Q2hhcmxlczptZHA=' \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/8.3.0'

curl --location 'http://localhost:3080/api/users/refresh' \
--header 'Content-Type: text/plain' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvIiwic3ViIjoicGl6emEtc2hvcC5kYiIsImF1ZCI6InBpenphc2hvcGNvbXBvbmVudHMtYXBpLnBpenphLWF1dGgtMSIsImlhdCI6MTY5OTMwNTY3OCwiZXhwIjoxNjk5MzA5Mjc4LCJ1c2VybmFtZSI6IkFsaXhQZXJyb3QifQ.k04E-pJedwOp_6Os0_7Y9S6GtftqF_nEfu3lhJcmcsg' \
--data '{    "refresh_token": "ac590b521c41d3d4dd0c901b040d1b6317817b693a7b830b5f1d1e010e411a9a"}'



## CURL DES ROUTES PAS PAS PAS GATEWAY :

## Produits :
curl --location 'http://localhost:2080/produits' \
--header 'Origin: *' \
--data ''

## Un produit par numéro :
curl --location 'http://localhost:2080/produit/1' \
--header 'Origin: *' \
--data ''

## Produits d’une catégorie :
curl --location 'http://localhost:2080/categories/7/produits' \
--header 'Origin: *' \
--data ''

## Affichage UNE commande :
curl --location 'http://localhost:2080/commandes/112e7ee1-3e8d-37d6-89cf-be3318ad6368' \
--header 'Origin: *' \
--data ''

## SIGNIN ds le shop :
curl --location --request POST 'http://localhost:2080/signin' \
--header 'Origin: *' \
--header 'Authorization: Basic QWxpeFBlcnJvdDpBbGl4UGVycm90' \
--data ''

## CreateCommand :
curl --location 'http://localhost:2080/createCommand' \
--header 'Origin: *' \
--header 'Content-Type: text/plain' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvIiwic3ViIjoicGl6emEtc2hvcC5kYiIsImF1ZCI6InBpenphc2hvcGNvbXBvbmVudHMtYXBpLnBpenphLWF1dGgtMSIsImlhdCI6MTcwNDgwOTA4NywiZXhwIjoxNzA0ODEyNjg3LCJ1c2VybmFtZSI6IkFsaXhQZXJyb3QifQ.s4afTZJQ42j5ifRYigOsMr3GrRpx8zPjiOnivOvqQDY' \
--data-raw '{
"refresh_token": "ac590b521c41d3d4dd0c901b040d1b6317817b693a7b830b5f1d1e010e411a9a",
"mail_client": "testtest@gmal.com", "type_livraison": 2,
"items": [
{
"numero": 1,
"taille": 1,
"quantite": 3
}
] }'
