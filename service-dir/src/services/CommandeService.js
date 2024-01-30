import knex from 'knex';

import config from "./knexfile";

const db = knex(config.development);

async function getCommandes() {
  try {
    const result = await db.select('id', 'date_commande', 'delai', 'montant_total', 'mail_client', 'type_livraison').from('Commande');
    return result;
  } catch (err) {
    console.error(err);
    throw new Error("Impossible d'accéder aux commandes");
  }
}

export { getCommandes };
