import { changeState } from '../services/CommandeService.js';

export default async function changeStateAction(req, res, next) {
    try{
        const commandeId = req.params.id;
        const state = req.body.state;
        const changed = await changeState(commandeId, state);
        res.json(changed);
    }catch (e){
        next(404);
    }

}