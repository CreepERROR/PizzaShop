
export default async function changeStateAction(req, res, next) {
    try{
        const { id } = req.params;
        const { newState } = req.body;
        const message = JSON.stringify({ id: parseInt(id), newState });

        await publishMessage(message);
    
        return res.status(200).json({ success: true });
    }catch (e){
        next(res.status(400).json({ error: 'L\'identifiant de la commande et le nouvel état sont requis.' }));
    }

}