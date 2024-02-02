import knex from 'knex';

import config from "../knexfile.js";

const db = knex(config.development);

async function getCommandes() {
  try {
    const result = await db.select( '*').from('commande');
    return result;
  } catch (err) {
    console.error(err);
    throw new Error("Impossible d'accéder aux commandes");
  }
}

async function changeState(commandeId, state) {
  try {
    const result = await db('commande').update({ etape: state }).where({ id: commandeId });
    return await db.select( '*').from('commande').where({ id: commandeId });
  } catch (err) {
    console.error(err);
    throw new Error("Impossible de changer l'état de la commande");
  }
}

export { getCommandes, changeState };
