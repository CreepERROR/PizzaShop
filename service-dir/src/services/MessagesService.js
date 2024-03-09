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
  async createSuiviQueue(channel) {
    const suiviExchange = 'pizzashop';
    const suiviQueue = 'suivi_commandes';
    const suiviRoutingKey = 'suivi';
    await channel.assertQueue(suiviQueue);
    await channel.bindQueue(suiviQueue, suiviExchange, suiviRoutingKey);
  }
  async publishMessageToSuivi(data) {
    try {
      const suiviExchange = 'pizzashop';
      const suiviRoutingKey = 'suivi';

      const conn = await amqp.connect(rabbitmq);
      const channel = await conn.createChannel();
      await channel.assertExchange(suiviExchange, 'direct', { durable: true });
      await this.createSuiviQueue(channel);
      await channel.publish(suiviExchange, suiviRoutingKey, Buffer.from(JSON.stringify(data)));
    } catch (err) {
      console.error(err);
      throw new Error("Unable to connect to RabbitMQ");
    }
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
        this.publishMessageToSuivi({
          commandId: data.commandId,
          newStatus: data.newStatus,
        });
        //ack() = used to acknowledge that the particular message has been received by the ‘client-app’.
        channel.ack(msg);
      })
    } catch (err) {
      console.error(err);
      throw new Error("Impossible de se connecter à RabbitMQ");
    }
  }


}