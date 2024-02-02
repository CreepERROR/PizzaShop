export default class GetCommandesAction {
    #_service; //attribut privé

    constructor(service) {
        this.#_service = service; //injection de dépendance
    }

    async execute(req, res, next) {
        try{
            const commandes = await this.#_service.getCommandes();
            res.json(commandes);
        }catch (e){
            console.error(e);
            next(404);
        }
    }
}