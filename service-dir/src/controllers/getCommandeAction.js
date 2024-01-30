import CommandeService from '../services/commandeService';

export default async function getCommandeAction(req, res, next) {
    try{
        const commandeService = new CommandeService();
        const commandes = await commandeService.getCommandes();
        res.json(commandes);
    }catch (e){
        next(404);
    }
}