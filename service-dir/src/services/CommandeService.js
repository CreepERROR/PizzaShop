import knex from 'knex';

import config from "../knexfile.js";

const db = knex(config.development);

export default class CommandeService {
  async getCommandes() {
    try {
      const result = await db.select( '*').from('commande');
      return result;
    } catch (err) {
      console.error(err);
      throw new Error("Impossible d'accéder aux commandes");
    }
  }

  async changeState(commandeId, state) {
    try {
      const result = await db('commande').update({ etape: state }).where({ id: commandeId });
      return await db.select( '*').from('commande').where({ id: commandeId });
    } catch (err) {
      console.error(err);
      throw new Error("Impossible de changer l'état de la commande");
    }
  }

  async createCommand(typeLivraison, montantTotal, mailClient) {
    try {
      const result = await db('commande').insert([{ type_livraison : typeLivraison }, { montant_total : montantTotal }, { mail_client : mailClient }, { etape : 1 }]);
      return await db.select( '*').from('commande').where({ id: result[0] });
    } catch (err) {
      console.error(err);
      throw new Error("Impossible de créer la commande");
    }
  }

}
