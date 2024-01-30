import { getCommandes } from '../services/CommandeService.js';

export default async function getCommandeAction(req, res, next) {
    try{
        const commandes = await getCommandes();
        res.json(commandes);
    }catch (e){
        console.error(e);
        next(404);
    }
}