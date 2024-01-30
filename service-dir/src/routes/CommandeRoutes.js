import express from 'express';
let router = express.Router();
import getCommandeAction from '../controllers/getCommandeAction.js';
import changeStateAction from '../controllers/changeStateAction.js';
router
    .route('/')
    .get(getCommandeAction)
    .all((req, res, next) => next(405));

router
    .route('/:id/state')
    .patch(changeStateAction)
    .all((req, res, next) => next(405));

export default router;