import ('../models/')

async function getCommandes() {
    return await Commande.findAll();
}

async function getCommande(id) {
    return await Commande.findOne({
        where: {
            id: id
        }
    });
}

export {getCommandes, getCommande}