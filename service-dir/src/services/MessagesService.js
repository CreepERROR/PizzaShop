import knex from 'knex';

import config from "../knexfile.js";
import CommandeService from './CommandeService.js';
import amqp from 'amqplib';
const db = knex(config.development);
const rabbitmq = 'amqp://localhost:5672';

export default class MessagesService {
  #_service; //attribut privé
  constructor() {
    this.#_service = new CommandeService();
  }
  async messageEnCommande() {
    try {
      const exchange = 'pizzashop';
      const queue = 'nouvelles_commandes';
      const routingKey = 'nouvelle';
      const conn = await amqp.connect(rabbitmq);
      const channel = await conn.createChannel();
      await channel.consume(queue, (msg) => {
        //console.log('msg content: ' + msg.content);
        let data = JSON.parse(msg.content);
        this.#_service.createCommand(data.type_livraison, data.montant_total, data.mail_client)
        //ack() = used to acknowledge that the particular message has been received by the ‘client-app’.
        channel.ack(msg);
      })
    } catch (err) {
      console.error(err);
      throw new Error("Impossible de se connecter à RabbitMQ");
    }
  }


}