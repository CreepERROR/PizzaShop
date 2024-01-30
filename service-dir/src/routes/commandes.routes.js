const express = require ('express');
let router = express.Router();

let CommandesController = require('../controllers/commande.controller')

router.get('/commandes', CommandesController.getCommande)

module.exports = router;