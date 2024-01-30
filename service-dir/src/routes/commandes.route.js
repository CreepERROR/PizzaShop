import express from 'express';
let router = express.Router();

let CommandController = require('../controllers/commande.controller')

router.get('/commandes', CommandesController.getCommande)

module.exports = router;