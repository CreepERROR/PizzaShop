import express from 'express';
let router = express.Router();
import getCommandeAction from '../controllers/getCommandeAction.js';
import changeStateAction from '../controllers/changeStateAction.js';
router
    .route('/commandes')
    .get(getCommandeAction)
    .all((req, res, next) => next(405));

router
    .route('/commandes/:id/state')
    .patch(changeStateAction)
    .all((req, res, next) => next(405));

module.exports = router;