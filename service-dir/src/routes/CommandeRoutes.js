import express from 'express';
let router = express.Router();
import CommandeService from '../services/CommandeService.js';
import GetCommandesAction from '../controllers/GetCommandesAction.js';
import ChangeStateAction from '../controllers/ChangeStateAction.js';

const commandeService = new CommandeService();
const getCommandeAction= new GetCommandesAction(commandeService);
router
    .route('/')
    .get(getCommandeAction.execute.bind(getCommandeAction))
    .all((req, res, next) => next(405));

const changeStateAction = new ChangeStateAction(commandeService);
router
    .route('/:id/state')
    .patch(changeStateAction.execute.bind(changeStateAction))
    .all((req, res, next) => next(405));

export default router;