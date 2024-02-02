export default class ChangeStateAction {
    #_service;
    constructor(service) {
        this.#_service = service;
    }
    async execute(req, res, next) {
        try{
            const commandeId = req.params.id;
            const state = req.body.state;
            const changed = await this.#_service.changeState(commandeId, state);
            res.json(changed);
        }catch (e){
            next(404);
        }
    }


}