import {} from '../services/CommandeService.js';

export default async function changeStateAction(req, res, next) {
    try{
        const commandeService = new CommandeService();
        const commande = req.params.id;
        const state = req.body.state;
        const changed = await commandeService.changeState(commande, state);
        res.json(changed);
    }catch (e){
        next(404);
    }

}